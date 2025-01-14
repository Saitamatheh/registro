<?php
include 'config.php';  // Incluir archivo de conexión

// Obtener el ID del archivo a mostrar
$id = $_GET['id'] ?? null;

if ($id) {
    // Obtener el archivo desde la base de datos
    $query = "SELECT archivo, tipo_archivo FROM archivos WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        // Establecer el tipo de contenido adecuado
        header("Content-Type: " . $file['tipo_archivo']);
        echo $file['archivo'];  // Mostrar el archivo
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "ID no válido.";
}
?>
