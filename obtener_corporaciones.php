<?php
require 'conexion.php';

// Obtener las corporaciones desde la base de datos
$query = "SELECT DISTINCT corporacion FROM aspirantes";
$result = mysqli_query($conn, $query);

$corporaciones = [];
while ($row = mysqli_fetch_assoc($result)) {
    $corporaciones[] = $row;
}

// Devolver las corporaciones en formato JSON
echo json_encode($corporaciones);
?>
