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
		$editarPlanificacion = "";
		$verModulos = "";
		$agregarModulos = "";
		$editarModulos = "";
		$borrarModulos = "";

		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inPlanificacion = "";
		$inModulos = "";

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
					<li <?php echo $editarPlanificacion; ?> ><a href="<?php echo site_url("Planificacion/editarPlanificacion")?>">Editar planificación</a></li>
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
		        	<li <?php echo $agregarModulos; ?> ><a href="<?php echo site_url("Modulos/agregarModulos")?>">Agregar módulos</a></li>
					<li <?php echo $editarModulos; ?> ><a href="<?php echo site_url("Modulos/editarModulos")?>">Editar módulos</a></li>
					<li <?php echo $borrarModulos; ?> ><a href="<?php echo site_url("Modulos/borrarModulos")?>">Borrar módulos</a></li>
		     	</div>
		    </div>
	  </div>
	</div>

