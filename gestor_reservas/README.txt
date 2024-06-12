Hola!
Bienvenido a la versión beta de mi gestor de reservas.
Te explico como realizar la instalación y un pequeño tour por la aplicación, tocando todas las funcionalidades

INSTALACIÓN:
Cuando entras en la aplicación en tu entorno web, si no detecta un archivo de configuración, te llevará a un archivo donde te dirá qué debes preparar cierta información.
Posteriormente, te redirigirá a un formulario qué te pedirá la ip del host de tu sistema gestor de base de datos, el usuario y contraseña de tu sistema gestor de base de datos, el nombre de la base de datos qué vas a utilizar y el puerto. 
Si la conexión se realiza de forma correcta, te redirigirá al siguiente paso de la instalación, donde te pedirá un nombre, apellidos, correo electrónico, un login (nombre de usuario) y una contraseña. Este último archivo, generará las tablas de la base de datos (admins, usuarios, reserva y servicios) e insertará los datos introducidos en la tabla admins. 
Si todo funciona correctamente te llevará al archivo index.php
(Si en algun momento necesitas volver a hacer la instalación, solo tienes que eliminar las tablas de la base de datos y el archivo config.php, que se encuentra en la carpeta config en el directorio raiz del programa)


Index.php:
En este archivo, podrás iniciar sesión, registrarte como nuevo usuario y acceder al login de administradores (dando click en el icono del engranaje).


Inicio de sesión:
Será el inicio de sesión para usuarios básicos, con un formulario qué te pedirá el login y la contraseña


Registro:
Podrás registrarte como usuario común, rellenando un formulario qué te pedirá nombre, apellidos, correo electrónico, un login (nombre de usuario) y una contraseña. Cuando realices el registro, te redirigirá de nuevo al index para poder iniciar sesión


Página del usuario básico (secure.php):
En esta página sólo podrás acceder si has iniciado sesión, y tendrá las siguientes funcionalidades: ver tu propio historial de reservas, acceder a la edición de datos de tu cuenta, tales como contraseña y nombre de usuario (pulsando en el icono de usuario), cerrar la sesión y realizar una nueva reserva


Historial de reservas:
Podrás ver todas tus reservas realizadas, ver su estado (pagada, cancelada, aplazada o pendiente de pago), cancelar la reserva, y realizar el pago si no se ha realizado al hacer la reserva.



Perfil:
Podrás cambiar tu contraseña y tu nombre de usuario.


Cerrar sesión:
Destruirá la variable de sesión y te devolverá al index


Realizar reservas:
En esta página, tendrás un pequeño formulario donde podrás elegir una fecha para la reserva y el tipo de servicio qué quieres. Solo será posible qué haya una reserva al día del mismo tipo de servicio, es decir, si el servicio es distinto, puedes tener tantas reservas en un día como servicios existan.
Al final del formulario, te dejará escoger entre pagar inmediatamente, o pagar más adelante.


Pago:
Una pequeña pasarela de pago [EN ESTE MOMENTO, AL SER UNA VERSIÓN DE PRUEBA, EL FORMULARIO NO TIENE FUNCIONALIDAD, NO GUARDA LOS DATOS EN NINGÚNA BASE DE DATOS] en la qué te pedirá datos bancarios, y al darle al botón de pagar, te dirá si se ha realizado el pago correctamente, devolviendote en 3 segundos a la página del usuario común.


MODO ADMINISTRADOR:
Al pulsar el engranaje, nos llevará a un login de administradores. Cuando hayamos iniciado la sesión, tendremos 3 botones: uno qué nos lleva a una nueva página para gestionar reservas, otro para gestionar usuarios y otro para gestionar servicios.


Gestionar Reservas:
En esta página tendremos la posibilidad de ver un listado con todos los datos de todas las reservas de la base de datos. Además, podremos eliminarlas y cambiar sus estados a nuestro antojo (eres administrador, tienes el control).


Gestionar Usuarios:
En esta página, veremos un listado de todos los usuarios de la base de datos, teniendo la posibilidad de eliminarlos (eres administrador, tienes el control).


Gestionar Servicios:
En esta última página, tendrás un listado de servicios. Estos podrán ser eliminados y también podrás crear servicios nuevos (eres administrador, tienes el control).


Y hasta aquí el tour, gracias por usar mi aplicación. Si tienes algún tipo de duda, no dudes en contactarme vía mail al siguiente correo: ddpq.2804@gmail.com

