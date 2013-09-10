<script>

	function comprobarNombre() {
		var nombre = document.getElementById("nombre_sesion").value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Sesiones/nombreExisteC") ?>", /* Se setea la url del controlador que responderá */
			data: { nombre_post: nombre},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == -1){
					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalNombreUsado').modal();
					document.getElementById("nombre_sesion").value = "";

				}

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

<script type="text/javascript">


	function agregarSesion(){
		var nombre = document.getElementById("nombre_sesion").value;
		var descripcion = document.getElementById("descripcion_sesion").value;

		if(nombre!="" ){
					return true;
		}
		else {
				alert("Ingrese todos los datos");
				return false;
		}
	}
</script>

		<fieldset>
			<legend>Agregar Sesión</legend>
		
				<div class="row-fluid">
					<div class="span6">
						<font color="red">* Campos Obligatorios</font>
					</div>
				</div>
			
			
			<div class= "row-fluid">
				<div class= "span6">
					<p>Complete los datos del formulario para agregar una sesión:</p>
				</div>
			</div>
					
			<div  class= "row-fluid">
				<?php
					$atributos= array('onsubmit' => 'return agregarSesion()', 'id' => 'formAgregar', 'name' => 'formAgregar', 'class' => 'form-horizontal');
					echo form_open('Sesiones/agregarSesiones/', $atributos);
				?>
				<div class= "span7">
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">1.- <font color="red">*</font> Nombre</label>
						<div class="controls">
							<input id="nombre_sesion" onblur="comprobarNombre()" type="text" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" name="nombre_sesion" maxlength="99" required >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">2.- <font color="red">*</font> Descripción</label>
						<div class="controls">
							<textarea id="descripcion_sesion" class="span12" type="text" cols="40" rows="5" name="descripcion_sesion" maxlength="99" required ></textarea>
						</div>
					</div>
				</div> 
			</div>
			<div class="span7" style="margin-left: 0px">
				<div class="controls pull-right">
					<button class="btn" type="submit" style= "margin-right: 7px" style="width:102px">
						<div class= "btn_with_icon_solo">Ã</div>
							&nbsp Agregar
					</button>
			
				
					<button class="btn" type="reset" style="width:105px">
						<div class= "btn_with_icon_solo">Â</div>
							&nbsp Cancelar
					</button>
				</div>
			</div>
							
							<!-- Modal de modalNombreUsado -->
				<div id="modalNombreUsado" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Nombre de la sesion ya existe.</h3>
					</div>
					<div class="modal-body">
						<p>Por favor ingrese otro nombre para la sesión y vuelva a intentarlo.</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>	

			</div>
		</fieldset>
