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
						<!--<input type="text" id="rutEditar" placeholder="11223344" class="span12" name="rutEditar" maxlength="10" required> -->
						<input id="rutEditar" class="span12" onblur="comprobarRut()" type="text" maxlength="10" pattern="[0-9]+" title="Ingrese sólo números sin dígito verificador" min="1" name="rutEditar" placeholder="Ej:17785874" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Primer nombre</label>
					<div class="controls">
						<input type="text" id="nombreunoEditar" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Juan" class="span12" name="nombre1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombredosEditar" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Mario" class="span12" name="nombre2" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">4-.<font color="red">*</font> Apellido Paterno</label>
					<div class="controls">
						<input type="text" id="apellidopaternoEditar" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" class="span12" name="apellido1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">5-.<font color="red">*</font> Apellido Materno</label>
					<div class="controls">
						<input type="text" id="apellidomaternoEditar" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" class="span12" name="apellido2" maxlength="20" required>
					</div>
				</div>
				
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputInfo">6-.<font color="red">*</font> Correo</label>
					<div class="controls">
						<input type="email" id="correoEditar" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" class="span12" name="correo1" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-. Correo secundario</label>
					<div class="controls">
						<input type="email" id="correoEditar2" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" class="span12" name="correo2" maxlength="40" placeholder="nombre_usuario2@miemail.com" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-. Teléfono</label>
					<div class="controls">
						<input type="text" id="fono" class="span12" name="fono" maxlength="10" pattern="[0-9]+" placeholder="44556677" >
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
								<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
							</div>
						</div>

					</div>
				</div>
			</div>	
		<?php echo form_close(""); ?>
	</div>
	<!-- Modal de modalRutUsado -->
	<div id="modalRutUsado" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>RUT ingresado está en uso</h3>
		</div>
		<div class="modal-body">
			<p>Por favor ingrese otro rut y vuelva a intentarlo</p>
		</div>
		<div class="modal-footer">
			<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
		</div>
	</div>		
</fieldset>

<script>
	function comprobarRut() {
		var rut = document.getElementById("rutEditar").value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/rutExisteC") ?>", /* Se setea la url del controlador que responderá */
			data: { rut_post: rut},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == -1){

					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalRutUsado').modal();
					document.getElementById("rutEditar").value = "";
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
