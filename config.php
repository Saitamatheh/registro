<?php
$host = "localhost";  // Host de la base de datos
$dbname = "archivo_db";  // Nombre de tu base de datos
$username = "root";  // Usuario de la base de datos
$password = "";  // Contraseña de la base de datos

// Establecer conexión con la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error para PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
