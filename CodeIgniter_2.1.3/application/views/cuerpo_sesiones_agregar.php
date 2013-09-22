<script>

	function comprobarNombreSesion() {
		var nombre = $("#nombre").val();
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Sesiones/nombreExisteAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { nombre_post: nombre},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var existe = jQuery.parseJSON(respuesta);
				if(existe == true) {
					$('#tituloErrorDialog').html('Error en el nombre');
					$('#textoErrorDialog').html('El nombre ingresado ya está repetido en el sistema');
					$('#modalError').modal();
					$("#nombre").val('');
				}

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
				}
		});
	}

</script>

<script type="text/javascript">


	function agregarSesion() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar sesión de clase');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar la sesión de clase al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	function resetearSesion() {
		$('#nombre').val("");
		$('#descripcion').val("");
		$('#id_moduloTem').val("");
	}
</script>

<fieldset>
	<legend>Agregar Sesión de clase</legend>
	<?php
		$atributos= array('id' => 'formAgregar', 'name' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Sesiones/postAgregarSesion/', $atributos);
	?>
	<div class="row-fluid">
		<div class="span6">
			<font color="red">* Campos Obligatorios</font>
		</div>
	</div>
	
	<div class= "row-fluid">
		<div class= "span6">
			<p>Complete los datos del formulario para agregar una sesión de clase:</p>
		</div>
	</div>
			
	<div  class= "row-fluid">
		<div class= "span7">
			<div class="control-group">
				<label class="control-label" for="nombre" >1.- <font color="red">*</font> Nombre</label>
				<div class="controls">
					<input id="nombre" name="nombre" onblur="comprobarNombreSesion()" placeholder="Tema de la clase" type="text" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" maxlength="99" required >
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="descripcion" >2.- Descripción</label>
				<div class="controls">
					<textarea id="descripcion" name="descripcion" style="resize: none;" class="span12" type="text" cols="40" rows="5" maxlength="99" ></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="id_moduloTem" >3.- <font color="red">*</font> Asignar módulo temático:</label>
				<div class="controls">
					<select required id="id_moduloTem" name="id_moduloTem" class="span12" title="asigne módulo temático">
					<?php
					if (isset($modulosTematicos)) {
						foreach ($modulosTematicos as $moduloTem) {
							?>
								<option value="<?php echo $moduloTem->id; ?>"><?php echo $moduloTem->nombre; ?></option>
							<?php 
						}
					}
					?>
					</select> 
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="button" class="btn" onclick="agregarSesion()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Agregar
					</button>
					<button class="btn" type="button" onclick="resetearSesion()" >
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
