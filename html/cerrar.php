<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["id_usuario"])) {

    $carrito_json = $_POST['carrito'];
    $id_usuario = $_SESSION["id_usuario"];
    
    $sql = "UPDATE Usuarios SET carrito_guardado = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $carrito_json, $id_usuario);
    $stmt->execute();
    $stmt->close();
}

session_unset();
session_destroy();
?>

<script>
    localStorage.removeItem('carrito');
    window.location.href = 'Index.php';
</script>
