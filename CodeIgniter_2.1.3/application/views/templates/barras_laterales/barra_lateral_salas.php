<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Salas
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li class="active"><a href="<?php site_url("Salas/verSalas")?>">Ver salas</a></li>
					<li><a href="<?php echo site_url("Salas/agregarSalas")?>">Agregar salas</a></li>
					<li><a href="<?php echo site_url("Salas/editarSalas")?>">Editar salas</a></li>
					<li><a href="<?php echo site_url("Salas/borrarSalas")?>">Borrar salas</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>