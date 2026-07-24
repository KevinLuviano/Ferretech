<?php
session_start();
if (isset($_GET['cerrar_sesion'])) {
    session_destroy();
    exit(); 
}
?>

<header class="header">

    <div class="header-superior">

        <div class="logo-titulo">
            <img src="../img/logo.png" alt="Logo Ferretech" height="50">
            <h1>FERRETECH</h1>
        </div>

        <form class="buscador">
            <input type="search" placeholder="Buscar...">
        </form>

        <div class="carrito-usuario">

            <div class="menu">
                <img src="../img/login.png" alt="Usuario" height="30">
                <div class="enlaces-texto">
    <?php if (isset($_SESSION["nombre"])) { ?>
        
        <span>Hola, <?php echo $_SESSION["nombre"]; ?></span>
        &nbsp; | &nbsp;
        <a href="cerrar.php" id="btn-logout">Cerrar sesión</a>
        
    <?php } else { ?>
        
        <a href="login.php">Iniciar sesión</a> | <a href="Registro.php">Registrarse</a>
        
    <?php } ?>
</div>
            </div>

           <a href="carrito.php" class="menu" style="position: relative;">
                <img src="../img/carrito.png" alt="Carrito" height="30">
                <div>Carrito</div>
                <span id="contador-carrito" class="notificacion-carrito">0</span>
            </a>

        </div>

    </div>

    <nav class="header-inferior">
        <div class="nav">
            <a href="Index.php">Inicio</a>
        </div>

        <div class="separador"></div>

        <details class="categorias">
            <summary>Categorías ▼</summary>
            <ul class="dropdown">
                <li><a href="Categoria-Herramientas.php">Herramientas</a></li>
                <li><a href="Categoria-Materiales.php">Materiales de Fijación</a></li>
            </ul>
        </details>
    </nav>

</header>

