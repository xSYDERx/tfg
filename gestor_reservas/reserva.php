<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['login'])) {
    header('Location: ./auth/login.php');
    exit;
}

// Obtener el login del usuario
$login = $_SESSION['login'];

// Verificar si se ha enviado el formulario de reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fecha_reserva'])) {
    // Conectar a la base de datos
    require_once './config/config.php';
    $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener la fecha de reserva y la ID del servicio del formulario
    $fecha_reserva = $conexion->real_escape_string($_POST['fecha_reserva']);
    $id_servicio = $conexion->real_escape_string($_POST['tipo_servicio']);

    // Verificar si el día ya está reservado para el servicio seleccionado
    $query_reservas = "SELECT referencia FROM reserva WHERE fecha_reserva = '$fecha_reserva' AND id_servicio = '$id_servicio'";
    $result_reservas = $conexion->query($query_reservas);

    if ($result_reservas) {
        while ($row_reservas = $result_reservas->fetch_assoc()) {
            // Obtener solo los dos últimos dígitos de la referencia actual
            $referencia_actual_sin_dos_digitos = substr($row_reservas['referencia'], 2);

            // Obtener solo los dos últimos dígitos de la nueva referencia
            $referencia_nueva_sin_dos_digitos = substr(generar_referencia_unica($id_servicio, $fecha_reserva), 2);

            if ($referencia_actual_sin_dos_digitos == $referencia_nueva_sin_dos_digitos) {
                $mensaje_error = "El día ya está reservado para este servicio, por favor, seleccione otro día.";
                break;  // Salir del bucle ya que ya encontramos una reserva para el día y servicio
            }
        }

        // Si no hay mensajes de error, proceder con la reserva
        if (!isset($mensaje_error)) {
            // Realizar la reserva, insertar en la base de datos
            $referencia = generar_referencia_unica($id_servicio, $fecha_reserva);
            $estado = "pendiente de pago"; // Puedes ajustar el estado según tus necesidades, en este caso, al existir la pasarela de pago, se queda con pendiente de pago

            $insert_query = "INSERT INTO reserva (referencia, fecha_reserva, estado, login, id_servicio) VALUES ('$referencia', '$fecha_reserva', '$estado', '$login', '$id_servicio')";

            if ($conexion->query($insert_query) === TRUE) {
                // Redirigir según el botón presionado
                if (isset($_POST['realizar_pago'])) {
                    header("Location: ./pago.php");
                } elseif (isset($_POST['reservar_sin_pago'])) {
                    header("Location: ./exito.html");
                }
                exit;
            } else {
                $mensaje_error = "Error al realizar la reserva: " . $conexion->error;
            }
        }
    } else {
        $mensaje_error = "Error en la consulta: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}

// Función para generar una referencia única
function generar_referencia_unica($id_servicio, $fecha_reserva) {
    // Obtener la parte de la fecha
    $parte_fecha = date('ymd', strtotime($fecha_reserva));

    // Generar la referencia combinando la ID del servicio, año, mes y día
    return str_pad($id_servicio, 2, '0', STR_PAD_LEFT) . $parte_fecha;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header_y_footer.css">
    <title>CBS Glup Glup</title>
    </head>
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
            <!--HEADER-->
<body>
    <h1>Reserva</h1>

    <?php if (isset($mensaje_exito)) : ?>
        <p style="color: green;"><?php echo $mensaje_exito; ?></p>
    <?php endif; ?>

    <?php if (isset($mensaje_error)) : ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
    <label for="fecha_reserva">Fecha de Reserva:</label>
    <input type="date" name="fecha_reserva" required><br>

    <!-- Añadir campo para mostrar tipo de servicio -->
    <label for="tipo_servicio">Tipo de Servicio:</label>
    <select name="tipo_servicio" required>
        <?php
        // Conectar a la base de datos
        require_once './config/config.php';
        $conexion = new mysqli(HOST, USUARIO, PASSWORD, BASEDATOS, PUERTO);

        // Verificar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consultar tipos de servicio desde la base de datos
        $query_servicios = "SELECT id_servicio, nombre, descripcion, precio FROM servicio";
        $result_servicios = $conexion->query($query_servicios);

        if ($result_servicios && $result_servicios->num_rows > 0) {
            while ($servicio = $result_servicios->fetch_assoc()) {
                echo "<option value='{$servicio['id_servicio']}'>{$servicio['nombre']} - {$servicio['descripcion']} - {$servicio['precio']} €</option>";
            }
        } else {
            echo "<option value='' disabled>No hay servicios disponibles</option>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </select><br>

    <input type="submit" name="realizar_pago" value="Realizar el pago">
    <input type="submit" name="reservar_sin_pago" value="Reservar sin realizar el pago">
</form>
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
