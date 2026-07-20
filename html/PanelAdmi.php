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
  
    <!-- Contenedor del Header Modular -->
    <div id="header-placeholder"></div>

    <main class="container my-5">
        <!-- Espacio reservado para las alertas dinámicas de desabasto -->
        <div id="alertas-stock" class="mb-4"></div>

        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="display-6 fw-bold border border-dark d-inline-block px-4 py-1" style="color: #000000;">
                    Inventario
                </h1>
            </div>
            <!-- Botón extra para agregar productos directamente -->
            <div class="col text-end">
                <a href="gestion.html" class="btn btn-dark fw-semibold px-4">➕ Agregar Nuevo Producto</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-corporativo text-white text-center py-2 border-0">
                <h4 class="mb-0 fw-semibold" style="letter-spacing: 0.5px;">Inventario Crítico</h4>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle mb-0 tabla-inventario">
                    <thead>
                        <tr>
                            <th>IDENTIFICACIÓN</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">F-001</td>
                            <td>Rotomartillo</td>
                            <td>H. electricas</td>
                            <td>45</td>
                            <td>$500</td>
                            <td>
                                <a href="gestion.html?id=F-001" class="btn-accion-tabla px-4">Gestionar</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">F-S0055</td>
                            <td>Taquete</td>
                            <td>Fijacion</td>
                            <td>250</td>
                            <td>$25</td>
                            <td>
                                <a href="gestion.html?id=F-S0055" class="btn-accion-tabla px-4">Gestionar</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">F-5558</td>
                            <td>Pulidora</td>
                            <td>H.electricas</td>
                            <td>5</td>
                            <td>$700</td>
                            <td>
                                <a href="gestion.html?id=F-5558" class="btn-accion-tabla px-4">Gestionar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Contenedor del Footer Modular -->
    <div id="footer-placeholder"></div>

    <!-- Scripts de Bootstrap y Lógica Compartida de la UI -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/header-footer.js"></script>

    <!-- Lógica Operativa Exclusiva del Panel de Administración -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ventas = JSON.parse(localStorage.getItem('historicoVentas')) || [];
            const inventario = JSON.parse(localStorage.getItem('inventario')) || [];

            // 1. Calcular e inyectar Ingresos Totales si existen los elementos en el DOM
            const ingresosTotales = ventas.reduce((suma, venta) => suma + venta.total, 0);
            const elemIngresos = document.getElementById('dash-ingresos');
            if (elemIngresos) elemIngresos.textContent = `$${ingresosTotales.toFixed(2)} MXN`;

            // 2. Calcular e inyectar Número de Ventas Realizadas
            const elemVentas = document.getElementById('dash-ventas-count');
            if (elemVentas) elemVentas.textContent = ventas.length;

            // 3. Alertas de Stock Bajo (Menos de 5 unidades)
            const contenedorAlertas = document.getElementById('alertas-stock');
            if (contenedorAlertas) {
                contenedorAlertas.innerHTML = "";
                const productosCriticos = inventario.filter(p => p.stock <= 5);
                
                if (productosCriticos.length === 0) {
                    contenedorAlertas.innerHTML = `<div class="alert alert-success m-0">✅ Todo el inventario está en niveles óptimos.</div>`;
                } else {
                    productosCriticos.forEach(p => {
                        contenedorAlertas.innerHTML += `
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-2">
                                <span>⚠️ Quedan solo <strong>${p.stock}</strong> unidades de <strong>${p.nombre}</strong></span>
                                <a href="gestion.html?id=${p.id}" class="btn btn-sm btn-outline-dark">Surtir</a>
                            </div>
                        `;
                    });
                }
            }
        });
    </script>
</body>
 <script src="../js/header-footer.js"></script>
</html>