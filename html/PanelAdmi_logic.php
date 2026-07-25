<?php

require_once 'connection.php';


$sql_productos = "
    SELECT 
        p.id_producto, 
        p.nombre_producto, 
        p.precio, 
        p.stock, 
        p.url_imagen,
        c.nombre_categoria
    FROM Productos p
    LEFT JOIN Categorias c ON p.id_categoria = c.id_categoria
    ORDER BY p.id_producto DESC
";

$resultado_productos = $conexion->query($sql_productos);
$productos = [];

if ($resultado_productos && $resultado_productos->num_rows > 0) {
    while ($row = $resultado_productos->fetch_assoc()) {
        $productos[] = $row;
    }
}


$productos_criticos = array_filter($productos, function($prod) {
    return $prod['stock'] <= 5;
});
?>