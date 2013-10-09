<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["Sección", "Modulo temático", "Semana de avance"];
	var lista_idSecciones = new Array();
	var lista_modulosTematicos = new Array();


	function resetTablaAvance() {
		var tablaResultados = document.getElementById("tablaAvanceSecciones");
		$(tablaResultados).find('tbody').remove();
		var tr, td;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("No hay secciones registradas en el sistema");
		$(td).attr('colspan', listaColumnas.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
	}


	//Carga una matriz con los datos del estudiante y sus asistencias
	function cargarAvanceSecciones() {
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Planificacion/getAvanceSeccionesAjax") ?>",
			data: { },
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaAvanceSecciones");
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaAvance();
					return;
				}
				var tr, td, tbody, nodo, nodoSelect, elementoSelect, temp;

				tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) { //Cada iteración es una fila o una sección (curso)
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:default");


					//NOMBRE DE LA SECCIÓN
					td = document.createElement('td'); //Creo la celda
					nodo = document.createTextNode(arrayRespuesta[i].nombre_seccion);
					td.appendChild(nodo);
					tr.appendChild(td); //Agrego la celda a la fila


					//SELECT CON LOS MÓDULOS TEMÁTICOS
					td = document.createElement('td'); //Creo la celda
					nodoSelect = document.createElement('select');
					nodoSelect.setAttribute("id", 'moduloTematico_'+arrayRespuesta[i].id);
					nodoSelect.setAttribute("onchange", 'moduloTematicoSeleccionado(this)');
					//Agrego los modulos temáticos al select
					elementoSelect = document.createElement('option');
					elementoSelect.setAttribute("value", '');
					nodo = document.createTextNode("Sin asignación");
					elementoSelect.appendChild(nodo);
					nodoSelect.appendChild(elementoSelect);
					for (var j = 0; j < lista_modulosTematicos.length; j++) {
						elementoSelect = document.createElement('option');
						elementoSelect.setAttribute("value", lista_modulosTematicos[j].id);
						nodo = document.createTextNode(lista_modulosTematicos[j].nombre);
						elementoSelect.appendChild(nodo);
						nodoSelect.appendChild(elementoSelect);
					}
					temp = arrayRespuesta[i].id_mod_tem== null ? '' : arrayRespuesta[i].id_mod_tem;
					nodoSelect.value = temp;
					td.appendChild(nodoSelect);
					tr.appendChild(td);


					//Input con el N° de semana sesion_seccion en que va avanzando
					var listaSesiones = getSesionesByModuloTematico(arrayRespuesta[i].id_mod_tem, arrayRespuesta[i].id);
					td = document.createElement('td'); //Creo la celda
					nodoSelect = document.createElement('select');
					nodoSelect.setAttribute("id", 'sesion_seccion_'+arrayRespuesta[i].id);
					nodoSelect.setAttribute("name", 'sesion_seccion['+arrayRespuesta[i].id+']');
					//Agrego las sesiones para el módulo temático seleccionado
					elementoSelect = document.createElement('option');
					elementoSelect.setAttribute("value", '');
					nodo = document.createTextNode("Sin asignación");
					elementoSelect.appendChild(nodo);
					nodoSelect.appendChild(elementoSelect);
					for (var j = 0; j < listaSesiones.length; j++) {
						elementoSelect = document.createElement('option');
						elementoSelect.setAttribute("value", listaSesiones[j].id);
						nodo = document.createTextNode(listaSesiones[j].num_sesion_de_seccion + " - " +listaSesiones[j].nombre_sesion);
						elementoSelect.appendChild(nodo);
						nodoSelect.appendChild(elementoSelect);
					}
					temp = arrayRespuesta[i].id_sesion == null ? '' : arrayRespuesta[i].id_sesion; //Se pone el select con un valor
					nodoSelect.value = temp;
					td.appendChild(nodoSelect);
					tr.appendChild(td);


					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);
			}
		});
	}

	function moduloTematicoSeleccionado(inputModTem) {
		//Obtengo el selectSesiones usando el id del inputModTem
		var idElem = inputModTem.id;
		var id_seccion = idElem.substring('moduloTematico_'.length, idElem.length);
		var selectSesiones = document.getElementById('sesion_seccion_'+id_seccion);
		$(selectSesiones).empty();
		$(selectSesiones).append(new Option( "Sin asignación", "", true, true));

		var id_modulo_tem = $(inputModTem).val();
		if (id_modulo_tem == "") {
			return;
		}

		var arrayRespuesta = getSesionesByModuloTematico(id_modulo_tem, id_seccion);
		for (var i = 0; i < arrayRespuesta.length; i++) {
			$(selectSesiones).append(new Option( arrayRespuesta[i].num_sesion_de_seccion + " - " + arrayRespuesta[i].nombre_sesion, arrayRespuesta[i].id, true, true));
		};
		if (arrayRespuesta.length > 0) {
			$(selectSesiones).val(arrayRespuesta[0].id);
		}
	}

	function getSesionesByModuloTematico(id_modulo_tem, id_seccion) {
		var respuesta = $.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Planificacion/getSesionesByModuloTematicoAndSeccionAjax") ?>",
			data: { id_mod_tem: id_modulo_tem, id_seccion: id_seccion },
			success: function(respuesta) {

			}
		});
		return arrayRespuesta = jQuery.parseJSON(respuesta.responseText);
	}


	function cargarHeadTabla() {
		var tablaResultados = document.getElementById("tablaAvanceSecciones");
		$(tablaResultados).find('thead').remove();
		
		var nodoCheckeable, nodoTexto, th, thead, tr;
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');

		//Recorro la lista de columnas para crearlas
		for (var i = 0; i < listaColumnas.length; i++) {
			th = document.createElement('th');
			nodoTexto = document.createTextNode(listaColumnas[i]);
			th.appendChild(nodoTexto);
			tr.appendChild(th);
		}

		thead.appendChild(tr);
		
		tablaResultados.appendChild(thead);
	}

	function cargarModulosTematicos() {
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Modulos/getModulosTematicosAjax") ?>",
			data: { },
			success: function(respuesta) {
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				lista_modulosTematicos = arrayRespuesta;
			}
		});
	}

	function cargarDatosAsignacionActual() {
		$('#icono_cargando').show();
		cargarHeadTabla();
		cargarAvanceSecciones();
		$('#icono_cargando').hide();
	}

	$(document).ready(function() {
		cargarModulosTematicos();
		cargarDatosAsignacionActual();
	});

	function guardarAsignacionActual() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar las asignaciones actuales');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar las asignaciones actuales en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

</script>


<fieldset>
	<legend>Asignacion Actual</legend>
	<?php
		$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Planificacion/postAsignacionActual/', $atributos);
	?>
		<div class="row-fluid">
			<div class="control-group offset7">
				<div class="controls ">
					<button class="btn" type="button" onclick="avanzarUnaSemana()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Avanzar todos
					</button>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<table id="tablaAvanceSecciones" class="table table-hover">
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group offset7">
				<div class="controls ">
					<button class="btn" type="button" onclick="guardarAsignacionActual()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Guardar
					</button>
					<button class="btn" type="button" onclick="resetearAsignacionActual()">
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
		<?php
			echo form_close('');
		?>
</fieldset>
