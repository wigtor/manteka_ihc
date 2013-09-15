<script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>


<script type="text/javascript">

	function resetearAyudante() {
		$('#rut').val("");
		$('#nombre1').val("");
		$('#nombre2').val("");
		$('#apellido1').val("");
		$('#apellido2').val("");
		$('#correo1').val("");
		$('#correo2').val("");
		$('#telefono').val("");
	}

	function agregarAyudante(){
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar ayudante');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar el ayudante al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
		
	}
	
</script>


<fieldset>
	<legend>Agregar Ayudante</legend>
	<?php
		$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Ayudantes/postAgregarAyudante', $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class= "span6" >
				<p>Complete los datos del formulario para ingresar un ayudante</p>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="rut">1-.<font color="red">*</font> RUT:</label>
					<div class="controls">
						<input type="text" id="rut" name="rut" class="span12" onblur="comprobarRutUsado(this, '<?php echo site_url('Profesores/rutExisteAjax') ?>')" maxlength="9" pattern="^\d{7,8}[0-9kK]{1}$" title="Ingrese su RUN sin puntos ni guion" min="8" placeholder="Ej:177858741" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre1">2-.<font color="red">*</font> Primer nombre:</label>
					<div class="controls">
						<input type="text" id="nombre1" name="nombre1" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Juan" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre2">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombre2" name="nombre2" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Mario" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido1">4-.<font color="red">*</font> Apellido Paterno:</label>
					<div class="controls">
						<input type="text" id="apellido1" name="apellido1" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido2">5-.<font color="red">*</font> Apellido Materno:</label>
					<div class="controls">
						<input type="text" id="apellido2" name="apellido2" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" maxlength="20" required>
					</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="correo1">6-.<font color="red">*</font> Correo:</label>
					<div class="controls">
						<input type="email" id="correo1" name="correo1" class="span12" onblur="comprobarCorreos(correo1, correo2)" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="correo2">7-. Correo secundario:</label>
					<div class="controls">
						<input type="email" id="correo2" name="correo2" class="span12" onblur="comprobarCorreos(correo1, correo2)" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="40" placeholder="nombre_usuario2@miemail.com" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="telefono">8-. Teléfono:</label>
					<div class="controls">
						<input type="text" id="telefono" name="telefono" class="span12" maxlength="10" pattern="[0-9]+" placeholder="44556677" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="id_profesores" style="cursor: default">9.- <font color="red">*</font> Asignar profesores:</label>
					<div class="controls">
						<select required id="id_profesores" name="id_profesores[]" class="span12" title="asigne profesor" multiple="multiple">
						<?php
						if (isset($profesores)) {
							foreach ($profesores as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarAyudante()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearAyudante()" >
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
