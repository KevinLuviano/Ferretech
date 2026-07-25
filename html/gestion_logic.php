<?php

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    
    $id_producto = isset($_POST['id_producto']) && !empty($_POST['id_producto']) ? intval($_POST['id_producto']) : null;
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $url_imagen = trim($_POST['imagen'] ?? '');
    $nombre_categoria = trim($_POST['categoria'] ?? '');

   
    $id_categoria = null;
    if (!empty($nombre_categoria)) {
      
        $stmt_cat = $conexion->prepare("SELECT id_categoria FROM Categorias WHERE nombre_categoria = ?");
        $stmt_cat->bind_param("s", $nombre_categoria);
        $stmt_cat->execute();
        $res_cat = $stmt_cat->get_result();

        if ($res_cat->num_rows > 0) {
            $row_cat = $res_cat->fetch_assoc();
            $id_categoria = $row_cat['id_categoria'];
        } else {
            
            $stmt_ins_cat = $conexion->prepare("INSERT INTO Categorias (nombre_categoria) VALUES (?)");
            $stmt_ins_cat->bind_param("s", $nombre_categoria);
            $stmt_ins_cat->execute();
            $id_categoria = $stmt_ins_cat->insert_id;
            $stmt_ins_cat->close();
        }
        $stmt_cat->close();
    }

    
    switch ($accion) {
        case 'registrar':
            if ($id_categoria && !empty($nombre) && $precio >= 0 && $stock >= 0) {
                $sql = "INSERT INTO Productos (id_categoria, nombre_producto, precio, stock, url_imagen) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("isdis", $id_categoria, $nombre, $precio, $stock, $url_imagen);
                
                if ($stmt->execute()) {
                    header("Location: PanelAdmi.php?msg=producto_creado");
                } else {
                    header("Location: gestion.php?error=" . urlencode($stmt->error));
                }
                $stmt->close();
            } else {
                header("Location: gestion.php?error=datos_incompletos");
            }
            break;

        case 'actualizar':
            if ($id_producto && $id_categoria && !empty($nombre)) {
                $sql = "UPDATE Productos SET id_categoria = ?, nombre_producto = ?, precio = ?, stock = ?, url_imagen = ? WHERE id_producto = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("isdisi", $id_categoria, $nombre, $precio, $stock, $url_imagen, $id_producto);
                
                if ($stmt->execute()) {
                    header("Location: PanelAdmi.php?msg=producto_actualizado");
                } else {
                    header("Location: gestion.php?id=" . $id_producto . "&error=" . urlencode($stmt->error));
                }
                $stmt->close();
            } else {
                header("Location: gestion.php?error=id_invalido");
            }
            break;

        case 'eliminar':
            if ($id_producto) {
                $sql = "DELETE FROM Productos WHERE id_producto = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $id_producto);
                
                if ($stmt->execute()) {
                    header("Location: PanelAdmi.php?msg=producto_eliminado");
                } else {
                    header("Location: gestion.php?id=" . $id_producto . "&error=no_se_pudo_eliminar");
                }
                $stmt->close();
            } else {
                header("Location: gestion.php?error=id_invalido");
            }
            break;

        default:
            header("Location: PanelAdmi.php");
            break;
    }
} else {
    // Si entran directo sin usar POST, redirigir al panel
    header("Location: PanelAdmi.php");
    exit();
}
?>