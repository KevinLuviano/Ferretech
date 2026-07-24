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

       
        <div class="card shadow-sm border-0 core-gestion-card">
            <div class="card-header bg-corporativo text-white text-center py-2 border-0">
                <h4 class="mb-0 fw-semibold" style="letter-spacing: 0.5px;">Formulario del Producto</h4>
            </div>
            
            <div class="card-body p-4">
                <form id="form-gestion-producto">
                    <div class="row g-3">
                        <!-- URL de la Imagen -->
                        <div class="col-md-6">
                            <label for="prodImagen" class="form-label fw-bold">URL de la Imagen del Producto</label>
                            <input type="url" class="form-control" id="prodImagen" placeholder="https://ejemplo.com/imagen.jpg" required>
                        </div>
                        
                        <!-- Nombre del Producto -->
                        <div class="col-md-6">
                            <label for="prodNombre" class="form-label fw-bold">Nombre del Producto</label>
                            <input type="text" class="form-control" id="prodNombre" placeholder="Ej: Rotomartillo" required>
                        </div>

                        <!-- Vista Previa de la Imagen -->
                        <div class="col-12 text-center my-2">
                            <div class="p-2 border rounded bg-light d-inline-block">
                                <p class="small text-muted mb-1 fw-bold">Vista previa de la imagen:</p>
                                <img id="imgPreview" src="https://via.placeholder.com/150?text=Sin+Imagen" alt="Vista Previa" class="img-thumbnail" style="max-height: 150px; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-4">
                            <label for="prodCategoria" class="form-label fw-bold">Categoría</label>
                            <select class="form-select" id="prodCategoria" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <option value="Fijacion">Fijación</option>
                                <option value="Manuales">Herramientas</option>
                            </select>
                        </div>

                   
                        <div class="col-md-4">
                            <label for="prodStock" class="form-label fw-bold">Cantidad en Almacén (Stock)</label>
                            <input type="number" class="form-control" id="prodStock" min="0" placeholder="0" required>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-4">
                            <label for="prodPrecio" class="form-label fw-bold">Precio Unitario ($)</label>
                            <input type="number" class="form-control" id="prodPrecio" min="0" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                    
                    <div class="row mt-5 pt-3 border-top border-light-subtle text-center text-md-start">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <button type="submit" class="btn btn-success btn-crud-accion me-2 fw-semibold">💾 Registrar / Guardar</button>
                            <button type="button" class="btn btn-info text-white btn-crud-accion fw-semibold" style="background-color: #0284c7; border-color: #0284c7;">🔄 Actualizar Info</button>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button type="button" class="btn btn-danger btn-crud-accion fw-semibold">🗑️ Eliminar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputImagen = document.getElementById('prodImagen');
            const imgPreview = document.getElementById('imgPreview');

            // Actualiza la vista previa al escribir o pegar una URL
            inputImagen.addEventListener('input', function() {
                const url = this.value.trim();
                if (url) {
                    imgPreview.src = url;
                } else {
                    imgPreview.src = "https://via.placeholder.com/150?text=Sin+Imagen";
                }
            });

            // En caso de que la imagen falle al cargar (URL rota o inválida)
            imgPreview.addEventListener('error', function() {
                this.src = "https://via.placeholder.com/150?text=Imagen+Invalida";
            });

            // Capturar la URL por si viene en los parámetros de la página
            const urlParams = new URLSearchParams(window.location.search);
            const imagenUrl = urlParams.get('imagen');
            if (imagenUrl) {
                inputImagen.value = imagenUrl;
                imgPreview.src = imagenUrl;
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            if (!localStorage.getItem('inventario')) {
                const productosIniciales = [
                    { id: "1", nombre: "Rotomartillo 1/2 Truper", stock: 15, precio: 1250, imagen: "" },
                    { id: "2", nombre: "Pulidora Truper 1200W", stock: 8, precio: 1800, imagen: "" },
                    { id: "3", nombre: "Kit de Tornillos Sujeción", stock: 50, precio: 350, imagen: "" }
                ];
                localStorage.setItem('inventario', JSON.stringify(productosIniciales));
            }

            const tablaCuerpo = document.getElementById('tabla-inventario-cuerpo'); 

            function renderizarInventario() {
                if (!tablaCuerpo) return;
                const inventario = JSON.parse(localStorage.getItem('inventario'));
                tablaCuerpo.innerHTML = "";

                inventario.forEach(prod => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td><img src="${prod.imagen || 'https://via.placeholder.com/50'}" alt="${prod.nombre}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                        <td>${prod.nombre}</td>
                        <td>$${prod.precio}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm input-stock" 
                                data-id="${prod.id}" value="${prod.stock}" style="width: 80px;">
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm btn-guardar" data-id="${prod.id}">Actualizar</button>
                        </td>
                    `;
                    tablaCuerpo.appendChild(fila);
                });

                document.querySelectorAll('.btn-guardar').forEach(boton => {
                    boton.addEventListener('click', (e) => {
                        const idProd = e.target.getAttribute('data-id');
                        const input = document.querySelector(`.input-stock[data-id="${idProd}"]`);
                        const nuevoStock = parseInt(input.value);

                        let inventarioActual = JSON.parse(localStorage.getItem('inventario'));
                        const index = inventarioActual.findIndex(p => p.id === idProd);
                        if (index !== -1) {
                            inventarioActual[index].stock = nuevoStock;
                            localStorage.setItem('inventario', JSON.stringify(inventarioActual));
                            alert(`¡Stock de ${inventarioActual[index].nombre} actualizado con éxito!`);
                        }
                    });
                });
            }

            renderizarInventario();
        });
    </script>
          
    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

</body>
</html>