<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Secciones"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "";
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

	<ul class="dropdown-menu" role="menu" aria-labelledby="drop_docentes">
		<li class="dropdown-header <?php echo $inProfesores; ?>">Profesores</li>
			<li <?php echo $verProfesores?>><a href="<?php echo site_url("Profesores/verProfesores")?>">Ver profesores</a></li>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<li <?php echo $agregarProfesor; ?> ><a href="<?php echo site_url("Profesores/agregarProfesor")?>">Agregar profesores</a></li>
			<li <?php echo $editarProfesor; ?> ><a href="<?php echo site_url("Profesores/editarProfesor")?>">Editar  profesores</a></li>
			<li <?php echo $eliminarProfesor; ?> ><a href="<?php echo site_url("Profesores/eliminarProfesor")?>">Borrar profesores</a></li>
		<?php } ?>

		<li class="divider"></li>

		<li class="dropdown-header <?php echo $inAyudantes; ?>">Ayudantes</li>
			<li <?php echo $verAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/verAyudantes")?>">Ver ayudantes</a></li>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<li <?php echo $agregarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/agregarAyudante")?>">Agregar ayudantes</a></li>
			<li <?php echo $editarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/editarAyudante")?>">Editar ayudantes</a></li>
			<li <?php echo $eliminarAyudante; ?> ><a href="<?php echo site_url("Ayudantes/eliminarAyudante")?>">Borrar ayudantes</a></li>
		<?php } ?>

		<li class="divider"></li>

		<li class="dropdown-header <?php echo $inCoordinadores; ?>">Coordinadores</li>
			<li <?php echo $verCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/verCoordinadores")?>">Ver coordinadores</a></li>
			<li <?php echo $agregarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/agregarCoordinador")?>">Agregar coordinadores</a></li>
			<li <?php echo $editarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/editarCoordinador")?>">Editar coordinadores</a></li>
			<li <?php echo $eliminarCoordinador; ?> ><a href="<?php echo site_url("Coordinadores/eliminarCoordinador")?>">Borrar coordinadores</a></li>
		
	</ul>
