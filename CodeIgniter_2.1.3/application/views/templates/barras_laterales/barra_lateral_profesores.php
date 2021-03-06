<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Secciones"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "correosEnviados";
		}
		if (!isset($id_tipo_usuario)) {
			$id_tipo_usuario = TIPO_USR_COORDINADOR; //Se debe borrar cuando todo se porte a MasterManteka
		}
		// Las operaciones por defecto no poseen clases
		$verProfesores = "";
		$agregarProfesor = "";
		$editarProfesor = "";
		$eliminarProfesor = "";
		$verAyudantes = "";
		$agregarAyudante = "";
		$editarAyudante = "";
		$eliminarAyudante = "";
		$verCoordinadores = "";
		$agregarCoordinador = "";
		$editarCoordinador = "";
		$eliminarCoordinador = "";

		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inProfesores = "";
		$inAyudantes = "";
		$inCoordinadores = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		//	Dependiendo de qué operación esta seleccionada, se abre un determinado grupo de acciones
		if ($subVistaLateralAbierta == "verProfesores") {
			$verProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarProfesor") {
			$agregarProfesor = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "editarProfesor") {
			$editarProfesor = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarProfesor") {
			$eliminarProfesor = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "verAyudantes") {
			$verAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "agregarAyudante") {
			$agregarAyudante = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "editarAyudante") {
			$editarAyudante = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarAyudante") {
			$eliminarAyudante = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "verCoordinadores") {
			$verCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarCoordinador") {
			$agregarCoordinador = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "editarCoordinador") {
			$editarCoordinador = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarCoordinador") {
			$eliminarCoordinador = 'class="active"';
			$inCoordinadores = "in";
		}
	?>

	<!--	Barra lateral de profesores	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Profesores</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse <?php echo $inProfesores; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verProfesores?>><a href="<?php echo site_url("Profesores/verProfesores")?>">Ver profesores</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarProfesor; ?> ><a href="<?php echo site_url("Profesores/agregarProfesor")?>">Agregar profesores</a></li>
						<li <?php echo $editarProfesor; ?> ><a href="<?php echo site_url("Profesores/editarProfesor")?>">Editar  profesores</a></li>
						<li <?php echo $eliminarProfesor; ?> ><a href="<?php echo site_url("Profesores/eliminarProfesor")?>">Borrar profesores</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Ayudantes</a>
			</div>
			<div id="collapseTwo" class="accordion-body collapse <?php echo $inAyudantes; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/verAyudantes")?>">Ver ayudantes</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/agregarAyudante")?>">Agregar ayudantes</a></li>
						<li <?php echo $editarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/editarAyudante")?>">Editar ayudantes</a></li>
						<li <?php echo $eliminarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/eliminarAyudante")?>">Borrar ayudantes</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
					Coordinadores</a>
				</div>
				<div id="collapseThree" class="accordion-body collapse <?php echo $inCoordinadores; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $verCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/verCoordinadores")?>">Ver coordinadores</a></li>
						<li <?php echo $agregarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/agregarCoordinador")?>">Agregar coordinadores</a></li>
						<li <?php echo $editarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/editarCoordinador")?>">Editar coordinadores</a></li>
						<li <?php echo $eliminarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/eliminarCoordinador")?>">Borrar coordinadores</a></li>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	