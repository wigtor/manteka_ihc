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

		// Las operaciones por defecto no poseen clases
		$verPlanificacion = "";
		$agregarPlanificacion = "";
		$editarPlanificacion = "";
		$borrarPlanificacion = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verPlanificacion") {
			$verPlanificacion = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarPlanificacion") {
			$agregarPlanificacion = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarPlanificacion") {
			$editarPlanificacion = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarPlanificacion") {
			$borrarPlanificacion = 'class="active"';
		}
	?>

	<!--	Barra lateral de correos	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Planificación</a>
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li class="active"><a href="<?php site_url("Planificacion/verPlanificacion")?>">Ver planificación</a></li>
					<li><a href="<?php echo site_url("Planificacion/editarPlanificacion")?>">Editar planificación</a></li>
		     	</div>
		    </div>
	  </div>
	  <div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Módulos</a>
		    </div>
		    <div id="collapseThree" class="accordion-body collapse">
		    	<div class="accordion-inner">
					<li <?php echo $verPlanificacion; ?> ><a href="<?php echo site_url("Modulos/verPlanificacion")?>">Ver módulos</a></li>
		        	<li <?php echo $agregarPlanificacion; ?> ><a href="<?php echo site_url("Modulos/agregarPlanificacion")?>">Agregar módulos</a></li>
					<li <?php echo $editarPlanificacion; ?> ><a href="<?php echo site_url("Modulos/editarPlanificacion")?>">Editar módulos</a></li>
					<li <?php echo $borrarPlanificacion; ?> ><a href="<?php echo site_url("Modulos/borrarPlanificacion")?>">Borrar módulos</a></li>
		     	</div>
		    </div>
	  </div>
	</div>

