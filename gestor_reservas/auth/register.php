<?php
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos (ajusta las credenciales según tu configuración)
    require_once '../config/config.php';
    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener datos del formulario
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $email = $conexion->real_escape_string($_POST['email']);
    $login = $conexion->real_escape_string($_POST['login']);
    $password = $conexion->real_escape_string($_POST['password']);

    // Hash de la contraseña
    $salt = random_int(10000000, 99999999);
    $password_hashed = password_hash($password . $salt, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellidos, email, login, password, salt) VALUES ('$nombre', '$apellidos', '$email','$login', '$password_hashed', '$salt')";

    if ($conexion->query($query) === TRUE) {
        $mensaje = "Usuario registrado exitosamente.";
        // Redireccionar al index después de registrar el usuario
        header("Location: ../index.php");
        exit();
    } else {
        $mensaje = "Error al registrar el usuario: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <h1>Registro de Usuario</h1>
    <?php echo $mensaje; ?>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br>

        <label for="email">Correo Electronico:</label>
        <input type="text" name="email" required><br>

        <label for="login">Login:</label>
        <input type="text" name="login" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Registrar">
    </form>
    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>

</html>
