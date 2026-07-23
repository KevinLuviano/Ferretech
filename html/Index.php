<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FerreTech: La tienda de herramientas líder en México. Encuentra todo para tus proyectos de construcción y hogar.">

    <meta property="og:title" content="FerreTech | Herramientas de Alta Calidad">
    <meta property="og:image" content="">
    <title>FerreTech - Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../Css/inicio.css" rel="stylesheet">
    <link href="../Css/header.css" rel="stylesheet">
    <link href="../Css/footer.css" rel="stylesheet">
</head>
 
<body>
  
    <div id="header-placeholder"></div>

    <main class="container my-4">   
        <section class="text-center mb-5">
            <div id="contenedor-carrusel"></div>
        </section>

        <section> 
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="mb-3">🏠 Perfil</h2>
                    <p class="text-start perfil-texto">
                        FerreTech es un grupo de establecimientos de autoservicio especializados en productos ferreteros de alta calidad. Con nuestra amplia selección de herramientas, materiales de construcción y productos para el hogar, somos la tienda de herramientas líder en México. Nuestro compromiso es brindar a nuestros clientes un servicio excepcional y una experiencia de compra conveniente. Visítanos en línea o en nuestras sucursales locales para encontrar todo lo que necesitas para tus proyectos de construcción y reparación. ¡Confía en FerreTech para todas tus necesidades de ferretería!
                    </p>
                </div>

                <div class="col-md-6">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.661592351234!2d-99.168693!3d19.432607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzU3LjQiTiA5OcKwMTAnMDcuMyJX!5e0!3m2!1ses!2smx!4v1625000000000!5m2!1ses!2smx" 
                        width="100%" 
                        height="300" 
                        class="mapa-iframe"
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </section>
    </main>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
     
      
    

    // 3. Cargar Carrusel 
    fetch('carrusel.php')
        .then(response => {
            if (!response.ok) throw new Error("No se pudo cargar el archivo del carrusel");
            return response.text();
        })
        .then(html => {
            document.getElementById('contenedor-carrusel').innerHTML = html;
        })
        .catch(error => console.error('Error cargando el componente:', error));

    </script>

    
    <script src="../js/header-footer.js?v=2"></script>
          <script src="../js/agregar-carrito.js"></script>
</body>
</html>