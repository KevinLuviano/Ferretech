<!DOCTYPE html>
<html>
<head>
    <title>FerreTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/loginh.css">
</head>
<body>
    
    <div id="header-placeholder"></div>

    <div class="contenedor-login">
        
        <div class="caja-formulario">
            
            <h1 class="titulo-log">Inicio sesión Host :</h1>
            
            <form id="formulario-host" action="validar_login_host.php" method="POST">
                <table class="tabla-form"> 
                    <tr>
                        <td><label for="email" class="etiqueta">Correo electrónico*</label></td>
                        <td><input type="email" id="email" name="email" class="entrada-log" size="25" placeholder="correo@ferretech.com" required /></td>
                    </tr>
                    <tr>
                        <td><label for="contraseña" class="etiqueta">Contraseña*</label></td>
                        <td><input type="password" id="contraseña" name="contraseña" class="entrada-log" size="25" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="botones-box">
                         
                            <button type="submit" class="btn-iniciar" style="width: 100%; border: none; cursor: pointer;">Iniciar sesión</button>
                        </td>
                    </tr>
                </table>
            </form>

        </div>

    </div>

    <div id="footer-placeholder"></div>

</body>

    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formulario = document.getElementById("formulario-host");
        const inputEmail = document.getElementById("email");
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('error') === 'contrasena_incorrecta') {
            alert("Contraseña incorrecta para Host corporativo.");
        } else if (urlParams.get('error') === 'usuario_no_encontrado') {
            alert("El correo corporativo no está registrado.");
        }

        const dominioRequerido = "@ferretech.com"; 

        formulario.addEventListener("submit", (evento) => {
            const emailValue = inputEmail.value.trim();

            
            if (!emailValue.endsWith(dominioRequerido)) {
                evento.preventDefault(); 
                alert(`Acceso denegado: Solo se permiten correos corporativos autorizados (${dominioRequerido}).`);
                inputEmail.style.border = "2px solid #dc3545";
                setTimeout(() => inputEmail.style.border = "", 2000);
            }
        });
    });
</script>
</html>