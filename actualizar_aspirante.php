<?php
require 'conexion.php';

$id = intval($_POST['id']);
$nombre = $_POST['nombre_completo'];
$edad = intval($_POST['edad']);
$curp = $_POST['curp'];
$corporacion = $_POST['corporacion'];
$correo = $_POST['correo_electronico'];
$telefono = $_POST['telefono'];

$query = "UPDATE aspirantes SET 
    nombre_completo = '$nombre', 
    edad = $edad, 
    curp = '$curp', 
    corporacion = '$corporacion', 
    correo_electronico = '$correo', 
    telefono = '$telefono' 
    WHERE id = $id";

if (mysqli_query($conexion, $query)) {
    echo "Aspirante actualizado correctamente";
} else {
    echo "Error al actualizar el aspirante";
}

mysqli_close($conexion);
?>
