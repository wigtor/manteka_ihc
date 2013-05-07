<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "verAlumnos";
		}
		$verAlumnos = "";
		$agregarAlumnos = "";
		$editarAlumnos = "";
		$borrarAlumnos = "";

		if ($subVistaLateralAbierta == "verAlumnos") {
			$verAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarAlumnos") {
			$agregarAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarAlumnos") {
			$editarAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarAlumnos") {
			$borrarAlumnos = 'class="active"';
		}
	?>
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Alumnos</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li <?php echo $verAlumnos; ?> ><a href="<?php echo site_url("Alumnos/verAlumnos")?>">Ver alumnos</a></li>
					<li <?php echo $agregarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/agregarAlumnos")?>">Agregar alumnos</a></li>
					<li <?php echo $editarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/editarAlumnos")?>">Editar alumnos</a></li>
					<li <?php echo $borrarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/borrarAlumnos")?>">Borrar alumnos</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>
