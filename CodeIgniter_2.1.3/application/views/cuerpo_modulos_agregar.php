
<script type="text/javascript">
	function nombreEnUso() {
		
	}

	function agregarModulo() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar módulo temático');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar el módulo temático al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	function resetearModulo() {
		$('#nombre').val("");
		$('#descripcion').val("");
		$('#id_requisitos').val("");
		$('#id_profesorLider').val("");
		$('#id_profesoresEquipo').val("");
	}

</script>


<fieldset style="min-width:1000px">
	<legend>Agregar Módulo temático</legend>
	<?php
		$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Modulos/postAgregarModulo', $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class= "span6" >
				<p>Complete los datos del formulario para ingresar un módulo temático</p>
			</div>
		</div>	
  		<div class="row-fluid">
			<div class="span6">
				<!-- nombre modulo -->
				<div class="control-group">
					<label class="control-label" for="nombre">1.- <font color="red">*</font> Nombre módulo:</label>
					<div class="controls">
						<input class="span12" id="nombre" required type="text" name="nombre" maxlength="49"  placeholder="Ej: Comunicación no verbal" onblur="nombreEnUso()">
					</div>
				</div>
				<br>

				<!-- descripción módulo temático -->
				<div class="control-group">
					<label class="control-label" for="descripcion">2.- <font color="red">*</font> Ingrese una descripción del módulo:</label>
					<div class="controls">
						<textarea required id="descripcion" name="descripcion" placeholder="Ingrese una descripción para el módulo temático" maxlength="99" rows="5" style="resize: none;" class="span12"></textarea>
					</div>
				</div>
				
				<!-- Implementos módulo temático -->
				<div class="control-group">
					<label class="control-label" for="id_implementos">3.- Agregar implementos requeridos:</label>
					<div class="controls">
						<select id="id_implementos" name="id_implementos[]" class="span12" title="Implementos necesarios para realizar el módulo temático" multiple="multiple">
						<?php
						if (isset($implementosModulo)) {
							foreach ($implementosModulo as $impl) {
								?>
									<option value="<?php echo $impl->id; ?>"><?php echo $impl->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>
			</div>
		
			<div class="span6">
				<!--profesor lider-->
				<div class="control-group">
					<label class="control-label" for="id_profesorLider" >4.- <font color="red">*</font> Asignar profesor lider:</label>
					<div class="controls">
						<select required id="id_profesorLider" name="id_profesorLider" class="span12" title="asigne profesor lider">
						<?php
						if (isset($posiblesProfesoresLider)) {
							foreach ($posiblesProfesoresLider as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>
				<br>
				
				<!--equipo profesores-->
				<div class="control-group">
					<label class="control-label" for="id_profesoresEquipo" >5.- <font color="red">*</font> Profesores del equipo:</label>
					<div class="controls">
						<select required id="id_profesoresEquipo" name="id_profesoresEquipo[]" class="span12" title="Escoja los profesores del equipo" multiple="multiple">
						<?php
						if (isset($posiblesProfesoresEquipo)) {
							foreach ($posiblesProfesoresEquipo as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				</br>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarModulo()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearModulo()" >
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
