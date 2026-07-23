<?php
$servidor = "localhost";
$usuario =  "root";
$password = "";
$base_datos = "ferretech_db";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);
 
if ($conexion -> connect_error) {
    die("Error de conexion" . $conexion->connect_error);
}
echo "conexion exitosa";
?>