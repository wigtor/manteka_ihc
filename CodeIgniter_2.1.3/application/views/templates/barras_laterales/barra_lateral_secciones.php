<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Secciones"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verSecciones";
		}

		// Las operaciones por defecto no poseen clases
		$verSecciones = "";
		$agregarSecciones = "";
		$editarSecciones = "";
		$borrarSecciones = "";
		$asignarAseccion = "";
		$borrarAsignar = "";

		$inAsignaciones = "";
		$inSecciones = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verSecciones") {
			$verSecciones = 'class="active"';
			$inSecciones = "in";

		}
		else if ($subVistaLateralAbierta == "agregarSecciones") {
			$agregarSecciones = 'class="active"';
			$inSecciones = "in";
		}
		else if ($subVistaLateralAbierta == "editarSecciones") {
			$editarSecciones = 'class="active"';
			$inSecciones = "in";
		}
		else if ($subVistaLateralAbierta == "borrarSecciones") {
			$borrarSecciones = 'class="active"';
			$inSecciones = "in";
		}
		else if ($subVistaLateralAbierta == "asignarAseccion"){
			$asignarAseccion = 'class="active"';
			$inAsignaciones="in";
		}
		else if ($subVistaLateralAbierta == "borrarAsignar"){
			$borrarAsignar = 'class="active"';
			$inAsignaciones="in";
		}
	?>

	<!--	Barra lateral de secciones	-->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Secciones</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse <?php echo $inSecciones; ?>">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verSecciones; ?> ><a href="<?php echo site_url("Secciones/verSecciones")?>">Ver secciones</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarSecciones; ?> ><a href="<?php echo site_url("Secciones/agregarSecciones")?>">Agregar secciones</a></li>
						<li <?php echo $editarSecciones; ?> ><a href="<?php echo site_url("Secciones/editarSecciones")?>">Editar secciones</a></li>
						<li <?php echo $borrarSecciones; ?> ><a href="<?php echo site_url("Secciones/borrarSecciones")?>">Borrar secciones</a></li>
					<?php } ?>
					</div>
				</div>
			</div>

	  	<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
	  	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Asignaciones</a>
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse <?php echo $inAsignaciones; ?>">
		    	<div class="accordion-inner nav nav-list">
					<li <?php echo $asignarAseccion; ?> ><a href="<?php echo site_url("Secciones/asignarAsecciones")?>">Agregar asignación</a></li>
					<li <?php echo $borrarAsignar; ?> ><a href="<?php echo site_url("Secciones/borrarAsignacion")?>">Eliminar asignación</a></li>
		     	</div>
		    </div>
	  	</div>
	  	<?php } ?>
	</div>
