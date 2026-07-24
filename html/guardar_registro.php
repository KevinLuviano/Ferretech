<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellido"];
    $correo = $_POST["email"];

    $password = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);


    $sql = "INSERT INTO Usuarios (nombre, apellidos, correo, contraseña) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellidos, $correo, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('¡Registro exitoso! Ya puedes iniciar sesión.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar el usuario. Es posible que el correo ya esté registrado.');
                window.location.href = 'Registro.php';
              </script>";
    }

    $stmt->close();
    $conexion->close();
}
?>