<!DOCTYPE html>
<html>
<head>
    <title>FerreTech</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    
   <div id="header-placeholder"></div>

    <div class="contenedor-login">
        
        <div class="caja-formulario">
            
            <h1 class="titulo-log">Iniciar sesión :</h1>
            
            <form id="formulario-login">
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

</body>
 
    <script src="../js/header-footer.js?v=2"></script>
    <script src="../js/agregar-carrito.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formulario = document.getElementById("formulario-login");
        const inputEmail = document.getElementById("email");
        const inputPassword = document.getElementById("contraseña");
        const btnIniciar = document.querySelector(".btn-iniciar");

        let intentosFallidos = 0;
        const maxIntentos = 3;

        formulario.addEventListener("submit", (evento) => {
            evento.preventDefault(); 

            const emailValue = inputEmail.value.trim();
            const passwordValue = inputPassword.value.trim();

           
            if (emailValue === "prueba@ferretech.com" && passwordValue === "Ferretech123") {
                alert("¡Ingreso exitoso! Bienvenido a FerreTech.");
                intentosFallidos = 0;
                formulario.submit(); 
            } else {
                intentosFallidos++;
                
               
                inputPassword.style.border = "2px solid #dc3545";
                inputEmail.style.border = "2px solid #dc3545";
                setTimeout(() => {
                    inputPassword.style.border = "";
                    inputEmail.style.border = "";
                }, 2000);

               
                if (intentosFallidos >= maxIntentos) {
                    let tiempoBloqueo = 15; 
                    btnIniciar.disabled = true;
                    btnIniciar.style.backgroundColor = "#6c757d"; 
                    btnIniciar.style.cursor = "not-allowed";

                    const cuentaRegresiva = setInterval(() => {
                        btnIniciar.value = `Bloqueado (${tiempoBloqueo}s)`;
                        tiempoBloqueo--;

                        if (tiempoBloqueo < 0) {
                            clearInterval(cuentaRegresiva);
                            btnIniciar.disabled = false;
                            btnIniciar.value = "Iniciar sesión";
                            btnIniciar.style.backgroundColor = "";
                            btnIniciar.style.cursor = "pointer";
                            intentosFallidos = 0; 
                        }
                    }, 1000);

                    alert("Has superado el límite de intentos. Botón bloqueado por seguridad.");
                } else {
                    alert(`Credenciales incorrectas. Te quedan ${maxIntentos - intentosFallidos} intentos.`);
                }
            }
        });
    });
</script>
</html>