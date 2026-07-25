<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellido"];
    $correo = $_POST["email"];

    $password = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO Usuarios (nombre, apellidos, correo, contraseña) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellidos, $correo, $password);

        $stmt->execute();

        echo "<script>
                alert('¡Registro exitoso! Ya puedes iniciar sesión.');
                window.location.href = 'login.php';
              </script>";

        $stmt->close();

    } catch (mysqli_sql_exception $e) {
    
        if ($e->getCode() === 1062) {
            echo "<script>
                    alert('El correo electrónico ya está registrado. Por favor intenta con otro.');
                    window.location.href = 'Registro.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar el usuario: " . addslashes($e->getMessage()) . "');
                    window.location.href = 'Registro.php';
                  </script>";
        }
    }

    $conexion->close();
}
?>