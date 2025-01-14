<?php
require 'config.php'; // Conexión a la base de datos

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Obtiene los datos del formulario
        $nombreCompleto = $_POST['nombre_completo'];
        $edad = $_POST['edad'];
        $curp = $_POST['curp'];
        $corporacion = $_POST['corporacion'];
        $correoElectronico = $_POST['correo_electronico'];
        $telefono = $_POST['telefono'];

        // Manejo del archivo de la foto
        $fotoRuta = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoNombre = $_FILES['foto']['name'];
            $fotoTmp = $_FILES['foto']['tmp_name'];
            $fotoExt = pathinfo($fotoNombre, PATHINFO_EXTENSION);
            
            // Validación de la extensión de la foto
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($fotoExt), $extensionesPermitidas)) {
                throw new Exception('Solo se permiten imágenes JPG, JPEG, PNG o GIF.');
            }
            
            $fotoNuevoNombre = uniqid() . '.' . $fotoExt; // Genera un nombre único para evitar colisiones
            $fotoRuta = 'uploads/' . $fotoNuevoNombre; // Ruta donde se almacenará la foto

            // Mueve el archivo a la carpeta 'uploads'
            if (!move_uploaded_file($fotoTmp, $fotoRuta)) {
                throw new Exception('Error al cargar la foto');
            }
        }

        // Inserta los datos en la base de datos
        $query = "INSERT INTO aspirantes (nombre_completo, edad, curp, corporacion, correo_electronico, telefono, foto)
                  VALUES (:nombre_completo, :edad, :curp, :corporacion, :correo_electronico, :telefono, :foto)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nombre_completo', $nombreCompleto, PDO::PARAM_STR);
        $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
        $stmt->bindParam(':curp', $curp, PDO::PARAM_STR);
        $stmt->bindParam(':corporacion', $corporacion, PDO::PARAM_STR);
        $stmt->bindParam(':correo_electronico', $correoElectronico, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':foto', $fotoRuta, PDO::PARAM_STR); // Guardar la ruta de la foto en la base de datos

        $stmt->execute();

        // Redirige al dashboard o a una página de éxito
        header("Location: guardar_aspirante.php");
        exit();
    } catch (Exception $e) {
        // Manejo de errores
        echo "Error al registrar los datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Aspirantes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Reset general para tener un control completo */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Cuerpo de la página */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f9;
    color: #4e5d6b;
    line-height: 1.6;
    padding: 0;
    overflow-x: hidden;
}

/* Barra de navegación */
.navbar {
    background-color: #1f2937;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    color: #f1f5f9 !important;
    font-weight: 600;
    letter-spacing: 1px;
    font-size: 1.6rem;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    color: #3b82f6 !important;
}

.navbar-nav .nav-link {
    color: #f1f5f9 !important;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #3b82f6 !important;
}

/* Contenedor principal */
.container {
    max-width: 800px;
    margin: 60px auto;
}

/* Título principal */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 40px;
}

/* Estilo del formulario de registro */
.form-container {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1s ease-out;
}

/* Animación de fadeIn */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Estilos de los campos de formulario */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    font-weight: 600;
    color: #4b5563;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 12px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.3);
}

/* Botón de submit */
.btn-primary {
    background-color: #3b82f6;
    border-color: #3b82f6;
    font-size: 1.1rem;
    padding: 14px 22px;
    width: 100%;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
    transform: translateY(-3px);
}

/* Pie de página */
footer {
    background-color: #1f2937;
    color: #f1f5f9;
    padding: 20px 0;
    text-align: center;
    font-size: 1rem;
    margin-top: 50px;
    position: fixed;
    width: 100%;
    bottom: 0;
}

footer p {
    margin: 0;
}

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Gestión de Aspirantes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Registro de Aspirantes</h1>
        <form method="POST" enctype="multipart/form-data" action="registro.php">
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Escribe tu nombre completo" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" placeholder="Ejemplo: 25" required>
            </div>
            <div class="mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" class="form-control" id="curp" name="curp" placeholder="Ejemplo: ABCD123456HDFRRL01" required>
            </div>
            <div class="mb-3">
                <label for="corporacion" class="form-label">Corporación</label>
                <input type="text" class="form-control" id="corporacion" name="corporacion" placeholder="Escribe la corporación" required>
            </div>
            <div class="mb-3">
                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ejemplo: 5512345678" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto del Aspirante</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
