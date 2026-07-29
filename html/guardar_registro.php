<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $apellidos = trim($_POST["apellido"] ?? '');
    $correo = trim($_POST["email"] ?? '');
    $rol = 'cliente'; // Asignación explícita del rol cliente

    $password = password_hash($_POST["contrasena"] ?? '', PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO Usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellidos, $correo, $password, $rol);

        $stmt->execute();

        echo "<script>
                alert('¡Registro exitoso! Ya puedes iniciar sesión.');
                window.location.href = 'login.php';
              </script>";

        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        // Código 1062: Error de clave duplicada en MySQL (correo UNIQUE)
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
} else {
    header("Location: Registro.php");
    exit();
}
?>