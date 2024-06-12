<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['loginadmin'])) {
    header('Location: loginadmin.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>Panel de control</title>
</head>
<body>
    <h1>Panel de control</h1>
    <div>
        <a href="../admin/admin_reserves.php">Gestionar Reservas</a>
        <a href="../admin/admin_users.php">Gestionar Usuarios</a>
        <a href="../admin/admin_services.php">Gestionar Servicios</a>
    </div>
    <a href="./logout.php">Cerrar sesion</a>
    <footer>
    <p>Gestor de reservas BETA </p>
    </footer>
</body>
</html>