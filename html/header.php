<?php
session_start();
?>

<header class="header">

    <div class="header-superior">

        <div class="logo-titulo">
            <img src="../img/logo.png" alt="Logo Ferretech" height="50">
            <h1>FERRETECH</h1>
        </div>

        <form class="buscador" action="buscador.php" method="GET">
         <input type="search" name="q" placeholder="Buscar..." required>
        </form>

        <div class="carrito-usuario">

            <div class="menu">
                <img src="../img/login.png" alt="Usuario" height="30">
                <div class="enlaces-texto">
    <?php if (isset($_SESSION["nombre"])) { ?>
        
        <span>Hola, <?php echo $_SESSION["nombre"]; ?></span>
        &nbsp; | &nbsp;

        <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === 'host') { ?>
            <a href="PanelAdmi.php" ">Panel Admin</a>
            &nbsp; | &nbsp;
        <?php } ?>

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
                <?php

                include_once("connection.php"); 

                if (isset($conexion)) {
                    $sql_cat = "SELECT id_categoria, nombre_categoria FROM Categorias";
                    $result_cat = mysqli_query($conexion, $sql_cat);

                    if ($result_cat && mysqli_num_rows($result_cat) > 0) {
                        while ($cat = mysqli_fetch_assoc($result_cat)) {
                            echo '<li><a href="categoria.php?id=' . $cat['id_categoria'] . '">' . htmlspecialchars($cat['nombre_categoria']) . '</a></li>';
                        }
                    } else {
                        echo '<li><a href="#">Sin categorías</a></li>';
                    }
                } else {
                    echo '<li><a href="#" >Falta variable $conexion</a></li>';
                }
                ?>
            </ul>
        </details>
    </nav>

</header>

