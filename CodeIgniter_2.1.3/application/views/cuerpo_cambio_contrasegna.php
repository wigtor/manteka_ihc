
<script type="text/javascript">
	function cambiarDatosUsuario() {
		var form = document.forms["formDatosUsuario"];
		if (form.checkValidity() ) {
			$('#formDatosUsuario #tituloConfirmacionDialog').html('Confirmación para actualizar sus datos');
			$('#formDatosUsuario #textoConfirmacionDialog').html('¿Está seguro que desea actualizar sus datos de contacto?');
			$('#formDatosUsuario #modalConfirmacion').modal();
		}
		else {
			$('#formDatosUsuario #tituloErrorDialog').html('Error en la validación');
			$('#formDatosUsuario #textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#formDatosUsuario #modalError').modal();
		}


	}


	function cambiarContrasegna() {
		var form = document.forms["formCambioContrasegna"];
		if ($('#nva_contrasegna').val() != $('#nva_contrasegna_rep').val()) {
			$('#formCambioContrasegna #tituloErrorDialog').html('Error en la validación');
			$('#formCambioContrasegna #textoErrorDialog').html('Las contraseñas no coinciden');
			$('#formCambioContrasegna #modalError').modal();
			return;
		}
		if (form.checkValidity() ) {
			$('#formCambioContrasegna #tituloConfirmacionDialog').html('Confirmación para cambiar la contraseña');
			$('#formCambioContrasegna #textoConfirmacionDialog').html('¿Está seguro que desea cambiar su contraseña?');
			$('#formCambioContrasegna #modalConfirmacion').modal();
		}
		else {
			$('#formCambioContrasegna #tituloErrorDialog').html('Error en la validación');
			$('#formCambioContrasegna #textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#formCambioContrasegna #modalError').modal();
		}
	}
</script>

<fieldset>
	<legend>Perfil de usuario</legend>
	<?php 
		$atributos= array('id' => 'formDatosUsuario', 'class' => 'form-horizontal');
		echo form_open('User/postCambiarDatosUsuario', $atributos);
	?>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="nombres" >Nombres:</label>
					<div class="controls">
						<input type="text" id="nombres" value="<?php echo $datos->nombre1." ".$datos->nombre2 ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellidos" >Apellidos:</label>
					<div class="controls">
						<input type="text" id="apellidos" value="<?php echo $datos->apellido1." ".$datos->apellido2 ?>" disabled>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="rut" >Rut:</label>
					<div class="controls">
						<input type="text" id="rut" value="<?php echo $rut_usuario ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tipo_usr" >Tipo de usuario:</label>
					<div class="controls">
						<input type="text" id="tipo_usr" value="<?php echo $datos->tipo_usuario ?>" disabled>
					</div>
				</div>
			</div>
		</div>

		<hr>

		<div class="row-fluid">
			<font class="span6" color="red">* Campos Obligatorios</font>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="correo1"><font color="red">*</font> Correo:</label>
					<div class="controls">
						<input type="email" id="correo1" name="correo1" placeholder="nombre_usuario@miemail.com" value="<?php echo $datos->email1 ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="correo2">  Correo alternativo:</label>
					<div class="controls">
						<input type="email" id="correo2" name="correo2" placeholder="nombre2_usuario@miemail.com" value="<?php echo $datos->email2 ?>" >
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="telefono">  Teléfono:</label>
					<div class="controls">
						<input type="text" id="telefono" name="telefono" maxlength="11" pattern="[0-9]+" placeholder="44556677" value="<?php echo $datos->telefono ?>" >
					</div>
				</div>
				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onclick="cambiarDatosUsuario()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="window.location.href='<?php echo site_url("Login/index/") ?>';">
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						if (isset($dialogos)) {
							echo $dialogos;
						}
					?>
				</div>
			</div>
		</div>
	<?php echo form_close(""); ?>
</fieldset>

<br>

<fieldset>
	<legend>Cambio de contraseña</legend>
	<?php 
		$atributos= array('id' => 'formCambioContrasegna', 'class' => 'form-horizontal');
		echo form_open('User/postCambiarContrasegna', $atributos);
	?>
	<div class="row-fluid">
		<div class="span12">
			<font color="red">* Campos Obligatorios en caso de que desee cambiar la contraseña</font>
		</div>
	</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="contrasegna_actual">1.- <font color="red">*</font> Contraseña actual:</label>
					<div class="controls">
						<input class="span12" id="contrasegna_actual" required type="password" name="contrasegna_actual" maxlength="100" placeholder="*****" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nva_contrasegna">2.- <font color="red">*</font> Nueva contraseña:</label>
					<div class="controls">
						<input class="span12" id="nva_contrasegna" required type="password" name="nva_contrasegna" maxlength="100" placeholder="*****" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nva_contrasegna_rep">3.- <font color="red">*</font> Confirme su nueva contraseña:</label>
					<div class="controls">
						<input class="span12" id="nva_contrasegna_rep" required type="password" name="nva_contrasegna_rep" maxlength="100" placeholder="*****" >
					</div>
				</div>

				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onclick="cambiarContrasegna()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="window.location.href='<?php echo site_url("Login/index/") ?>';">
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						if (isset($dialogos)) {
							echo $dialogos;
						}
					?>
				</div>
			</div>
		</div>
	<?php echo form_close(""); ?>
</fieldset>
