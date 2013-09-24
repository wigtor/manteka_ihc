<script type="text/javascript">
	function Cancelar(){
		var borrar = document.getElementById("formAsignar");
		borrar.action ="<?php echo site_url("Secciones/asignarAsecciones/");?>"
		borrar.submit()	
	}

	function profesDelModulo(elemTabla) {

		/* Obtengo el nombre del modulo clickeado */
		var nombre_clickeado = elemTabla;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postDetalleModulos") ?>", /* Se setea la url del controlador que responderá */
			data: { nombre_modulo: nombre_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var profes = document.getElementById("profes");

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				if(datos.length!=0){
					for (var i = 0; i < datos.length; i++) {
						var profesores = profesores+'<tr><td style="width:26px;"><input required type="radio" name="profesor_seleccionado" id="profesor_'+i+'" value="'+datos[i].RUT_USUARIO2+'"> '+datos[i].NOMBRE1_PROFESOR+' '+datos[i].APELLIDO1_PROFESOR+'</td></tr>';
					}
				}else{
					var profesores = "";
				}
				
				$(profes).html(profesores);
				

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	function verificaHorario(){
		var dia = document.getElementById("dia").value;
		var bloque = document.getElementById("bloque").value;

		var retorno = -1;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postVerificaHorarios") ?>", /* Se setea la url del controlador que responderá */
			data: { dia_post: dia,bloque_post: bloque }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			async: false,
			success: function(respuesta){ /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var dato = jQuery.parseJSON(respuesta);
				retorno=dato;
			}
		});

		return retorno;
	}

	function resetearPlanificacion() {
		$('#seccion').val("");
		$('#moduloTematico').val("");
		$('#sesion').val("");
		$('#profesor').val("");
		$('#sala').val("");
		$('#dia').val("");
		$('#bloque').val("");

		$("#profesor").empty();
		var opcionDefault = new Option("Seleccione profesor", "");
		opcionDefault.setAttribute("disabled","disabled");
		opcionDefault.setAttribute("selected","selected");
		$("#profesor").append(opcionDefault);

		$("#sesion").empty();
		var opcionDefault = new Option("Seleccione sesión de clase", "");
		opcionDefault.setAttribute("disabled","disabled");
		opcionDefault.setAttribute("selected","selected");
		$("#sesion").append(opcionDefault);
	}

	function agregarPlanificacion(){
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar profesor');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar el profesor al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	//Se cargan los profesores y las sesiones de clase
	function seleccionadoModuloTem() {
		var codigo_modulo = $('#moduloTematico').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Planificacion/getSesionesByModuloTematico") ?>",
			data: { id_moduloTematico: codigo_modulo},
			success: function(respuesta) {
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				$("#sesion").empty();
				var opcionDefault = new Option("Seleccione sesión de clase", "");
				opcionDefault.setAttribute("disabled","disabled");
				opcionDefault.setAttribute("selected","selected");
				$("#sesion").append(opcionDefault);

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$("#sesion").append(new Option(arrayRespuesta[i].nombre, arrayRespuesta[i].id));
				}


			}
		});

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Planificacion/getProfesoresByModuloTematico") ?>",
			data: { id_moduloTematico: codigo_modulo},
			success: function(respuesta) { 
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				$("#profesor").empty();
				var opcionDefault = new Option("Seleccione profesor", "");
				opcionDefault.setAttribute("disabled","disabled");
				opcionDefault.setAttribute("selected","selected");
				$("#profesor").append(opcionDefault);
				
				var texto;
				for (var i = 0; i < arrayRespuesta.length; i++) {
					texto = arrayRespuesta[i].rut + " - "+arrayRespuesta[i].nombre1+" "+arrayRespuesta[i].apellido1;
					$("#profesor").append(new Option(texto, arrayRespuesta[i].rut));
				}
			}
		});

		$('#icono_cargando').hide();
	}

	$(document).ready(function() {
		$('#dp3').datepicker({
		});
	});
	

</script>

<div class="row-fluid">
	<div class="span12">
		<fieldset>
			<legend>Agregar Planificación de Clase</legend>
			<div class="row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					<p>Complete los datos del formulario para agregar una asignacion:</p>
				</div>
			</div>
			<?php
				$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal');
		 		echo form_open('Planificacion/postAgregarPlanificacion/', $atributos);
			?>
			<div class="row-fluid">
				<div class= "span6">
					<div class="control-group">
						<label class="control-label" for="seccion">1.- <font color="red">*</font> Sección de curso:</label>
						<div class="controls">
							<select id="seccion" name="seccion" class="span10" title="Sección que desea planificar" required>
								<option value="" disabled selected>Seleccione sección de curso</option>
								<?php
								if (isset($listadoSecciones)) {
									foreach ($listadoSecciones as $valor) {
										?>
											<option value="<?php echo $valor->id?>"><?php echo $valor->nombre; ?></option>
										<?php 
									}
								}
								?>

							</select>
						</div>
					</div>

					<!-- Seleccion de módulo tematico y sesión de clase -->
					<div class="control-group">
						<div>2.- Sesión de clase a planificar</div>
					</div>
					
					<div class="control-group" >
						<label class="control-label" for="moduloTematico">2.1.- <font color="red">*</font> Módulo temático:</label>
						<div class="controls">
							<select id="moduloTematico" name="moduloTematico" class="span10" onchange="seleccionadoModuloTem();" required title="Módulo temático que se va a planificar para esa sección">
								<option value="" disabled selected>Seleccione módulo temático</option>
								<?php
								if (isset($listadoModulosTematicos)) {
									foreach ($listadoModulosTematicos as $valor) {
										?>
											<option value="<?php echo $valor->id?>"><?php echo $valor->nombre?></option>
										<?php 
									}
								}
								?>
							</select>
						</div>
					</div>

					<!-- Variable según el módulo temático que se seleccione -->
					<div class="control-group">
						<label class="control-label" for="sesion">2.2.- <font color="red">*</font> Sesión de clase:</label>
						<div class="controls">
							<select id="sesion" name="sesion" class="span10" required title="Sección que desea planificar">
								<option value="" disabled selected>Seleccione sesión de clase</option>

							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="profesor">3.- <font color="red">*</font> Profesor:</label>
						<div class="controls">
							<select id="profesor" name="profesor" class="span10" title="Sección que desea planificar">
								<option value="" disabled selected>Seleccione profesor</option>
								
							</select>
						</div>
					</div>
				</div>


				<div class="span6">
					<div class="row-fluid" >
						<div class="span9">
							<div class="control-group">
								<div>4.- Seleccione la sala y horario</div>
							</div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="sala">4.1.- <font color="red">*</font> Sala:</label>
						<div class="controls">
							<select id="sala" name="sala" class="span6" required>
								<option value="" disabled selected>Seleccione sala</option>
									<?php
									if (isset($listadoSalas)) {
										foreach ($listadoSalas as $valor) {
											?>
												<option value="<?php echo $valor->id?>"><?php echo 'N°'.$valor->numero.' - Capacidad:'.$valor->capacidad; ?></option>
											<?php 
										}
									}
									?>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="dia">4.2.- <font color="red">*</font> Horario:</label>
						<div class="controls">
							<input id="dia" name="dia" class="span6" required value="">

							<input id="bloque" name="bloque" class="span6" required value="">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="fecha_planificada">5.- <font color="red">*</font> Fecha planificada:</label>
						<div class="controls">
							<div class="input-append date" id="dp3" data-date="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd">
								<input class="span8" size="16" readonly id="fecha_planificada" name="fecha_planificada" type="text" value="">
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<button type="button" class="btn" onclick="agregarPlanificacion()" >
								<div class="btn_with_icon_solo">Ã</div>
								&nbsp; Agregar
							</button>
							<button class="btn" type="button" onclick="resetearPlanificacion()" >
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
	</div>
	</form>
</div>