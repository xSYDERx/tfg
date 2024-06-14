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
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header_y_footer.css">
</head>

<body>

<header>
            <button id="menuButton"><img src="../../assets/svg/blue_bg_menu.svg" alt=""></button>
            <div>
            <a href="../../index.html" id="club_a">
            <img src="../../assets/img/logo_cbs.png" alt="Logo club" id="logo_club">
            </a>
            </div>
            <nav id="mainMenu">
            <ul>
            <li><a href="../../index.html">Inicio</a></li>
            <li><a href="../../html/who.html">El club</a></li>
            <li><a href="../../html/galeria.html">Galería</a>
            </li>
            <li><a href="../../html/tienda.html">Tienda</a>
            </li>
            <li><a href="../../html/contacto.html">Contacto</a></li>
            <li><a href="../../html/actividades.html">Realiza tu reserva</a></li>
            <li id="user"><a href="">Inicio de sesión</a></li>
            </ul>
            </nav>
            </header>
            <?php echo $mensaje; ?>
            <div class="register-container">
                <h1>Registro</h1>
                <form action="" method="post">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" required>
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" required>
                    <label for="login">Login:</label>
                    <input type="text" name="login" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" required>
                    <input type="submit" value="Registrar">
                </form>
                <p>¿Ya eres parte del club? <a href="./login.php">¡Inicia sesión!</a></p>
            </div>
    <footer>
        <section id="fotos_footer">
          <img src="" alt="">
          <div id="logos">
            <img src="../../assets/img/instructor_trainer-removebg-preview.png" alt="logo acuc">
            <img src="../../assets/img/Cressi_pittogramma_neg.png" alt="logo cressi">
          </div>
        </section>
          <section>
            <h2 id="redes_title">Nuestras Redes sociales</h2>
            <div id="redes">
              <a href="https://www.youtube.com/@JoseGlup"><img src="../assets/svg/youtube-svgrepo-com.svg" alt="youtube"></a>
              <a href="https://www.instagram.com/cbsglupglup/"><img src="../assets/svg/Instagram_logo_2016.svg" alt="instagram"></a>
              <a href="https://www.facebook.com/cbglupglup"><img src="../assets/svg/Facebook_f_logo_(2019).svg" alt="facebook"></a>
              <a href="https://www.tiktok.com/@cbsglupglup?lang=es"><img src="../assets/svg/tiktok-logo-logo-svgrepo-com.svg" alt="tiktok"></a>
            </div>
          </section>
          <div id="legal">
            <a href="../../html/cookies.html">Política de cookies</a>
            <a href="../../html/legal.html">Aviso legal</a>
            <a href="../../html/privacidad.html">Política de privacidad</a>
            </div>
          <p>© 2024 CBS Glup Glup</p>
      </footer>
      <button id="scrollToTopBtn">&#8679;</button>

      <script src="../../js/gotopbutton.js"></script>
      <script src="../../js/burgermenu.js"></script>

</body>

</html>
