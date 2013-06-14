<!--	Barra lateral con las operaciones que puede realizar el usuario cuando se encuentra en el módulo "Alumnos"	-->
	<?php
		/**
		*	Determinar qué grupo se encuentra abierto en caso de tenerlos.
		*	Determinar qué operación está seleccionada
		*/

		//	Si la variable no se ha seteado, se asume operación principal.
		if (!isset($subVistaLateralAbierta)) {
			$subVistaLateralAbierta = "verAlumnos";
		}

		// Las operaciones por defecto no poseen clases
		$verAlumnos = "";
		$agregarAlumnos = "";
		$editarAlumnos = "";
		$borrarAlumnos = "";
		$cambiarSeccionAlumnos = "";
		$cargaMasivaAlumnos = "";


		//	En caso de que tal operación específica este seleccionada.
		//	La operación seleccionada tiene clase "active"
		if ($subVistaLateralAbierta == "verAlumnos") {
			$verAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "agregarAlumnos") {
			$agregarAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "editarAlumnos") {
			$editarAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "borrarAlumnos") {
			$borrarAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "cambiarSeccionAlumnos") {
			$cambiarSeccionAlumnos = 'class="active"';
		}
		else if ($subVistaLateralAbierta == "cargaMasivaAlumnos") {
			$cargaMasivaAlumnos = 'class="active"';
		}
	?>

	<!--	Barra lateral de alumnos	-->
	<div class="accordion" id="accordion2">
    	<div class="accordion-group">
		    <div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				Alumnos</a>
		    </div>
		    <div id="collapseOne" class="accordion-body collapse in">
		    	<div class="accordion-inner nav nav-list">
		        	<li <?php echo $verAlumnos; ?> ><a href="<?php echo site_url("Alumnos/verAlumnos")?>">Ver alumnos</a></li>
		        	<?php if ($id_tipo_usuario == TIPO_USR_COORDINADOR) { ?>
						<li <?php echo $agregarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/agregarAlumnos")?>">Agregar alumnos</a></li>
						<li <?php echo $editarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/editarAlumnos")?>">Editar alumnos</a></li>
						<li <?php echo $borrarAlumnos; ?> ><a href="<?php echo site_url("Alumnos/borrarAlumnos")?>">Borrar alumnos</a></li>
						<li <?php echo $cambiarSeccionAlumnos; ?> ><a href="<?php echo site_url("Alumnos/cambiarSeccionAlumnos")?>">Cambiar de sección</a></li>
						<li <?php echo $cargaMasivaAlumnos; ?> ><a href="<?php echo site_url("Alumnos/cargaMasivaAlumnos")?>">Carga masiva</a></li>
		     		<?php } ?>
		     	</div>
		    </div>
	  	</div>
	</div>
