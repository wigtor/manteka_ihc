
<script type="text/javascript">
	function comprobarSeccion() {
		//POR ALGUNA RAZÓN NO FUNCIONA
		var letra = $.trim($("#letra_seccion").val());
		var num = $.trim($("#numero_seccion").val());

		if((letra != "") & (num != "")) {

			/* Muestro el div que indica que se está cargando... */
			$('#icono_cargando').show();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("Secciones/secExisteAjax") ?>",
				data: { letra_post:letra, num_post: num},
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var existe = jQuery.parseJSON(respuesta);
					
					if(existe == true) {
						$('#tituloErrorDialog').html('Error en el nombre de la sección');
						$('#textoErrorDialog').html('La sección '+letra+'-'+num+' que ha ingresado ya se encuentra en el sistema');
						$('#modalError').modal();
						$('#letra_seccion').val("");
						$('#numero_seccion').val("");
					}
				
					/* Quito el div que indica que se está cargando */
					$('#icono_cargando').hide();
				}
			});
		}
	}

	function resetearSeccion() {
		$('#letra_seccion').val("");
		$('#numero_seccion').val("");
	}

	function agregarSeccion(){
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar sección');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar la sección al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}
</script>

<div class="row-fluid">
    <div class= "span11">
        <fieldset> 
		<legend>Agregar Sección</legend>
		<?php
				$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
				echo form_open('Secciones/postAgregarSeccion', $attributes);
			?>
			<div class="row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					<p>Ingrese la información de la sección:</p>
				</div>
			</div>
			
			
            <div class="span8">
				<div class="control-group">
					<label class="control-label" for="letra_seccion">1.- <font color="red">*</font> Sección:<br>
						<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
					</label>
					
					<div class="controls">
						<input id="letra_seccion" name="letra_seccion" onblur="comprobarSeccion(letra_seccion, numero_seccion)" maxlength="1" title=" Ingrese sólo una letra" pattern="^([A-Z]{1}|[a-z]{1})$" type="text" class="span1" required>
						-<input id="numero_seccion" name="numero_seccion"  onblur="comprobarSeccion(letra_seccion, numero_seccion)" maxlength="2"  title=" Ingrese sólo dos dígitos" pattern="[0-9]" type="text" class="span2" required>
					</div>
				</div>
				<div class="control-group">
					<div class="controls ">
						<button type="button" class="btn" onclick="agregarSeccion()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearSeccion()" >
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
			<?php echo form_close(''); ?>
		</fieldset>
	</div>
</div>