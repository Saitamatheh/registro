<?php
require 'config.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM aspirantes WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $aspirante = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aspirante) {
        echo "Aspirante no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}

// Aquí iría el formulario de edición con los datos cargados del aspirante
?>
