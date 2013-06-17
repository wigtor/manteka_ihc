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
		$id_tipo_usuario = TIPO_USR_COORDINADOR; //Se debe borrar cuando todo se porte a MasterManteka
		// Las operaciones por defecto no poseen clases
		$verPlanificacion = "";
		$editarPlanificacion = "";
		$verModulos = "";
		$agregarModulos = "";
		$editarModulos = "";
		$borrarModulos = "";
		$verSesiones = "";
		$agregarSesiones = "";
		$editarSesiones = "";
		$borrarSesiones = "";


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
		else if ($subVistaLateralAbierta == "editarPlanificacion") {
			$editarPlanificacion = 'class="active"';
			$inPlanificacion = 'in';
		}
		else if ($subVistaLateralAbierta == "verModulos") {
			$verModulos = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "agregarModulos") {
			$agregarModulos = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "editarModulos") {
			$editarModulos = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "borrarModulos") {
			$borrarModulos = 'class="active"';
			$inModulos = 'in';
		}
		else if ($subVistaLateralAbierta == "verSesiones") {
			$verSesiones = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "agregarSesiones") {
			$agregarSesiones = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "editarSesiones") {
			$editarSesiones = 'class="active"';
			$inSesiones = 'in';
		}
		else if ($subVistaLateralAbierta == "borrarSesiones") {
			$borrarSesiones = 'class="active"';
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
					<li <?php echo $verPlanificacion; ?> ><a href="<?php site_url("Planificacion/verPlanificacion")?>">Ver planificación</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $editarPlanificacion; ?> ><a href="<?php echo site_url("Planificacion/editarPlanificacion")?>">Editar planificación</a></li>
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
						<li <?php echo $agregarModulos; ?> ><a href="<?php echo site_url("Modulos/agregarModulos")?>">Agregar módulos</a></li>
						<li <?php echo $editarModulos; ?> ><a href="<?php echo site_url("Modulos/editarModulos")?>">Editar módulos</a></li>
						<li <?php echo $borrarModulos; ?> ><a href="<?php echo site_url("Modulos/borrarModulos")?>">Borrar módulos</a></li>
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
						<li <?php echo $agregarSesiones; ?> ><a href="<?php echo site_url("Sesiones/agregarSesiones")?>">Agregar sesiones</a></li>
						<li <?php echo $editarSesiones; ?> ><a href="<?php echo site_url("Sesiones/editarSesiones")?>">Editar sesiones</a></li>
						<li <?php echo $borrarSesiones; ?> ><a href="<?php echo site_url("Sesiones/borrarSesiones")?>">Borrar sesiones</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

