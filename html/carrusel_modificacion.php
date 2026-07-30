<?php
session_start();

// Control de acceso estricto: solo el host autenticado puede ingresar
if (!isset($_SESSION["es_host"]) || $_SESSION["es_host"] !== true) {
    header("Location: login-host.php");
    exit();
}

require_once 'connection.php';

$mensaje = "";
$error = "";

// 1. LÓGICA PARA ELIMINAR UNA PROMOCIÓN DEL CARRUSEL
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    $sql_del = "DELETE FROM Carrusel WHERE id_carrusel = ?";
    $stmt_del = $conexion->prepare($sql_del);
    $stmt_del->bind_param("i", $id_eliminar);

    if ($stmt_del->execute()) {
        $mensaje = "Promoción #{$id_eliminar} eliminada correctamente del carrusel.";
    } else {
        $error = "Error al eliminar la promoción: " . $conexion->error;
    }
    $stmt_del->close();
}

// 2. LÓGICA PARA AGREGAR NUEVA PROMOCIÓN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $badge = trim($_POST['badge_promo'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $url_imagen = trim($_POST['url_imagen'] ?? '');

    if (empty($badge) || empty($titulo) || empty($descripcion) || empty($categoria) || empty($url_imagen)) {
        $error = "Por favor, completa todos los campos requeridos.";
    } else {
        $sql = "INSERT INTO Carrusel (badge_promo, titulo, descripcion, categoria, url_imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $badge, $titulo, $descripcion, $categoria, $url_imagen);

        if ($stmt->execute()) {
            $mensaje = "¡Promoción guardada con éxito en el carrusel!";
        } else {
            $error = "Error al guardar en la base de datos: " . $conexion->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: Modificación y Gestión de Carrusel">
    <title>FerreTech - Modificar Carrusel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
    <link href="../Css/carrusel.css" rel="stylesheet">
    
    <style>
        .form-contenedor {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .preview-box {
            border: 2px dashed #0a192f;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>

    <div id="header-placeholder"></div>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-bold border border-dark px-4 py-1" style="color: #000000;">
                Modificar Carrusel
            </h1>
            <a href="PanelAdmi.php" class="btn btn-outline-dark fw-semibold">← Volver al Panel</a>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Formulario de Configuración -->
            <div class="col-lg-5">
                <div class="form-contenedor border">
                    <h4 class="fw-bold mb-3" style="color: #0a192f;">Agregar Promoción</h4>
                    <form method="POST" action="carrusel_modificacion.php" id="formCarrusel">
                        
                        <div class="mb-3">
                            <label for="badge_promo" class="form-label fw-semibold">Etiqueta Promocional (Badge)</label>
                            <input type="text" class="form-control" id="badge_promo" name="badge_promo" placeholder="Ej: Mes de las Herramientas" required>
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-semibold">Frase / Título Promocional</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Pulidoras Truper de la mejor calidad" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Potencia industrial de 1200W..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label fw-semibold">Categoría Perteneciente</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <option value="Herramientas">Herramientas</option>
                                <option value="Materiales">Materiales de Fijación</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="url_imagen" class="form-label fw-semibold">URL de la Imagen</label>
                            <input type="text" class="form-control" id="url_imagen" name="url_imagen" placeholder="../img/pulidoraIndustrial.jpg" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold mt-2 py-2">Guardar Promoción</button>
                    </form>
                </div>
            </div>

            <!-- Vista Previa en Tiempo Real -->
            <div class="col-lg-7">
                <h4 class="fw-bold mb-3" style="color: #0a192f;">Vista Previa</h4>
                <div class="preview-box p-2">
                    <div class="carrusel-promociones" style="border-radius: 6px; overflow: hidden;">
                        <div class="contenedor-promocion py-4">
                            <div class="texto-promocion">
                                <span class="badge-promo" id="prev-badge">ETIQUETA PROMO</span>
                                <h2 id="prev-titulo">Título Promocional</h2>
                                <p id="prev-descripcion">Aquí se mostrará la descripción introducida para la promoción del carrusel.</p>
                                <a href="#" class="btn btn-accion" id="prev-btn">Ver Categoría</a>
                            </div>
                            <div class="contenedor-imagen">
                                <img id="prev-imagen" src="https://via.placeholder.com/300x300?text=Vista+Previa" alt="Imagen del Producto" class="imagen-producto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA DE GESTIÓN DE PROMOCIONES REGISTRADAS -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white text-center py-2">
                        <h4 class="mb-0 fw-semibold">Promociones Activas en el Carrusel</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center mb-0 bg-white">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Etiqueta</th>
                                    <th>Título</th>
                                    <th>Categoría</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_list = "SELECT * FROM Carrusel ORDER BY id_carrusel DESC";
                                $res_list = $conexion->query($sql_list);
                                if ($res_list && $res_list->num_rows > 0):
                                    while ($carr = $res_list->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="fw-bold">#<?php echo $carr['id_carrusel']; ?></td>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($carr['url_imagen']); ?>" alt="Img" style="width: 50px; height: 50px; object-fit: contain;">
                                        </td>
                                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($carr['badge_promo']); ?></span></td>
                                        <td><?php echo htmlspecialchars($carr['titulo']); ?></td>
                                        <td><?php echo htmlspecialchars($carr['categoria']); ?></td>
                                        <td>
                                            <a href="carrusel_modificacion.php?eliminar=<?php echo $carr['id_carrusel']; ?>" 
                                               class="btn btn-sm btn-outline-danger fw-bold px-3" 
                                               onclick="return confirm('¿Estás seguro de que deseas eliminar esta promoción?');">
                                               🗑️ Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="6" class="py-4 text-muted">No hay promociones registradas en el carrusel.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/header-footer.js?v=2"></script>
    
    <script>
        // Actualización dinámica de la vista previa con JS
        document.addEventListener('DOMContentLoaded', () => {
            const inputBadge = document.getElementById('badge_promo');
            const inputTitulo = document.getElementById('titulo');
            const inputDesc = document.getElementById('descripcion');
            const selectCat = document.getElementById('categoria');
            const inputUrl = document.getElementById('url_imagen');

            const prevBadge = document.getElementById('prev-badge');
            const prevTitulo = document.getElementById('prev-titulo');
            const prevDesc = document.getElementById('prev-descripcion');
            const prevBtn = document.getElementById('prev-btn');
            const prevImg = document.getElementById('prev-imagen');

            inputBadge.addEventListener('input', () => {
                prevBadge.textContent = inputBadge.value.trim() || 'ETIQUETA PROMO';
            });

            inputTitulo.addEventListener('input', () => {
                prevTitulo.innerHTML = inputTitulo.value.trim() || 'Título Promocional';
            });

            inputDesc.addEventListener('input', () => {
                prevDesc.textContent = inputDesc.value.trim() || 'Aquí se mostrará la descripción introducida para la promoción del carrusel.';
            });

            selectCat.addEventListener('change', () => {
                prevBtn.textContent = 'Ver ' + (selectCat.value || 'Categoría');
            });

            inputUrl.addEventListener('input', () => {
                const url = inputUrl.value.trim();
                prevImg.src = url !== '' ? url : 'https://via.placeholder.com/300x300?text=Vista+Previa';
            });
        });
    </script>
</body>
</html>