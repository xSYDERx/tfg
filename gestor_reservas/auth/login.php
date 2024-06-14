<?php
session_start();

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['login'])) {
    header('Location: secure.php');
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/config.php';

    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    $login = $conexion->real_escape_string($_POST['login']);
    $password = $conexion->real_escape_string($_POST['password']);

    // Consultar la base de datos para obtener la contraseña almacenada
    $result = $conexion->query("SELECT login, password, salt FROM usuarios WHERE login = '$login'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $salt = $row['salt'];

        // Verificar la contraseña
        if (password_verify($password . $salt, $storedPassword)) {
            // Autenticación exitosa
            $_SESSION['login'] = $login;
            header('Location: secure.php');
            exit;
        } else {
            // Contraseña incorrecta
            $error = "Credenciales incorrectas";
        }
    } else {
        // Usuario no encontrado
        $error = "Usuario no encontrado";
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
    <link rel="stylesheet" href="../css/login.css">
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
            <li><a href="../html/who.html">El club</a></li>
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

    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form method="post" action="">
            <label for="login">Usuario:</label>
            <input type="text" name="login" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Iniciar sesión">
        </form>
        <p>¿Aún no tienes cuenta? ¡Registrate!</p>
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
