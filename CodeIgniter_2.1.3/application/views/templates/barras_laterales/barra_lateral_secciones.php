<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario según el botón de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "verSecciones";
		}
		$verSecciones = "";
		$agregarSecciones = "";
		$editarSecciones = "";
		$borrarSecciones = "";
		if ($subVistaLateralAbierta == "verSecciones") {
			$verSecciones = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarSecciones") {
			$agregarSecciones = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarSecciones") {
			$editarSecciones = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarSecciones") {
			$borrarSecciones = 'class="active"';
		}
	?>
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Secciones</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li <?php echo $verSecciones; ?> ><a href="<?php echo site_url("Secciones/verSecciones")?>">Ver secciones</a></li>
	        		<li <?php echo $agregarSecciones; ?> ><a href="<?php echo site_url("Secciones/agregarSecciones")?>">Agregar secciones</a></li>
					<li <?php echo $editarSecciones; ?> ><a href="<?php echo site_url("Secciones/editarSecciones")?>">Editar secciones</a></li>
					<li <?php echo $borrarSecciones; ?> ><a href="<?php echo site_url("Secciones/borrarSecciones")?>">Borrar secciones</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>
