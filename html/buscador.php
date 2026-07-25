<?php
require_once("connection.php");

$busqueda = isset($_GET['q']) ? $_GET['q'] : '';

$sql = "SELECT p.id_producto, p.nombre_producto, p.precio, p.url_imagen, c.nombre_categoria 
        FROM Productos p
        INNER JOIN Categorias c ON p.id_categoria = c.id_categoria
        WHERE p.nombre_producto LIKE ?";

$stmt = $conexion->prepare($sql);

$parametro_busqueda = "%" . $busqueda . "%";

$stmt->bind_param("s", $parametro_busqueda);

$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - FerreTech</title>

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/categorias.css">
</head>

<body>

    <div id="header-placeholder"></div>

    <main>
        <section class="categoria">
            <h2 style="text-transform: uppercase;">RESULTADOS PARA: "<?php echo htmlspecialchars($busqueda); ?>"</h2>
        </section>

        <section class="grid-productos">
            <?php
            if ($busqueda != '' && $resultado->num_rows > 0) {

                while ($fila = $resultado->fetch_assoc()) {
            ?>
                    <article class="producto">
                        <div class="imagen-producto">
                            <img src="<?php echo $fila["url_imagen"]; ?>" alt="<?php echo $fila["nombre_producto"]; ?>">
                        </div>
                        <div class="info-producto">
                            <h3><?php echo $fila["nombre_producto"]; ?></h3>
                            
                            <p style="font-size: 12px; color: gray; margin-bottom: 5px;">
                                Categoría: <?php echo $fila["nombre_categoria"]; ?>
                            </p>
                            
                            <p class="precio">$<?php echo number_format($fila["precio"], 2); ?></p>
                            
                            <button class="btn-agregar" data-id="<?php echo $fila["id_producto"]; ?>">Agregar</button>
                        </div>
                    </article>
            <?php
                }
                
            } else {
                echo "<h3 style='grid-column: 1 / -1; text-align: center; margin-top: 50px;'>No se encontraron productos que coincidan con '" . htmlspecialchars($busqueda) . "'.</h3>";
            }

            $stmt->close();
            $conexion->close();
            ?>
        </section>
    </main>

    <div id="footer-placeholder"></div>

    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

</body>
</html>