<?php
require 'conexion.php';

$query = "SELECT id, nombre_completo, edad, curp, corporacion, correo_electronico, telefono, foto FROM aspirantes";
$result = mysqli_query($conexion, $query);

$aspirantes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $aspirantes[] = $row;
}

echo json_encode($aspirantes);
?>