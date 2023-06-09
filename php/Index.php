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
    
    // Asignar el valor de $limit
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

    // Query para rellenar la tabla de datos
    $sql = "SELECT * FROM pacientes WHERE true";
    if (!empty($_POST["dni"])) {
        $dni = $_POST["dni"];
        $sql .= " AND dni LIKE :dni";
    }

    $sql .= " LIMIT " . $limit;
    $stmt = $pdo->prepare($sql);

    if (!empty($_POST["dni"])) {
        $dni = '%' . $dni . '%';
        $stmt->bindParam(':dni', $dni);
    }

    $stmt->execute();

    // Verificar si se recibió el id en la URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query para eliminar pacientes
        $sql = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirigir a la página actualizada
        header("Location: Index.php");
        exit();
    }
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
            <p>Bienvenido, aquí podrás gestionar a los Pacientes</p>
        </div>
        <div>
            <a href="Crear_Paciente.php">Crear Paciente</a>
        </div>
    </header>
    <div class="buscador">
        <form action="Index.php" method="post">
            <label for="dni">DNI:</label>
            <input type="text" name="dni" placeholder="Ingresa el dni">
            <input type="submit" value="enviar">
        </form>
        <div class="limit-selector">
        <form method="GET" action="">
            <label for="limit">Mostrar:</label>
            <select name="limit" id="limit">
                <option value="2" <?php echo $limit == 2 ? 'selected' : ''; ?>>2</option>
                <option value="4" <?php echo $limit == 4 ? 'selected' : ''; ?>>4</option>
                <option value="8" <?php echo $limit == 8 ? 'selected' : ''; ?>>8</option>
                <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
            </select>
            <input type="submit" value="Actualizar">
        </form>
    </div>
    </div>
    <div class="container">
        <div class="sidebar"></div>
        <form action="" method="POST">
            <table>
                <thead>
                    <tr>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch()) {
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
                        echo '<td><a href="editar.php?id='.$row['id'].'">Editar</a> | <a href="Index.php?id='.$row['id'].'">Eliminar</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
        <div class="sidebar_derecha"></div>
    </div>
    </body>
    <footer>
        <div class="footer-section">
            <h3>Administrador</h3>
            <p>Nombre: John Doe</p>
            <p>Rol: Administrador</p>
        </div>
        <div class="footer-section">
            <h3>Contacto</h3>
            <p>Teléfono: xxx-xxx-xxxx</p>
            <p>Correo electrónico: admin@example.com</p>
        </div>
        <div class="footer-right">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Pacientes</a></li>
                <li><a href="#">Reportes</a></li>
                <li><a href="#">Configuración</a></li>
            </ul>
        </div>
    </footer>
</html>
