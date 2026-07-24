<?php
require_once("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["email"];
    $password = $_POST["contrasena"];


    $sql = "SELECT id_usuario, nombre, contraseña FROM Usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
   
        if (password_verify($password, $usuario["contraseña"])) {
        
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            
 
            header("Location: Index.php");
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
}
?>