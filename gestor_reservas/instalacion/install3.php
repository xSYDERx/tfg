<?php
    $procediendo=false;
    $error=false;
    if(isset($_REQUEST['proceder'])){
        $procediendo=true;
        require_once '../config/config.php';
        $conexion = new mysqli(HOST,USUARIO,PASSWORD,BASEDATOS,PUERTO);
        $nombre = $conexion->real_escape_string($_REQUEST['nombre']); 
        $apellidos = $conexion->real_escape_string($_REQUEST['apellidos']);
        $loginadmin = $conexion->real_escape_string($_REQUEST['loginadmin']);
        $email = $conexion->real_escape_string($_REQUEST['email']);
        $password = $conexion->real_escape_string($_REQUEST['password']);
        $salt=random_int(10000000,99999999);
        $password = password_hash($password.$salt,PASSWORD_DEFAULT);
        
        $sql['admins'] = <<<SQL
            CREATE TABLE IF NOT EXISTS admins(
                nombre VARCHAR(50) NOT NULL,
                apellidos VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL,
                loginadmin VARCHAR(50) NOT NULL PRIMARY KEY,
                password VARCHAR(255) NOT NULL,
                salt VARCHAR(8) NOT NULL
            )ENGINE=InnoDB DEFAULT CHARSET=utf8;
        SQL;
        $sql['insert_admin'] = <<<SQL
            INSERT INTO admins(nombre,apellidos,email,loginadmin,password,salt)
            VALUES('$nombre','$apellidos','$email','$loginadmin','$password',$salt);
        SQL;
        $sql['usuarios']=<<<SQL
            CREATE TABLE  IF NOT EXISTS `usuarios` (
             `login` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
             `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
             `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
             `apellidos` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
             `password` VARCHAR(255) NOT NULL,
             `salt` VARCHAR(8) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de usuarios ';
        SQL;
        $sql['servicio'] = <<<SQL
    CREATE TABLE IF NOT EXISTS `servicio` (
        `id_servicio` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Clave primaria de la tabla',
        `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
        `descripcion` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
        `precio` int UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de servicios de nuestro gestor';
SQL;
$sql['reserva'] = <<<SQL
    CREATE TABLE IF NOT EXISTS `reserva` (
        `referencia` int UNSIGNED NOT NULL PRIMARY KEY COMMENT 'Clave primaria de la tabla',
        `fecha_reserva` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
        `estado` enum('pendiente de pago','reservada','actividad realizada','aplazada','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL,
        `login` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Será una clave foránea de la tabla usuarios',
        `id_servicio` INT UNSIGNED DEFAULT NULL COMMENT 'Será una clave foránea de la tabla servicio',
        FOREIGN KEY (login) REFERENCES usuarios (login),
        FOREIGN KEY (id_servicio) REFERENCES servicio (id_servicio)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de reservas de nuestro gestor';
SQL;


        $mensaje = "";
        foreach($sql as $clave=>$consulta){
            try{
                $conexion->query($consulta);
                $mensaje .= "<p class='exito'>La tabla o la ejecución $clave se ha creado correctamente</p>";
            }catch(Exception $e){
                $mensaje .= "<p class='error'>Ha habido un error en la creación de la tabla o ejecución $clave</p>
                <p>Inténtelo de nuevo</p> ";
                $error=true;
                
            }
        }
        if(!$error){
            $mensaje.="<p class='exito'>La instalación se ha realizado correctamente</p>";
            $mensaje.="<p>Puede proceder a borrar la carpeta install</p>";
            $mensaje.="<p>Ya puede acceder a la aplicación</p>";
            $mensaje.="<a href='../index.php'>Ir a la aplicación</a>";
     } 
        
    }else{
    if(file_exists("../config/config.php")){
        require_once '../config/config.php';
        if($conexion=new mysqli(HOST,USUARIO,PASSWORD,BASEDATOS,PUERTO)){
            $mensaje= "<p>La conexión se ha realizado correctamente</p>
            <p>Procede a crear las tablas de la base de datos y el primer usuario admnistrador</p>";
        }else{
            header("Location: install2.php");
        }
        
    }else{
        header("Location: ../index.php");
    }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación Aplicación Gestor de Reservas</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <script>
        function muestra(elemento){
            if(elemento.type=="password"){
                elemento.type="text";
            }else{
                elemento.type="password";
            }
            return false;
        }
    </script>
</head>
<body>
    <h1>Instalación Aplicación Gestor de Reservas</h1>
    <?php
       
       if(isset($mensaje)){
            echo $mensaje;
       }
       if($procediendo==false){
    ?>
    <form action="" method="post" onsubmit="">
        <fieldset>
            <legend>Primer usuario administrador</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required><br>
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" required><br>
            <label for="email">Correo Electronico</label>
            <input type="text" name="email" id="email" required><br>
            <label for="loginadmin">login</label>
            <input type="text" name="loginadmin" id="loginadmin" required><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required><button onclick="return muestra(this.previousSibling);">&#128065;</button><br>
            <input type="submit" name="proceder" value="proceder">

        </fieldset>
    </form>
    <?php
       }//fin if procediendo
     
    ?>
    <footer> <p>Gestor de reservas BETA</p>
    
    </footer>
</body>
</html>