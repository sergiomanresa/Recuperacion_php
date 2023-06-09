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

    // Calcular el total de registros y el número total de páginas
    $registrosPagina = $limit;
    $totalRegistros = $pdo->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
    $totalPaginas = ceil($totalRegistros / $registrosPagina);

    // Obtener el valor de la página actual
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Verificar si se hizo clic en el botón "Retroceder"
    if (isset($_POST['retroceder'])) {
        $pagina = intval($_POST['retroceder']);
        if ($pagina < 1) {
            $pagina = 1;
        }
    }

    // Verificar si se hizo clic en el botón "Avanzar"
    if (isset($_POST['avanzar'])) {
        $pagina = intval($_POST['avanzar']);
        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }
    }

    // Verificar si se hizo clic en el botón "Ir a la última página"
    if (isset($_POST['ultima'])) {
        $pagina = $totalPaginas;
    }

    // Calcular el desplazamiento para la consulta SQL
    $offset = ($pagina - 1) * $limit;

    // Query para rellenar la tabla de datos
    $sql = "SELECT * FROM pacientes WHERE true";
    $params = array();

    if (!empty($_GET["dni"])) {
        $dni = $_GET["dni"];
        $sql .= " AND dni LIKE :dni";
        $params[':dni'] = '%' . $dni . '%';
    }

    $sql .= " LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();

   
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Gestion Pacientes</title>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Menú Gestión Pacientes</h1>
            <p>Bienvenido, aquí podrás gestionar a los Pacientes</p>
        </div>
        <div>
            <a href="Crear_Paciente.php">Crear Paciente</a>
        </div>
    </header>
    <div class="buscador">
        <form action="Index.php" method="GET">
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
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
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
                        echo '<td><a href="Editar_paciente.php?id='.$row['id'].'">Editar</a> | <a href="eliminar_Paciente.php?id='.$row['id'].'">Eliminar</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <form method="POST" action="" class="formulario">
                    <button name="retroceder" value="1" <?php echo $pagina == 1 ? 'disabled' : ''; ?>>&lt;&lt;</button>
                    <button name="retroceder" value="<?php echo $pagina > 1 ? $pagina - 1 : 1; ?>" <?php echo $pagina == 1 ? 'disabled' : ''; ?>>&lt;</button>
                    <span>Página <?php echo $pagina; ?> de <?php echo $totalPaginas; ?></span>
                    <button name="avanzar" value="<?php echo $pagina < $totalPaginas ? $pagina + 1 : $totalPaginas; ?>" <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>>&gt;</button>
                    <button name="avanzar" value="<?php echo $totalPaginas; ?>" <?php echo $pagina == $totalPaginas ? 'disabled' : ''; ?>>&gt;&gt;</button>
                    <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                </form>
            </div>
        </form>
    </div>
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
</body>
</html>

