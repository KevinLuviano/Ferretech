<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: Finaliza tu compra de herramientas de forma segura.">
    <title>FerreTech - Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../Css/checkout.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
    
    <link href="../Css/carrusel.css" rel="stylesheet">
</head>
<body>

    <div id="promoCarousel" class="carousel slide carrusel-promociones" data-bs-ride="carousel">
      
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2"></button>
      </div>

      <div class="carousel-inner">
        
        
        <div class="carousel-item active">
          <div class="contenedor-promocion">
            <div class="texto-promocion">
              <span class="badge-promo">Mes de las Herramientas Eléctricas</span>
              <h2>Pulidoras Truper<br>de la mejor calidad</h2>
              <p>Potencia industrial de 1200W para acabados perfectos. Incluye garantía oficial .</p>
              <!-- Enlace y texto modificados -->
              <a href="Categoria-herramientas.php" class="btn btn-accion">Ver catálogo</a>
            </div>
            <div class="contenedor-imagen">
              <img src="../img/pulidoraIndustrial.jpg" alt="Pulidora Industrial" class="imagen-producto" height="200px" width="200px">
              <img src="../img/pulidoraRotativa.jpg" alt="pulidora rotativa" class="imagen-producto" height="200px" width="200px">
            </div>
          </div> 
        </div>

        
        <div class="carousel-item">
          <div class="contenedor-promocion">
            <div class="texto-promocion">
              <span class="badge-promo">Fijación Profesional</span>
              <h2>Sujeción Absoluta<br>Precios de Mayoreo</h2>
              <p>Todo en tornillería de alta resistencia, taquetes y sistemas de fijación para concreto y metal.</p>
              
              <a href="Categoria-Materiales.php" class="btn btn-accion">Ver materiales</a>
            </div>
            <div class="contenedor-imagen">
              <img src="../img/sistemadetornillos.jpg" class="imagen-producto" alt="Sistemas de fijación Truper" height="300px" width="350px">
            </div>
          </div>
        </div>

        
        <div class="carousel-item">
          <div class="contenedor-promocion">
            <div class="texto-promocion">
              <span class="badge-promo">Combo Imperdible</span>
              <h2>Rotomartillo 1/2"<br>+ Kit de Brocas </h2>
              <p>Equípate con el potente motor de 650W sobre baleros de bolas. Ideal para concreto, acero y madera.</p>
              
              <a href="Categoria-herramientas.php" class="btn btn-accion">Ver catálogo</a>
            </div>
            <div class="contenedor-imagen">
              <img src="../img/rotomartillo.png" class="imagen-producto" alt="Rotomartillo Truper Profesional" height="300px" width="350px">
            </div>
          </div>
        </div>

      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

    
  


    <script>
    // Usamos una función autoejecutable para aislar las variables y que no choquen con otros scripts
    (() => {
      const inicializarMiCarrusel = () => {
        const miCarruselElemento = document.getElementById('promoCarousel');
        if (!miCarruselElemento) return;

        // 1. Inicializamos el carrusel mediante JS
        const miCarrusel = new bootstrap.Carousel(miCarruselElemento, {
          interval: 4000,
          wrap: true,
          pause: 'hover'
        });

        // 2. Aplicamos el efecto a los botones una vez que están renderizados
        const botonesAccion = miCarruselElemento.querySelectorAll('.btn-accion');
        botonesAccion.forEach(boton => {
          boton.addEventListener('mouseenter', () => miCarrusel.pause());
          boton.addEventListener('mouseleave', () => miCarrusel.cycle());
        });
      };

      // Si Bootstrap ya está cargado, lo ejecutamos inmediatamente
      if (typeof bootstrap !== 'undefined') {
        inicializarMiCarrusel();
      } else {
        
        window.addEventListener('load', inicializarMiCarrusel);
      }
    })();
  </script>
</body>
</body>
</html>