<?php
session_start();
if (!isset($_SESSION["es_host"]) || $_SESSION["es_host"] !== true) {
    header("Location: login-host.php");
    exit();
}

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id_producto = isset($_POST['id_producto']) && !empty($_POST['id_producto']) ? intval($_POST['id_producto']) : null;

    // Procesar acción de Eliminación
    if ($accion === 'eliminar') {
        if ($id_producto) {
            $sql = "DELETE FROM Productos WHERE id_producto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id_producto);
            
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: PanelAdmi.php?msg=producto_eliminado");
                exit();
            } else {
                $error = $stmt->error;
                $stmt->close();
                header("Location: gestion.php?id=" . $id_producto . "&error=" . urlencode("No se pudo eliminar el producto: " . $error));
                exit();
            }
        } else {
            header("Location: gestion.php?error=ID_producto_invalido");
            exit();
        }
    }

    // Datos para Registro y Actualización
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $url_imagen = trim($_POST['imagen'] ?? '');
    $id_categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : null;

    switch ($accion) {
        case 'registrar':
            if ($id_categoria && !empty($nombre) && $precio >= 0 && $stock >= 0) {
                $sql = "INSERT INTO Productos (id_categoria, nombre_producto, precio, stock, url_imagen) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("isdis", $id_categoria, $nombre, $precio, $stock, $url_imagen);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: PanelAdmi.php?msg=producto_creado");
                    exit();
                } else {
                    $error = $stmt->error;
                    $stmt->close();
                    header("Location: gestion.php?error=" . urlencode("Error al registrar: " . $error));
                    exit();
                }
            } else {
                header("Location: gestion.php?error=Datos_incompletos_o_invalidos");
                exit();
            }
            break;

        case 'actualizar':
            if ($id_producto && $id_categoria && !empty($nombre)) {
                $sql = "UPDATE Productos SET id_categoria = ?, nombre_producto = ?, precio = ?, stock = ?, url_imagen = ? WHERE id_producto = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("isdisi", $id_categoria, $nombre, $precio, $stock, $url_imagen, $id_producto);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: PanelAdmi.php?msg=producto_actualizado");
                    exit();
                } else {
                    $error = $stmt->error;
                    $stmt->close();
                    header("Location: gestion.php?id=" . $id_producto . "&error=" . urlencode("Error al actualizar: " . $error));
                    exit();
                }
            } else {
                header("Location: gestion.php?error=Datos_o_ID_incompletos");
                exit();
            }
            break;

        default:
            header("Location: PanelAdmi.php");
            exit();
    }
} else {
    header("Location: PanelAdmi.php");
    exit();
}
?>