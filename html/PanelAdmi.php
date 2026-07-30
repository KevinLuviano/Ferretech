<?php require_once 'PanelAdmi_logic.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: Panel de administración de inventario crítico.">
    <title>FerreTech - PanelAdmi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Css/PanelAdmi.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="container my-5">
        <!-- Indicadores Rápidos -->
        <div class="row mb-4 text-center">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm bg-light">
                    <h6 class="text-muted">Ingresos Totales</h6>
                    <h3 class="text-success fw-bold mb-0">$<?php echo number_format($total_ingresos, 2); ?> MXN</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm bg-light">
                    <h6 class="text-muted">Unidades Vendidas</h6>
                    <h3 class="text-primary fw-bold mb-0"><?php echo intval($total_ventas); ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm bg-light">
                    <h6 class="text-muted">Stock Crítico (≤ 5)</h6>
                    <h3 class="text-danger fw-bold mb-0"><?php echo count($productos_criticos); ?></h3>
                </div>
            </div>
        </div>

        <!-- Alertas dinámicas de desabasto -->
        <div id="alertas-stock" class="mb-4">
            <?php if (empty($productos_criticos)): ?>
                <div class="alert alert-success m-0">✅ Todo el inventario está en niveles óptimos.</div>
            <?php else: ?>
                <?php foreach ($productos_criticos as $p): ?>
                    <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                        <span>⚠️ Quedan solo <strong><?php echo $p['stock']; ?></strong> unidades de <strong><?php echo htmlspecialchars($p['nombre_producto']); ?></strong></span>
                        <a href="gestion.php?id=<?php echo $p['id_producto']; ?>" class="btn btn-sm btn-outline-dark">Surtir</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

       <div class="row mb-4 align-items-center">
    <!-- Lado Izquierdo: Título Inventario -->
    <div class="col-md-4">
        <h1 class="display-6 fw-bold border border-dark d-inline-block px-4 py-1" style="color: #000000;">
            Inventario
        </h1>
    </div>

    <!-- Lado Derecho: Grupo de Botones alineados en una sola fila -->
    <div class="col-md-8 text-end">
        <a href="carrusel_modificacion.php" class="btn btn-dark fw-semibold px-3 me-2">🎡 Modificar Carrusel</a>
        <a href="gestion.php" class="btn btn-dark fw-semibold px-3 me-2">➕ Agregar Nuevo Producto</a>
        <a href="registro-host.php" class="btn btn-dark fw-semibold px-3">➕ Agregar Nuevo host</a>
    </div>
</div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-corporativo text-white text-center py-2 border-0">
                <h4 class="mb-0 fw-semibold" style="letter-spacing: 0.5px;">Inventario Registrado</h4>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle mb-0 tabla-inventario">
                    <thead>
                        <tr>
                            <th>IDENTIFICACIÓN</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($productos)): ?>
                            <tr>
                                <td colspan="7" class="py-4 text-muted">No se encontraron productos en la base de datos.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($productos as $prod): ?>
                                <tr>
                                    <td class="fw-bold">#<?php echo $prod['id_producto']; ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($prod['url_imagen'] ?: 'https://via.placeholder.com/50'); ?>" alt="Producto" style="width: 45px; height: 45px; object-fit: contain;">
                                    </td>
                                    <td><?php echo htmlspecialchars($prod['nombre_producto']); ?></td>
                                    <td><?php echo htmlspecialchars($prod['nombre_categoria'] ?? 'Sin Categoría'); ?></td>
                                    <td>
                                        <span class="badge <?php echo $prod['stock'] <= 5 ? 'bg-danger' : 'bg-secondary'; ?>">
                                            <?php echo $prod['stock']; ?>
                                        </span>
                                    </td>
                                    <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                                    <td>
                                        <a href="gestion.php?id=<?php echo $prod['id_producto']; ?>" class="btn-accion-tabla px-3">Gestionar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/header-footer.js?v=2"></script>
</body>
</html>