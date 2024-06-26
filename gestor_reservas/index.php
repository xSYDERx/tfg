<?php
    if(!file_exists("./config/config.php")){
        header("Location: ./instalacion/install.php");
    }
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
            <!--HEADER-->
            <main>
                <a href="./auth/login.php">Iniciar Sesion</a>
                <a href="./auth/register.php">Registrarse</a>
            <a href="./auth/loginadmin.php"><img src="./img/engine.png" alt="Inicio de sesion para administradores"></a>
        
        </main>
        <!--FOOTER-->
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
