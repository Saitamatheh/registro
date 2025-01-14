<?php
header('Content-Type: application/json');
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM aspirantes WHERE id = $id";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $aspirante = mysqli_fetch_assoc($result);
        if ($aspirante) {
            echo json_encode($aspirante);
        } else {
            echo json_encode(["error" => "Aspirante no encontrado"]);
        }
    } else {
        echo json_encode(["error" => "Error en la consulta: " . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}

mysqli_close($conexion);
?>
