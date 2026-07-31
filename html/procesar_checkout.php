<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. Obtener ID de usuario buscando en las variables de sesión más comunes
$id_usuario = $_SESSION['id_usuario'] ?? $_SESSION['usuario_id'] ?? $_SESSION['id'] ?? null;

if (!$id_usuario) {
    echo json_encode([
        'success' => false, 
        'message' => 'Tu sesión ha expirado o no has iniciado sesión.'
    ]);
    exit();
}

// 2. Incluir conexión
if (!file_exists('connection.php')) {
    echo json_encode([
        'success' => false, 
        'message' => 'No se encontró el archivo connection.php'
    ]);
    exit();
}

require_once 'connection.php';

$db = null;
if (isset($conexion)) {
    $db = $conexion;
} elseif (isset($conn)) {
    $db = $conn;
}

if (!$db) {
    echo json_encode([
        'success' => false, 
        'message' => 'No se detectó una variable de conexión válida en connection.php'
    ]);
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $direccion  = trim($data['direccion'] ?? '');
    $telefono   = trim($data['telefono'] ?? '');
    $carrito    = $data['carrito'] ?? [];

    if (empty($direccion)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Por favor ingresa una dirección válida.'
        ]);
        exit();
    }

    if (empty($carrito)) {
        echo json_encode([
            'success' => false, 
            'message' => 'El carrito está vacío.'
        ]);
        exit();
    }

    try {
        // Verificar si el id_usuario realmente existe en la tabla 'usuarios'
        $checkUser = $db->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
        $checkUser->bind_param("i", $id_usuario);
        $checkUser->execute();
        $resUser = $checkUser->get_result();

        if ($resUser->num_rows === 0) {
            // Si el usuario guardado en la sesión no existe en la BD, buscamos el primer usuario existente
            $firstUser = $db->query("SELECT id_usuario FROM usuarios LIMIT 1");
            if ($row = $firstUser->fetch_assoc()) {
                $id_usuario = $row['id_usuario'];
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'No hay ningún usuario registrado en la tabla usuarios de la base de datos.'
                ]);
                exit();
            }
        }
        $checkUser->close();

        $db->begin_transaction();

        $sql = "INSERT INTO pedidos (id_producto, id_usuario, precio, cantidad, direccion, telefono_contacto, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);

        $sql_stock = "UPDATE Productos SET stock = stock - ? WHERE id_producto = ?";
        $stmt_stock = $db->prepare($sql_stock);

        $sql_check = "SELECT stock, nombre_producto FROM Productos WHERE id_producto = ?";
        $stmt_check = $db->prepare($sql_check);

        $id_ultimo_pedido = 0;

        foreach ($carrito as $item) {
            $id_producto = (int)($item['id'] ?? $item['id_producto'] ?? 1);
            $precio      = (float)($item['precio'] ?? 0);
            $cantidad    = (int)($item['cantidad'] ?? 1);

            $stmt_check->bind_param("i", $id_producto);
            $stmt_check->execute();
            $res_check = $stmt_check->get_result();
            $datos_producto = $res_check->fetch_assoc();

            if (!$datos_producto || $datos_producto['stock'] < $cantidad) {
                $db->rollback();
                $nombre_prod = $datos_producto ? $datos_producto['nombre_producto'] : 'Desconocido';
                $stock_actual = $datos_producto ? $datos_producto['stock'] : 0;
                
                echo json_encode([
                    'success' => false, 
                    'message' => "Stock insuficiente para: $nombre_prod. Solo quedan $stock_actual unidades."
                ]);
                exit();
            }

            // Si hay suficiente stock, procedemos a guardar el pedido
            $stmt->bind_param("iidiss", $id_producto, $id_usuario, $precio, $cantidad, $direccion, $telefono);
            $stmt->execute();
            
            $id_ultimo_pedido = $stmt->insert_id;

            $stmt_stock->bind_param("ii", $cantidad, $id_producto);
            $stmt_stock->execute();
        }


        $stmt->close();
        $stmt_stock->close();
        $stmt_check->close();


        $db->commit();
        $_SESSION['pedido_completado'] = true;

        echo json_encode([
            'success' => true,
            'idPedido' => $id_ultimo_pedido
        ]);
        exit();

    } catch (Exception $e) {
        $db->rollback();
        echo json_encode([
            'success' => false, 
            'message' => 'Error de MySQL: ' . $e->getMessage()
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