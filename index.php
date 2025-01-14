<?php
require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Aspirantes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    background-color: #f8f9fa;
    color: #495057;
    line-height: 1.6;
    padding: 0;
    overflow-x: hidden;
}

/* Barra de navegación */
.navbar {
    background-color: #2c3e50;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    color: #ecf0f1 !important;
    font-weight: 600;
    letter-spacing: 1px;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    color: #3498db !important;
}

.navbar-nav .nav-link {
    color: #ecf0f1 !important;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #3498db !important;
}

/* Contenedor principal */
.container {
    max-width: 1200px;
    margin: 50px auto;
}

/* Título principal */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 40px;
}

/* Filtros */
#globalSearch, #corporacionFilter {
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

#globalSearch {
    border: 1px solid #ddd;
}

#corporacionFilter {
    border: 1px solid #ddd;
    background-color: #ffffff;
}

/* Contenedor de tabla */
.table-container {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1s ease-out;
    overflow-x: auto;
}

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

/* Estilo para la tabla */
.table {
    width: 100%;
    margin-bottom: 0;
    border-radius: 8px;
    border-collapse: collapse;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    table-layout: fixed; /* Para fijar el ancho de las columnas */
}

.table th {
    background-color: #34495e;
    color: #ecf0f1;
    text-transform: uppercase;
    font-weight: 600;
    word-wrap: break-word;
}

.table td {
    background-color: #ffffff;
    color: #7f8c8d;
    padding: 16px;
    font-size: 1rem;
    word-wrap: break-word;
}

.table-striped tbody tr:nth-child(odd) {
    background-color: #f4f6f7;
}

.table-hover tbody tr:hover {
    background-color: #ecf0f1;
    transition: background-color 0.3s ease;
}

/* Botones de acción */
.action-btn button {
    padding: 8px 16px;
    font-size: 0.9rem;
    border-radius: 5px;
    transition: all 0.3s ease;
    border: none;
}

.action-btn button:hover {
    transform: translateY(-3px);
}

/* Botones individuales */
.btn-warning {
    background-color: #f39c12;
    color: #ffffff;
}

.btn-warning:hover {
    background-color: #e67e22;
    transform: translateY(-3px);
}

.btn-danger {
    background-color: #e74c3c;
    color: #ffffff;
}

.btn-danger:hover {
    background-color: #c0392b;
    transform: translateY(-3px);
}

/* Modal de edición */
.modal-header {
    background-color: #2c3e50;
    color: #ffffff;
}

.modal-body {
    padding: 30px;
}

.form-label {
    font-weight: 500;
    color: #34495e;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced6e0;
    padding: 10px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-3px);
}

/* Estilo para el pie de página */
footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 15px 0;
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

/* Estilo para los filtros */
.filter-container {
    margin-bottom: 20px;
}

.filter-container input, .filter-container select {
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .container {
        margin: 20px;
    }

    h1 {
        font-size: 1.8rem;
    }

    .filter-container {
        flex-direction: column;
        align-items: flex-start;
    }

    #globalSearch, #corporacionFilter {
        width: 100%;
    }

    .table-container {
        overflow-x: auto;
    }
}

/* Animación de carga de la tabla */
@keyframes slideInUp {
    0% {
        transform: translateY(50px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.table-container {
    animation: slideInUp 0.8s ease-out;
}

/* Estilo de la tabla */
.table-container {
    max-height: 600px; /* Limita la altura */
    overflow-y: auto; /* Muestra la barra de desplazamiento si es necesario */
}

.table {
    table-layout: fixed;
    width: 100%;
}


    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Gestión de Aspirantes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    </div>

    <!-- Filtros avanzados -->
<div class="container mt-4">
    <h1 class="text-center">Lista de Aspirantes</h1>
    <!-- Filtros avanzados -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="globalSearch" class="form-control" placeholder="Buscar en toda la tabla">
        </div>
        <div class="col-md-4">
            <select id="corporacionFilter" class="form-control">
                <option value="">Filtrar por Corporación</option>
                <!-- Opciones dinámicas de corporación se llenarán con JS -->
            </select>
        </div>
    </div>
    <div class="table-container mt-4">
        <table id="aspirantesTable" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nombre Completo</th>
                    <th>Edad</th>
                    <th>CURP</th>
                    <th>Corporación</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="aspirantesBody">
                <!-- Filas generadas dinámicamente -->
            </tbody>
        </table>
    </div>
</div>



    <!-- Modal para editar aspirante -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Aspirante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre_completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edit_edad" name="edad" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_curp" class="form-label">CURP</label>
                            <input type="text" class="form-control" id="edit_curp" name="curp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_corporacion" class="form-label">Corporación</label>
                            <input type="text" class="form-control" id="edit_corporacion" name="corporacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="edit_correo" name="correo_electronico" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="edit_telefono" name="telefono" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Sistema de Gestión de Aspirantes. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            cargarAspirantes();

            $('#aspirantesTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            const editForm = document.getElementById("editForm");
            editForm.addEventListener("submit", function (e) {
                e.preventDefault();
                actualizarAspirante();
            });
        });

        function cargarAspirantes() {
            fetch("obtener_lista_aspirantes.php")
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById("aspirantesBody");
                    tbody.innerHTML = "";
                    data.forEach(aspirante => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${aspirante.id}</td>
                                <td><img src="${aspirante.foto}" alt="Foto de ${aspirante.nombre_completo}" width="50" height="50"></td>
                                <td>${aspirante.nombre_completo}</td>
                                <td>${aspirante.edad}</td>
                                <td>${aspirante.curp}</td>
                                <td>${aspirante.corporacion}</td>
                                <td>${aspirante.correo_electronico}</td>
                                <td>${aspirante.telefono}</td>
                                <td class="action-btn">
                                    <button class="btn btn-warning btn-sm" onclick="editarAspirante(${aspirante.id})">Editar</button>
                                    <button class="btn btn-danger btn-sm" onclick="eliminarAspirante(${aspirante.id})">Eliminar</button>
                                </td>
                            </tr>`;
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los aspirantes:', error);
                });
        }

        function editarAspirante(id) {
            fetch(`obtener_aspirante.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById("edit_id").value = data.id;
                        document.getElementById("edit_nombre").value = data.nombre_completo;
                        document.getElementById("edit_edad").value = data.edad;
                        document.getElementById("edit_curp").value = data.curp;
                        document.getElementById("edit_corporacion").value = data.corporacion;
                        document.getElementById("edit_correo").value = data.correo_electronico;
                        document.getElementById("edit_telefono").value = data.telefono;

                        const modal = new bootstrap.Modal(document.getElementById("editModal"));
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Error al editar aspirante:', error);
                    alert('Ocurrió un error al obtener los datos del aspirante.');
                });
        }

        function actualizarAspirante() {
            const formData = new FormData(document.getElementById("editForm"));
            fetch("actualizar_aspirante.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    cargarAspirantes();
                    const modal = bootstrap.Modal.getInstance(document.getElementById("editModal"));
                    modal.hide();
                })
                .catch(error => {
                    console.error('Error al actualizar aspirante:', error);
                    alert('Ocurrió un error al actualizar los datos del aspirante.');
                });
        }

        function eliminarAspirante(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este aspirante?")) {
                fetch(`eliminar_aspirante.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        cargarAspirantes();
                    })
                    .catch(error => {
                        console.error('Error al eliminar aspirante:', error);
                        alert('Ocurrió un error al eliminar el aspirante.');
                    });
            }
        }
    </script>
    <script>
    $(document).ready(function() {
    // Verificar si DataTable ya está inicializada
    if ($.fn.dataTable.isDataTable('#aspirantesTable')) {
        // Si ya está inicializada, destrúyela y vuelve a inicializarla
        $('#aspirantesTable').DataTable().clear().destroy();
    }

    // Inicialización de DataTable con búsqueda y filtros por columna
    var table = $('#aspirantesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        dom: 'lrtip', // Muestra solo la tabla sin el texto extra
        initComplete: function() {
            // Filtros de columna dinámicos
            this.api().columns().every(function() {
                var column = this;
                var input = $('<input type="text" class="form-control" placeholder="Buscar...">')
                    .appendTo($(column.header()).empty())
                    .on('keyup', function() {
                        column.search($(this).val()).draw();
                    });
            });
        },
    });

    // Agregar búsqueda global
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Filtro inteligente
    $('#corporacionFilter').on('change', function() {
        table.column(5).search(this.value).draw(); // Suponiendo que "Corporación" está en la columna 5
    });
});

$(document).ready(function() {
    // Verificar si DataTable ya está inicializada
    if ($.fn.dataTable.isDataTable('#aspirantesTable')) {
        // Si ya está inicializada, destrúyela y vuelve a inicializarla
        $('#aspirantesTable').DataTable().clear().destroy();
    }

    var table = $('#aspirantesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        dom: 'lrtip',
        initComplete: function() {
            // Crear un filtro por columna para cada columna de la tabla
            this.api().columns().every(function() {
                var column = this;
                var input = $('<input type="text" class="form-control" placeholder="Buscar...">')
                    .appendTo($(column.header()).empty())
                    .on('keyup', function() {
                        column.search($(this).val()).draw();
                    });
            });

            // Cargar las opciones para el filtro de Corporación
            cargarCorporaciones();
        },
    });

    // Búsqueda global
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Filtro por Corporación
    $('#corporacionFilter').on('change', function() {
        table.column(5).search(this.value).draw(); // Suponiendo que "Corporación" está en la columna 5
    });
});

// Cargar las opciones de Corporación dinámicamente
function cargarCorporaciones() {
    fetch('obtener_corporaciones.php') // Suponiendo que tienes este archivo para obtener las corporaciones
        .then(response => response.json())
        .then(data => {
            const corporacionFilter = document.getElementById('corporacionFilter');
            data.forEach(corporacion => {
                const option = document.createElement('option');
                option.value = corporacion.nombre;
                option.textContent = corporacion.nombre;
                corporacionFilter.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar las corporaciones:', error);
        });
}




</script>
</body>

</html>
