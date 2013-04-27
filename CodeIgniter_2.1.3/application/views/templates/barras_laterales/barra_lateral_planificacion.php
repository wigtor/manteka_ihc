<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Planificación
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
				Módulos 
		    </div>
		    <div id="collapseThree" class="accordion-body collapse">
		    	<div class="accordion-inner">
					<li><a href="<?php echo site_url("Modulos/verModulos")?>">Ver módulos</a></li>
		        	<li><a href="<?php echo site_url("Modulos/agregarModulos")?>">Agregar módulos</a></li>
					<li><a href="<?php echo site_url("Modulos/editarModulos")?>">Editar módulos</a></li>
					<li><a href="<?php echo site_url("Modulos/borrarModulos")?>">Borrar módulos</a></li>
		     	</div>
		    </div>
	  </div>
	</div>

