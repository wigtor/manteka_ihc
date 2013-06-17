<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Salas"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verSalas";
		}

		// Las operaciones por defecto no poseen clases
		$verSalas = "";
		$agregarSalas = "";
		$editarSalas = "";
		$borrarSalas = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
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

	<!--	Barra lateral de salas	-->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Salas</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner nav nav-list">
		        	<li <?php echo $verSalas; ?> ><a href="<?php echo site_url("Salas/verSalas")?>">Ver salas</a></li>
		        	<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarSalas; ?> ><a href="<?php echo site_url("Salas/agregarSalas")?>">Agregar salas</a></li>
						<li <?php echo $editarSalas; ?> ><a href="<?php echo site_url("Salas/editarSalas")?>">Editar salas</a></li>
						<li <?php echo $borrarSalas; ?> ><a href="<?php echo site_url("Salas/borrarSalas")?>">Borrar salas</a></li>
					<?php } ?>
		     	</div>
		    </div>
	  	</div>
	</div>