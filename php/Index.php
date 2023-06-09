<?php
// Incluir el archivo de configuración de la base de datos
require_once '../config/Conexion_db.php';

// Establecer la conexión a la base de datos utilizando PDO
$dsn = "mysql:host=localhost;dbname=hospital";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
//query para rellenar la tabla de datos
$sql = "Select * from pacientes limit 10";
$stmt= $pdo->prepare($sql);

$stmt->execute();
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
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
        <form action="" method="POST">
            <table>
                <thead>
                    <th>id</th>
                    <th>sip</th>
                    <th>dni</th>
                    <th>nombre</th>
                    <th>apellido 1</th>
                    <th>apellido 2</th>
                    <th>telefono</th>
                    <th>sexo</th>
                    <th>fecha_nacimiento</th>
                    <th>localidad</th>
                    <th>calle</th>
                    <th>ED / EL</th>
                </thead>
                <?php
                while($row = $stmt->fetch()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['sip']."</td>";
                    echo "<td>".$row['dni']."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['apellido1']."</td>";
                    echo "<td>".$row['apellido2']."</td>";
                    echo "<td>".$row['telefono']."</td>";
                    echo "<td>".$row['sexo']."</td>";
                    echo "<td>".$row['fecha_nacimiento']."</td>";
                    echo "<td>".$row['localidad']."</td>";
                    echo "<td>".$row['calle']."</td>";
                    echo '<td><a href="editar.php?id='.$row['id'].'">Editar</a> | <a href="eliminar.php?id='.$row['id'].'">Eliminar</a></td>';
                    echo "</tr>";
                }
                ?>
            </table>
        </form>
        <div class="sidebar_derecha"></div>
    </div>
    
</body>
</html>