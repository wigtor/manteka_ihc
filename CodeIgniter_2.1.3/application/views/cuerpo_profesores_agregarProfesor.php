<script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>

<script>
	function comprobarRut() {
		var rut = document.getElementById("rut_profesor").value;
		if( rut== ""){
			return null;
		}
		dv = rut.charAt(rut.length-1);
		rut = rut.substring(0,rut.length-1);
		if(calculaDigitoVerificador(rut,dv) != 0){
			$('#modalRutIncorrecto').modal();
			document.getElementById("rut_profesor").value = "";
			return;
		}
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Profesores/rutExisteAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { rut_post: rut},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var existe = jQuery.parseJSON(respuesta);
				if(existe == true){

					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalRutUsado').modal();
					document.getElementById("rut_profesor").value = "";
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		
	}

</script>
<script>
	function correo() {
		var correo = document.getElementById("correo_profesor").value;
		var correo1 = document.getElementById("correo_profesor1").value;
		if(correo==correo1){
			if(correo!='' && correo1!=''){
				var mensaje = document.getElementById("mensaje");
				$(mensaje).empty();
				$('#modalCorreo').modal();
				document.getElementById("correo_profesor").value = "";
				document.getElementById("correo_profesor1").value = "";
			}
		}
	}
	function agregarProfesor(){
			var rut = document.getElementById("rut_profesor").value;
			document.getElementById("rut_profesor").value = rut.substring(0,rut.length-1);
			return true;
	}

</script>
		<div id="mensaje"></div>
		<fieldset>		
			<legend>Agregar Profesor</legend>	
			<form  class="form-horizontal" id="formAgregar" onsubmit="agregarProfesor()" type="post" method="post" action="<?php echo site_url("Profesores/postInsertarProfesor/")?>">

			
			<div class="row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class= "row-fluid">
				<div class= "span6">
						Complete los datos del formulario para ingresar un profesor:
				</div>
			</div>
			<div  class= "row-fluid">
					<div class= "span6">
						<div class="control-group">
		  					<label class="control-label" for="inputInfo" style="cursor: default" > 1.- <font color="red">*</font> RUN:</label>
		  					<div class="controls">
		    					<input id="rut_profesor"  class="span12" onblur="comprobarRut()" type="text" maxlength="9" pattern="^\d{7,8}[0-9kK]{1}$" title="Ingrese su RUN sin puntos ni guion" min="1" name="rut_profesor" placeholder="Ej:177858741" required>
		  					</div>
						</div>
						<div class="control-group">
		  					<label class="control-label" for="inputInfo" style="cursor: default">2.- <font color="red">*</font> Primer nombre:</label>
		  					<div class="controls">
		    					<input type="text"  class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre1_profesor" maxlength="19" required >
		  					</div>
						</div>
						<div class="control-group">
		  					<label class="control-label" for="inputInfo" style="cursor: default">3.- Segundo nombre:</label>
		  					<div class="controls">
		    					<input type="text" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre2_profesor" maxlength="19" >
		  					</div>
						</div>
						<div class="control-group">
  							<label class="control-label" for="inputInfo" style="cursor: default">4.- <font color="red">*</font> Apellido paterno:</label>
	  						<div class="controls">
		    					<input type="text" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido1_profesor" maxlength="19" required >
		  					</div>
						</div>
						<div class="control-group">
  							<label class="control-label" for="inputInfo" style="cursor: default">5.- <font color="red">*</font> Apellido materno:</label>
  							<div class="controls">
	   							<input type="text" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido2_profesor" maxlength="19" required >
		  					</div>
						</div>
					</div>

					<!-- Segunda columna -->
					<div class="span6">
						<div class="control-group">
		  					<label class="control-label" for="inputInfo" style="cursor: default">6.- <font color="red">*</font> Correo:</label>
		  					<div class="controls">
		    					<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" class="span12" name="correo_profesor" maxlength="199" placeholder="nombre1_usuario@miemail.com" required>
		  					</div>
						</div>
						<div class="control-group">
  							<label class="control-label" for="inputInfo" style="cursor: default">7.- Correo secundario:</label>
  							<div class="controls">
    							<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" class="span12" name="correo_profesor1" maxlength="199" placeholder="nombre2_usuario@miemail.com">
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
					
						<div class="row">
							<div class="controls pull-right">
								<button class="btn" type="submit" style= "margin-right: 7px">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								<button class="btn" type="reset" >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
					
						<!-- Modal de modalRutUsado -->
						<div id="modalRutUsado" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>RUT ingresado está en uso</h3>
							</div>
							<div class="modal-body">
								<p>Por favor ingrese otro rut y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>	
						<div id="modalCorreo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>El correo secundario y principal son iguales</h3>
							</div>
							<div class="modal-body">
								<p>Por favor ingrese correos distintos y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
						<!-- Modal de modalRutIncorrecto -->
					<div id="modalRutIncorrecto" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Dígito verificador incorrecto</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese el rut nuevamente.</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
					
					</div>
				<?php echo form_close(''); ?>
			</div>
		</fieldset>