<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Estudiantes"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "";
		}

		// Las operaciones por defecto no poseen clases
		$verEstudiantes = "";
		$agregarEstudiante = "";
		$editarEstudiante = "";
		$eliminarEstudiante = "";
		$cambiarSeccionEstudiantes = "";
		$cargaMasivaEstudiantes = "";
		$agregarAsistencia = "";
		$verAsistencia = "";
		$agregarCalificaciones = "";
		$verCalificaciones = "";


		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inEstudiantes = "";
		$inAsistencia = "";
		$inCalificaciones = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verEstudiantes") {
			$verEstudiantes = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "agregarEstudiante") {
			$agregarEstudiante = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "editarEstudiante") {
			$editarEstudiante = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarEstudiante") {
			$eliminarEstudiante = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "cambiarSeccionEstudiantes") {
			$cambiarSeccionEstudiantes = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "cargaMasivaEstudiantes") {
			$cargaMasivaEstudiantes = 'class="active"';
			$inEstudiantes = "in";
		}
		else if ($subVistaLateralAbierta == "verAsistencia") {
			$verAsistencia = 'class="active"';
			$inAsistencia = "in";
		}
		else if ($subVistaLateralAbierta == "agregarAsistencia") {
			$agregarAsistencia = 'class="active"';
			$inAsistencia = "in";
		}
		else if ($subVistaLateralAbierta == "agregarCalificaciones") {
			$agregarCalificaciones = 'class="active"';
			$inCalificaciones = "in";
		}
		else if ($subVistaLateralAbierta == "verCalificaciones") {
			$verCalificaciones = 'class="active"';
			$inCalificaciones = "in";
		}
	?>

	<ul class="dropdown-menu" role="menu" aria-labelledby="drop_estudiantes">
		<li class="dropdown-header <?php echo $inEstudiantes; ?>">Estudiantes</li>
			<li <?php echo $verEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/verEstudiantes")?>">Ver estudiantes</a></li>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<li <?php echo $agregarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/agregarEstudiante")?>">Agregar estudiantes</a></li>
			<li <?php echo $editarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/editarEstudiante")?>">Editar estudiantes</a></li>
			<li <?php echo $eliminarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/eliminarEstudiante")?>">Borrar estudiantes</a></li>
			<li <?php echo $cambiarSeccionEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cambiarSeccionEstudiantes")?>">Cambiar de sección</a></li>
			<li <?php echo $cargaMasivaEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cargaMasivaEstudiantes")?>">Carga masiva</a></li>
		<?php } ?>

		<li class="divider"></li>

		<li class="dropdown-header <?php echo $inAsistencia; ?>">Asistencia</li>
			<li <?php echo $verAsistencia; ?> ><a href="<?php echo site_url("Estudiantes/verAsistencia")?>">Ver asistencia</a></li>
			<li <?php echo $agregarAsistencia; ?> ><a href="<?php echo site_url("Estudiantes/agregarAsistencia")?>">Agregar asistencia</a></li>
		
		<li class="divider"></li>

		<li class="dropdown-header <?php echo $inCalificaciones; ?>">Calificaciones</li>
			<li <?php echo $verCalificaciones; ?> ><a href="<?php echo site_url("Estudiantes/verCalificaciones")?>">Ver calificaciones</a></li>
			<li <?php echo $agregarCalificaciones; ?> ><a href="<?php echo site_url("Estudiantes/agregarCalificaciones")?>">Agregar calificaciones</a></li>
			
	</ul>
