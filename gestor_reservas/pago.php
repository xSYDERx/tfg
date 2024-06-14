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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header_y_footer.css">
    <title>CBS Glup Glup</title>
    </head>
    <body>
                        
                        
                        
                        <!--HEADER-->
                        <header>
                        <button id="menuButton"><img src="../assets/svg/blue_bg_menu.svg" alt=""></button>
                        <div>
                        <a href="../index.html" id="club_a">
                        <img src="../assets/img/logo_cbs.png" alt="Logo club" id="logo_club">
                        </a>
                        </div>
                        <nav id="mainMenu">
                        <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../html/who.html">El club</a></li>
                        <li><a href="../html/galeria.html">Galería</a>
                        </li>
                        <li><a href="../html/tienda.html">Tienda</a>
                        </li>
                        <li><a href="../html/contacto.html">Contacto</a></li>
                        <li><a href="../html/actividades.html">Realiza tu reserva</a></li>
                        <li id="user"><a href="">Inicio de sesión</a></li>
                        </ul>
                        </nav>
                        </header>
    <body>
    <h1>Pasarela de Pago</h1>

    <?php if (isset($mensaje_exito)) : ?>
        <p style="color: green;"><?php echo $mensaje_exito; ?></p>
        <p style="color: green;">Si no has sido redirigido, pincha <a href="./auth/secure.php">aquí</a>
    <?php endif; ?>

    <?php if (isset($mensaje_error)) : ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>
<div class="login-container">
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
</div>

    <footer>
        <section id="fotos_footer">
          <img src="" alt="">
          <div id="logos">
            <img src="../assets/img/instructor_trainer-removebg-preview.png" alt="logo acuc">
            <img src="../assets/img/Cressi_pittogramma_neg.png" alt="logo cressi">
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
            <a href="../html/cookies.html">Política de cookies</a>
            <a href="../html/legal.html">Aviso legal</a>
            <a href="../html/privacidad.html">Política de privacidad</a>
            </div>
          <p>© 2024 CBS Glup Glup</p>
      </footer>
      <button id="scrollToTopBtn">&#8679;</button>

      <script src="../js/gotopbutton.js"></script>
      <script src="../js/burgermenu.js"></script>
</body>
</html>
