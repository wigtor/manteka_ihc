<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["Rut", "Nombres", "Apellido paterno", "Apellido materno"];
	var ruts_estudiantes = new Array();
	var lista_idSesiones = new Array();

	function resetTablaAsistencia() {
		var tablaResultados = document.getElementById("tablaAsistencia");
		$(tablaResultados).find('tbody').remove();
		var tr, td;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("No hay asistencia para la sección seleccionada en esa sesión de clase o no tiene estudiantes");
		$(td).attr('colspan', listaColumnas.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
	}

	//Carga una matriz con los datos del estudiante y sus asistencias
	function cargarDatosAsistencia() {
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getAsistenciaEstudiantesBySeccionAjax") ?>",
			data: { id_seccion: id_seccion},
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaAsistencia");
				$(tablaResultados).find('tbody').remove();

				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
				var arrayRespuesta = new Array();
				ruts_estudiantes = new Array();
				for (var i = 0; i < arrayObjectRespuesta.length; i++) {
					ruts_estudiantes[i] = arrayObjectRespuesta[i].rut; //Guardo los ruts de los estudiantes
					arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) { //Transformo de array asociativo a basado en indices
						return (value == null ? "": value);
					});
				}

				var nodo, tr, td, divTd, estaPresente, comentario, nodoComentario;


				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaAsistencia();
					return;
				}

				var tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) { //Cada iteración es una fila o un estudiante
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:pointer");


					for (j = 0; j < arrayRespuesta[i].length; j++) { //cada iteración es una columna (datos del estudiante o dias de asistencia)
						

						//Entonces se están cargando las columnas relacionadas con los datos del estudiante
						if (j < listaColumnas.length) {
							td = document.createElement('td'); //Creo la celda
							nodo = document.createTextNode(arrayRespuesta[i][j]);
							td.appendChild(nodo);
							tr.appendChild(td); //Agrego la celda a la fila
						}
						else { //Entonces se están cargando las columnas relacionadas con la asistencia
							//arrayRespuesta[i][j] = jQuery.parseJSON(arrayRespuesta[i][j]);
							for (var k = 0; (k < arrayObjectRespuesta[i].asistencia.length) && (k < lista_idSesiones.length) ; k++) {
								td = document.createElement('td'); //Creo la celda
								divTd = document.createElement('div'); //Creo la celda

								nodo = document.createElement('input');
								nodo.setAttribute("type", 'checkbox');

								comentario = arrayObjectRespuesta[i].comentarios[k].comentario == null ? '' : arrayObjectRespuesta[i].comentarios[k].comentario; //paso a booleano
								nodoComentario = document.createElement('input');
								nodoComentario.setAttribute("type", 'hidden');
								nodoComentario.setAttribute("id", 'comentarioHidden_'+arrayObjectRespuesta[i].rut+'_'+lista_idSesiones[k]);
								nodoComentario.setAttribute("name", 'comentario['+arrayObjectRespuesta[i].rut+']['+lista_idSesiones[k]+']');
								nodoComentario.setAttribute("value", comentario);
								divTd.appendChild(nodoComentario);
										
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								nodo.setAttribute("disabled", 'disabled');
										<?php
									}
								?>
								nodo.setAttribute("name", 'asistencia['+arrayObjectRespuesta[i].rut+']['+lista_idSesiones[k]+']');
								estaPresente = arrayObjectRespuesta[i].asistencia[k].presente == undefined ? false : arrayObjectRespuesta[i].asistencia[k].presente;
								estaPresente = arrayObjectRespuesta[i].asistencia[k].presente == 1 ? true : false; //paso a booleano
								$(nodo).prop('checked', estaPresente);
								nodo.setAttribute("id", 'asistencia_'+arrayObjectRespuesta[i].rut+'_'+lista_idSesiones[k]);



								//Agrego el popover para poner comentarios
								
								var divBtnCerrar = '';// '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
								var divs = '<div ><input class="popovers" onChange="cambioComentario(this)" value="'+comentario+
								'" id="comentario_'+arrayObjectRespuesta[i].rut+'_'+lista_idSesiones[k]+
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								'" disabled="disabled'+
										<?php
									}
								?>
								'" type="text" ></div>';
								$(divTd).clickover({html:true, content: divs, onShown: copiarDeHidenToClickover, placement:'top', title:"Comentarios", indice1: arrayObjectRespuesta[i].rut, indice2: lista_idSesiones[k]});
								divTd.appendChild(nodo);
								td.appendChild(divTd);
								tr.appendChild(td); //Agrego la celda a la fila
							}
							break; //Se mostró todo el listado de asistencias, esto no funciona si se agregan más atributos despues de las asistencias
						}
					}


					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);
			}
		});
	}


	function cambioComentario(inputComentario) {
		var valor = inputComentario.value;
		var part2Nombre = inputComentario.id.substring('comentario_'.length, inputComentario.length);
		$('#comentarioHidden_'+part2Nombre).val(valor);
	}

	function copiarDeHidenToClickover() {
		var input_popover = document.getElementById("comentario_"+this.options.indice1+"_"+this.options.indice2);
		var inputHidden = document.getElementById("comentarioHidden_"+this.options.indice1+"_"+this.options.indice2);
	
		if (input_popover != undefined) {
			$(input_popover).focus();
			$(input_popover).val($(inputHidden).val());

		}
	}


	function getListaSesiones() {
		var idElem = $('#seccion').val();
		var respuesta = $.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Sesiones/getSesionesBySeccionAjax") ?>",
			data: { seccion: idElem },
			success: function(respuesta) {

			}
		});
		var arrayRespuesta = jQuery.parseJSON(respuesta.responseText);
		lista_idSesiones = new Array();
		for (var i = 0; i < arrayRespuesta.length; i++) {
			lista_idSesiones[i] = arrayRespuesta[i].id;
		}
		return arrayRespuesta;
	}


	function cargarHeadTabla() {
		var tablaResultados = document.getElementById("tablaAsistencia");
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


		//Ahora recorro la lista de columnas para poner la asistencia, esto depende cuantas sesiones de clase existan
		var listaSesiones = getListaSesiones();
		for (var i = 0; i < listaSesiones.length; i++) {
			th = document.createElement('th');

			//Agrego el input que los checkea a todos
			nodoCheckeable = document.createElement('input');
			nodoCheckeable.setAttribute('data-previous', 'false,true,false');
			nodoCheckeable.setAttribute('type', 'checkbox');
			<?php 
				if ($ONLY_VIEW === TRUE) {
					?>
			nodoCheckeable.setAttribute("disabled", 'disabled');
					<?php
				}
			?>
			nodoCheckeable.setAttribute('id', 'selectorTodos_'+listaSesiones[i].id);
			nodoCheckeable.setAttribute('title', 'Seleccionar todos');
			nodoCheckeable.setAttribute('onchange', "checkAll(this);");
			th.appendChild(nodoCheckeable);

			//Agrego la fecha de la sesión
			nodoTexto = document.createTextNode(listaSesiones[i].fecha_planificada);
			th.appendChild(nodoTexto);
			tr.appendChild(th);
		}

		thead.appendChild(tr);
		
		tablaResultados.appendChild(thead);
	}

	function cargarAsistencia() {
		$('#icono_cargando').show();
		cargarHeadTabla();
		cargarDatosAsistencia();
		$('#icono_cargando').hide();
	}


<?php
	if ($ONLY_VIEW !== TRUE) {
?>

	function checkAll(checkboxAll) {
		var idSesion = checkboxAll.id;
		idSesion = idSesion.substring('selectorTodos_'.length, idSesion.length);//obtengo los 2 id separados por un _
		//idSesion = idSesion.substring(idSesion.search('_'), idSesion.length);

		var checkeado = false;
		if ($(checkboxAll).is(':checked')) {
			checkeado = true;
		}
		for (var i = 0; i < ruts_estudiantes.length; i++) {
			$('#asistencia_'+ruts_estudiantes[i]+'_'+idSesion).prop('checked', checkeado);
		}
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

<?php
	}
?>
</script>


<fieldset>
	<?php
		if ($ONLY_VIEW === TRUE) {
	?>
	<legend>Ver asistencia</legend>
	<?php
		} else {
	?>
	<legend>Agregar asistencia</legend>
	<?php
	}
		$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal');
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
					<label class="control-label" for="seccion">1.- <font color="red">*</font> Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="cargarAsistencia();">
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
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<table id="tablaAsistencia" class="table table-hover">
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group offset7">
				<?php if ($ONLY_VIEW !== TRUE) { ?>
				<div class="controls ">
					<button class="btn" type="button" onclick="guardarAsistencia()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Guardar
					</button>
					<button class="btn" type="button" onclick="resetearAsistencia()">
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>
				</div>
				<?php
					}
					if (isset($dialogos)) {
						echo $dialogos;
					}
				?>
			</div>
		</div>
		<?php
			if ($ONLY_VIEW !== TRUE) {
				echo form_close('');
		}
		?>
</fieldset>
