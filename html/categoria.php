<?php
require_once("connection.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Index.php");
    exit;
}

$id_categoria_actual = $_GET['id'];

$sql_nombre = "SELECT nombre_categoria FROM Categorias WHERE id_categoria = ?";
$stmt_nombre = $conexion->prepare($sql_nombre);
$stmt_nombre->bind_param("i", $id_categoria_actual);
$stmt_nombre->execute();
$resultado_nombre = $stmt_nombre->get_result();

if ($resultado_nombre->num_rows > 0) {
    $fila_cat = $resultado_nombre->fetch_assoc();
    $nombre_categoria = $fila_cat['nombre_categoria'];
} else {
    $nombre_categoria = "Categoría no encontrada";
}

$sql_productos = "SELECT id_producto, nombre_producto, precio, url_imagen FROM Productos WHERE id_categoria = ?";
$stmt_prod = $conexion->prepare($sql_productos);
$stmt_prod->bind_param("i", $id_categoria_actual);
$stmt_prod->execute();
$resultado_productos = $stmt_prod->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FerreTech - <?php echo htmlspecialchars($nombre_categoria); ?></title>

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/categorias.css">
</head>

<body>

    <div id="header-placeholder"></div>

    <main>
        <section class="categoria">
            <h2><?php echo mb_strtoupper(htmlspecialchars($nombre_categoria)); ?></h2>
        </section>

        <section class="grid-productos">
            <?php
            if ($resultado_productos->num_rows > 0) {
                while ($fila = $resultado_productos->fetch_assoc()) {
            ?>
                    <article class="producto" data-id="<?php echo $fila["id_producto"]; ?>">
                        <div class="imagen-producto">
                            <img src="<?php echo $fila["url_imagen"]; ?>" alt="<?php echo htmlspecialchars($fila["nombre_producto"]); ?>">
                        </div>
                        <div class="info-producto">
                            <h3><?php echo htmlspecialchars($fila["nombre_producto"]); ?></h3>
                            <p class="precio">$<?php echo number_format($fila["precio"], 2); ?></p>
                            <button class="btn-agregar">Agregar</button>
                        </div>
                    </article>
            <?php
                }
            } else {
                echo "<h3 class='mensaje-vacio'>No hay productos disponibles en esta categoría por el momento.</h3>";
            }
            
            $stmt_nombre->close();
            $stmt_prod->close();
            $conexion->close();
            ?>
        </section>
    </main>

    <div id="footer-placeholder"></div>

    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

</body>
</html>