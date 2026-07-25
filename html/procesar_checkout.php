<?php

require_once 'connection.php';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $inputJSON = file_get_contents('php://input');
    $datos = json_decode($inputJSON, true);

    if (!$datos) {
        echo json_encode(['success' => false, 'message' => 'Datos de compra no válidos.']);
        exit();
    }

  
    $nombre = trim($datos['nombre'] ?? '');
    $apellidos = trim($datos['apellidos'] ?? '');
    $correo = trim($datos['correo'] ?? '');
    $direccion = trim($datos['direccion'] ?? '');
    $telefono = trim($datos['telefono'] ?? 'Sin Teléfono');
    $carrito = $datos['carrito'] ?? [];

    if (empty($correo) || empty($carrito)) {
        echo json_encode(['success' => false, 'message' => 'Carrito vacío o datos del cliente incompletos.']);
        exit();
    }

    
    $conexion->begin_transaction();

    try {
        
        $stmt_usr = $conexion->prepare("SELECT id_usuario FROM Usuarios WHERE correo = ?");
        $stmt_usr->bind_param("s", $correo);
        $stmt_usr->execute();
        $res_usr = $stmt_usr->get_result();

        if ($res_usr->num_rows > 0) {
            $row_usr = $res_usr->fetch_assoc();
            $id_usuario = $row_usr['id_usuario'];
        } else {
            
            $pass_temp = password_hash("123456", PASSWORD_BCRYPT);
            $stmt_ins_usr = $conexion->prepare("INSERT INTO Usuarios (nombre, apellidos, correo, contraseña) VALUES (?, ?, ?, ?)");
            $stmt_ins_usr->bind_param("ssss", $nombre, $apellidos, $correo, $pass_temp);
            $stmt_ins_usr->execute();
            $id_usuario = $stmt_ins_usr->insert_id;
            $stmt_ins_usr->close();
        }
        $stmt_usr->close();

        
        $stmt_pedido = $conexion->prepare("INSERT INTO Pedidos (id_producto, id_usuario, precio, cantidad, direccion, telefono_contacto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_update_stock = $conexion->prepare("UPDATE Productos SET stock = stock - ? WHERE id_producto = ? AND stock >= ?");

        foreach ($carrito as $item) {
            $id_producto = intval($item['id']);
            $precio = intval($item['precio']);
            $cantidad = intval($item['cantidad']);

        
            $stmt_pedido->bind_param("iiiiss", $id_producto, $id_usuario, $precio, $cantidad, $direccion, $telefono);
            $stmt_pedido->execute();

           
            $stmt_update_stock->bind_param("iii", $cantidad, $id_producto, $cantidad);
            $stmt_update_stock->execute();
        }

        $stmt_pedido->close();
        $stmt_update_stock->close();

       
        $conexion->commit();

        
        $id_orden = "FT-" . rand(10000, 99999);

        echo json_encode([
            'success' => true,
            'idPedido' => $id_orden,
            'cliente' => $nombre . " " . $apellidos,
            'total' => $datos['total'] ?? 0
        ]);

    } catch (Exception $e) {
       
        $conexion->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al procesar el pedido: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>