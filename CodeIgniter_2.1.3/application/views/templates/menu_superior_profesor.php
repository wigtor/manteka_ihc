<!--	Menú que contiene los distintos módulos que soporta el sistema ManteKA							-->
<!--	Contiene las secciones Correos, Docentes, Secciones, Planificación, Salas, Alumnos, Informes	-->
<!--	Para cada una de las secciones se determina si está seleccionada o no							-->
<!--	Se recibe en la vista la variable $menuSuperiorAbierto desde el controlador						-->
<!--	Determinando cuál es el módulo que está seleccionado											-->

<?php
	//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($menuSuperiorAbierto)) {
			$menuSuperiorAbierto = "Correos";
		}

		// Las operaciones por defecto no poseen clases
		$Correos = "";
		$Secciones = "";
		$Alumnos = "";
		$Informes = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($menuSuperiorAbierto == "Correos") {
			$Correos = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Secciones") {
			$Secciones = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Alumnos") {
			$Alumnos = 'class="active"';
		}
		else if ($menuSuperiorAbierto == "Informes") {
			$Informes = 'class="active"';
		}


?>

	<div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li <?php echo $Correos;?> >
					<a class="btn_with_icon" href="<?php echo site_url("Correo/indexProfesor") ?>">M Correos</a>
				</li>
				<li <?php echo $Secciones;?> >
					<a class="btn_with_icon" href="<?php echo site_url("Secciones/indexProfesor") ?>">K Secciones</a>
				</li>
				<li <?php echo $Alumnos;?> >
					<a class="btn_with_icon" href="<?php echo site_url("Alumnos/indexProfesor") ?>">Ù Alumnos</a>
				</li>
				<li <?php echo $Informes;?> >
					<a class="btn_with_icon" href="<?php echo site_url("Informes/indexProfesor") ?>">E Informes</a>
				</li>
			</ul>
		</div>
	</div>
