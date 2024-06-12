<?php
    //Verifica si está creado el archivo config
    if(file_exists("../config/config.php")){
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación Aplicación Gestor de Reservas</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Instalación Aplicación Gestor de Reservas</h1>
    <p>Si desea instalar la aplicación web, prepare la siguiente información:
        <ol>
            <li>IP o nombre del host para el sistema gestor de bases de datos MariaDB o Mysql</li>
            <li>Usuario con privilegios sobre una base de datos en ese SGBD</li>
            <li>Contraseña del usuario</li>
            <li>Nombre de la base de datos</li>
            <li>Puerto de conexión a esa base de datos (si no es el estándar)</li>
        </ol>
    </p>
    <a href="install2.php">Procedamos</a>
    <footer> <p>Gestor de reservas BETA </p>
    
    </footer>
</body>
</html>