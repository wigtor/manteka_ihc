<?php
/**
* Este Archivo corresponde al cuerpo central de la vista crear coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>

<script>
	function resetearCoordinador() {

		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var correoDetalle = document.getElementById("correoEditar");
		var fonoDetalle = document.getElementById("fono");
		var correoDetalle2 = document.getElementById("correoEditar2");
		$(rutDetalle).val("");
		$(nombre1Detalle).val("");
		$(nombre2Detalle).val("");
		$(apellido1Detalle).val("");
		$(apellido2Detalle).val("");
		$(correoDetalle).val("");
		$(correoDetalle2).val("");
		$(fonoDetalle).val("");
	}

	function agregarCoordinador(){
		rutAEliminar = $("#rutEditar").val();
		nombre1Detalle = $("#nombreunoEditar").val();
		nombre2Detalle = $("#nombredosEditar").val();
		apellido1Detalle = $("#apellidopaternoEditar").val();
		apellido2Detalle = $("#apellidomaternoEditar").val();
		correoDetalle = $("#correoEditar").val();
		correoDetalle2 = $("#correoEditar2").val();
		fonoDetalle = $("#fono").val();
		if ((rutAEliminar == "") || (nombre1Detalle == "") || (apellido1Detalle == "") || (apellido2Detalle == "") || (correoDetalle == "")) {
			return; //Faltan campos!!!
		}
		$('#modalConfirmacion').modal();
	}
</script>

<fieldset>
	<legend>Agregar Coordinador</legend>
	<div class="row-fluid">
		<div class="span6">
			<font color="red">* Campos Obligatorios</font>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6" >
			<p>Complete los datos del formulario para agregar el coordinador:</p>
		</div>
	</div>

	<div class="row-fluid">
		<?php
				$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
				echo form_open('Coordinadores/agregarCoordinadores', $attributes);
			?>
		<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputInfo">1-.<font color="red">*</font> RUT</label>
					<div class="controls">
						<input type="text" id="rutEditar" name="rutEditar" maxlength="10" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Primer nombre</label>
					<div class="controls">
						<input type="text" id="nombreunoEditar" name="nombre1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombredosEditar" name="nombre2" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">4-.<font color="red">*</font> Apellido Paterno</label>
					<div class="controls">
						<input type="text" id="apellidopaternoEditar" name="apellido1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">5-.<font color="red">*</font> Apellido Materno</label>
					<div class="controls">
						<input type="text" id="apellidomaternoEditar" name="apellido2" maxlength="20" required>
					</div>
				</div>
				
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputInfo">6-.<font color="red">*</font> Correo</label>
					<div class="controls">
						<input type="email" id="correoEditar" name="correo1" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-. Correo secundario</label>
					<div class="controls">
						<input type="email" id="correoEditar2" name="correo2" maxlength="40" placeholder="nombre_usuario2@miemail.com" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-. Teléfono</label>
					<div class="controls">
						<input type="text" id="fono" name="fono" maxlength="10" placeholder="44556677" >
					</div>
				</div>

				<div class="control-group">
					<div class="controls ">
						<button type="button" class="btn" onclick="agregarCoordinador()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearCoordinador()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>&nbsp;

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se van a guardar los cambios del coordinador ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Ã</div>&nbsp; Cancelar</button>
								<button type="submit" class="btn"><div class="btn_with_icon_solo">Â</div>&nbsp; Aceptar</button>
							</div>
						</div>

						<!-- Modal de seleccionaAlgo -->
						<div id="modalSeleccioneAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No ha seleccionado un coordinador</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione un coordinador y vuelva a intentarlo</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>
			</div>	
		<?php echo form_close(""); ?>
		
	</div>











	<!--
		<div class="span7">
		<div class="span12">
			<h4>Complete los siguientes datos para agregar un coordinador:</h4><br/>
				<?php
					$attributes = array('onSubmit' => 'return validar(this)', 'class' => 'span9');
					echo form_open('Coordinadores/agregarCoordinadores', $attributes);
				?>
				<br/>
				<table>
					<tr>
					<td><h6><span class="text-error">(*)</span>Nombre completo:</h6></td>
					<td><input class ="input-xlarge" name='nombre' type="text" placeholder="ej:SOLAR FUENTES MAURICIO IGNACIO" required></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Rut :</h6></td>
					<td><input class ="input-xlarge" name='rut' type="text" placeholder="ej:5946896-3" required pattern="([0-9]{8}|[0-9]{7})-([0-9]{1}|k)" ></td>
					</tr>			
					<tr>
					<td><h6><span class="text-error">(*)</span>Contraseña:</h6></td>
					<td><input class ="input-xlarge" name='contrasena'  type="password" placeholder="*******" required></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Confirmar contraseña:</h6></td>
					<td><input class ="input-xlarge" name='contrasena2' type="password" placeholder="*******" required></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Correo 1:</h6></td>
					<td><input class ="input-xlarge" name='correo1' type="email" placeholder="ej:edmundo.leiva@usach.cl" required ></td>
					</tr>
					<tr>
					<td><h6>Correo 2:</h6></td>
					<td><input class ="input-xlarge" name='correo2' type="email" placeholder="ej:edmundo.leiva@gmail.com"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Teléfono:</h6></td>
					<td><input class ="input-xlarge" name='fono' type="text" placeholder="ej:9-87654321" required></td>
					</tr>
					<tr>
					<td></td>
					<td>Los campos con <span class="text-error">(*)</span> son obligatorios</td>
					</tr>
				</table>
				<br />
				<div class="span6 offset6">
					<button class="btn" type="submit">Agregar</button>
					<a class="btn" href="/manteka/index.php/Coordinadores/verCoordinadores/" type="button">Cancelar</a>
				</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
-->
</fieldset>

