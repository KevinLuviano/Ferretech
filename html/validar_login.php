<?php
require_once("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["email"];
    $password = $_POST["contrasena"];
    
    // Capturar la ruta de redirección enviada desde el formulario
    $redirect = !empty($_POST["redirect"]) ? $_POST["redirect"] : 'Index.php';

    $sql = "SELECT id_usuario, nombre, contraseña, carrito_guardado FROM Usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($password, $usuario["contraseña"])) {
        
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];

            $carrito_bd = !empty($usuario["carrito_guardado"]) ? $usuario["carrito_guardado"] : '[]';

            // Redirección dinámica basada en la variable $redirect
            echo "<script>
                    localStorage.setItem('carrito', '" . addslashes($carrito_bd) . "');
                    window.location.href = '" . $redirect . "';
                  </script>";
            exit();
   
        } else {
            echo "<script>
                    alert('Contraseña incorrecta.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('El correo electrónico no está registrado.');
                window.location.href = 'login.php';
              </script>";
    }

    $stmt->close();
    $conexion->close();

?>