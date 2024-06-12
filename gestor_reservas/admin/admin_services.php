<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Servicios</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <h1>Administración de Servicios</h1>

    <?php
    // Verificar si el usuario está autenticado
    session_start();
    if (!isset($_SESSION['loginadmin'])) {
        header('Location: ../auth/loginadmin.php');
        exit;
    }

    // Conectar a la base de datos
    require_once '../config/config.php';
    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Manejar la inserción de nuevos servicios si se envía el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_servicio'])) {
        $nombreServicio = $conexion->real_escape_string($_POST['nombre_servicio']);
        $descripcionServicio = $conexion->real_escape_string($_POST['descripcion_servicio']);
        $precioServicio = $conexion->real_escape_string($_POST['precio_servicio']);

        $insertQuery = "INSERT INTO servicio (nombre, descripcion, precio) VALUES ('$nombreServicio', '$descripcionServicio', '$precioServicio')";
        
        if ($conexion->query($insertQuery) === TRUE) {
            echo "<p style='color: green;'>Servicio agregado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al agregar el servicio: " . $conexion->error . "</p>";
        }
    }

    // Eliminar servicio si se proporciona un ID
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['eliminar_servicio'])) {
        $idServicio = $conexion->real_escape_string($_GET['eliminar_servicio']);
        $deleteQuery = "DELETE FROM servicio WHERE id_servicio = '$idServicio'";

        if ($conexion->query($deleteQuery) === TRUE) {
            echo "<p style='color: green;'>Servicio eliminado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al eliminar el servicio: " . $conexion->error . "</p>";
        }
    }

    // Consultar todos los servicios
    $query = "SELECT * FROM servicio";
    $result = $conexion->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>";

            while ($servicio = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$servicio['id_servicio']}</td>
                        <td>{$servicio['nombre']}</td>
                        <td>{$servicio['descripcion']}</td>
                        <td>{$servicio['precio']} €</td>
                        <td>
                            <a href='?eliminar_servicio={$servicio['id_servicio']}' onclick='return confirm(\"¿Seguro que desea eliminar este servicio?\")'>Eliminar</a>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay servicios registrados.";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    ?>

    <h2>Añadir Nuevo Servicio</h2>
    <form method="post">
        <label for="nombre_servicio">Nombre:</label>
        <input type="text" name="nombre_servicio" required><br>

        <label for="descripcion_servicio">Descripción:</label>
        <textarea name="descripcion_servicio" required></textarea><br>

        <label for="precio_servicio">Precio (€):</label>
        <input type="text" name="precio_servicio" required><br>

        <input type="submit" value="Agregar Servicio">
    </form>
    <br>
<a href="../auth/secureadmin.php"><--volver atras</a>

<footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>

</html>
