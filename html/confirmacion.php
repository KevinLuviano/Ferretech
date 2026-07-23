<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: Confirmación de pago exitoso.">
    <title>FerreTech - Pago Exitoso</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../Css/confirmacion.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
</head>
 
<body>
  
    <div id="header-placeholder"></div>

    <main class="container my-4">
        
        <nav class="text-center text-muted my-4">
            <small>1. Carrito &nbsp;➔&nbsp; 2. Envío y Pago &nbsp;➔&nbsp; <strong class="text-dark">3. Confirmación</strong></small>
        </nav>

        

                <div class="card shadow-sm p-4 text-center">
            <h4 class="text-success fw-bold">¡Gracias por tu compra!</h4>
            <p class="text-muted">Hemos recibido tu pedido correctamente.</p>
            
            <div class="my-4 p-3 bg-light rounded text-start">
                <p class="mb-2"><strong>Número de Pedido:</strong> <span id="num-pedido" class="text-primary fw-bold">Cargando...</span></p>
                <p class="mb-2"><strong>Cliente:</strong> <span id="nombre-cliente">Cargando...</span></p>
                <p class="mb-2"><strong>Fecha de Compra:</strong> <span id="fecha-compra">Cargando...</span></p>
                <p class="mb-2"><strong>Método de Pago:</strong> <span id="metodo-pago">Cargando...</span></p>
                <hr>
                <h5 class="mb-0 d-flex justify-content-between fw-bold">
                    <span>Total Pagado:</span>
                    <span id="total-pago" class="text-success">$0.00</span>
                </h5>
            </div>
            
            <a href="inicio.php" class="btn btn-primary w-100 py-2 fw-bold">Volver a la Tienda</a>
        </div>

                </section>
            </main>

            <div id="footer-placeholder"></div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
       
                        
            document.addEventListener("DOMContentLoaded", () => {
                // 1. Leemos la información que guardó la página de checkout
                const ultimaCompra = JSON.parse(localStorage.getItem('ultimaCompra'));

                if (ultimaCompra) {
                    // 2. Localizamos las etiquetas correspondientes en el HTML
                    const elPedido = document.getElementById('num-pedido');
                    const elCliente = document.getElementById('nombre-cliente');
                    const elFecha = document.getElementById('fecha-compra');
                    const elTotal = document.getElementById('total-pago');
                    const elMetodo = document.getElementById('metodo-pago');

                    // 3. Reemplazamos el contenido con los datos dinámicos
                    if (elPedido) elPedido.textContent = ultimaCompra.idPedido;
                    if (elCliente) elCliente.textContent = ultimaCompra.cliente;
                    if (elFecha) elFecha.textContent = ultimaCompra.fecha;
                    if (elMetodo) elMetodo.textContent = ultimaCompra.metodo;
                    if (elTotal) elTotal.textContent = `$${ultimaCompra.total.toFixed(2)} MXN`;
                } else {
                    // Si entran directo a confirmacion.html sin haber hecho checkout antes
                    const tarjeta = document.querySelector('.card');
                    if (tarjeta) {
                        tarjeta.innerHTML = `
                            <h4 class="text-danger fw-bold">No se encontró información de compra</h4>
                            <p class="text-muted">Por favor, realiza tu pedido primero en el Checkout.</p>
                            <a href="checkout.html" class="btn btn-warning w-100 mt-3 py-2 fw-bold">Ir al Checkout</a>
                        `;
                    }
                }
            });

    </script>
    
          
          <script src="../js/header-footer.js?v=2"></script>
          <script src="../js/agregar-carrito.js"></script>
</body>
</html>