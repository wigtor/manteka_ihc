

<script>
	function comprobarNum() {
		var num = $('#num_sala').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/numSalaExisteAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { num_post: num},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();

				var existe = jQuery.parseJSON(respuesta);
				if(existe == true){
					$('#tituloErrorDialog').html('Error en el número de sala');
					$('#textoErrorDialog').html('El N° de sala ingresado ya existe en el sistema');
					$('#modalError').modal();
					$('#num_sala').val('');
				}
			}
		});
	}

	function resetearSala() {
		$('#num_sala').val("");
		$('#capacidad').val("");
		$('#ubicacion').val("");
	}

	function agregarSala(){
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar sala');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar la sala al sistema?');
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
	<legend>Agregar Sala</legend>
	<?php
		$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Salas/postAgregarSala', $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class= "row-fluid">
			<div class= "span6" >
				Complete los datos del formulario para ingresar una sala:
			</div>
		</div>
		<div  class= "row-fluid">
			<div class= "span6">
				<div class="control-group">
  					<label class="control-label" for="num_sala" > 1.- <font color="red">*</font> Número de la sala:</label>
  					<div class="controls">
    					<input id="num_sala" name="num_sala" class="span12" onblur="comprobarNum()" maxlength="3"  title=" Ingrese el número de la sala usando tres dígitos" pattern="[0-9]{3}" type="text" placeholder="Ej:258" required>
  					</div>
				</div>
				<div class="control-group">
  					<label class="control-label" for="capacidad" > 2.- <font color="red">*</font> Capacidad:</label>
  					<div class="controls">
    					<input class="span12" id="capacidad" name="capacidad" title="Ingrese la capacidad de la sala" max="999" type="number" min="1" placeholder="Número de personas. Ej:80" required>
  					</div>
				</div>
				<div class="control-group">
						<label class="control-label" for="ubicacion">3.- <font color="red">*</font> Ubicación:</label>
						<div class="controls">
						<textarea  class="span12" id="ubicacion" name="ubicacion" title= "Ingrese la ubicación de la sala en no más de 100 carácteres" maxlength="100" required="required" style="resize: none;"></textarea>
						</div>
				</div>
			</div>
			
			<!-- Segunda columna -->
			<div class="span6">
				<div class="control-group">
					<label class="control-label" style="cursor: default" style="width: 150px" for="run_profe">4.- Seleccione los implementos</label>
					<div class="controls">
						<select id="id_implementos" name="id_implementos[]" class="span12" title="asigne los implementos" multiple="multiple">
						<?php
						if (isset($implementos)) {
							foreach ($implementos as $impl) {
								?>
									<option value="<?php echo $impl->id; ?>"><?php echo $impl->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarSala()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearSala()" >
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
	<?php echo form_close(""); ?>
</fieldset>
