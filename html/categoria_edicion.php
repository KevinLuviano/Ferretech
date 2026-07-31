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

// 1. LÓGICA PARA ELIMINAR UNA CATEGORÍA
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    
    // Verificar si la categoría tiene productos asociados
    $check_sql = "SELECT COUNT(*) as total FROM Productos WHERE id_categoria = ?";
    $stmt_check = $conexion->prepare($check_sql);
    $stmt_check->bind_param("i", $id_eliminar);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    if ($res_check['total'] > 0) {
        $error = "No se puede eliminar la categoría porque tiene productos asociados.";
    } else {
        $sql_del = "DELETE FROM Categorias WHERE id_categoria = ?";
        $stmt_del = $conexion->prepare($sql_del);
        $stmt_del->bind_param("i", $id_eliminar);

        if ($stmt_del->execute()) {
            $mensaje = "Categoría eliminada correctamente.";
        } else {
            $error = "Error al eliminar la categoría: " . $conexion->error;
        }
        $stmt_del->close();
    }
}

// 2. LÓGICA PARA AGREGAR NUEVA CATEGORÍA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_categoria = trim($_POST['nombre_categoria'] ?? '');

    if (empty($nombre_categoria)) {
        $error = "Por favor, escribe el nombre de la categoría.";
    } else {
        $sql = "INSERT INTO Categorias (nombre_categoria) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombre_categoria);

        if ($stmt->execute()) {
            $mensaje = "¡Categoría registrada con éxito!";
        } else {
            $error = "Error al guardar la categoría (puede que ya exista): " . $conexion->error;
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
    <meta name="description" content="FerreTech: Gestión y Edición de Categorías">
    <title>FerreTech - Edición de Categorías</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
    
    <style>
        .form-contenedor {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div id="header-placeholder"></div>

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-bold border border-dark px-4 py-1" style="color: #000000;">
                Gestión de Categorías
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
            <!-- Formulario de Registro -->
            <div class="col-lg-5">
                <div class="form-contenedor border">
                    <h4 class="fw-bold mb-3" style="color: #0a192f;">Nueva Categoría</h4>
                    <form method="POST" action="categoria_edicion.php">
                        <div class="mb-3">
                            <label for="nombre_categoria" class="form-label fw-semibold">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Ej: Pinturas, Plomería, Iluminación" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold mt-2 py-2">Guardar Categoría</button>
                    </form>
                </div>
            </div>

            <!-- TABLA DE CATEGORÍAS EXISTENTES -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white text-center py-2">
                        <h4 class="mb-0 fw-semibold">Categorías Registradas</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center mb-0 bg-white">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de Categoría</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_cats = "SELECT * FROM Categorias ORDER BY id_categoria DESC";
                                $res_cats = $conexion->query($sql_cats);
                                if ($res_cats && $res_cats->num_rows > 0):
                                    while ($cat = $res_cats->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td class="fw-bold">#<?php echo $cat['id_categoria']; ?></td>
                                        <td><?php echo htmlspecialchars($cat['nombre_categoria']); ?></td>
                                        <td>
                                            <a href="categoria_edicion.php?eliminar=<?php echo $cat['id_categoria']; ?>" 
                                               class="btn btn-sm btn-outline-danger fw-bold px-3" 
                                               onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                               🗑️ Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="3" class="py-4 text-muted">No hay categorías registradas aún.</td>
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
</body>
</html>