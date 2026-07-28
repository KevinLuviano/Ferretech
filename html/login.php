<?php
session_start();
// Si viene la variable 'redirect' por URL la guardamos; de lo contrario por defecto va a Index.php
$redirect = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : 'Index.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>FerreTech - Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    
   <div id="header-placeholder"></div>

    <div class="contenedor-login">
        
        <div class="caja-formulario">

            <!-- Alerta si fue derivado desde checkout -->
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'inicia_sesion_requerido'): ?>
                <div style="background-color: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                    🔒 Debes <strong>iniciar sesión</strong> para finalizar tu compra.
                </div>
            <?php endif; ?>
            
            <form id="formulario-login" action="validar_login.php" method="POST">
                <!-- CAMPO OCULTO CON LA RUTA DE DESTINO -->
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

                <table class="tabla-form"> 
                    <tr>
                        <td><label for="email" class="etiqueta">Correo electrónico*</label></td>
                        <td><input type="email" id="email" name="email" class="entrada-log" size="25" placeholder="correo@ferretech.com" required /></td>
                    </tr>
                    <tr>
                        <td><label for="contraseña" class="etiqueta">Contraseña*</label></td>
                        <td><input type="password" id="contraseña" name="contrasena" class="entrada-log" size="25" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="botones-box">
                            <input type="submit" value="Iniciar sesión" class="btn-iniciar"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; padding-top: 15px;">
                            <a href="login-host.php" class="enlace-host" style="color: #0056b3; text-decoration: none; font-size: 0.9rem;">¿Eres Host? Inicia sesión aquí</a>
                        </td>
                    </tr>
                </table>
            </form>

        </div>

    </div>

    <div id="footer-placeholder"></div>

    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formulario = document.getElementById("formulario-login");

        let intentosFallidos = 0;
        const maxIntentos = 3;

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'credenciales_incorrectas') {
            alert("Correo o contraseña incorrectos.");
        }

        formulario.addEventListener("submit", (evento) => {
            if (intentosFallidos >= maxIntentos) {
                evento.preventDefault();
                alert("Has superado el límite de intentos en pantalla.");
            }
        });
    });
</script>
</body>
</html>