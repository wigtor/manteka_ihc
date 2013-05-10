manteka_ihc
Lea la wiki para seguir las instrucciones de instalación de WAMPP y clonar el repositorio

=================================
¿Cómo arreglar problemas de merge localmente? (entre el github que tienen en su computador y el repositorio)
Paso 1:
Abrir la consola de github mediante el programa github, abrir el repositorio, click en "tools" (aparece arriba)
y luego "open a shell here"

Paso 2:
Escribir en la consola:
    git checkout master
    
Paso 3:
Escribir en la consola:
    git pull https://github.com/USUARIO/manteka_ihc.git BRANCHNAME
Donde "USUARIO" es el nombre del usuario dueño del repositorio de su grupo (scrum master de su grupo)
"BRANCHNAME" es un nombre cualquiera con que van a nombrar a su rama local con cambios. Por ejemplo: cambios7Mayo_mario

Paso 4:
El paso anterior les va a mostrar los nombres de todos los archivos que tienen conflictos, deben abrir estos archivos 
utilizando su editor de texto preferido y buscar los siguiente tipos de código:

    >>>>>> HEAD
    //código cualquiera, es el que se encuentra en el repositorio remoto (github.com)
    
    =========
    //Código local que tiene conflictos con la sección de código que está arriba de los signos igual.
    =========3546323b23451b14cdf23f
    
Ese número extraño que aparece al final es un hash para identificar sus cambios, lo que escribí es un ejemplo.
Esta es una forma que tiene github para delimitar las lineas de código que tienen conflictos.
Deben editar las partes del archivo que tengan algo como lo indicado anteriormente, escoger con que lineas de código se quedan
Finalmente borrar las lineas que dicen ">>>> HEAD", "=======" y "=========3546323b23451b14cdf23f", además de borrar
las lineas de código con que no se quieren quedar.
Luego de arreglar todos los archivos con conflictos y todos los conflictos que haya en cada archivo, guarden los archivos.

Paso 5:
Escribir en la consola:
    git commit -a
Se abrirá el notepad, cierrenlo.

Paso 6: 
Escribir en la consola:
    git push origin master
    
    
Con esto es suficiente, el último paso hace que se suban los cambios al repositorio de su grupo, 
luego de esto es recomendable que hable con su grupo indicando que se hizo un merge con conflictos y 
que se avise inmediatamente si se han perdido lineas de código.
(revisen los historiales de github y restauren las lineas perdidas en caso de que ocurran problemas así)


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
