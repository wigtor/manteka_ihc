
<script type="text/javascript">
	function comprobarSeccion() {
		//POR ALGUNA RAZÓN NO FUNCIONA
		var letra = document.getElementById("rs_seccion").value;
		var num = document.getElementById("rs_seccion2").value;
		var resultadoAjax =false;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/secExiste") ?>", /* Se setea la url del controlador que responderá */
			data: { letra_post:letra,num_post: num},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == 1){
					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalSeccionExiste').modal();
					document.getElementById("rs_seccion").value = "";
					document.getElementById("rs_seccion2").value = "";
				}else {document.getElementById("formAgregar").submit();}
				
				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}
</script>

<div class="row-fluid">
    <div class= "span11">
        <fieldset> 
		<legend>Agregar Sección</legend>
		<?php
				$attributes = array('onsubmit' => 'return comprobarSeccion()','id' => 'formAgregar', 'class' => 'form-horizontal');
				echo form_open('Secciones/ingresarSecciones', $attributes);
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
					<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Sección:<br>
						<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
					</label>
					
					<div class="controls">
					<input id="res"  value="" type="hidden">
					
						<input id="rs_seccion" name="rs_seccion"  maxlength="1" title=" Ingrese sólo una letra" pattern="^([A-Z]{1}|[a-z]{1})$" type="text" class="span1" required>
						-<input id="rs_seccion2" name="rs_seccion2"  maxlength="2"  title=" Ingrese sólo dos dígitos" pattern="[0-9]{2}" type="text" class="span2" required>
					</div>
				</div>
				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onClick="comprobarSeccion()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="reset" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>&nbsp;
					</div>
				</div>
					<!-- Modal de modalRutUsado -->
					<div id="modalSeccionExiste" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>La sección ingresada ya existe</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese otro nombre de sección y vuelva a intentarlo</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				
			</div>
			<?php echo form_close(''); ?>
		</fieldset>
	</div>
</div>