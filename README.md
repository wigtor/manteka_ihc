manteka_ihc
Lea la wiki para seguir las instrucciones de instalación de WAMPP y clonar el repositorio

=================================
CONFIGURACIÓN DE LA BASE DE DATOS
A continuación se presentan los datos de configuración de la base de datos, 
los cuales deben ser configurados en el gestor de mysql que utilice (phpmyAdmin por ejemplo)
Primero debe crear un usuario de la base de datos con los siguientes datos:
nombre de usuario = 'manteka_user'
Contraseña = 'manteka_IHC2013-1'
servidor = 'localhost'  (No se debe escribir localhost, phpmyadmin muestra un select en que una opción es localhost)

Ahora se deben configurar estos datos en el proyecto manteka, para que se pueda conectar a la base de datos creada.
Esto es innecesario para la mayoría si usó los datos anteriores, debido a que estos valores son los por defecto.
En el archivo ubicado en 'CodeIgniter_2.1.3\application\config\database.php' se configuran los datos para conectarse 
a la base de datos, mirar las siguientes lineas de ese archivo:

    $db['default']['hostname'] = 'localhost';
    $db['default']['username'] = 'manteka_user';
    $db['default']['password'] = 'manteka_IHC2013-1';
    $db['default']['database'] = 'manteka_db';
    $db['default']['dbdriver'] = 'mysql';

================================



================================
CONFIGURACIONES EXTRAS A WAMP Y PHP
Existen funcionalidades de ManteKA que necesitan de ciertas configuraciones de WAMP y PHP para funcionar, 
Como ejemplo de estas funcionalidades están: Loguin a través de Gmail, envío de mails.

Habilitar 'ssl_module' de Apache:
En el ícono de WAMP del área de notificación, hacer click sobre este e ir a las opciones:
Apache->Módulos de apache   y luego marcar la extensión 'ssl_module'.

Habilitar 'php_sockets' y 'php_openssl':
En el ícono de WAMP del área de notificación, hacer click sobre este e ir a las opciones:
PHP->Extensiones de php    y luego marcar las extensiones 'php_sockets' y 'php_openssl'.

Configurar un servidor SMTP:
Es necesario crear el directorio 'sendmail' en 'C:\wamp\' (o el directorio que elijió como instalación de wamp)
Dentro de este directorio se deben descomprimir los siguientes archivos: 'sendmail.exe', 'libeay32.dll', 'ssleay32.dll' and 'sendmail.ini'
Estos archivos son descargables en un archivo comprimido desde http://www.glob.com.au/sendmail/sendmail.zip
Editar el archivo 'sendmail.ini' y configurar las siguientes opciones:

    smtp_server=smtp.gmail.com
    smtp_port=465
    smtp_ssl=ssl
    default_domain=localhost
    error_logfile=error.log
    debug_logfile=debug.log
    auth_username=[your_gmail_account_username]@gmail.com
    auth_password=[your_gmail_account_password]
    pop3_server=
    pop3_username=
    pop3_password=
    force_sender=
    force_recipient=
    hostname=localhost

Cuando ManteKA esté en producción se configurará con la cuenta de gmail de Romina Rojas .T. que nos indicó el cliente.
Por ahora configúrenlo con su propia cuenta de correo para realizar pruebas.

Luego se debe configurar la ruta del archivo 'sendmail.exe' para que wamp sepa donde se encuentra:
Editar el archivo 'php.ini' ubicado en el directorio: 'C:\wamp\bin\apache\Apache2.2.17\bin\' y dejar las siguientes opciones:

    [mail function]
    ; For Win32 only.
    ; http://php.net/smtp
    ;SMTP =
    ; http://php.net/smtp-port
    ;smtp_port = 25

    ; For Win32 only.
    ; http://php.net/sendmail-from
    ;sendmail_from = you@domain.com
    ; For Unix only.  You may supply arguments as well (default: "sendmail -t -i").
    ; http://php.net/sendmail-path
    sendmail_path = "C:\wamp\sendmail\sendmail.exe -t -i"

================================


================================
CONSIDERACIONES PARA PROGRAMADORES
ManteKA está configurado para mostrar todo en formato UTF-8, se debe obligar a su editor de texto que guarde
los archivos en UTF-8 cuando los edite.

================================



================================
CONFIGURACIÓN DE RUTAS 'MANTEKA'
En el repositorio en github se tiene configurado manteka para funcionar en un servidor dentro de un directorio 
o alias llamado 'manteka', sin embargo para poder utilizar manteka en otro entorno es posible cambiar esto modificando 
el archivo 'CodeIgniter_2.1.3\application\config\config.php', al final del archivo se encuentra la linea:

    $config['dir_alias'] = "manteka";

Esto hace que manteka entienda que se ejecuta en un servidor con dirección de ejemplo:
http://localhost/manteka/
O también: http://www.direccion.com/manteka/

Si se tiene un servidor en que se instalará manteka en la raiz del servidor web, por ejemplo: http://www.direccion.com/
Notar que no existe el nombre manteka, no hay un alias. En ese caso la variable señalada anteriormente en el archivo 
config.php debe ser seteada a un string vacio como se indica a continuación:

    $config['dir_alias'] = "";


(Para instalarlo en el diinf debe ser cambiada esta opción, por ejemplo el alias en ese caso es 'anavarrete', o eso creo)

================================
FIN README
