<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "verPlanificacion";
		}
		$verPlanificacion = "";
		$agregarPlanificacion = "";
		$editarPlanificacion = "";
		$borrarPlanificacion = "";
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

