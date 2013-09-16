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
		$agregarSala = "";
		$editarSala = "";
		$eliminarSala = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verSalas") {
			$verSalas = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarSala") {
			$agregarSala = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarSala") {
			$editarSala = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "eliminarSala") {
			$eliminarSala = 'class="active"';
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
						<li <?php echo $agregarSala; ?> ><a href="<?php echo site_url("Salas/agregarSala")?>">Agregar salas</a></li>
						<li <?php echo $editarSala; ?> ><a href="<?php echo site_url("Salas/editarSala")?>">Editar salas</a></li>
						<li <?php echo $eliminarSala; ?> ><a href="<?php echo site_url("Salas/eliminarSala")?>">Borrar salas</a></li>
					<?php } ?>
		     	</div>
		    </div>
	  	</div>
	</div>