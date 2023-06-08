<?php
// Incluir el archivo de configuración de la base de datos
require_once '../config/Conexion_db.php';


// Establecer la conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "hospital");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\style.css">
    <title>Gestion Pacientes</title>
</head>
<body>
    <header>
            <div class="header-content">
                <h1>Menu Gestion Pacientes</h1>
                <p>Bienvenido aqui podras gesionar a los Pacientes</p>
            </div>
            <div>
                <a href="Crear_Paciente.php">Crear Paciente</a>
            </div>
    </header>
    <div>
        <div class="sidebar"></div>
        <div class="sidebar_derecha"></div>
    </div>
    
</body>
</html>