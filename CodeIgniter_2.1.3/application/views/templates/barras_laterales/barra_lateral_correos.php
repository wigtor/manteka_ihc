<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Correos"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "correosEnviados";
		}

		// Las operaciones por defecto no poseen clases
		$correosRecibidos = "";
		$correosEnviados = "";
		$enviarCorreo = "";
		$verBorradores = "";
		$agregarPlantilla = "";
		$editarPlantilla = "";
		$eliminarPlantilla = "";
		$verGrupos = "";
		$agregarGrupoContacto = "";
		$editarGrupoContacto = "";
		$eliminarGrupoContacto = "";
		$logEliminados = "";

		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inCorreos = "";
		$inPlantillas = "";
		$inGrupos = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		//	Dependiendo de qué operación esta seleccionada, se abre un determinado grupo de acciones
		if ($subVistaLateralAbierta == "correosRecibidos") {
			$correosRecibidos = 'class="active"';
			$inCorreos = "in";
		}
		if ($subVistaLateralAbierta == "correosEnviados") {
			$correosEnviados = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "enviarCorreo") {
			$enviarCorreo = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "verBorradores") {
			$verBorradores = 'class="active"';
			$inCorreos = "in";
		}
		else if ($subVistaLateralAbierta == "agregarPlantilla") {
			$agregarPlantilla = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "editarPlantilla") {
			$editarPlantilla = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarPlantilla") {
			$eliminarPlantilla = 'class="active"';
			$inPlantillas = "in";
		}
		else if ($subVistaLateralAbierta == "verGrupos") {
			$verGrupos = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "agregarGrupoContacto") {
			$agregarGrupoContacto = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "editarGrupoContacto") {
			$editarGrupoContacto = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "eliminarGrupoContacto") {
			$eliminarGrupoContacto = 'class="active"';
			$inGrupos = "in";
		}
		else if ($subVistaLateralAbierta == "logEliminados") {
			$logEliminados = 'class="active"';
			$inCorreos = "in";
		}

		$mensajesNoLeidos = "";
		if (isset($numNoLeidos)) {
			if ($numNoLeidos > 0) {
				$mensajesNoLeidos = " (".$numNoLeidos.")";
			}
		}
	?>

	<!--	Barra lateral de correos	-->
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
						Correos</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse <?php echo $inCorreos; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $correosRecibidos; ?> ><a href="<?php echo site_url("Correo/correosRecibidos")?>">Correos recibidos <span id="botonLateralCorreosRecibidos"><?php echo $mensajesNoLeidos ?></span></a></li>
						<li <?php echo $correosEnviados; ?> ><a href="<?php echo site_url("Correo/correosEnviados")?>">Correos enviados</a></li>
						<li <?php echo $enviarCorreo; ?> ><a href="<?php echo site_url("Correo/enviarCorreo")?>">Enviar correo</a></li>
						<li <?php echo $verBorradores; ?> ><a href="<?php echo site_url("Correo/verBorradores")?>">Ver borradores</a></li>
						<li <?php echo $logEliminados; ?> ><a href="<?php echo site_url("Correo/logEliminados")?>">Log de eliminados</a></li>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
					Plantillas</a>
				</div>
				<div id="collapseTwo" class="accordion-body collapse <?php echo $inPlantillas; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $agregarPlantilla; ?> ><a href="<?php echo site_url("Plantillas/agregarPlantilla")?>">Agregar plantillas</a></li>
						<li <?php echo $editarPlantilla; ?> ><a href="<?php echo site_url("Plantillas/editarPlantilla")?>">Editar plantillas</a></li>
						<li <?php echo $eliminarPlantilla; ?> ><a href="<?php echo site_url("Plantillas/eliminarPlantilla")?>">Eliminar plantillas</a></li>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
					Grupos de contactos</a>
				</div>
				<div id="collapseThree" class="accordion-body collapse <?php echo $inGrupos; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $verGrupos; ?> ><a href="<?php echo site_url("GruposContactos/verGrupos")?>">Ver grupos</a></li>
						<li <?php echo $agregarGrupoContacto; ?> ><a href="<?php echo site_url("GruposContactos/agregarGrupoContacto")?>">Agregar grupos</a></li>
						<li <?php echo $editarGrupoContacto; ?> ><a href="<?php echo site_url("GruposContactos/editarGrupoContacto")?>">Editar grupos</a></li>
						<li <?php echo $eliminarGrupoContacto; ?> ><a href="<?php echo site_url("GruposContactos/eliminarGrupoContacto")?>">Eliminar grupos</a></li>
					</div>
				</div>
			</div>
		</div>

