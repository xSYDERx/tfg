<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de Reservas</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <h1>Administración de Reservas</h1>

    <?php
    // Verificar si el usuario está autenticado
    session_start();
    if (!isset($_SESSION['loginadmin'])) {
        header('Location: ./auth/loginadmin.php');
        exit;
    }

    // Obtener el login del usuario
    $login = $_SESSION['loginadmin'];

    // Conectar a la base de datos
    require_once '../config/config.php';
    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Manejar cambios de estado si se proporcionan la referencia y el nuevo estado
    if (isset($_POST['referencia']) && isset($_POST['nuevo_estado'])) {
        $referenciaActualizar = $conexion->real_escape_string($_POST['referencia']);
        $nuevoEstado = $conexion->real_escape_string($_POST['nuevo_estado']);
        $updateQuery = "UPDATE reserva SET estado = '$nuevoEstado' WHERE referencia = '$referenciaActualizar'";
        if ($conexion->query($updateQuery) === TRUE) {
            echo "<p style='color: green;'>Estado de la reserva actualizado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al actualizar el estado de la reserva: " . $conexion->error . "</p>";
        }
    }

    // Manejar eliminación de reservas si se proporciona la referencia
    if (isset($_POST['eliminar_referencia'])) {
        $referenciaEliminar = $conexion->real_escape_string($_POST['eliminar_referencia']);
        $deleteQuery = "DELETE FROM reserva WHERE referencia = '$referenciaEliminar'";
        if ($conexion->query($deleteQuery) === TRUE) {
            echo "<p style='color: green;'>Reserva eliminada exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al eliminar la reserva: " . $conexion->error . "</p>";
        }
    }

    // Consultar todas las reservas con información de usuario
    $query = "SELECT r.referencia, r.fecha_reserva, r.estado, u.login, u.nombre, u.apellidos FROM reserva r
              JOIN usuarios u ON r.login = u.login";
    $result = $conexion->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Referencia</th>
                        <th>Login</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Fecha de Reserva</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>";

            while ($reserva = $result->fetch_assoc()) {
                // Convertir la fecha al formato correcto
                $fechaFormateada = DateTime::createFromFormat('Y-m-d', $reserva['fecha_reserva']);
                
                echo "<tr>
                        <td>{$reserva['referencia']}</td>
                        <td>{$reserva['login']}</td>
                        <td>{$reserva['nombre']}</td>
                        <td>{$reserva['apellidos']}</td>
                        <td>{$fechaFormateada->format('Y-m-d')}</td>
                        <td>{$reserva['estado']}</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='referencia' value='{$reserva['referencia']}'>
                                <select name='nuevo_estado'>
                                    <option value='pendiente de pago'>pendiente de pago</option>
                                    <option value='reservada'>reservada</option>
                                    <option value='cancelada'>cancelada</option>
                                    <option value='aplazada'>aplazada</option>
                                </select>
                                <input type='submit' value='Actualizar Estado'>
                            </form>
                            <form method='post'>
                                <input type='hidden' name='eliminar_referencia' value='{$reserva['referencia']}'>
                                <input type='submit' value='Eliminar'>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay reservas registradas.";
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
