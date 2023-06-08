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
    <link rel="stylesheet" href="/css/Style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <h1>Menu Gestion Pacientes</h1>
        </div>
        <div>
            <h3>Bienvenido administrador aqui podras gesionar a los Pacientes</h3>
        </div>
    </header>
</body>
</html>