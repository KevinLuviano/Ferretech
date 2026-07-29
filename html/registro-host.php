<!DOCTYPE html>
<html>
<head>
    <title>FerreTech - Registro Host</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Tu archivo CSS con el nombre que querías -->
    <link rel="stylesheet" href="../css/registroh.css">
</head>
<body>
    
    <div id="header-placeholder"></div>

    <div class="contenedor-registro">
        <div class="caja-formulario">
            <h1 class="titulo-reg">Registro Host Corporativo:</h1>
            
            <form id="formulario-registro-host" action="guardar_registro_host.php" method="POST">
                <table class="tabla-form"> 
                    <tr>
                        <td><label for="nombre" class="etiqueta">Nombre*</label></td>
                        <td><input type="text" id="nombre" name="nombre" class="entrada-reg" size="25" pattern="[A-Za-z\s]*" title="solo letras" placeholder="Raul" required /></td>
                    </tr>
                    <tr>
                        <td><label for="apellido" class="etiqueta">Apellido*</label></td>
                        <td><input type="text" id="apellido" name="apellido" class="entrada-reg" size="25" pattern="[A-Za-z\s]*" title="solo letras" placeholder="Moreno Altamirano" required /></td>
                    </tr>
                    <tr>
                        <td><label for="email" class="etiqueta">Correo Corporativo*</label></td>
                        <td><input type="email" id="email" name="email" class="entrada-reg" size="25" placeholder="usuario@ferretech.com" required /></td>
                    </tr>
                    <tr>
                        <td><label for="contraseña" class="etiqueta">Contraseña*</label></td>
                        <td><input type="password" id="contraseña" name="contrasena" class="entrada-reg" size="25" required /></td>
                    </tr>
                    <tr>
                        <td><label for="confirmar_contraseña" class="etiqueta">Confirmar Contraseña*</label></td>
                        <td><input type="password" id="confirmar_contraseña" name="confirmar_contraseña" class="entrada-reg" size="25" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="botones-box">
                            <input type="reset" value="limpiar datos" class="btn-limpiar"/>
                            <input type="submit" value="Registrar Host" class="btn-registrar"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; padding-top: 15px;">
                            <a href="login-host.php" class="enlace-host">¿Ya tienes cuenta de Host? Inicia sesión aquí</a>
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
            const formulario = document.getElementById("formulario-registro-host");
            const inputEmail = document.getElementById("email");
            const inputPass = document.getElementById("contraseña");
            const inputConfirmPass = document.getElementById("confirmar_contraseña");
            const dominioRequerido = "@ferretech.com";

            inputConfirmPass.addEventListener("input", () => {
                if (inputPass.value !== inputConfirmPass.value) {
                    inputConfirmPass.style.border = "2px solid #dc3545";
                } else {
                    inputConfirmPass.style.border = "2px solid #28a745";
                }
            });

            formulario.addEventListener("reset", () => {
                inputConfirmPass.style.border = "";
                inputPass.style.border = "";
                inputEmail.style.border = "";
            });

            formulario.addEventListener("submit", (evento) => {
                const emailValue = inputEmail.value.trim();
                const passValue = inputPass.value;
                const confirmValue = inputConfirmPass.value;
                const regexSeguridad = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

                if (!emailValue.endsWith(dominioRequerido)) {
                    evento.preventDefault();
                    alert(`Acceso denegado: Solo se permite registro con correo corporativo (${dominioRequerido}).`);
                    inputEmail.style.border = "2px solid #dc3545";
                    inputEmail.focus();
                    return;
                }

                if (!regexSeguridad.test(passValue)) {
                    evento.preventDefault();
                    alert("La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.");
                    inputPass.focus();
                    return;
                }

                if (passValue !== confirmValue) {
                    evento.preventDefault();
                    alert("Las contraseñas no coinciden. Por favor, verifícalas.");
                    inputConfirmPass.focus();
                    return;
                }
            });
        });
    </script>
</body>
</html>