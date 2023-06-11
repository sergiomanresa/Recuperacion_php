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

    $sql = "SELECT MAX(id) as ultimo FROM pacientes";
    $resultado = $pdo->query($sql);
    $fila_ultimo_id = $resultado->fetch(PDO::FETCH_ASSOC);
    $ultimo_id = $fila_ultimo_id['ultimo'];
    $nuevo_id = $ultimo_id + 1;

    if (isset($_POST['crear_cliente'])) {
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

        // Preparar la consulta SQL
        $sql_ = "INSERT INTO pacientes (sip,dni,nombre, apellido1, apellido2, telefono, sexo, fecha_nacimiento, localidad, calle) VALUES (:dni,:sip,:nombre, :apellido1, :apellido2, :telefono, :sexo, :fecha_nacimiento, :localidad, :calle)";
        $resultado_insert = $pdo->prepare($sql_);

        // Asignar los valores a los parámetros de la consulta
        $resultado_insert->bindParam(':sip', $sip);
        $resultado_insert->bindParam(':dni', $dni);
        $resultado_insert->bindParam(':nombre', $nombre);
        $resultado_insert->bindParam(':apellido1', $apellido1);
        $resultado_insert->bindParam(':apellido2', $apellido2);
        $resultado_insert->bindParam(':telefono', $telefono);
        $resultado_insert->bindParam(':sexo', $sexo);
        $resultado_insert->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $resultado_insert->bindParam(':localidad', $localidad);
        $resultado_insert->bindParam(':calle', $calle);

        $resultado_insert->execute();

        if ($resultado_insert) {
            // La reserva se creó correctamente, redirigir al usuario a admin_reservas.php
            header("Location: Index.php");
            exit();
        } else {
            // Ocurrió un error al crear la reserva, puedes mostrar un mensaje de error o realizar alguna otra acción
            echo "Error al crear el paciente: " . $resultado_insert->errorInfo()[2];
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
    <link rel="stylesheet" href="../css/Style.css">
    <title>Crear paciente</title>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Bienvenido a Crear Pacientes</h1>
            <p>Aquí puedes crear pacientes</p>
        </div>
    </header>
    <div class="container">
        <form action="crear_Paciente.php" method="post">
            <label for="sip">SIP:</label>
            <input type="number" name="sip" required><br>
            <label for="dni">DNI:</label>
            <input type="text" name="dni" required><br>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre"><br>
            <label for="apellido1">Apellido 1:</label>
            <input type="text" name="apellido1"><br>
            <label for="apellido2">Apellido 2:</label>
            <input type="text" name="apellido2"><br>
            <label for="telefono">Teléfono:</label>
            <input type="number" name="telefono" pattern="[0-9]+" required><br>
            <label for="sexo">Sexo:</label>
            <select name="sexo" required>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
            </select><br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" required><br>
            <label for="localidad">Localidad:</label>
            <input type="text" name="localidad" required><br>
            <label for="calle">Calle:</label>
            <input type="text" name="calle" required><br>
            <input type="submit" name="crear_cliente" value="Crear Paciente">
        </form>
    </div>
</body>

</html>
