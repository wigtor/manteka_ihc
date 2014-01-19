<script src="/<?php echo config_item('dir_alias') ?>/javascripts/descargaByJquery.js"></script>
<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["N°", "Rut", "Nombres"];
	var ruts_estudiantes = new Array();
	var LARGO_MAXIMO_NOMBRE = 19;

	function resetTablaNombres() {
		var tablaResultados = document.getElementById("tablaCalificaciones");
		$(tablaResultados).find('tbody').remove();
		var tr, td, nodoAsterisco;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("La sección no tiene estudiantes");
		$(td).attr('colspan', listaColumnas.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
	}
	
	function subirActa() {
		alert("No implementao aún...");
	
	}

	//Carga una matriz con los datos del estudiante y sus Calificacioness
	function cargarDatosEstudiantes() {
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}
		
		var tablaNombres = document.getElementById("tablaCalificacionesNombres");
		$(tablaNombres).find('tbody').remove();
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getCalificacionesEstudiantesBySeccionAjax") ?>",
			data: { id_seccion: id_seccion},
			success: function(respuesta) {
				var tablaNombres = document.getElementById("tablaCalificacionesNombres");

				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
				var arrayRespuesta = new Array();
				ruts_estudiantes = new Array();
				for (var i = 0; i < arrayObjectRespuesta.length; i++) {
					ruts_estudiantes[i] = arrayObjectRespuesta[i].rut; //Guardo los ruts de los estudiantes
					arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) { //Transformo de array asociativo a basado en indices
						return (value == null ? "": value);
					});
				}

				var nodo, td, divTd, estaPresente, comentario, nodoComentario, nodoIconComentario, icono, tbodyNombres, trNombres, stringTemp;

				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaNombres();
					return;
				}

				var tbodyNombres = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) { //Cada iteración es una fila o un estudiante
					trNombres = document.createElement('tr');
					trNombres.setAttribute('style', "cursor:default; height:47px;");
					
					for (j = 0; j < listaColumnas.length; j++) { //cada iteración es una columna (datos del estudiante o dias de Calificaciones)
						
						//Entonces se están cargando las columnas relacionadas con los datos del estudiante
							td = document.createElement('td'); //Creo la celda
							stringTemp = arrayRespuesta[i][j];
							if (stringTemp.length > LARGO_MAXIMO_NOMBRE) {
								stringTemp = stringTemp.substring(0, LARGO_MAXIMO_NOMBRE) + "..."
							}
							else {
								stringTemp = stringTemp.substring(0, LARGO_MAXIMO_NOMBRE);
							}
							nodo = document.createTextNode(stringTemp);
							td.appendChild(nodo);
							trNombres.appendChild(td); //Agrego la celda a la fila
					}
					tbodyNombres.appendChild(trNombres);
				}
				tablaNombres.appendChild(tbodyNombres);
			}
		});
	}
	
	function cargarDatosAsistencia() {
		cargarDatosAjax("tablaAsistenciaPromedio", "getAsistenciaPromedioEstudiantesBySeccionAjax");
	}
	
	function cargarDatosAsistenciaActividades() {
		cargarDatosAjax("tablaAsistenciaActividadesPromedio", "getAsistenciaActividadesPromedioEstudiantesBySeccionAjax");
	}
	
	function cargarDatosCalificaciones() {
		cargarDatosAjax("tablaCalificacionesPromedio", "getCalificacionesPromedioEstudiantesBySeccionAjax");
	}
	
	function cargarSituacionFinal() {
		cargarDatosAjax("tablaFinalPromedio", "getSituacionFinalEstudiantesBySeccionAjax");
	}
	

	function cargarDatosAjax(idTabla, ajaxMethod) {
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}
		
		var tabla = document.getElementById(idTabla);
		$(tabla).find('tbody').remove();
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/") ?>/"+ajaxMethod,
			data: { id_seccion: id_seccion},
			success: function(respuesta) {
				var tabla = document.getElementById(idTabla);
				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);

				var nodo, tr, td, divTd, estaPresente, comentario, nodoComentario, nodoIconComentario, icono, stringTemp;

				var tbody = document.createElement('tbody');
				for (var i = 0; i < arrayObjectRespuesta.length; i++) { //Cada iteración es una fila o un estudiante
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:default;height:47px;");
					td = document.createElement('td'); //Creo la celda
					stringTemp = arrayObjectRespuesta[i].valor;
					nodo = document.createTextNode(stringTemp);
					td.appendChild(nodo);
					tr.appendChild(td); //Agrego la celda a la fila
					tbody.appendChild(tr);
				}
				tabla.appendChild(tbody);
			}
		});
	}

	function cargarHeadTabla() {
		var tablaNombres = document.getElementById("tablaCalificacionesNombres");
		var tablaAsistenciaAct = document.getElementById("tablaAsistenciaActividadesPromedio");
		var tablaAsistencia = document.getElementById("tablaAsistenciaPromedio");
		var tablaCalificaciones = document.getElementById("tablaCalificacionesPromedio");
		var tablaFinalPromedio = document.getElementById("tablaFinalPromedio");

		$(tablaNombres).find('thead').remove();
		$(tablaAsistenciaAct).find('thead').remove();
		$(tablaAsistencia).find('thead').remove();
		$(tablaCalificaciones).find('thead').remove();
		$(tablaFinalPromedio).find('thead').remove();
		
		var nodoCheckeable, nodoTexto, th, thead, tr;
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:77px;");

		//Recorro la lista de columnas para crearlas
		for (var i = 0; i < listaColumnas.length; i++) {
			th = document.createElement('th');
			if (i == 0) {
				th.setAttribute('style', "min-width:30px");
			}
			else if (i == 1)
				th.setAttribute('style', "min-width:70px");
			else
				th.setAttribute('style', "min-width:200px");
			nodoTexto = document.createTextNode(listaColumnas[i]);
			th.appendChild(nodoTexto);
			tr.appendChild(th);
		}
		thead.appendChild(tr);
		tablaNombres.appendChild(thead);


		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:77px;");
		th = document.createElement('th');
		th.setAttribute('style', "min-width:80px");

		//Agrego el nombre de la evaluación
		nodoTexto = document.createTextNode("asistencia a eventos");
		th.appendChild(nodoTexto);
		tr.appendChild(th);
		thead.appendChild(tr);
		tablaAsistenciaAct.appendChild(thead);


		//Cargo la tabla para el porcentaje de asistencia total
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:77px;");
		th = document.createElement('th');
		th.setAttribute('style', "min-width:30px");
		nodoTexto = document.createTextNode("asistencia a clases");
		th.appendChild(nodoTexto);
		tr.appendChild(th);
		thead.appendChild(tr);
		tablaAsistencia.appendChild(thead);
		
		//Cargo la tabla para el porcentaje de asistencia total
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:77px;");
		th = document.createElement('th');
		th.setAttribute('style', "min-width:30px");
		nodoTexto = document.createTextNode("Promedio Notas");
		th.appendChild(nodoTexto);
		tr.appendChild(th);
		thead.appendChild(tr);
		tablaCalificacionesPromedio.appendChild(thead);
		
		//Cargo la tabla para el porcentaje de asistencia total
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:77px;");
		th = document.createElement('th');
		th.setAttribute('style', "min-width:30px");
		nodoTexto = document.createTextNode("Calificación final");
		th.appendChild(nodoTexto);
		tr.appendChild(th);
		thead.appendChild(tr);
		tablaFinalPromedio.appendChild(thead);
	}

	function cargarDatos() {
		$('#icono_cargando').show();
		cargarHeadTabla();
		
		cargarDatosEstudiantes();
		cargarDatosAsistencia();
		cargarDatosAsistenciaActividades();
		cargarDatosCalificaciones();
		cargarSituacionFinal();
		
		
		//Quito el foco al select de la sección
		$('#seccion').blur();

		//Habilito el botón de descarga
		$('#btn_descargar').prop('disabled', false).button('refresh');

		$('#icono_cargando').hide();
	}

	function descargarToArchivo() {
		alert("No implementado aún...");
		return;
		$('#icono_cargando').show();
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}

		url =  "<?php echo site_url("Estudiantes/generateCSVCalificacionFinalBySeccionAjax") ?>";
		parametros = 'id_seccion='+id_seccion;
		$.download(url, parametros);
		$('#icono_cargando').hide();
	}

</script>


<fieldset>
	<legend>Ver calificaciones finales y subir actas</legend>
	<?php
		$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Estudiantes/postSubirActas/', $atributos);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">*</font> indica que se han ingresado comentarios
			</div>
		</div>
		<div class="row-fluid">
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="seccion">1.- Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="cargarDatos();">
							<option value="" disabled selected>Sección</option>
							<?php
							if (isset($secciones)) {
								foreach ($secciones as $valor) {
									?>
										<option value="<?php echo $valor->id; ?>"><?php echo $valor->nombre; ?></option>
									<?php 
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onclick="subirActa()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Subir acta
						</button>
						<button class="btn" type="button" id="btn_descargar" onclick="descargarToArchivo()" disabled title="Debe seleccionar una sección para descargar su registro de calificaciones">
							<i class="icon-download-alt"></i>
							&nbsp; Descargar a archivo
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			
			<div class="span5" style="margin-left:0px; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaCalificacionesNombres" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span2" style="margin-left:0px; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaCalificacionesPromedio" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span2" style="margin-left:0px; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaAsistenciaPromedio" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span2" style="margin-left:0px; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaAsistenciaActividadesPromedio" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span2" style="margin-left:0px; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaFinalPromedio" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
		</div>
		<div class="row-fluid">
			<div class="control-group span6 offset6" style="margin-top:10px;">
				<div class="controls ">
					<button class="btn" type="button" onclick="subirActa()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Subir acta
					</button>
				</div>
				<?php
					if (isset($dialogos)) {
						echo $dialogos;
					}
				?>
			</div>
		</div>
		<?php
			echo form_close('');
		?>
</fieldset>
