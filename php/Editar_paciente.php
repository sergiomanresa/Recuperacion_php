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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Obtener los datos del paciente existente
        $sql = "SELECT * FROM pacientes WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $paciente = $statement->fetch(PDO::FETCH_ASSOC);

        // Verificar si se envió el formulario para actualizar el paciente
        if (isset($_POST['editar_paciente'])) {
            // Obtener los datos del formulario
            $sip = $_POST["sip"];
            $dni = $_POST["dni"];
            $nombre = $_POST["nombre"];
            $apellido1 = $_POST["apellido1"];
            $apellido2 = $_POST["apellido2"];
            $telefono = $_POST["telefono"];
            $sexo = $_POST["sexo"];
            $fecha_nacimiento = $_POST["fecha_nacimiento"];
            $localidad = $_POST["localidad"];
            $calle = $_POST["calle"];

            // Actualizar los datos del paciente en la base de datos
            $sql_update = "UPDATE pacientes SET sip = :sip, dni = :dni, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, telefono = :telefono, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento, localidad = :localidad, calle = :calle WHERE id = :id";
            $statement_update = $pdo->prepare($sql_update);
            $statement_update->bindParam(':sip', $sip);
            $statement_update->bindParam(':dni', $dni);
            $statement_update->bindParam(':nombre', $nombre);
            $statement_update->bindParam(':apellido1', $apellido1);
            $statement_update->bindParam(':apellido2', $apellido2);
            $statement_update->bindParam(':telefono', $telefono);
            $statement_update->bindParam(':sexo', $sexo);
            $statement_update->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $statement_update->bindParam(':localidad', $localidad);
            $statement_update->bindParam(':calle', $calle);
            $statement_update->bindParam(':id', $id);
            $statement_update->execute();

            // Redirigir al usuario a la página de visualización de pacientes después de la actualización
            header("Location: Index.php?id=" . $id);
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Style_crear.css">
    <title>Editar paciente</title>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Bienvenido a Editar Pacientes</h1>
            <p>Aquí puedes editar pacientes</p>
        </div>
    </header>
    <div class="container">
        <h1>Cliente</h1>
        <form action="" method="post">
            <label for="sip">SIP:</label>
            <input type="number" name="sip" value="<?php echo $paciente['sip']; ?>" required><br>
            <label for="dni">DNI:</label>
            <input type="text" name="dni" value="<?php echo $paciente['dni']; ?>" required><br>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $paciente['nombre']; ?>"><br>
            <label for="apellido1">Apellido 1:</label>
            <input type="text" name="apellido1" value="<?php echo $paciente['apellido1']; ?>"><br>
            <label for="apellido2">Apellido 2:</label>
            <input type="text" name="apellido2" value="<?php echo $paciente['apellido2']; ?>"><br>
            <label for="telefono">Teléfono:</label>
            <input type="number" name="telefono" value="<?php echo $paciente['telefono']; ?>" required><br>
            <label for="sexo">Sexo:</label>
            <select name="sexo" required>
                <option value="Hombre" <?php if ($paciente['sexo'] === 'Hombre') echo 'selected'; ?>>Hombre</option>
                <option value="Mujer" <?php if ($paciente['sexo'] === 'Mujer') echo 'selected'; ?>>Mujer</option>
            </select><br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="<?php echo $paciente['fecha_nacimiento']; ?>" required><br>
            <label for="localidad">Localidad:</label>
            <input type="text" name="localidad" value="<?php echo $paciente['localidad']; ?>" required><br>
            <label for="calle">Calle:</label>
            <input type="text" name="calle" value="<?php echo $paciente['calle']; ?>" required><br>
            <input type="submit" name="editar_paciente" value="Guardar cambios">
        </form>
    </div>
</body>

</html>
