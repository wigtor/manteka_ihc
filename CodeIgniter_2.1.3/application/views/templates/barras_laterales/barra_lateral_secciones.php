<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Secciones"	-->
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
		$verSecciones = "";
		$agregarSeccion = "";
		$editarSeccion = "";
		$eliminarSeccion = "";
		$inSecciones = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verSecciones") {
			$verSecciones = 'class="active"';
			$inSecciones = "in";

		}
		else if ($subVistaLateralAbierta == "agregarSeccion") {
			$agregarSeccion = 'class="active"';
			$inSecciones = "in";
		}
		else if ($subVistaLateralAbierta == "editarSeccion") {
			$editarSeccion = 'class="active"';
			$inSecciones = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarSeccion") {
			$eliminarSeccion = 'class="active"';
			$inSecciones = "in";
		}
	?>


	<ul class="dropdown-menu" role="menu" aria-labelledby="drop_secciones">
		<li class="dropdown-header <?php echo $inSecciones; ?>">Secciones</li>
			<li <?php echo $verSecciones; ?> ><a href="<?php echo site_url("Secciones/verSecciones")?>">Ver secciones</a></li>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<li <?php echo $agregarSeccion; ?> ><a href="<?php echo site_url("Secciones/agregarSeccion")?>">Agregar sección</a></li>
			<li <?php echo $editarSeccion; ?> ><a href="<?php echo site_url("Secciones/editarSeccion")?>">Editar sección</a></li>
			<li <?php echo $eliminarSeccion; ?> ><a href="<?php echo site_url("Secciones/eliminarSeccion")?>">Eliminar sección</a></li>
		<?php } ?>
	</ul>
