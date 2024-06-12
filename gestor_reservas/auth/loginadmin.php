<?php
session_start();


// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/config.php';

    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    $login = $conexion->real_escape_string($_POST['loginadmin']);
    $password = $conexion->real_escape_string($_POST['password']);

    // Consultar la base de datos para obtener la contraseña almacenada
    $result = $conexion->query("SELECT loginadmin, password, salt FROM admins WHERE loginadmin = '$login'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $salt = $row['salt'];

        // Verificar la contraseña
        if (password_verify($password . $salt, $storedPassword)) {
            // Autenticación exitosa
            $_SESSION['loginadmin'] = $login;
            header('Location: secureadmin.php');
            exit;
        } else {
            // Contraseña incorrecta
            $error = "Credenciales incorrectas";
        }
    } else {
        // Usuario no encontrado
        $error = "Administrador no encontrado";
    }
    //Cierra la variable de conexion
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Admin Login</h1>

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="loginadmin">Usuario:</label>
        <input type="text" name="loginadmin" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Iniciar sesión">
    </form>
    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>
</html>
