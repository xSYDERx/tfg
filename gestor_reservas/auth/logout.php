<?php
session_start(); //Inicia la sesion
session_unset(); //Elimina todas las variables de sesion
session_destroy(); //Destruye la sesion actual
header('Location: ../index.php'); // Redirige a la página de inicio
exit;
?>
