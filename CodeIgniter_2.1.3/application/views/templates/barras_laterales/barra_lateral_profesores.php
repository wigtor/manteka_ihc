<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "correosEnviados";
		}
		$verProfesores = "";
		$agregarProfesores = "";
		$editarProfesores = "";
		$borrarProfesores = "";
		$verAyudantes = "";
		$agregarAyudantes = "";
		$editarAyudantes = "";
		$borrarAyudantes = "";
		$verCoordinadores = "";
		$agregarCoordinadores = "";
		$editarCoordinadores = "";
		$borrarCoordinadores = "";

		$inProfesores = "";
		$inAyudantes = "";
		$inCoordinadores = "";

		if ($subVistaLateralAbierta == "verProfesores") {
			$verProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarProfesores") {
			$agregarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "editarProfesores") {
			$editarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "borrarProfesores") {
			$borrarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "verAyudantes") {
			$verAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "agregarAyudantes") {
			$agregarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "editarAyudantes") {
			$editarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "borrarAyudantes") {
			$borrarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "verCoordinadores") {
			$verCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarCoordinadores") {
			$agregarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "editarCoordinadores") {
			$editarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "borrarCoordinadores") {
			$borrarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
	?>
    <div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Profesores</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse <?php echo $inProfesores; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $verProfesores?>><a href="<?php echo site_url("Profesores/verProfesores")?>">Ver profesores</a></li>
	        		<li <?php echo $agregarProfesores; ?> ><a href="<?php echo site_url("Profesores/agregarProfesores")?>">Agregar profesores</a></li>
					<li <?php echo $editarProfesores; ?> ><a href="<?php echo site_url("Profesores/editarProfesores")?>">Editar  profesores</a></li>
					<li <?php echo $borrarProfesores; ?> ><a href="<?php echo site_url("Profesores/borrarProfesores")?>">Borrar profesores</a></li>
		     	</div>
		    </div>
	  	</div>
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Ayudantes</a>
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse <?php echo $inAyudantes; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $verAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/verAyudantes")?>">Ver ayudantes</a></li>
					<li <?php echo $agregarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/agregarAyudantes")?>">Agregar ayudantes</a></li>
					<li <?php echo $editarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/editarAyudantes")?>">Editar ayudantes</a></li>
					<li <?php echo $borrarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/borrarAyudantes")?>">Borrar ayudantes</a></li>
		     	</div>
		    </div>
	  </div>
	  <div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
				Coordinadores</a>
		    </div>
		    <div id="collapseThree" class="accordion-body collapse <?php echo $inCoordinadores; ?>">
		    	<div class="accordion-inner">
		        	<li <?php echo $verCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/verCoordinadores")?>">Ver coordinadores</a></li>
					<li <?php echo $agregarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/agregarCoordinadores")?>">Agregar coordinador</a></li>
					<li <?php echo $editarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/editarCoordinadores")?>">Editar coordinador</a></li>
					<li <?php echo $borrarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/borrarCoordinadores")?>">Borrar coordinador</a></li>
		     	</div>
		    </div>
	  </div>
	</div>
	