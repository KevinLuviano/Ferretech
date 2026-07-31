<?php
session_start();
if (!isset($_SESSION["es_host"]) || $_SESSION["es_host"] !== true) {
    header("Location: login-host.php");
    exit();
}

require_once 'connection.php';

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto_editar = null;

if ($id_producto > 0) {
    $stmt = $conexion->prepare("SELECT * FROM Productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $producto_editar = $res->fetch_assoc();
    }
    $stmt->close();
}

// Cargar todas las categorías ordenadas alfabéticamente desde la base de datos
$categorias_res = $conexion->query("SELECT * FROM Categorias ORDER BY nombre_categoria ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: Gestión y CRUD de productos de inventario.">
    <title>FerreTech - Gestión de Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Css/gestionar.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="container my-5">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="display-6 fw-bold border border-dark d-inline-block px-4 py-1" style="color: #000000;">
                    Editor de Inventario
                </h1>
            </div>
            <div class="col text-end">
                <a href="PanelAdmi.php" class="btn btn-outline-dark fw-semibold">← Volver al Panel</a>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ⚠️ <strong>Error:</strong> <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 core-gestion-card">
            <div class="card-header bg-corporativo text-white text-center py-2 border-0">
                <h4 class="mb-0 fw-semibold">
                    <?php echo $producto_editar ? 'Editar Producto #' . $producto_editar['id_producto'] : 'Registrar Nuevo Producto'; ?>
                </h4>
            </div>
            
            <div class="card-body p-4">
                <form id="form-gestion-producto" action="gestion_logic.php" method="POST">
                    <!-- Campo Oculto ID Producto -->
                    <input type="hidden" name="id_producto" value="<?php echo $producto_editar['id_producto'] ?? ''; ?>">
                    
                    <!-- Campo Oculto para Definir la Acción -->
                    <input type="hidden" id="accion" name="accion" value="<?php echo $producto_editar ? 'actualizar' : 'registrar'; ?>">

                    <div class="row g-3">
                        <!-- URL de la Imagen -->
                        <div class="col-md-6">
                            <label for="prodImagen" class="form-label fw-bold">URL de la Imagen del Producto</label>
                            <input type="url" class="form-control" id="prodImagen" name="imagen" placeholder="https://ejemplo.com/imagen.jpg" value="<?php echo htmlspecialchars($producto_editar['url_imagen'] ?? ''); ?>" required>
                        </div>
                        
                        <!-- Nombre del Producto -->
                        <div class="col-md-6">
                            <label for="prodNombre" class="form-label fw-bold">Nombre del Producto</label>
                            <input type="text" class="form-control" id="prodNombre" name="nombre" placeholder="Ej: Martillo de uña curva" value="<?php echo htmlspecialchars($producto_editar['nombre_producto'] ?? ''); ?>" required>
                        </div>

                        <!-- Vista Previa de la Imagen -->
                        <div class="col-12 text-center my-2">
                            <div class="p-2 border rounded bg-light d-inline-block">
                                <p class="small text-muted mb-1 fw-bold">Vista previa de la imagen:</p>
                                <img id="imgPreview" src="<?php echo htmlspecialchars($producto_editar['url_imagen'] ?? 'https://via.placeholder.com/150?text=Sin+Imagen'); ?>" alt="Vista Previa" class="img-thumbnail" style="max-height: 150px; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Categoría con botón para añadir más -->
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="prodCategoria" class="form-label fw-bold m-0">Categoría</label>
                                <a href="categoria_edicion.php" class="text-decoration-none small fw-bold text-primary">+ Editar Categorías</a>
                            </div>
                            <select class="form-select" id="prodCategoria" name="categoria" required>
                                <option value="" disabled <?php echo !$producto_editar ? 'selected' : ''; ?>>Seleccionar...</option>
                                <?php if ($categorias_res && $categorias_res->num_rows > 0): ?>
                                    <?php while ($cat = $categorias_res->fetch_assoc()): ?>
                                        <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($producto_editar && $producto_editar['id_categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-4">
                            <label for="prodStock" class="form-label fw-bold">Cantidad en Almacén (Stock)</label>
                            <input type="number" class="form-control" id="prodStock" name="stock" min="0" placeholder="0" value="<?php echo $producto_editar['stock'] ?? 0; ?>" required>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-4">
                            <label for="prodPrecio" class="form-label fw-bold">Precio Unitario ($)</label>
                            <input type="number" class="form-control" id="prodPrecio" name="precio" min="0" step="0.01" placeholder="0.00" value="<?php echo $producto_editar['precio'] ?? '0.00'; ?>" required>
                        </div>
                    </div>

                    <!-- Panel de Botones de Acción -->
                    <div class="row mt-5 pt-3 border-top align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0 text-start">
                            <?php if ($producto_editar): ?>
                                <!-- BOTÓN: Actualizar Producto -->
                                <button type="submit" onclick="setAccion('actualizar')" class="btn btn-primary me-2 fw-semibold">
                                    💾 Guardar Cambios
                                </button>
                            <?php else: ?>
                                <!-- BOTÓN: Crear Nuevo Producto -->
                                <button type="submit" onclick="setAccion('registrar')" class="btn btn-success me-2 fw-semibold">
                                    ➕ Registrar Producto
                                </button>
                            <?php endif; ?>

                            <!-- BOTÓN: Limpiar Formulario -->
                            <a href="gestion.php" class="btn btn-secondary fw-semibold">
                                🔄 Limpiar / Nuevo Formulario
                            </a>
                        </div>

                        <?php if ($producto_editar): ?>
                            <!-- BOTÓN: Eliminar Producto (Solo visible en modo edición) -->
                            <div class="col-md-4 text-md-end">
                                <button type="submit" onclick="return confirmarEliminar()" class="btn btn-danger fw-semibold">
                                    🗑️ Eliminar Producto
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setAccion(act) {
            document.getElementById('accion').value = act;
        }

        function confirmarEliminar() {
            setAccion('eliminar');
            const inputs = document.querySelectorAll('#form-gestion-producto input[required], #form-gestion-producto select[required]');
            inputs.forEach(input => input.removeAttribute('required'));
            
            return confirm("⚠️ ¿Estás seguro de que deseas eliminar permanentemente este producto del inventario?");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const inputImagen = document.getElementById('prodImagen');
            const imgPreview = document.getElementById('imgPreview');

            inputImagen.addEventListener('input', function() {
                const url = this.value.trim();
                imgPreview.src = url ? url : "https://via.placeholder.com/150?text=Sin+Imagen";
            });

            imgPreview.addEventListener('error', function() {
                this.src = "https://via.placeholder.com/150?text=Imagen+Invalida";
            });
        });
    </script>
    <script src="../js/header-footer.js?v=2"></script>
</body>
</html>