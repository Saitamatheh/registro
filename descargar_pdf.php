<?php

if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    if (file_exists($file)) {
        echo "<h1>Registro Completado</h1>";
        echo "<p>Haga clic en el enlace para descargar el PDF:</p>";
        echo "<a href='$file' download>Descargar PDF</a>";
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "No se especificó ningún archivo.";
}
?>
