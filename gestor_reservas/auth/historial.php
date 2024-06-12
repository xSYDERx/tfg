<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Reservas</title>
    <link rel="stylesheet" href="../css/estilo.css">
    
    <script>
        //Funcion de JavaScript que habre un menú para confirmar una acción 
        function confirmarAccion(referencia, accion) {
            var mensaje = '';
            if (accion === 'cancelar') {
                mensaje = '¿Seguro que quiere cancelar su reserva?';
            } else if (accion === 'pagar') {
                mensaje = '¿Seguro que quiere ir a la pasarela de pago?';
            }

            var confirmacion = confirm(mensaje);
            if (confirmacion) {
                if (accion === 'cancelar') {
                    window.location.href = 'historial.php?ref=' + referencia + '&accion=cancelar';
                } else if (accion === 'pagar') {
                    window.location.href = '../pago.php?ref=' + referencia;
                }
            }
        }
    </script>
</head>

<body>
    <h1>Historial de Reservas</h1>

    <?php
    // Verificar si el usuario está autenticado
    session_start();
    if (!isset($_SESSION['login'])) {
        header('Location: login.php');
        exit;
    }

    // Obtener el login del usuario
    $login = $_SESSION['login'];

    // Conectar a la base de datos
    require_once '../config/config.php';
    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Manejar la acción de cancelar si se proporciona la referencia y la acción es 'cancelar'
    if (isset($_GET['ref']) && isset($_GET['accion']) && $_GET['accion'] === 'cancelar') {
        $referenciaCancelar = $conexion->real_escape_string($_GET['ref']);
        $updateQuery = "UPDATE reserva SET estado = 'cancelada' WHERE referencia = '$referenciaCancelar'";
        if ($conexion->query($updateQuery) === TRUE) {
            echo "<p style='color: green;'>Reserva cancelada exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al cancelar la reserva: " . $conexion->error . "</p>";
        }
    }

    // Consultar el historial de reservas del usuario
    $query = ("SELECT referencia, fecha_reserva, estado FROM reserva WHERE login = '$login'");
    $result = $conexion->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Referencia</th>
                        <th>Fecha de Reserva</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>";

            while ($reserva = $result->fetch_assoc()) {
                // Convertir la fecha al formato correcto
                $fechaFormateada = DateTime::createFromFormat('Y-m-d', $reserva['fecha_reserva']);
                
                echo "<tr>
                        <td>{$reserva['referencia']}</td>
                        <td>{$fechaFormateada->format('Y-m-d')}</td>
                        <td>{$reserva['estado']}</td>
                        <td>";

                // Agregar botones según el estado de la reserva
                if ($reserva['estado'] == 'pendiente de pago') {
                    echo "<button onclick='confirmarAccion(\"{$reserva['referencia']}\", \"pagar\")'>Pagar</button>";
                } elseif ($reserva['estado'] == 'cancelada') {
                    echo "Reserva cancelada";
                } else {
                    echo "<button onclick='confirmarAccion(\"{$reserva['referencia']}\", \"cancelar\")'>Cancelar</button>";
                }

                echo "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "No hay reservas para este usuario.";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    ?>

<br>
<a href="../auth/secure.php"><--volver atras</a>
<footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>

</html>
