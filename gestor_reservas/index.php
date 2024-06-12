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
    <title>Gestor de Reservas</title>
    <link rel="stylesheet" href="./css/index_style.css">
</head>
<body>
    <header>
        <h1>Gestor de reservas</h1>
    </header>
    <main>
        <a href="./auth/login.php">Iniciar Sesion</a>
        <a href="./auth/register.php">Registrarse</a>
    </main>
    <footer>
            <p>Gestor de reservas BETA </p>
        <div>
            <a href="./auth/loginadmin.php"><img src="./img/engine.png" alt="Inicio de sesion para administradores"></a>
            
        </div>    
    </footer>
</body>
</html>