<?php
require_once("connection.php");

// Consultar los elementos del carrusel ordenados desde el más reciente
$sql = "SELECT badge_promo, titulo, descripcion, url_imagen, categoria FROM Carrusel ORDER BY id_carrusel DESC";
$resultado = $conexion->query($sql);
?>

<div id="promoCarousel" class="carousel slide carrusel-promociones" data-bs-ride="carousel">
  
  <div class="carousel-indicators">
    <?php 
    if ($resultado && $resultado->num_rows > 0): 
        $i = 0;
        while ($row = $resultado->fetch_assoc()):
            $active = ($i === 0) ? 'class="active" aria-current="true"' : '';
            echo '<button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="' . $i . '" ' . $active . '></button>';
            $i++;
        endwhile;
        $resultado->data_seek(0); // Reiniciar el puntero para el loop principal
    endif; 
    ?>
  </div>

  <div class="carousel-inner">
    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <?php $active = true; ?>
        <?php while ($item = $resultado->fetch_assoc()): ?>
            <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
              <div class="contenedor-promocion">
                <div class="texto-promocion">
                  <span class="badge-promo"><?php echo htmlspecialchars($item['badge_promo']); ?></span>
                  <h2><?php echo htmlspecialchars($item['titulo']); ?></h2>
                  <p><?php echo htmlspecialchars($item['descripcion']); ?></p>
                  
                  <?php 
                    // Redirección dinámica según categoría
                    $link = (stristr($item['categoria'], 'Material')) ? "Categoria-Materiales.php" : "Categoria-Herramientas.php";
                  ?>
                  <a href="<?php echo $link; ?>" class="btn btn-accion">Ver <?php echo htmlspecialchars($item['categoria']); ?></a>
                </div>
                <div class="contenedor-imagen">
                  <img src="<?php echo htmlspecialchars($item['url_imagen']); ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>" class="imagen-producto">
                </div>
              </div> 
            </div>
            <?php $active = false; ?>
        <?php endwhile; ?>
    <?php else: ?>
        <!-- Vista por defecto si la base de datos no tiene items registrados aún -->
        <div class="carousel-item active">
          <div class="contenedor-promocion">
            <div class="texto-promocion">
              <span class="badge-promo">Mes de las Herramientas</span>
              <h2>Herramientas de Alta Calidad</h2>
              <p>Conoce nuestro catálogo oficial con las mejores ofertas.</p>
              <a href="Categoria-Herramientas.php" class="btn btn-accion">Ver catálogo</a>
            </div>
            <div class="contenedor-imagen">
              <img src="../img/pulidoraIndustrial.jpg" alt="Producto" class="imagen-producto">
            </div>
          </div>
        </div>
    <?php endif; ?>
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

<script>
    (() => {
      const inicializarMiCarrusel = () => {
        const miCarruselElemento = document.getElementById('promoCarousel');
        if (!miCarruselElemento) return;

        const miCarrusel = new bootstrap.Carousel(miCarruselElemento, {
          interval: 4000,
          wrap: true,
          pause: 'hover'
        });

        const botonesAccion = miCarruselElemento.querySelectorAll('.btn-accion');
        botonesAccion.forEach(boton => {
          boton.addEventListener('mouseenter', () => miCarrusel.pause());
          boton.addEventListener('mouseleave', () => miCarrusel.cycle());
        });
      };

      if (typeof bootstrap !== 'undefined') {
        inicializarMiCarrusel();
      } else {
        window.addEventListener('load', inicializarMiCarrusel);
      }
    })();
</script>