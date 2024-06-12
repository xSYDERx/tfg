<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/config.php';
$conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = '';

// Verificar si se ha enviado el formulario de cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $conexion->real_escape_string($_POST['current_password']);
    $new_password = $conexion->real_escape_string($_POST['new_password']);
    $confirm_password = $conexion->real_escape_string($_POST['confirm_password']);

    // Obtener la contraseña almacenada del usuario
    $login = $_SESSION['login'];
    $result = $conexion->query("SELECT password, salt FROM usuarios WHERE login = '$login'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $salt = $row['salt'];

        // Verificar la contraseña actual
        if (password_verify($current_password . $salt, $storedPassword)) {
            // Verificar si las contraseñas nuevas coinciden
            if ($new_password === $confirm_password) {
                // Hash de la nueva contraseña
                $new_password_hashed = password_hash($new_password . $salt, PASSWORD_DEFAULT);

                // Actualizar la contraseña en la base de datos
                $update_query = "UPDATE usuarios SET password = '$new_password_hashed' WHERE login = '$login'";
                $conexion->query($update_query);

                $mensaje = 'Contraseña cambiada exitosamente.';
            } else {
                $mensaje = 'Las nuevas contraseñas no coinciden.';
            }
        } else {
            $mensaje = 'Contraseña actual incorrecta.';
        }
    }
}

// Verificar si se ha enviado el formulario de cambio de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_login'])) {
    $new_login = $conexion->real_escape_string($_POST['new_login']);

    // Verificar si el nuevo login está disponible
    $login_check_query = "SELECT * FROM usuarios WHERE login = '$new_login'";
    $result = $conexion->query($login_check_query);

    if ($result->num_rows == 0) {
        // Actualizar el login en la base de datos
        $login = $_SESSION['login'];
        $update_query = "UPDATE usuarios SET login = '$new_login' WHERE login = '$login'";
        $conexion->query($update_query);

        // Actualizar la variable de sesión
        $_SESSION['login'] = $new_login;

        $mensaje = 'Login cambiado exitosamente.';
    } else {
        $mensaje = 'El nuevo login ya está en uso.';
    }
}
//Cierra la variable de conexion
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Perfil de Usuario</h1>

    <?php echo $mensaje; ?>

    <h2>Cambiar Contraseña</h2>
    <form method="post" action="">
        <label for="current_password">Contraseña Actual:</label>
        <input type="password" name="current_password" required><br>
        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" name="new_password" required><br>
        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
        <input type="password" name="confirm_password" required><br>
        <input type="submit" name="change_password" value="Cambiar Contraseña">
    </form>

    <h2>Cambiar Login</h2>
    <form method="post" action="">
        <label for="new_login">Nuevo Login:</label>
        <input type="text" name="new_login" required><br>
        <input type="submit" name="change_login" value="Cambiar Login">
    </form>

    <br>
    <a href="../auth/secure.php"><--volver atras</a>
    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>
</html>
