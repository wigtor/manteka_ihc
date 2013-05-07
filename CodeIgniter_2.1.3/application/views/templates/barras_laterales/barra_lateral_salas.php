<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "verSalas";
		}
		$verSalas = "";
		$agregarSalas = "";
		$editarSalas = "";
		$borrarSalas = "";
		if ($subVistaLateralAbierta == "verSalas") {
			$verSalas = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarSalas") {
			$agregarSalas = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarSalas") {
			$editarSalas = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarSalas") {
			$borrarSalas = 'class="active"';
		}
	?>
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Salas</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li <?php echo $verSalas; ?> ><a href="<?php site_url("Salas/verSalas")?>">Ver salas</a></li>
					<li <?php echo $agregarSalas; ?> ><a href="<?php echo site_url("Salas/agregarSalas")?>">Agregar salas</a></li>
					<li <?php echo $editarSalas; ?> ><a href="<?php echo site_url("Salas/editarSalas")?>">Editar salas</a></li>
					<li <?php echo $borrarSalas; ?> ><a href="<?php echo site_url("Salas/borrarSalas")?>">Borrar salas</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>