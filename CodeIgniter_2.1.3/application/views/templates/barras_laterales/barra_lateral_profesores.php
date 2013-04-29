<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->

    <div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Profesores
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Profesores/verProfesores")?>">Ver profesores</a></li>
	        		<li><a href="<?php echo site_url("Profesores/agregarProfesores")?>">Agregar profesores</a></li>
					<li><a href="<?php echo site_url("Profesores/editarProfesores")?>">Editar  profesores</a></li>
					<li><a href="<?php echo site_url("Profesores/borrarProfesores")?>">Borrar profesores</a></li>
		     	</div>
		    </div>
	  	</div>
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Ayudantes
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Ayudantes/verAyudantes")?>">Ver ayudantes</a></li>
					<li><a href="<?php echo site_url("Ayudantes/agregarAyudantes")?>">Agregar ayudantes</a></li>
					<li><a href="<?php echo site_url("Ayudantes/editarAyudantes")?>">Editar ayudantes</a></li>
					<li><a href="<?php echo site_url("Ayudantes/borrarAyudantes")?>">Borrar ayudantes</a></li>
		     	</div>
		    </div>
	  </div>
	  <div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Coordinadores
		    </div>
		    <div id="collapseThree" class="accordion-body collapse">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Coordinadores/verCoordinadores")?>">Ver Coordinadores</a></li>
					<li><a href="<?php echo site_url("Coordinadores/agregarCoordinadores")?>">Agregar coordinador</a></li>
					<li><a href="<?php echo site_url("Coordinadores/borrarCoordinadores")?>">Borrar coordinador</a></li>
		     	</div>
		    </div>
	  </div>
	</div>
	