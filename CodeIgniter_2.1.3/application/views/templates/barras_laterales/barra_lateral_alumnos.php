<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Alumnos
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li class="active"><a href="<?php echo site_url("Alumnos/verAlumnos")?>">Ver alumnos</a></li>
					<li><a href="<?php echo site_url("Alumnos/agregarAlumnos")?>">Agregar alumnos</a></li>
					<li><a href="<?php echo site_url("Alumnos/editarAlumnos")?>">Editar alumnos</a></li>
					<li><a href="<?php echo site_url("Alumnos/borrarAlumnos")?>">Borrar alumnos</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>
