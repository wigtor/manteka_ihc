<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Secciones
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Secciones/verSecciones")?>">Ver secciones</a></li>
	        		<li><a href="<?php echo site_url("Secciones/agregarSecciones")?>">Agregar secciones</a></li>
					<li><a href="<?php echo site_url("Secciones/editarSecciones")?>">Editar secciones</a></li>
					<li><a href="<?php echo site_url("Secciones/borrarSecciones")?>">Borrar secciones</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>
