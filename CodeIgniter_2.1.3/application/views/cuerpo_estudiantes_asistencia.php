<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var tiposFiltro = ["", "Rut", "Nombre", "Apellido paterno", "Comentario"];
	var ruts_estudiantes = new Array();

	function guardarAsistencia() {
		
	}

	function seleccionadaSeccion() {
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		//cargarSesionesDeClase();
		cargarEstudiantesSeccion();

		/* Quito el div que indica que se está cargando */
		$('#icono_cargando').hide();
	}

	function cargarSesionesDeClase() {
		var idElem = $('#seccion').val();

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
			}
		});
	}


	function cargarEstudiantesSeccion() {
		var idElem = $('#seccion').val();
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getEstudiantesBySeccionAjax") ?>",
			data: { seccion: idElem },
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaAsistencia");
				$(tablaResultados).find('tbody').remove();

				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
				var arrayRespuesta = new Array();
				ruts_estudiantes = arrayObjectRespuesta;
				for (var i = 0; i < arrayObjectRespuesta.length; i++) {
					arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) {
						return (value == null ? "": value);
					});
				}

				var nodoTexto, tr, td, inicio;


				//CARGO EL CUERPO DE LA TABLA
				var tbody = document.createElement('tbody');
				if (arrayRespuesta.length == 0) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					$(td).html("La sección no tiene estudiantes");
					$(td).attr('colspan', tiposFiltro.length);
					tr.appendChild(td);
					tbody.appendChild(tr);
				}

				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:pointer");
					//tr.setAttribute("onClick", "marcarAsistencia(this);");

					td = document.createElement('td');
					nodoTexto = document.createElement('input');
					//nodoTexto.type = 'checkbox';
					nodoTexto.setAttribute("type", 'checkbox');
					nodoTexto.setAttribute("name", 'asistencia[\''+arrayObjectRespuesta[i].id+'\']');
					nodoTexto.setAttribute("id", 'asistencia_'+arrayObjectRespuesta[i].id);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayObjectRespuesta[i].rut);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayObjectRespuesta[i].nombre1);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayObjectRespuesta[i].apellido1);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					td = document.createElement('td');
					nodoTexto = document.createElement('input');
					nodoTexto.setAttribute('type', 'text');
					nodoTexto.setAttribute('name', 'comentario[\''+arrayObjectRespuesta[i].id+'\']');
					nodoTexto.setAttribute('id', 'comentario_'+arrayObjectRespuesta[i].id);
					nodoTexto.setAttribute('maxlength', '100');
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);			}
		});
	}

	function cargaHeadTabla() {
		var tablaResultados = document.getElementById("tablaAsistencia");
		$(tablaResultados).find('thead').remove();
		
		var nodoCheckeable, nodoTexto, th, thead, tr;
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');

		for (var i = 0; i < tiposFiltro.length; i++) {
			th = document.createElement('th');
			if (tiposFiltro[i] != '') {
				// Texto
				nodoTexto = document.createTextNode(tiposFiltro[i]);
				th.appendChild(nodoTexto);
			}
			else { //Esto es para el caso de los checkbox que marcan toda la tabla
				nodoCheckeable = document.createElement('input');
				nodoCheckeable.setAttribute('data-previous', 'false,true,false');
				nodoCheckeable.setAttribute('type', 'checkbox');
				nodoCheckeable.setAttribute('id', 'selectorTodos');
				nodoCheckeable.setAttribute('title', 'Seleccionar todos');
				nodoCheckeable.setAttribute('onchange', "checkAll(this);");
				th.appendChild(nodoCheckeable);
			}
			tr.appendChild(th);
		}
		thead.appendChild(tr);
		
		tablaResultados.appendChild(thead);
	}

	function checkAll(checkboxAll) {
		var checkeado = false;
		if ($(checkboxAll).is(':checked')) {
			checkeado = true;
		}
		for (var i = 0; i < ruts_estudiantes.length; i++) {
			$('#asistencia_'+ruts_estudiantes[i].id).prop('checked', checkeado);
		}
	}

	//Se cargan por ajax
	$(document).ready(function() {
		cargaHeadTabla();
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

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group offset6">
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
	<?php echo form_close(''); ?>
</fieldset>
