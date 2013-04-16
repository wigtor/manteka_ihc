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
			<a class="btn_with_icon" href="<?php echo site_url("Correo/index") ?>">M Correos</a>
		</li>
		<?php 
			if ($menuSuperiorAbierto == "Docentes") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Profesores/index") ?>">L Docentes</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Secciones") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Secciones/index") ?>">K Secciones</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Planificacion") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Planificacion/index") ?>">É Planificación</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Salas") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Salas/index") ?>">S Salas</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Alumnos") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Alumnos/index") ?>">Ù Alumnos</a></li>
		<?php 
			if ($menuSuperiorAbierto == "Informes") {
				echo '<li class="active">';
			}
			else {
				echo '<li>';
			}
		?>
		<a class="btn_with_icon" href="<?php echo site_url("Informes/index") ?>">E Informes</a></li>
		
	</ul>
	</div>
    </div>