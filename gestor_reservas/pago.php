<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['login'])) {
    header('Location: ./auth/login.php');
    exit;
}

// Conectar a la base de datos
require_once './config/config.php';
$conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario de pasarela
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['referencia'])) {
    // Obtener la referencia de la reserva y actualizar el estado a "pagada"
    $referencia = $conexion->real_escape_string($_POST['referencia']);

    // Verificar si la referencia existe en la base de datos
    $check_referencia_query = "SELECT * FROM reserva WHERE referencia = '$referencia'";
    $result_check_referencia = $conexion->query($check_referencia_query);

    if ($result_check_referencia && $result_check_referencia->num_rows > 0) {
        $update_query = "UPDATE reserva SET estado = 'reservada' WHERE referencia = '$referencia'";

        if ($conexion->query($update_query) === TRUE) {
            $mensaje_exito = "Pago realizado exitosamente. La reserva ahora está pagada. Te redireccionaremos a tu pagina principal en un momento";
        } else {
            $mensaje_error = "Error al procesar el pago: " . $conexion->error;
        }
    } else {
        $mensaje_error = "Referencia no encontrada en la base de datos.";
    }
}

if (isset($mensaje_exito)) {
    // Agrega una redirección después de 3 segundos
    echo '<meta http-equiv="refresh" content="3;url=./exito.html">';
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pasarela de Pago</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Pasarela de Pago</h1>

    <?php if (isset($mensaje_exito)) : ?>
        <p style="color: green;"><?php echo $mensaje_exito; ?></p>
        <p style="color: green;">Si no has sido redirigido, pincha <a href="./auth/secure.php">aquí</a>
    <?php endif; ?>

    <?php if (isset($mensaje_error)) : ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <!-- Agrega un campo oculto para la referencia -->
        <input type="hidden" name="referencia" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : ''; ?>">

        <!-- Agrega aquí los campos para la información de la tarjeta -->
        <label for="titular">Nombre del Titular:</label>
        <input type="text" name="titular" required><br>

        <label for="numero">Número de Tarjeta:</label>
        <input type="text" name="numero" required><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required><br>

        <label for="caducidad">Fecha de Caducidad:</label>
        <input type="text" name="caducidad" required><br>

        <input type="submit" value="Pagar">
    </form>

    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>
</html>
