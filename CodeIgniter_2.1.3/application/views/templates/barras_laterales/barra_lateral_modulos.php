<!-- Esta es la barra lateral con las operaciones que puede realizar el usuario seg?n el bot?n de la barra superior en que se encuentre -->
	<?php
		if (!isset($subVistaLateralAbierta)) { //Con esto se evita que no se haya seteado la variable aún
			$subVistaLateralAbierta = "verModulos";
		}
		$verModulos = "";
		$agregarModulos = "";
		$editarModulos = "";
		$borrarModulos = "";
		if ($subVistaLateralAbierta == "verModulos") {
			$verModulos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarModulos") {
			$agregarModulos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarModulos") {
			$editarModulos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarModulos") {
			$borrarModulos = 'class="active"';
		}
	?>
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Modulos</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner">
		        	<li <?php echo $verModulos; ?> ><a href="<?php site_url("Modulos/verModulos")?>">Ver m?dulos</a></li>
					<li <?php echo $agregarModulos; ?> ><a href="<?php echo site_url("Modulos/agregarModulos")?>">Agregar m?dulos</a></li>
					<li <?php echo $editarModulos; ?> ><a href="<?php echo site_url("Modulos/editarModulos")?>">Editar m?dulos</a></li>
					<li <?php echo $borrarModulos; ?> ><a href="<?php echo site_url("Modulos/borrarModulos")?>">Borrar m?dulos</a></li>
		     	</div>
		    </div>
	  	</div>
	</div>