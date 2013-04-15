<!-- Contiene los botones que debe tener el menu superior -->
<?php
	#En este archivo se definen los botones que tendrá el menu superior del administrador.
	#De esta forma es posible a futuro sólo modificar este archivo para agregar botones
	#Esto se hace mediante un arreglo asociativo
	#En el primer elemento se especifica el texto del botón
	#En el segundo elemento se especifica la URL del ícono que se mostrará en el botón
	#En el tercer elemento se especifica un arreglo de enteros con los tipos de usuarios que ven esta vista (Ver el archivo de constantes del framework)
	$botones_menu_superior = array(
	
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Correo", "url_icono" => "/".config_item('dir_alias')."/img/icons/mail-message.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)), 
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Profesores", "url_icono" => "/".config_item('dir_alias')."/img/icons/system-users.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)), 
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Secciones", "url_icono" => "/".config_item('dir_alias')."/img/icons/seccion.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)),
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Módulos", "url_icono" => "/".config_item('dir_alias')."/img/icons/university.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)),
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Salas", "url_icono" => "/".config_item('dir_alias')."/img/icons/sala.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)),
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Alumnos", "url_icono" => "/".config_item('dir_alias')."/img/icons/system-users.png", "tipo_usr" => array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR)),
		array("link"=> "/".config_item('dir_alias')."/img/icons/mail-message.png", "texto" => "Informes", "url_icono" => "/".config_item('dir_alias')."/img/icons/inform.png", "tipo_usr" => array(TIPO_USR_COORDINADOR)) //Este por ejemplo solo se muestra al coordinador
	)
	
	##Olvidenlo, no me sirvió, sale peor así
?>