<script type="text/javascript">

	function guardarAsistencia() {
		
	}

	function seleccionadaSeccion() {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = $('#seccion').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getSesionesBySeccionAndProfesorAjax") ?>",
			data: { seccion: idElem },
			success: function(respuesta) {
				var arrayRespuesta = jQuery.parseJSON(respuesta);

				$("#sesion_de_clase").empty();
				var opcionDefault;
				if (arrayRespuesta.length == 0) {
					opcionDefault = new Option("No hay sesiones de clase para la sección", "");
				}
				else {
					opcionDefault = new Option("Seleccione sección", "");
				}
				opcionDefault.setAttribute("disabled","disabled");
				opcionDefault.setAttribute("selected","selected");
				$("#selectSeccionOrigen").append(opcionDefault);

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$("#selectSeccionOrigen").append(new Option(arrayRespuesta[i].nombre, arrayRespuesta[i].id));
				}
				

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function seleccionadaClase() {

	}

	//Se cargan por ajax
	$(document).ready(function() {

	});

</script>


<fieldset> 
<legend>Agregar asistencia</legend>
	<?php
		$atributos= array('id' => 'formEditar', 'class' => 'form-horizontal');
		echo form_open('Estudiantes/postAgregarAsistencia/', $atributos);
	?>
		<div class="row-fluid">
			<div class="span5">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="dia">1.- <font color="red">*</font> Sección:</label>
					<div class="controls">
						<select id="seccion" class="span10" required onchange="seleccionadaSeccion()">
							<option value="" disabled selected>Sección</option>
							<?php
							if (isset($secciones)) {
								foreach ($secciones as $valor) {
									?>
										<option value="<?php echo $valor->id?>"><?php echo $valor->nombre; ?></option>
									<?php 
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dia">2.- <font color="red">*</font> Clase planificada:</label>
					<div class="controls">
						<select id="sesion_de_clase" class="span10" required onchange="seleccionadaClase()">
							<option value="" disabled selected>Clase</option>

						</select>
					</div>
				</div>
			</div>
			<div class="span7">
				<table id="tablaAsistencia" class="table table-hover">
					<thead>
						<tr>
							<th>
								<input type="checkbox">
							</th>
							<th>
								Rut
							</th>
							<th>
								Nombre
							</th>
							<th>
								Apellido
							</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onclick="guardarAsistencia()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearAsistencia(true)">
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
