<!DOCTYPE html>
<html>
<head>
    <title>FerreTech - Login Host</title>
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
                        <td><label for="email_usuario" class="etiqueta">Correo electrónico*</label></td>
                        <td>
                            <div class="entrada-correo-box">
                                <input type="text" id="email_usuario" class="entrada-log" size="25" placeholder="correo" required />
                                <span class="sufijo-dominio">@ferretech.com</span>
                            </div>
                            <input type="hidden" id="email" name="email" />
                        </td>
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

    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const formulario = document.getElementById("formulario-host");
            const inputEmailUsuario = document.getElementById("email_usuario");
            const inputEmailOculto = document.getElementById("email");

            formulario.addEventListener("submit", (evento) => {
                let usuarioLimpio = inputEmailUsuario.value.trim().replace(/@.*$/, '');

                if (!usuarioLimpio) {
                    evento.preventDefault();
                    alert("Por favor, ingresa tu usuario de correo corporativo.");
                    inputEmailUsuario.focus();
                    return;
                }

                inputEmailOculto.value = usuarioLimpio + "@ferretech.com";
            });

            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.get('error') === 'contrasena_incorrecta') {
                alert("Contraseña incorrecta para Host corporativo.");
            } else if (urlParams.get('error') === 'usuario_no_encontrado') {
                alert("El correo corporativo no está registrado o no tiene el rol de Host.");
            } else if (urlParams.get('error') === 'campos_vacios') {
                alert("Por favor, completa todos los campos.");
            }
        });
    </script>
</body>
</html>