<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "correosEnviados";
		}
		$correosEnviados = "";
		$enviarCorreo = "";
		$verBorradores = "";
		$agregarPlantillas = "";
		$editarPlantillas = "";
		$borrarPlantillas = "";
		$verGrupos = "";
		$agregarGrupos = "";
		$editarGrupos = "";
		$borrarGrupos = "";
		$inCorreos = "";
		$inPlantillas = "";
		$inGrupos = "";

		if ($subVistaLateralAbierta == "correosEnviados") {
			$correosEnviados = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "enviarCorreo") {
			$enviarCorreo = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "verBorradores") {
			$verBorradores = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "agregarPlantillas") {
			$agregarPlantillas = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "editarPlantillas") {
			$editarPlantillas = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "borrarPlantillas") {
			$borrarPlantillas = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "verGrupos") {
			$verGrupos = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "agregarGrupos") {
			$agregarGrupos = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "editarGrupos") {
			$editarGrupos = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "borrarGrupos") {
			$borrarGrupos = 'class="active"';
			$inGrupos = "in";
		}
	?>
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Correos</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse <?php echo $inCorreos; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $correosEnviados; ?> ><a href="<?php echo site_url("Correo/correosEnviados")?>">Correos enviados</a></li>
	        		<li <?php echo $enviarCorreo; ?> ><a href="<?php echo site_url("Correo/enviarCorreo")?>">Enviar correo</a></li>
					<li <?php echo $verBorradores; ?> ><a href="<?php echo site_url("Correo/verBorradores")?>">Ver borradores</a></li>
		     	</div>
		    </div>
	  	</div>
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Plantillas</a>
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse <?php echo $inPlantillas; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $agregarPlantillas; ?> ><a href="<?php echo site_url("Plantillas/agregarPlantillas")?>">Agregar plantillas</a></li>
					<li <?php echo $editarPlantillas; ?> ><a href="<?php echo site_url("Plantillas/editarPlantillas")?>">Editar plantillas</a></li>
					<li <?php echo $borrarPlantillas; ?> ><a href="<?php echo site_url("Plantillas/borrarPlantillas")?>">Borrar plantillas</a></li>
		     	</div>
		    </div>
	  </div>
	  <div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Grupos de contactos</a>
		    </div>
		    <div id="collapseThree" class="accordion-body collapse <?php echo $inGrupos; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $verGrupos; ?> ><a href="<?php echo site_url("GruposContactos/verGrupos")?>">Ver grupos</a></li>
					<li <?php echo $agregarGrupos; ?> ><a href="<?php echo site_url("GruposContactos/agregarGrupos")?>">Agregar grupos</a></li>
					<li <?php echo $editarGrupos; ?> ><a href="<?php echo site_url("GruposContactos/editarGrupos")?>">Editar grupos</a></li>
					<li <?php echo $borrarGrupos; ?> ><a href="<?php echo site_url("GruposContactos/borrarGrupos")?>">Borrar grupos</a></li>
		     	</div>
		    </div>
	  </div>
	</div>

