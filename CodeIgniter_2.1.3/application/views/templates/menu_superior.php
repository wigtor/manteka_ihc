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
		else if ($menuSuperiorAbierto == "Estudiantes") {
			$Estudiantes = 'class="active"';
		}

		
		$mensajesNoLeidos = "";
		if (isset($numNoLeidos)) {
			if ($numNoLeidos > 0) {
				$mensajesNoLeidos = " (".$numNoLeidos.")";
			}
		}
?>

	<ul class="nav navbar-nav">
		<li <?php echo $Correos;?> >
			<a class="dropdown-toggle" id="drop_correos" data-toggle="dropdown" role="button" href="<?php echo site_url("Correo/index") ?>">
				Correos
				<span id="botonCorreosSuperior"><?php echo $mensajesNoLeidos ?></span>
				<span class="caret"></span>
			</a>
			<?php
				echo $barra_lateral_correos; //	Barra Lateral
			?>
		</li>

		<li <?php echo $Docentes;?> >
			<a class="dropdown-toggle" id="drop_docentes" data-toggle="dropdown" role="button" href="<?php echo site_url("Profesores/index") ?>">
				Docencia
				<span class="caret"></span>
			</a>
			<?php
				echo $barra_lateral_profesores; //	Barra Lateral
			?>
		</li>

		<li <?php echo $Secciones;?> >
			<a class="dropdown-toggle" id="drop_secciones" data-toggle="dropdown" role="button" href="<?php echo site_url("Secciones/index") ?>">
				Secciones
				<span class="caret"></span>
			</a>
			<?php
				echo $barra_lateral_secciones; //	Barra Lateral
			?>
		</li>

		<li <?php echo $Planificacion;?> >
			<a class="dropdown-toggle" id="drop_planificacion" data-toggle="dropdown" role="button" href="<?php echo site_url("Planificacion/index") ?>">
				Planificación
				<span class="caret"></span>
			</a>
			<?php
				echo $barra_lateral_planificacion; //	Barra Lateral
			?>
		</li>

		<li <?php echo $Estudiantes;?> >
			<a class="dropdown-toggle" id="drop_estudiantes" data-toggle="dropdown" role="button" href="<?php echo site_url("Estudiantes/index") ?>">
				Estudiantes
				<span class="caret"></span>
			</a>
			<?php
				echo $barra_lateral_estudiantes; //	Barra Lateral
			?>
		</li>
	</ul>
