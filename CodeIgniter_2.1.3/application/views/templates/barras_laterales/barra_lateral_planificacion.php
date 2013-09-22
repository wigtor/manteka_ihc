<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Planificación"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verPlanificacion";
		}
		if (!isset($id_tipo_usuario)) {
			$id_tipo_usuario = TIPO_USR_COORDINADOR; //Se debe borrar cuando todo se porte a MasterManteka
		}
		// Las operaciones por defecto no poseen clases
		$verPlanificacion = "";
		$agregarPlanificacion = "";
		$eliminarPlanificacion = "";
		$verModulos = "";
		$agregarModulo = "";
		$editarModulo = "";
		$eliminarModulo = "";
		$verSesiones = "";
		$agregarSesion = "";
		$editarSesion = "";
		$eliminarSesion = "";

		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inPlanificacion = "";
		$inModulos = "";
		$inSesiones = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verPlanificacion") {
			$verPlanificacion = 'class="active"';
			$inPlanificacion = 'in';
		}
		else if ($subVistaLateralAbierta == "agregarPlanificacion"){
			$agregarPlanificacion = 'class="active"';
			$inPlanificacion = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarPlanificacion"){
			$eliminarPlanificacion = 'class="active"';
			$inPlanificacion = "in";
		}
		else if ($subVistaLateralAbierta == "verModulos") {
			$verModulos = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "agregarModulo") {
			$agregarModulo = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "editarModulo") {
			$editarModulo = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "eliminarModulo") {
			$eliminarModulo = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "verSesiones") {
			$verSesiones = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "agregarSesion") {
			$agregarSesion = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "editarSesion") {
			$editarSesion = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "eliminarSesion") {
			$eliminarSesion = 'class="active"';
			$inSesiones = 'in';
		}
	?>

	<!--	Barra lateral de correos	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Planificación</a>
			</div>
			<div id="collapseTwo" class="accordion-body collapse <?php echo $inPlanificacion; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verPlanificacion; ?> ><a href="<?php echo site_url("Planificacion/verPlanificacion")?>">Ver planificación</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarPlanificacion; ?> ><a href="<?php echo site_url("Planificacion/agregarPlanificacion")?>">Agregar planificación</a></li>
						<li <?php echo $eliminarPlanificacion; ?> ><a href="<?php echo site_url("Planificacion/eliminarPlanificacion")?>">Eliminar planificación</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Módulos</a>
			</div>
			<div id="collapseThree" class="accordion-body collapse <?php echo $inModulos; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verModulos; ?> ><a href="<?php echo site_url("Modulos/verModulos")?>">Ver módulos</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarModulo; ?> ><a href="<?php echo site_url("Modulos/agregarModulo")?>">Agregar módulos</a></li>
						<li <?php echo $editarModulo; ?> ><a href="<?php echo site_url("Modulos/editarModulo")?>">Editar módulos</a></li>
						<li <?php echo $eliminarModulo; ?> ><a href="<?php echo site_url("Modulos/eliminarModulo")?>">Eliminar módulos</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
				Sesiones de clase</a>
			</div>
			<div id="collapseFour" class="accordion-body collapse <?php echo $inSesiones; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verSesiones; ?> ><a href="<?php echo site_url("Sesiones/verSesiones")?>">Ver sesiones</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarSesion; ?> ><a href="<?php echo site_url("Sesiones/agregarSesion")?>">Agregar sesiones</a></li>
						<li <?php echo $editarSesion; ?> ><a href="<?php echo site_url("Sesiones/editarSesion")?>">Editar sesiones</a></li>
						<li <?php echo $eliminarSesion; ?> ><a href="<?php echo site_url("Sesiones/eliminarSesion")?>">Eliminar sesiones</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

