<?php
require 'config.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el aspirante
    $query = "DELETE FROM aspirantes WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirige de nuevo a la lista de aspirantes
        exit;
    } else {
        echo "Error al eliminar el aspirante.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
