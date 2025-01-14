<?php
require 'config.php';  // Conexión a la base de datos
require 'fpdf186/fpdf.php';  // Librería para generar PDFs

// Verificamos que la librería se incluye correctamente generando un PDF de prueba
$pdf = new FPDF();
$pdf->AddPage();

// Establecer la fuente para el título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'Ficha de Pago - Sistema de Gestion de Aspirantes', 0, 1, 'C');

// Espacio
$pdf->Ln(10);

// Obtener los datos del estudiante desde la base de datos (Aquí puedes hacer una consulta con el ID del estudiante)
$id_estudiante = $_GET['id'];  // Asumiendo que pasas el id del estudiante por GET
$query = "SELECT * FROM aspirantes WHERE id = '$id_estudiante'";
$result = mysqli_query($conexion, $query);
$estudiante = mysqli_fetch_assoc($result);

// Mostrar los datos en el PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Nombre:', 0, 0);
$pdf->Cell(150, 10, $estudiante['nombre_completo'], 0, 1);

$pdf->Cell(50, 10, 'Edad:', 0, 0);
$pdf->Cell(150, 10, $estudiante['edad'], 0, 1);

$pdf->Cell(50, 10, 'CURP:', 0, 0);
$pdf->Cell(150, 10, $estudiante['curp'], 0, 1);

$pdf->Cell(50, 10, 'Corporacion:', 0, 0);
$pdf->Cell(150, 10, $estudiante['corporacion'], 0, 1);

$pdf->Cell(50, 10, 'Correo Electrónico:', 0, 0);
$pdf->Cell(150, 10, $estudiante['correo_electronico'], 0, 1);

$pdf->Cell(50, 10, 'Teléfono:', 0, 0);
$pdf->Cell(150, 10, $estudiante['telefono'], 0, 1);

// Espacio
$pdf->Ln(10);

// Detalle de pago
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(200, 10, 'Detalle de Pago', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Concepto', 1, 0, 'C');
$pdf->Cell(50, 10, 'Monto', 1, 1, 'C');

// Aquí puedes agregar una lógica para obtener los detalles de pago desde la base de datos, por ejemplo:
$pdf->Cell(50, 10, 'Inscripción', 1, 0, 'C');
$pdf->Cell(50, 10, '$1000', 1, 1, 'C');

// Puedes agregar más conceptos y montos si es necesario

// Resumen de pago
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Total a Pagar:', 0, 0);
$pdf->Cell(150, 10, '$1000', 0, 1);

// Guardar el PDF
$pdf->Output('I', 'Ficha_de_Pago_' . $estudiante['id'] . '.pdf'); // Muestra el PDF en el navegador

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos
    $nombre_completo = $_POST['nombre_completo'];
    $edad = $_POST['edad'];
    $curp = $_POST['curp'];
    $corporacion = $_POST['corporacion'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];

    // Validaciones en el servidor
    if (empty($nombre_completo) || empty($edad) || empty($curp) || empty($corporacion) || empty($correo_electronico) || empty($telefono)) {
        die("Todos los campos son obligatorios.");
    }

    if (!filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    if (!preg_match("/^[A-Z]{4}\d{6}[HM][A-Z]{5}\d{2}$/", $curp)) {
        die("CURP no válida.");
    }

    // Procesar la foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }

    // Insertar datos
    $query = "INSERT INTO aspirantes (nombre_completo, edad, curp, corporacion, correo_electronico, telefono, foto) 
              VALUES (:nombre_completo, :edad, :curp, :corporacion, :correo_electronico, :telefono, :foto)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':edad', $edad);
    $stmt->bindParam(':curp', $curp);
    $stmt->bindParam(':corporacion', $corporacion);
    $stmt->bindParam(':correo_electronico', $correo_electronico);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        // Generar el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Registro de Aspirante', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Nombre Completo: $nombre_completo", 0, 1);
        $pdf->Cell(0, 10, "Edad: $edad", 0, 1);
        $pdf->Cell(0, 10, "CURP: $curp", 0, 1);
        $pdf->Cell(0, 10, "Corporacion: $corporacion", 0, 1);
        $pdf->Cell(0, 10, "Correo Electronico: $correo_electronico", 0, 1);
        $pdf->Cell(0, 10, "Telefono: $telefono", 0, 1);

        $filename = "aspirante_" . time() . ".pdf";
        $pdf->Output("F", $filename);

        // Redirección a la página con el enlace de descarga
        header("Location: descargar_pdf.php?file=" . urlencode($filename));
        exit;
    } else {
        echo "Error al registrar al aspirante.";
    }
}
?>
