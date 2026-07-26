<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Tu sesión ha expirado o no estás autenticado.'
    ]);
    exit();
}

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener JSON del cuerpo de la petición HTTP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id_usuario = $_SESSION['id_usuario'];
    $direccion = trim($data['direccion'] ?? '');
    $metodo_pago = trim($data['metodo_pago'] ?? '');

    if (empty($direccion) || empty($metodo_pago)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Por favor completa todos los campos requeridos.'
        ]);
        exit();
    }

    $sql = "INSERT INTO Pedidos (id_usuario, direccion_envio, metodo_pago, fecha_pedido) VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iss", $id_usuario, $direccion, $metodo_pago);
        
        if ($stmt->execute()) {
            $id_pedido = $stmt->insert_id;
            $stmt->close();

            echo json_encode([
                'success' => true,
                'idPedido' => $id_pedido,
                'cliente' => $id_usuario
            ]);
            exit();
        } else {
            $error = $stmt->error;
            $stmt->close();
            echo json_encode([
                'success' => false, 
                'message' => 'Error al registrar el pedido: ' . $error
            ]);
            exit();
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error en la consulta de base de datos.'
        ]);
        exit();
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Método de petición no permitido.'
    ]);
    exit();
}
?>