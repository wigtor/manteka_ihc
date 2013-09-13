<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Estudiantes"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verEstudiantes";
		}

		// Las operaciones por defecto no poseen clases
		$verEstudiantes = "";
		$agregarEstudiante = "";
		$editarEstudiante = "";
		$eliminarEstudiante = "";
		$cambiarSeccionEstudiantes = "";
		$cargaMasivaEstudiantes = "";
		$asistencia = "";
		$calificaciones = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verEstudiantes") {
			$verEstudiantes = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarEstudiante") {
			$agregarEstudiante = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarEstudiante") {
			$editarEstudiante = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "eliminarEstudiante") {
			$eliminarEstudiante = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "cambiarSeccionEstudiantes") {
			$cambiarSeccionEstudiantes = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "cargaMasivaEstudiantes") {
			$cargaMasivaEstudiantes = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "asistencia") {
			$asistencia = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "calificaciones") {
			$calificaciones = 'class="active"';
		}
	?>

	<!--	Barra lateral de estudiantes	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Estudiantes</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/verEstudiantes")?>">Ver estudiantes</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/agregarEstudiante")?>">Agregar estudiantes</a></li>
						<li <?php echo $editarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/editarEstudiante")?>">Editar estudiantes</a></li>
						<li <?php echo $eliminarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/eliminarEstudiante")?>">Borrar estudiantes</a></li>
						<li <?php echo $cambiarSeccionEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cambiarSeccionEstudiantes")?>">Cambiar de sección</a></li>
						<li <?php echo $cargaMasivaEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cargaMasivaEstudiantes")?>">Carga masiva</a></li>
					<?php } ?>
					<?php if ($id_tipo_usuario == TIPO_USR_PROFESOR) { ?>
						<li <?php echo $asistencia; ?> ><a href="<?php echo site_url("Estudiantes/asistencia")?>">Asistencia</a></li>
						<li <?php echo $calificaciones; ?> ><a href="<?php echo site_url("Estudiantes/calificaciones")?>">Calificaciones</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
