
<script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>

<script>
	function resetearProfesor() {
		$('#rut').val("");
		$('#nombre1').val("");
		$('#nombre2').val("");
		$('#apellido1').val("");
		$('#apellido2').val("");
		$('#correo1').val("");
		$('#correo2').val("");
		$('#telefono').val("");
	}

	function correo() {
		var correo1 = $('#correo1').val();
		var correo2 = $('#correo2').val();
		if(correo1==correo2){
			if(correo1.trim() != '' && correo2.trim() != ''){
				var mensaje = document.getElementById("mensaje");
				$(mensaje).empty();
				$('#modalError').modal();
				$('#correo1').val("");
				$('#correo2').val("");
			}
		}
	}

	function agregarProfesor(){
		$('#tituloConfirmacionDialog').html('Confirmación para agregar profesor');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar el profesor al sistema?');
		$('#modalConfirmacion').modal();
	}

</script>

<fieldset>		
	<legend>Agregar Profesor</legend>	
	<?php
		$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Profesores/postAgregarProfesor', $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class= "span6">
				Complete los datos del formulario para ingresar un profesor:
			</div>
		</div>
		<div  class="row-fluid">
			<div class= "span6">
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

			<!-- Segunda columna -->
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="correo1" style="cursor: default">6.- <font color="red">*</font> Correo:</label>
					<div class="controls">
						<input type="email" id="correo1" name="correo1" class="span12" onblur="comprobarCorreos()" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="199" placeholder="nombre1_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="correo2" style="cursor: default">7.- Correo secundario:</label>
					<div class="controls">
						<input type="email" id="correo2" name="correo2" class="span12" onblur="comprobarCorreos()" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="199" placeholder="nombre2_usuario@miemail.com">
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">8.- <font color="red">*</font> Teléfono:</label>
					<div class="controls">
						<input id="inputInfo"  class="span12" maxlength="10" minlength="7" type="text" pattern="[0-9]{8}" title="Ingrese sólo números" name="telefono_profesor" placeholder="Ingrese solo numeros" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">9.- <font color="red">*</font> Tipo:</label>
					<div class="controls">
						<select id="tipoDeFiltro"  class="span12" title="Tipo de contrato" name="tipo_profesor">
							<?php
							foreach ($tipos_profesores as $valor) {
								?>
									<option value="<?php echo $valor->id?>"><?php echo $valor->nombre_tipo?></option>
								<?php 
							}
							?>
						</select>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarProfesor()" >
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearProfesor()" >
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
	<?php echo form_close(''); ?>
</fieldset>
