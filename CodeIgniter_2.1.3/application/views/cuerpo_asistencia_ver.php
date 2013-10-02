<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var tiposFiltro = ["", "Rut", "Nombre", "Apellido paterno", "Comentario"];
	var ruts_estudiantes = new Array();

	function seleccionadaSeccion() {
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		cargarSesionesDeClase();
		//$('#sesion_de_clase').val("");
		resetTablaAsistencia();

		/* Quito el div que indica que se está cargando */
		$('#icono_cargando').hide();
	}

	function seleccionadaClase() {
		cargarAsistenciaEstudiantes();
	}

	function cargarSesionesDeClase() {
		var idElem = $('#seccion').val();

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Sesiones/getSesionesBySeccionAjax") ?>",
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
				$("#sesion_de_clase").append(opcionDefault);

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$("#sesion_de_clase").append(new Option(arrayRespuesta[i].nombre+" - "+arrayRespuesta[i].fecha_planificada, arrayRespuesta[i].id));
				}
			}
		});
	}

	function resetTablaAsistencia() {
		var tablaResultados = document.getElementById("tablaAsistencia");
		$(tablaResultados).find('tbody').remove();
		var tr, td;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("No hay asistencia para la sección seleccionada en esa sesión de clase o no tiene estudiantes");
		$(td).attr('colspan', tiposFiltro.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
	}


	function cargarAsistenciaEstudiantes() {
		var id_seccion = $('#seccion').val();
		var id_sesion_de_clase = $('#sesion_de_clase').val();
		if ((id_seccion == "") || (id_sesion_de_clase == "")) {
			return;
		}
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getAsistenciaEstudiantesBySeccionAndSesionAjax") ?>",
			data: { id_seccion: id_seccion, id_sesion_de_clase: id_sesion_de_clase },
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

				var nodoTexto, tr, td, inicio, estaPresente;


				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaAsistencia();
					return;
				}

				var tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:pointer");
					//tr.setAttribute("onClick", "marcarAsistencia(this);");

					td = document.createElement('td');
					nodoTexto = document.createElement('input');
					//nodoTexto.type = 'checkbox';
					nodoTexto.setAttribute("type", 'checkbox');
					nodoTexto.setAttribute("disabled", 'disabled');
					nodoTexto.setAttribute("name", 'asistencia['+arrayObjectRespuesta[i].id+']');
					estaPresente = arrayObjectRespuesta[i].presente == undefined ? false : arrayObjectRespuesta[i].presente;
					estaPresente = arrayObjectRespuesta[i].presente == 1 ? true : false; //paso a booleano
					$(nodoTexto).prop('checked', estaPresente);
					//nodoTexto.checked = estaPresente;
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
					nodoTexto.setAttribute('name', 'comentario['+arrayObjectRespuesta[i].id+']');
					nodoTexto.setAttribute("value", arrayObjectRespuesta[i].comentario == "" ? '' : $.trim(arrayObjectRespuesta[i].comentario));
					nodoTexto.setAttribute('id', 'comentario_'+arrayObjectRespuesta[i].id);
					nodoTexto.setAttribute('maxlength', '100');
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);
			}
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
				nodoCheckeable.setAttribute("disabled", 'disabled');
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

	function guardarAsistencia() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar asistencia');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar el registro de asistencia en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	//Se cargan por ajax
	$(document).ready(function() {
		cargaHeadTabla();
		resetTablaAsistencia();
	});

</script>


<fieldset> 
<legend>Ver asistencia</legend>
		<div class="row-fluid">
			<div class="span5">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="seccion">1.- <font color="red">*</font> Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="seleccionadaSeccion()">
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
					<label class="control-label" for="sesion_de_clase">2.- <font color="red">*</font> Clase planificada:</label>
					<div class="controls">
						<select id="sesion_de_clase" name="sesion_de_clase" class="span12" required onchange="seleccionadaClase()">
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
		<?php if ($id_tipo_usuario == TIPO_USR_PROFESOR) { ?>
		<div class="row-fluid">
			<div class="control-group offset7">
				<div class="controls" >
					<a href="<?php echo site_url("Estudiantes/agregarAsistencia")?>" class="btn" type="button">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Editar asistencia
					</a>
				</div>
				<?php
					if (isset($dialogos)) {
						echo $dialogos;
					}
				?>
			</div>
		</div>
		<?php } ?>
</fieldset>
