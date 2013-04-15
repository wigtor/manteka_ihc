<!-- Menu que contiene todos los "casos de uso" (lo más macro) -->


	<ul class="nav nav-tabs barra_superior">
		<?php 
			if ($menuSuperiorAbierto == "Correos") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
			<a href="<?php echo site_url("Correo/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/mail.png" alt="Correo">Correos</a>
		</li>
		<?php 
			if ($menuSuperiorAbierto == "Docentes") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Profesores/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/user4.png" alt="Correo">Docentes</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Secciones") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Secciones/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/seccion.png" alt="Correo">Secciones</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Planificacion") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Planificacion/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/university.png" alt="Correo">Planificación</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Salas") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Salas/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/sala.png"  alt="Correo">Salas</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Alumnos") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Alumnos/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/user.png" alt="Correo" height="50px" width="50px">Alumnos</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Informes") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Informes/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/book.png" alt="Correo" height="50px" width="50px">Informes</a></li>
		
	</ul>
