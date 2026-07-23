<!DOCTYPE html>
<html>
<head>
    <title>FerreTech</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/registrocss.css">
</head>
<body>
    
    <div id="header-placeholder"></div>

    <div class="contenedor-registro">
        
        <div class="caja-formulario">
            
            <h1 class="titulo-reg">Crear cuenta :</h1>
            
            <form id="formulario-registro">
                <table class="tabla-form"> 
                    <tr>
                        <td><label for="nombre" class="etiqueta">Nombre*</label></td>
                        <td><input type="text" id="nombre" name="nombre" class="entrada-reg" size="25" pattern="[A-Za-z\s]*" title="solo letras" placeholder="Elizabeth " required /></td>
                    </tr>
                    <tr>
                        <td><label for="apellido" class="etiqueta">Apellido*</label></td>
                        <td><input type="text" id="apellido" name="apellido" class="entrada-reg" size="25" pattern="[A-Za-z\s]*" title="solo letras" placeholder="Luviano ventura" required /></td>
                    </tr>
                    <tr>
                        <td><label for="email" class="etiqueta">Correo electrónico*</label></td>
                        <td><input type="email" id="email" name="email" class="entrada-reg" size="25" placeholder="correo@ferretech.com" required /></td>
                    </tr>
                    <tr>
                        <td><label for="contraseña" class="etiqueta">Contraseña*</label></td>
                        <td><input type="password" id="contraseña" name="contraseña" class="entrada-reg" size="25" required /></td>
                    </tr>
                    <tr>
                        <td><label for="confirmar_contraseña" class="etiqueta">Confirmar Contraseña*</label></td>
                        <td><input type="password" id="confirmar_contraseña" name="confirmar_contraseña" class="entrada-reg" size="25" required /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="botones-box">
                            <input type="reset" value="limpiar datos" class="btn-limpiar"/>
                            <input type="submit" value="Registrarse" class="btn-registrar"/>
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
        const formulario = document.getElementById("formulario-registro");
        const inputPass = document.getElementById("contraseña");
        const inputConfirmPass = document.getElementById("confirmar_contraseña");

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
        });

        formulario.addEventListener("submit", (evento) => {
            evento.preventDefault();

            const passValue = inputPass.value;
            const confirmValue = inputConfirmPass.value;
            const regexSeguridad = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (!regexSeguridad.test(passValue)) {
                alert("La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.");
                inputPass.focus();
                return;
            }

            if (passValue !== confirmValue) {
                alert("Las contraseñas no coinciden. Por favor, verifícalas.");
                inputConfirmPass.focus();
                return;
            }

            alert("¡Registro exitoso! Tu cuenta ha sido creada.");
            formulario.submit();
        });
    });
</script>
</html>