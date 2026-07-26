<?php
session_start();
if (!isset($_SESSION["es_host"]) || $_SESSION["es_host"] !== true) {
    header("Location: login-host.php");
    exit();
}

require_once 'connection.php';

// Consulta para listar los productos con el nombre de su categoría asociada
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

// Ventas totales e ingresos directo desde la tabla Pedidos
$sql_ventas = "SELECT SUM(precio * cantidad) AS total_ingresos, SUM(cantidad) AS total_unidades FROM Pedidos";
$res_ventas = $conexion->query($sql_ventas);
$totales = $res_ventas ? $res_ventas->fetch_assoc() : ['total_ingresos' => 0, 'total_unidades' => 0];

$total_ingresos = $totales['total_ingresos'] ?? 0;
$total_ventas = $totales['total_unidades'] ?? 0;

// Filtrar en PHP aquellos con stock <= 5
$productos_criticos = array_filter($productos, function($prod) {
    return $prod['stock'] <= 5;
});
?>