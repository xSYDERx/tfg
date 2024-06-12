<?php
    //Verifica si está creado el archivo config
    if(file_exists("../config/config.php")){
        header("Location: ../index.php");
    }
    if(isset($_POST['host'])){
        $host = $_POST['host'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $basedatos = $_POST['basedatos'];
        $puerto = $_POST['puerto'];
        try{
              $conexion=new mysqli($host,$usuario,$password,$basedatos,$puerto);
              $ruta = substr($_SERVER['HTTP_REFERER'],0,-20);
            $config = <<<CONFIG
            <?php
                define("HOST","$host");
                define("USUARIO","$usuario");
                define("PASSWORD","$password");
                define("BASEDATOS","$basedatos");
                define("PUERTO","$puerto");
                define("RUTA_APP","$ruta");
            ?>
            CONFIG;
            file_put_contents("../config/config.php",$config);
            header("Location: install3.php");
        }catch(Exception $e){
            $mensaje= "<p class='error' >Ha habido un error en la conexión <br>Inténtelo de nuevo</p>";
        }

        
 }    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación Aplicación Gestor de Reservas</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <h1>Instalación Aplicación Gestor de Reservas</h1>
    
    <form action="" method="post">
        <fieldset>
            <legend>Configuración de la base de datos</legend>
            <label for="host">Host</label>
            <input type="text" name="host" id="host" required><br>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" required><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required><br>
            <label for="basedatos">Base de datos</label>
            <input type="text" name="basedatos" id="basedatos" required><br>
            <label for="puerto">Puerto</label>
            <input type="text" name="puerto" id="puerto" value="3306"><br>
            <input type="submit" value="Enviar">
        </fieldset>
    </form>
    <?php
       
    if(isset($mensaje)){
        echo $mensaje;
    }
    
    
    ?>
    <footer> <p>Gestor de reservas BETA </p>
    
    </footer>
</body>
</html>