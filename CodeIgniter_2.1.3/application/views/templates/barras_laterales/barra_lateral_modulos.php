<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Modulos"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verModulos";
		}

		// Las operaciones por defecto no poseen clases
		$verModulos = "";
		$agregarModulos = "";
		$editarModulos = "";
		$borrarModulos = "";


		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
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
						<li <?php echo $agregarModulos; ?> ><a href="<?php echo site_url("Modulos/agregarModulos")?>">Agregar módulos</a></li>
						<li <?php echo $editarModulos; ?> ><a href="<?php echo site_url("Modulos/editarModulos")?>">Editar módulos</a></li>
						<li <?php echo $borrarModulos; ?> ><a href="<?php echo site_url("Modulos/borrarModulos")?>">Borrar módulos</a></li>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>