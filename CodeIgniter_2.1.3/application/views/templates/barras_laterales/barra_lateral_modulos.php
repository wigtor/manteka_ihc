<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Modulos"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "";
		}

		// Las operaciones por defecto no poseen clases
		$verModulos = "";
		$agregarModulo = "";
		$editarModulo = "";
		$eliminarModulo = "";


		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verModulos") {
			$verModulos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarModulo") {
			$agregarModulo = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarModulo") {
			$editarModulo = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "eliminarModulo") {
			$eliminarModulo = 'class="active"';
		}
	?>

	<!--	Barra lateral de modulos	-->
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Modulos</a>
			</div>
			<div id="collapseOne" class="accordion-body collapse in">
				<div class="accordion-inner nav nav-list">
					<li <?php echo $verModulos;  ?> ><a href="<?php echo site_url("Modulos/verModulos")?>">Ver módulos</a></li>
					<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarModulo; ?> ><a href="<?php echo site_url("Modulos/agregarModulo")?>">Agregar módulos</a></li>
						<li <?php echo $editarModulo; ?> ><a href="<?php echo site_url("Modulos/editarModulo")?>">Editar módulos</a></li>
						<li <?php echo $eliminarModulo; ?> ><a href="<?php echo site_url("Modulos/eliminarModulo")?>">Eliminar módulos</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>