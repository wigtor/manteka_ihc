<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Correos
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Correo/correosEnviados")?>">Correos enviados</a></li>
	        		<li><a href="<?php echo site_url("Correo/enviarCorreo")?>">Enviar correo</a></li>
					<li><a href="<?php echo site_url("Correo/verBorradores")?>">Ver borradores</a></li>
		     	</div>
		    </div>
	  	</div>
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Plantillas
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("Plantillas/agregarPlantillas")?>">Agregar plantillas</a></li>
					<li><a href="<?php echo site_url("Plantillas/editarPlantillas")?>">Editar plantillas</a></li>
					<li><a href="<?php echo site_url("Plantillas/borrarPlantillas")?>">Borrar plantillas</a></li>
		     	</div>
		    </div>
	  </div>
	  <div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Grupos de contactos 
		    </div>
		    <div id="collapseThree" class="accordion-body collapse">
		    	<div class="accordion-inner">
		        	<li><a href="<?php echo site_url("GruposContactos/verGrupos")?>">Ver grupos</a></li>
					<li><a href="<?php echo site_url("GruposContactos/agregarGrupos")?>">Agregar grupos</a></li>
					<li><a href="<?php echo site_url("GruposContactos/editarGrupos")?>">Editar grupos</a></li>
					<li><a href="<?php echo site_url("GruposContactos/borrarGrupos")?>">Borrar grupos</a></li>
		     	</div>
		    </div>
	  </div>
	</div>

