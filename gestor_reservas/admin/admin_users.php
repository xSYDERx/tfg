<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <h1>Administración de Usuarios</h1>

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

    // Manejar eliminación de usuarios si se proporciona el login
    if (isset($_POST['eliminar_login'])) {
        $loginEliminar = $conexion->real_escape_string($_POST['eliminar_login']);
        $deleteQuery = "DELETE FROM usuarios WHERE login = '$loginEliminar'";
        if ($conexion->query($deleteQuery) === TRUE) {
            echo "<p style='color: green;'>Usuario eliminado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al eliminar el usuario: " . $conexion->error . "</p>";
        }
    }

    // Consultar todos los usuarios
    $query = "SELECT * FROM usuarios";
    $result = $conexion->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Login</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>";

            while ($usuario = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$usuario['login']}</td>
                        <td>{$usuario['nombre']}</td>
                        <td>{$usuario['apellidos']}</td>
                        <td>{$usuario['email']}</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='eliminar_login' value='{$usuario['login']}'>
                                <input type='submit' value='Eliminar'>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay usuarios registrados.";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    ?>

<br>
<a href="../auth/secureadmin.php"><--volver atras</a>
<footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>

</html>
