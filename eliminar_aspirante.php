<?php
require 'conexion.php';

$id = intval($_GET['id']);
$query = "DELETE FROM aspirantes WHERE id = $id";

if (mysqli_query($conexion, $query)) {
    echo "Aspirante eliminado correctamente";
} else {
    echo "Error al eliminar el aspirante";
}

mysqli_close($conexion);
?>
