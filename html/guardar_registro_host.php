<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $apellido = trim($_POST["apellido"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $contrasena = $_POST["contrasena"] ?? '';
    $confirmar_contrasena = $_POST["confirmar_contraseña"] ?? '';
    $rol = 'host';

    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena) || empty($confirmar_contrasena)) {
        echo "<script>
                alert('Por favor, completa todos los campos.');
                window.history.back();
              </script>";
        exit();
    }

    if (!str_ends_with($email, '@ferretech.com')) {
        echo "<script>
                alert('El registro de Host solo está permitido con un correo corporativo (@ferretech.com).');
                window.history.back();
              </script>";
        exit();
    }

    if ($contrasena !== $confirmar_contrasena) {
        echo "<script>
                alert('Las contraseñas no coinciden.');
                window.history.back();
              </script>";
        exit();
    }

    $sql_check = "SELECT id_usuario FROM Usuarios WHERE correo = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('El correo electrónico ya se encuentra registrado.');
                window.history.back();
              </script>";
        $stmt_check->close();
        $conexion->close();
        exit();
    }
    $stmt_check->close();

    $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO Usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $nombre, $apellido, $email, $password_hash, $rol);

    if ($stmt_insert->execute()) {
        echo "<script>
                alert('¡Registro de Host exitoso! Bienvenido a panel admin.');
                window.location.href = 'PanelAdmi.php';
              </script>";
    } else {
        echo "<script>
                alert('Ocurrió un error al registrar la cuenta: " . addslashes($conexion->error) . "');
                window.history.back();
              </script>";
    }

    $stmt_insert->close();
    $conexion->close();
} else {
    header("Location: registro-host.php");
    exit();
}
?>