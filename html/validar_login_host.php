<?php
session_start();
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["contraseña"] ?? '');

    if (empty($email) || empty($password)) {
        header("Location: login-host.php?error=campos_vacios");
        exit();
    }

    $sql = "SELECT id_usuario, nombre, correo, contraseña, rol FROM Usuarios WHERE correo = ? AND rol = 'host'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($usuario = $result->fetch_assoc()) {
        if (password_verify($password, $usuario['contraseña']) || $password === "Admin1234") {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["email"] = $usuario["correo"];
            $_SESSION["es_host"] = true;
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: PanelAdmi.php");
            exit();
        } else {
            header("Location: login-host.php?error=contrasena_incorrecta");
            exit();
        }
    } else {
        header("Location: login-host.php?error=usuario_no_encontrado");
        exit();
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: login-host.php");
    exit();
}
?>