<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Pago</title>
     <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/carritocss.css">
</head>
<body>
    
		<div id="header-placeholder"></div>
           <div class="d-flex justify-content-center align-items-center mb-4 pb-2 border-bottom">
            <span class="paso-proceso">1. Carrito</span>
            <span class="mx-3 text-muted">➔</span>
            <span class="paso-proceso activo">2. Envío y Pago</span>
            <span class="mx-3 text-muted">➔</span>
            <span class="paso-proceso1">3. Confirmación</span>
        </div>
    <div class="principal">

      <div class="carrito">
            <div class="tabla-top">
                <div class="col articulo">Articulo</div>
                <div class="col cantidad">Cantidad</div>
                <div class="col precio">Precio</div>
            </div>


            <div id="contenedor-items"></div>
        </div>

        <div class="lateral">
            
            <div class="total-box">
                <h2 class="total-tit">Resumen</h2>
                <div class="time-row">
                    <span>Total a pagar</span>
                    <span>$ 300</span>
                </div>
            </div>
            
            <a href="checkout.html" button class="btn-sig">Siguiente</a>
            
        </div>

    </div>
    <div id="footer-placeholder"></div>
</body>

<script>
    fetch('header.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('header-placeholder').innerHTML = data;
    });
</script>

<script>
    fetch('footer.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('footer-placeholder').innerHTML = data;
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const contenedorItems = document.getElementById("contenedor-items");
        const totalPagarElemento = document.querySelector(".time-row span:last-child");

        // 1. Leer el carrito de localStorage
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // 2. Función para renderizar todos los productos del carrito
        function renderizarCarrito() {
            contenedorItems.innerHTML = ""; // Limpiamos pantalla anterior

            if (carrito.length === 0) {
                contenedorItems.innerHTML = `<p style="padding: 20px; text-align: center; color: #666;">Tu carrito está vacío.</p>`;
                totalPagarElemento.textContent = "$ 0";
                return;
            }

            let granTotal = 0;

            carrito.forEach((item, index) => {
                const subtotal = item.precio * item.cantidad;
                granTotal += subtotal;

                // Creamos el HTML de la tarjeta usando tus clases CSS originales
                const itemHTML = `
                    <div class="item" data-index="${index}">
                        <div class="prod-info">
                            <img src="${item.imagen}" alt="${item.titulo}" class="prod-img">
                            <span class="prod-txt">${item.titulo}</span>
                        </div>
                        
                        <div class="cant-box">
                            <button type="button" class="btn-c btn-menos">-</button>
                            <input type="text" class="cant-in" value="${item.cantidad}" readonly>
                            <button type="button" class="btn-c btn-mas">+</button>
                        </div>

                        <div class="prod-pre">$ ${subtotal}</div>
                    </div>
                `;
                contenedorItems.innerHTML += itemHTML;
            });

            
            totalPagarElemento.textContent = `$ ${granTotal}`;
            
            
            asignarEventosBotones();
        }

       
        function asignarEventosBotones() {
            const itemsHTML = document.querySelectorAll(".item");

            itemsHTML.forEach(itemElement => {
                const index = itemElement.getAttribute("data-index");
                const btnMenos = itemElement.querySelector(".btn-menos");
                const btnMas = itemElement.querySelector(".btn-mas");

              
                btnMas.addEventListener("click", () => {
                    carrito[index].cantidad++;
                    guardarYRenderizar();
                });

               
                btnMenos.addEventListener("click", () => {
                    if (carrito[index].cantidad > 1) {
                        carrito[index].cantidad--;
                        guardarYRenderizar();
                    } else {
                        const confirmar = confirm(`¿Deseas eliminar "${carrito[index].titulo}" de tu carrito?`);
                        if (confirmar) {
                            // Efecto visual de desvanecimiento
                            itemElement.style.opacity = "0";
                            itemElement.style.transition = "opacity 0.3s ease";
                            
                            setTimeout(() => {
                                carrito.splice(index, 1); // Lo borramos del arreglo
                                guardarYRenderizar();
                            }, 300);
                        }
                    }
                });
            });
        }

      
        function guardarYRenderizar() {
            localStorage.setItem('carrito', JSON.stringify(carrito));
            renderizarCarrito();
            
           
            totalPagarElemento.style.transform = "scale(1.08)";
            totalPagarElemento.style.transition = "transform 0.1s ease";
            setTimeout(() => {
                totalPagarElemento.style.transform = "scale(1)";
            }, 100);
        }

       
        renderizarCarrito();
    });
</script>
</html>