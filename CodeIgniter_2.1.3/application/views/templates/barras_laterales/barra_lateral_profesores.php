<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Secciones"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "correosEnviados";
		}
		$id_tipo_usuario = TIPO_USR_COORDINADOR; //Se debe borrar cuando todo se porte a MasterManteka
		// Las operaciones por defecto no poseen clases
		$verProfesores = "";
		$agregarProfesores = "";
		$editarProfesores = "";
		$borrarProfesores = "";
		$verAyudantes = "";
		$agregarAyudantes = "";
		$editarAyudantes = "";
		$borrarAyudantes = "";
		$verCoordinadores = "";
		$agregarCoordinadores = "";
		$editarCoordinadores = "";
		$borrarCoordinadores = "";

		// Variables que determinan que grupo de operaciones se encuentra abierta
		$inProfesores = "";
		$inAyudantes = "";
		$inCoordinadores = "";

		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		//	Dependiendo de qué operación esta seleccionada, se abre un determinado grupo de acciones
		if ($subVistaLateralAbierta == "verProfesores") {
			$verProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarProfesores") {
			$agregarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "editarProfesores") {
			$editarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "borrarProfesores") {
			$borrarProfesores = 'class="active"';
			$inProfesores = "in";
		}
		else if ($subVistaLateralAbierta == "verAyudantes") {
			$verAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "agregarAyudantes") {
			$agregarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "editarAyudantes") {
			$editarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "borrarAyudantes") {
			$borrarAyudantes = 'class="active"';
			$inAyudantes = "in";
		}
		else if ($subVistaLateralAbierta == "verCoordinadores") {
			$verCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "agregarCoordinadores") {
			$agregarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "editarCoordinadores") {
			$editarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
		else if ($subVistaLateralAbierta == "borrarCoordinadores") {
			$borrarCoordinadores = 'class="active"';
			$inCoordinadores = "in";
		}
	?>

	<!--	Barra lateral de profesores	-->
    <div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Profesores</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse <?php echo $inProfesores; ?>">
		    	<div class="accordion-inner nav nav-list">
		        	<li <?php echo $verProfesores?>><a href="<?php echo site_url("Profesores/verProfesores")?>">Ver profesores</a></li>
		        	<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
		        		<li <?php echo $agregarProfesores; ?> ><a href="<?php echo site_url("Profesores/agregarProfesores")?>">Agregar profesores</a></li>
						<li <?php echo $editarProfesores; ?> ><a href="<?php echo site_url("Profesores/editarProfesores")?>">Editar  profesores</a></li>
						<li <?php echo $borrarProfesores; ?> ><a href="<?php echo site_url("Profesores/borrarProfesores")?>">Borrar profesores</a></li>
		     		<?php } ?>
		     	</div>
		    </div>
	  	</div>
		<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
				Ayudantes</a>
		    </div>
		    <div id="collapseTwo" class="accordion-body collapse <?php echo $inAyudantes; ?>">
		    	<div class="accordion-inner nav nav-list">
		        	<li <?php echo $verAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/verAyudantes")?>">Ver ayudantes</a></li>
		        	<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/agregarAyudantes")?>">Agregar ayudantes</a></li>
						<li <?php echo $editarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/editarAyudantes")?>">Editar ayudantes</a></li>
						<li <?php echo $borrarAyudantes; ?> ><a href="<?php echo site_url("Ayudantes/borrarAyudantes")?>">Borrar ayudantes</a></li>
					<?php } ?>
		     	</div>
		    </div>
  		</div>
		<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
					Coordinadores</a>
				</div>
				<div id="collapseThree" class="accordion-body collapse <?php echo $inCoordinadores; ?>">
					<div class="accordion-inner nav nav-list">
						<li <?php echo $verCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/verCoordinadores")?>">Ver coordinadores</a></li>
						<li <?php echo $agregarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/agregarCoordinadores")?>">Agregar coordinadores</a></li>
						<li <?php echo $editarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/editarCoordinadores")?>">Editar coordinadores</a></li>
						<li <?php echo $borrarCoordinadores; ?> ><a href="<?php echo site_url("Coordinadores/borrarCoordinadores")?>">Borrar coordinadores</a></li>
					</div>
				</div>
			</div>
	  	<?php } ?>
	</div>
	