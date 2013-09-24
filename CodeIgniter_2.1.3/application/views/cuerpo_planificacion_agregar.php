<script type="text/javascript">

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

	//Se carga el horario válido para esa sección
	function seleccionadaSeccion() {
		var id_seccion = $('#seccion').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST",
			url: "<?php echo site_url("Planificacion/getHorarioSeccionAjax") ?>",
			data: { id_seccion: id_seccion},
			success: function(respuesta) {
				var objResp = jQuery.parseJSON(respuesta);
				$('#horario').html(objResp.horario + " - "+objResp.nombre_dia+"-"+objResp.hora_clase);
				//Inicio el datepicker deshabilitando los días en que la sección no tiene clases
				$('#dia').val(objResp.dia);
				iniciarDatepicker();
				$('#icono_cargando').hide();
			}
		});

	}


	//Se cargan los profesores y las sesiones de clase
	function seleccionadoModuloTem() {
		var codigo_modulo = $('#moduloTematico').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Planificacion/getSesionesByModuloTematicoAjax") ?>",
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
			url: "<?php echo site_url("Planificacion/getProfesoresByModuloTematicoAjax") ?>",
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

	function iniciarDatepicker() {
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		var diaSemana = $('#dia').val();
		var daysDisabled = "";
		for (var i = 0; i < 7; i++) {
			if (i != 0) {
				daysDisabled += ",";
			}
			if (diaSemana != i) {
				daysDisabled += i;
			}
		}
		$('#dp_fecha_planificada').datepicker("remove");
		$('#dp_fecha_planificada').datepicker({
			language: "es",
			calendarWeeks: true,
			format: 'yyyy-mm-dd',
			daysOfWeekDisabled: daysDisabled,
			autoclose: true
		});

		//$('#dp_fecha_planificada').datepicker('refresh');
	}

	$(document).ready(function() {
		iniciarDatepicker();
	});

</script>

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
					<select id="seccion" name="seccion" onchange="seleccionadaSeccion();" class="span10" title="Sección que desea planificar" required>
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
			<div class="control-group">
				<label class="control-label" for="sala">4.- <font color="red">*</font> Sala:</label>
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
				<label class="control-label" for="fecha_planificada">5.- <font color="red">*</font> Fecha planificada:</label>
				<div class="controls">
					<div class="input-append date pull-left" id="dp_fecha_planificada" data-date-format="yyyy-mm-dd" data-date="">
						<input class="span8" size="16" readonly id="fecha_planificada" required name="fecha_planificada" type="text" value="">
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>
					<label class="control-label" id="horario" class="pull-left" class="span2"></label>
					<input type="hidden" id="dia" value="0">
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
