<!--	Menú que contiene los distintos módulos que soporta el sistema ManteKA							-->
<!--	Contiene las secciones Correos, Docentes, Secciones, Planificación, Salas, Estudiantes, Informes	-->
<!--	Para cada una de las secciones se determina si está seleccionada o no							-->
<!--	Se recibe en la vista la variable $menuSuperiorAbierto desde el controlador						-->
<!--	Determinando cuál es el módulo que está seleccionado											-->

<?php
	//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($menuSuperiorAbierto)) {
			$menuSuperiorAbierto = "Correos";
		}
		if (!isset($id_tipo_usuario)) {
			$id_tipo_usuario = TIPO_USR_COORDINADOR; //Se debe borrar cuando todo se porte a MasterManteka
		}
		// Las operaciones por defecto no poseen clases
		$Correos = "";
		$Docentes = "";
		$Secciones = "";
		$Planificacion = "";
		$Salas = "";
		$Estudiantes = "";
		$Reportes = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($menuSuperiorAbierto == "Correos") {
			$Correos = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Docentes") {
			$Docentes = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Secciones") {
			$Secciones = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Planificacion") {
			$Planificacion = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Salas") {
			$Salas = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Estudiantes") {
			$Estudiantes = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Reportes") {
			$Reportes = 'class="active"';
		}

		
		$mensajesNoLeidos = "";
		if (isset($numNoLeidos)) {
			if ($numNoLeidos > 0) {
				$mensajesNoLeidos = " (".$numNoLeidos.")";
			}
		}
?>

	<div class="navbar pull-right">
		<div class="navbar-inner" style="width:815px;">
			<ul class="nav">
				<li <?php echo $Correos;?> >
					<a class="btn_with_icon" style="max-width:100px;" href="<?php echo site_url("Correo/index") ?>">M Correos<span id="botonCorreosSuperior"><?php echo $mensajesNoLeidos ?></span></a>
				</li>
				<li <?php echo $Docentes;?> >
					<a class="btn_with_icon" style="max-width:100px;" href="<?php echo site_url("Profesores/index") ?>">L Docencia</a>
				</li>
				<li <?php echo $Secciones;?> >
					<a class="btn_with_icon" style="max-width:100px;" href="<?php echo site_url("Secciones/index") ?>">K Secciones</a>
				</li>
				<li <?php echo $Planificacion;?> >
					<a class="btn_with_icon" style="max-width:100px;" href="<?php echo site_url("Planificacion/index") ?>">É Planificación</a>
				</li>
				<li <?php echo $Salas;?> >
					<a class="btn_with_icon" style="max-width:90px;" href="<?php echo site_url("Salas/index") ?>">S Salas</a>
				</li>
				<li <?php echo $Estudiantes;?> >
					<a class="btn_with_icon" style="max-width:95px;" href="<?php echo site_url("Estudiantes/index") ?>">Ù Estudiantes</a>
				</li>
				<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
				<li <?php echo $Reportes;?> >
					<a class="btn_with_icon" style="max-width:100px;" href="<?php echo site_url("ReportesSistema/index") ?>">E Reportes</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
