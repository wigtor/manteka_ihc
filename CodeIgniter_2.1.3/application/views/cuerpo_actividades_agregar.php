
<script type="text/javascript">
	function nombreEnUso() {
		
	}
	
	function seleccionarTodasInstancias() {
		var selectObj = document.getElementById('instancias');
		for(var i = 0; i < selectObj.length; i++) {
			selectObj.options[i].selected = true;
		}
	}

	function agregarActividad() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			seleccionarTodasInstancias();
			$('#tituloConfirmacionDialog').html('Confirmación para agregar actividad masiva');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar la actividad masiva al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}
	
	function agregarInstancia() {
		var fecha = $('#fecha_planificada').val();
		var lugar = $('#lugar').val();
		if (fecha == "") {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('No ha seleccionado una fecha para la instancia en que se desarrolla la actividad');
			$('#modalError').modal();
		}
		else if (!document.getElementById('lugar').checkValidity() ) {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('No ha ingresado un lugar en que se desarrolla la actividad');
			$('#modalError').modal();
		}
		else {
			
			$('#instancias')
				.append('<option value=\'{"fecha":"'+fecha+'", "lugar":"'+lugar+'"}\'>'+fecha + ' - ' + lugar+'</option>');
			//{fecha:\''+fecha+'\', lugar:\''+lugar+'\'}
		}
	}
	
	function iniciarDatepicker() {
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		var diaSemana = $('#dia').val();
		/*
		var daysDisabled = "";
		for (var i = 0; i < 7; i++) {
			if (i != 0) {
				daysDisabled += ",";
			}
			if (diaSemana != i) {
				daysDisabled += i;
			}
		}
		*/
		$('#dp_fecha_planificada').datepicker("remove");
		$('#dp_fecha_planificada').datepicker({
			language: "es",
			calendarWeeks: true,
			format: 'yyyy-mm-dd',
			autoclose: true
		});

		//$('#dp_fecha_planificada').datepicker('refresh');
	}

	function resetearActividad() {
		$('#nombre').val("");
	}
	
	$(document).ready(function() {
		iniciarDatepicker();
	});
	
</script>


<fieldset style="min-width:1000px">
	<legend>Agregar Actividad Masiva</legend>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class= "span6" >
				<p>Complete los datos del formulario para ingresar una actividad masiva</p>
			</div>
		</div>	
  		<div class="row-fluid">
			<div class="span6">
				<?php
					$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
					echo form_open('ActividadesMasivas/postAgregarActividad', $attributes);
				?>
			
				<!-- nombre de la actividad masiva -->
				<div class="control-group">
					<label class="control-label" for="nombre">1.- <font color="red">*</font> Nombre de la actividad masiva:</label>
					<div class="controls">
						<input class="span12" id="nombre" required type="text" name="nombre" maxlength="49"  placeholder="Ej: Teatro" onblur="nombreEnUso()">
					</div>
				</div>
				
				<!-- Instancias de la actividad masiva -->
				<div class="control-group">
					<label class="control-label" for="instancias">3.- Instancias de la actividad masiva:</label>
					<div class="controls">
						<select id="instancias" name="listaInstanciasActividades[]" class="span12" title="Instancias en que será realizada la actividad masiva" multiple="multiple">
						
						</select> 
					</div>
				</div>
				
				</br>
				
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarActividad()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearActividad()" >
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
				
				<?php echo form_close(""); ?>
				
			</div>
		
			<div class="span6">
				
				<fieldset>
				<?php
					$attributes = array('id' => 'formAgregarInstancia', 'class' => 'form-horizontal');
					echo form_open('ActividadesMasivas/postAgregarActividad', $attributes);
				?>
					<h5>Agregar instancia para la actividad masiva</h5>
					<div class="control-group">
						<label class="control-label" for="fecha_planificada">2.- <font color="red">*</font> Fecha en que se realizará:</label>
						<div class="controls">
							<div class="input-append date pull-left" id="dp_fecha_planificada" data-date-format="yyyy-mm-dd" data-date="2014-01-01">
								<input class="span8" size="16" readonly id="fecha_planificada" required name="fecha_planificada" type="text" value="">
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
							<label class="control-label" id="horario" class="pull-left" class="span2"></label>
							<input type="hidden" id="dia" value="0">
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="lugar">3.- <font color="red">*</font> Lugar en que se realizará:</label>
						<div class="controls">
							<input class="span12" id="lugar" type="text" name="lugar" maxlength="49" required placeholder="Av. Matucana 100">
						</div>
					</div>
					<button type="button" class="btn" onclick="agregarInstancia()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Agregar instancia
					</button>
					<?php echo form_close(""); ?>
				
				</fieldset>
				
				
			</div>
		</div>
</fieldset>
