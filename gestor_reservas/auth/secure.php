<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Gestor de reservas</title>
</head>
<body>
    <header>
        <a href="./historial.php">Tu historial de reservas</a>
        <a href="./profile.php"><img src="../img/profile.png" alt="" style="width: 10%;"></a>
        <a href="./logout.php">Cerrar sesion</a>
    </header>
    <main>
        <h2>Bienvenido <span style="color: red;"><?php echo $_SESSION['login'];?></span> </h2>
        <h1>Realizar reserva</h1>
        <a href="../reserva.php">Pincha aquí para realizar una reserva</a>
    </main>
    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>
</html>