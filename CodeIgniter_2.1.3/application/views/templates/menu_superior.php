<!-- Menu que contiene todos los "casos de uso" (lo más macro) -->
    <div class="navbar">
		<div class="navbar-inner">
			


	<ul class="nav">
		<?php 
			if ($menuSuperiorAbierto == "Correos") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
			<a class="btn_with_icon" href="<?php echo site_url("Correo/index") ?>">MCorreos</a>
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
		<a href="<?php echo site_url("Secciones/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/users.png" alt="Correo">Secciones</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Planificacion") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Planificacion/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/calendar2.png" alt="Correo">Planificación</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Salas") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a href="<?php echo site_url("Salas/index") ?>"><img class="icon_menu_superior" src="/<?php echo config_item('dir_alias') ?>/img/icons/library.png"  alt="Correo">Salas</a></li>
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
	</div>
    </div>