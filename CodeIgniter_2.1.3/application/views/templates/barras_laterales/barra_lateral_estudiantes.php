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
		$agregarAsistencia = "";
		$verAsistencia = "";
		$cargaMasivaAsistencia = "";
		$agregarCalificaciones = "";
		$verCalificaciones = "";
		$cargaMasivaCalificaciones = "";


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
		else if ($subVistaLateralAbierta == "cargaMasivaAsistencia") {
			$cargaMasivaAsistencia = 'class="active"';
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
		else if ($subVistaLateralAbierta == "cargaMasivaCalificaciones") {
			$cargaMasivaCalificaciones = 'class="active"';
			$inCalificaciones = "in";
		}
	?>

	<!--	Barra lateral de estudiantes	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Estudiantes</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse <?php echo $inEstudiantes; ?>" >
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/verEstudiantes")?>">Ver estudiantes</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/agregarEstudiante")?>">Agregar estudiantes</a></li>
						<li <?php echo $editarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/editarEstudiante")?>">Editar estudiantes</a></li>
						<li <?php echo $eliminarEstudiante; ?> ><a href="<?php echo site_url("Estudiantes/eliminarEstudiante")?>">Borrar estudiantes</a></li>
						<li <?php echo $cambiarSeccionEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cambiarSeccionEstudiantes")?>">Cambiar de sección</a></li>
						<li <?php echo $cargaMasivaEstudiantes; ?> ><a href="<?php echo site_url("Estudiantes/cargaMasivaEstudiantes")?>">Carga masiva</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Asistencia</a>
			</div>
			<div id="collapseTwo" class="accordion-body collapse <?php echo $inAsistencia; ?>" >
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verAsistencia; ?> ><a href="<?php echo site_url("Estudiantes/verAsistencia")?>">Ver asistencia</a></li>
					<li <?php echo $agregarAsistencia; ?> ><a href="<?php echo site_url("Estudiantes/agregarAsistencia")?>">Agregar asistencia</a></li>
					<li <?php echo $cargaMasivaAsistencia; ?> ><a href="<?php echo site_url("Estudiantes/cargaMasivaAsistencia")?>">Carga masiva asistencia</a></li>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Calificaciones</a>
			</div>
			<div id="collapseThree" class="accordion-body collapse <?php echo $inCalificaciones; ?>" >
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verCalificaciones; ?> ><a href="<?php echo site_url("Estudiantes/verCalificaciones")?>">Ver calificaciones</a></li>
					<li <?php echo $agregarCalificaciones; ?> ><a href="<?php echo site_url("Estudiantes/agregarCalificaciones")?>">Agregar calificaciones</a></li>
					<li <?php echo $cargaMasivaCalificaciones; ?> ><a href="<?php echo site_url("Estudiantes/cargaMasivaCalificaciones")?>">Carga masiva calificaciones</a></li>
				</div>
			</div>
		</div>
	</div>
