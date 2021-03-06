<script src="/<?php echo config_item('dir_alias') ?>/javascripts/descargaByJquery.js"></script>
<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["N°", "Rut", "Nombres"];
	var ruts_estudiantes = new Array();
	var lista_idActividades = new Array();
	var LARGO_MAXIMO_NOMBRE = 19;

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

	function buscarAsistencia(arrayAsistencia, id_actividad_buscada) {
		for (var i = 0; i < arrayAsistencia.length; i++) {
			if (arrayAsistencia[i].id == id_actividad_buscada) {
				return i;
			}
		};
		return -1;
	}


	function agregarPorcentajeAsistenciaToTable(rutEstudiante, porcentaje) {
		var tbody, td, tr, nodoTexto, tablaAsistenciaPorcentaje, tdExiste;
		tdExiste = false;

		if (!tdExiste) {
			tablaAsistenciaPorcentaje = document.getElementById("tablaAsistenciaPorcentaje");

			tbody = $("#tablaAsistenciaPorcentaje tbody");
			tbody.append('<tr style="cursor:default; height:47px;"><td>'+porcentaje+'%</td></tr>');
		}
	}


	//Carga una matriz con los datos del estudiante y sus asistencias
	function cargarDatosAsistencia() {
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}

		var only_view = 0;
		<?php 
			if ($ONLY_VIEW === TRUE) {
				?>
			only_view = 1;
				<?php
			}
		?>

		var tablaResultados = document.getElementById("tablaAsistencia");
		var tablaNombres = document.getElementById("tablaAsistenciaNombres");
		var tablaAsistenciaPorcentaje = document.getElementById("tablaAsistenciaPorcentaje");
		$(tablaResultados).find('tbody').remove();
		$(tablaNombres).find('tbody').remove();
		$(tablaAsistenciaPorcentaje).find('tbody').remove();
		var tbodyPorcentaje = document.createElement('tbody');
		tablaAsistenciaPorcentaje.appendChild(tbodyPorcentaje);


		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getAsistenciaActividadesEstudiantesBySeccionAjax") ?>",
			data: { id_seccion: id_seccion, only_view: only_view},
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaAsistencia");
				var tablaNombres = document.getElementById("tablaAsistenciaNombres");

				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
				var arrayRespuesta = new Array();
				ruts_estudiantes = new Array();
				for (var i = 0; i < arrayObjectRespuesta.length; i++) {
					ruts_estudiantes[i] = arrayObjectRespuesta[i].rut; //Guardo los ruts de los estudiantes
					arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) { //Transformo de array asociativo a basado en indices
						return (value == null ? "": value);
					});
				}

				var nodo, tr, td, divTd, estaPresente, comentario, nodoComentario, nodoIconComentario, icono, blanco, tbodyNombres, trNombres, stringTemp;


				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaAsistencia();
					return;
				}

				var tbody = document.createElement('tbody');
				var tbodyNombres = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) { //Cada iteración es una fila o un estudiante
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:default");
					trNombres = document.createElement('tr');
					trNombres.setAttribute('style', "cursor:default; height:47px;");
					

					var cantidadAtributos = Object.keys(arrayObjectRespuesta[i]).length;
					for (j = 0; j < cantidadAtributos; j++) { //cada iteración es una columna (datos del estudiante o dias de asistencia)
						
						//Entonces se están cargando las columnas relacionadas con los datos del estudiante
						if (j < listaColumnas.length) {
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
						else { //Entonces se están cargando las columnas relacionadas con la asistencia
							//arrayRespuesta[i][j] = jQuery.parseJSON(arrayRespuesta[i][j]);

							contadorAsistencia = 0;
							for (var k = 0; k < lista_idActividades.length ; k++) {

								//Busco si viene esa asistencia en la respuesta del servidor
								var indiceEncontrado = buscarAsistencia(arrayObjectRespuesta[i].asistencia, lista_idActividades[k]);
								if (indiceEncontrado >= 0) {
									comentario = arrayObjectRespuesta[i].comentarios[indiceEncontrado].comentario == null ? '' : arrayObjectRespuesta[i].comentarios[indiceEncontrado].comentario; //paso a booleano
									estaPresente = arrayObjectRespuesta[i].asistencia[indiceEncontrado].presente == undefined ? false : arrayObjectRespuesta[i].asistencia[indiceEncontrado].presente;
									estaPresente = arrayObjectRespuesta[i].asistencia[indiceEncontrado].presente == 1 ? true : false; //paso a booleano
									blanco = false;
								}
								else { //Si se encontró -1
									comentario = '';
									estaPresente = false;
									blanco = true;
								}

								
								td = document.createElement('td'); //Creo la celda
								divTd = document.createElement('div');
								divTd.setAttribute('class', 'row-fluid');

								nodo = document.createElement('input');
								nodo.setAttribute("type", 'text');
								nodo.setAttribute("autocomplete", "off");
								nodo.setAttribute("class", 'popover-input');
								nodo.setAttribute("style", 'width:20px;');

								nodo.setAttribute("pattern", "[0-1]?");

								
								nodoComentario = document.createElement('input');
								nodoComentario.setAttribute("type", 'hidden');
								nodoComentario.setAttribute("id", 'comentarioHidden_'+arrayObjectRespuesta[i].rut+'_'+lista_idActividades[k]);
								nodoComentario.setAttribute("name", 'comentario['+arrayObjectRespuesta[i].rut+']['+lista_idActividades[k]+']');
								nodoComentario.setAttribute("value", comentario);
								//nodoComentario.setAttribute("class", 'span2');
								divTd.appendChild(nodoComentario);
								
								nodoAsterisco = document.createElement('font');
								nodoAsterisco.setAttribute('color', 'red');
								if ($.trim(comentario) != '') {
									nodoComentario = document.createTextNode('\u00a0*');
								}
								else {
									nodoComentario = document.createTextNode("\u00a0");
								}
								nodoAsterisco.appendChild(nodoComentario);
								
										
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								nodo.setAttribute("readOnly", 'readOnly');
										<?php
									}
								?>
								nodo.setAttribute("name", 'asistencia['+arrayObjectRespuesta[i].rut+']['+lista_idActividades[k]+']');
								
								//$(nodo).prop('checked', estaPresente);
								if (!blanco) {
									if (estaPresente) {
										nodo.setAttribute("value", "1");
										contadorAsistencia++;
									}
									else {
										nodo.setAttribute("value", "0");
									}
								}
								nodo.setAttribute("id", 'asistencia_'+arrayObjectRespuesta[i].rut+'_'+lista_idActividades[k]);



								//Agrego el popover para poner comentarios
								var divBtnCerrar = '';// '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
								var divs;
								divs = '<div ><input class="popovers" onChange="cambioComentario(this)" value="'+comentario+
								'" id="comentario_'+arrayObjectRespuesta[i].rut+'_'+lista_idActividades[k]+
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								'" readOnly="readOnly'+
										<?php
									}
								?>
								'" type="text" ></div>';

								//Son como las "llaves" para identificar un input de asistencia
								nodo.setAttribute("indice1", arrayObjectRespuesta[i].rut);
								nodo.setAttribute("indice2", lista_idActividades[k]);
								$(nodo).dblclick(function(evento){ //mostrar popover
									//evento.stopPropagation();
									//$('.popover-input').not('#'+evento.currentTarget.id).popover('hide');
									$(evento.currentTarget).popover('show');
									copiarDeHidenToClickover(evento.currentTarget.getAttribute("indice1"), evento.currentTarget.getAttribute("indice2"));
								});
								$(nodo).popover({html:true, trigger:'manual', content: divs, onShown: copiarDeHidenToClickoverMasquerade, placement:'top', title:"Comentarios", indice1: arrayObjectRespuesta[i].rut, indice2: lista_idActividades[k]});
								
								divTd.appendChild(nodo);
								divTd.appendChild(nodoAsterisco);
								td.appendChild(divTd);
								tr.appendChild(td); //Agrego la celda a la fila
							}
							var total = lista_idActividades.length;
							var porcentajeAsistencia = (contadorAsistencia*100)/lista_idActividades.length;
							if (isNaN(porcentajeAsistencia)) {
								porcentajeAsistencia = 0;
							}
							porcentajeAsistencia = Math.round(porcentajeAsistencia);
							agregarPorcentajeAsistenciaToTable(arrayObjectRespuesta[i].rut, porcentajeAsistencia);

							break; //Se mostró todo el listado de asistencias, esto no funciona si se agregan más atributos despues de las asistencias
						}
					}


					tbody.appendChild(tr);
					tbodyNombres.appendChild(trNombres);
				}
				tablaNombres.appendChild(tbodyNombres);
				tablaResultados.appendChild(tbody);
			}
		});
	}


	function cambioComentario(inputComentario) {
		var valor = $.trim(inputComentario.value);
		var fontAsterisco = $(inputComentario).parent().parent().parent().parent().parent().children().find('font');
		if (valor != '') { //Pongo el asterisco rojo indicando que hay un comentario
			fontAsterisco.html('\u00a0*');
		}
		else {
			fontAsterisco.html('\u00a0');
		}
		var part2Nombre = inputComentario.id.substring('comentario_'.length, inputComentario.id.length);
		$('#comentarioHidden_'+part2Nombre).val(valor);
	}

	function copiarDeHidenToClickover(indice1, indice2) {
		var input_popover = document.getElementById("comentario_"+indice1+"_"+indice2);
		var inputHidden = document.getElementById("comentarioHidden_"+indice1+"_"+indice2);
	
		if (input_popover != undefined) {
			$(input_popover).focus();
			$(input_popover).val($(inputHidden).val());

			$('.popover').focusout(function(evento) {
				var esPopOverInput = $(evento.currentTarget).hasClass("popover-input");
				if (!esPopOverInput) {
					$('.popover-input').popover('hide');
				}
				else {
					console.log("No se oculta");
				}
			});
		}
	}

	function copiarDeHidenToClickoverMasquerade() {
		copiarDeHidenToClickover(this.options.indice1, this.options.indice2);
	}


	function getListaActividades() {
		var idElem = $('#seccion').val();

		var only_view = 0;
		<?php 
			if ($ONLY_VIEW === TRUE) {
				?>
			only_view = 1;
				<?php
			}
		?>

		var respuesta = $.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getActividadesBySeccionAndProfesorAjax") ?>",
			data: { seccion: idElem, only_view: only_view },
			success: function(respuesta) {

			}
		});
		var arrayRespuesta = jQuery.parseJSON(respuesta.responseText);
		lista_idActividades = new Array();
		for (var i = 0; i < arrayRespuesta.length; i++) {
			lista_idActividades[i] = arrayRespuesta[i].id;
		}
		return arrayRespuesta;
	}


	function cargarHeadTabla() {
		var tablaResultados = document.getElementById("tablaAsistencia");
		var tablaNombres = document.getElementById("tablaAsistenciaNombres");
		var tablaAsistenciaPorcentaje = document.getElementById("tablaAsistenciaPorcentaje");

		$(tablaResultados).find('thead').remove();
		$(tablaNombres).find('thead').remove();
		$(tablaAsistenciaPorcentaje).find('thead').remove();
		
		var nodoCheckeable, nodoTexto, th, thead, tr;
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:56px;");

		//Recorro la lista de columnas de la primera tabla para crearlas
		for (var i = 0; i < listaColumnas.length; i++) {
			th = document.createElement('th');
			if (i == 0)
				th.setAttribute('style', "min-width:30px");
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
		tr.setAttribute('style', "height:56px;");
		//Ahora recorro la lista de columnas para poner la asistencia, esto depende cuantas sesiones de clase existan
		var listaActividades = getListaActividades();
		for (var i = 0; i < listaActividades.length; i++) {
			th = document.createElement('th');
			th.setAttribute('style', "min-width:65px");

			//Agrego la fecha de la sesión
			nodoTexto = document.createTextNode(listaActividades[i].nombre);
			th.appendChild(nodoTexto);
			tr.appendChild(th);
		}
		thead.appendChild(tr);
		tablaResultados.appendChild(thead);


		//Cargo la tabla para el porcentaje de asistencia total
		thead = document.createElement('thead');
		thead.setAttribute('style', "cursor:default;");
		tr = document.createElement('tr');
		tr.setAttribute('style', "height:56px;");
		th = document.createElement('th');
		th.setAttribute('style', "min-width:30px");
		nodoTexto = document.createTextNode("Total");
		th.appendChild(nodoTexto);
		tr.appendChild(th);
		thead.appendChild(tr);
		tablaAsistenciaPorcentaje.appendChild(thead);
	}

	//Confierte la fecha de formato yyyy-mm-dd a: dd-mes
	function tranformFecha(fechaStr) {
		var indexGuion = fechaStr.indexOf('-');
		var agnoInt = fechaStr.substring(0, indexGuion);
		agnoInt = parseInt(agnoInt);
		fechaStr = fechaStr.substring(indexGuion+1);
		indexGuion = fechaStr.indexOf('-');
		var mesInt = fechaStr.substring(0, indexGuion);
		mesInt = parseInt(mesInt);
		fechaStr = fechaStr.substring(indexGuion+1);
		var diaInt = parseInt(fechaStr);
		var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
    	var mes;
    	if ((mesInt >= 0) && mesInt <= monthNames.length)
    		mes = (monthNames[mesInt-1]).substring(0, 3);
		return diaInt+"-"+mes;
	}

	function cargarAsistencia() {
		$('#icono_cargando').show();
		cargarHeadTabla();
		cargarDatosAsistencia();

		//Quito el foco al select de la sección
		$('#seccion').blur();

		//Habilito el botón de descarga
		$('#btn_descargar').prop('disabled', false).button('refresh');

		$('#icono_cargando').hide();
	}

	function descargarToArchivo() {
		$('#icono_cargando').show();
		var id_seccion = $('#seccion').val();
		if (id_seccion == "") {
			return;
		}

		var only_view = 0;
		<?php 
			if ($ONLY_VIEW === TRUE) {
				?>
			only_view = 1;
				<?php
			}
		?>
		url =  "<?php echo site_url("Estudiantes/generateCSVAsistenciaActividadesBySeccionAjax") ?>";
		parametros = 'id_seccion='+id_seccion+'&only_view='+only_view;
		$.download(url, parametros);
		$('#icono_cargando').hide();
	}


<?php
	if ($ONLY_VIEW !== TRUE) {
?>

//NO FUNCIONA POR AHORA ESTA
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

<?php 
if ($IS_PROFESOR_LIDER == TRUE) {
	?>
	function verSoloMisSeccionesClicked() {
		var soloMisSecciones = $('#checkVerSoloMisSecciones').is(':checked');
		var verTodas = 1;
		if (soloMisSecciones) {
			verTodas = 0;
		}
		var only_view = 0;
		<?php 
			if ($ONLY_VIEW === TRUE) {
				?>
		only_view = 1;
				<?php
			}
		?>
		$('#icono_cargando').show();

		var respuesta = $.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getSeccionesByProfesorAjax") ?>",
			data: { verTodas: verTodas },
			success: function(respuesta) {
				var elementoSelect = document.getElementById('seccion');
				$(elementoSelect).empty();
				$(elementoSelect).append(new Option( "Sección", "", true, true));
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					$(elementoSelect).append(new Option( arrayRespuesta[i].nombre, arrayRespuesta[i].id, false, false));
				}
				$('#icono_cargando').hide();
			}
		});
	}
	<?php
}
?>
</script>


<fieldset>
	<?php
		if ($ONLY_VIEW === TRUE) {
	?>
	<legend>Ver asistencia de actividades masivas</legend>
	<?php
		} else {
	?>
	<legend>Agregar asistencia de actividades masivas</legend>
	<?php
	}
		$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal', 'style' => 'max-width:1000px;');
		echo form_open('Estudiantes/postAgregarAsistenciaActividades/', $atributos);
	?>
		<div class="row-fluid">
			<div class="span5">
				<font color="red">*</font> indica que se han ingresado comentarios
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="seccion">1.- Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="cargarAsistencia();">
							<option value="" disabled selected>Sección</option>
							<?php
							if (isset($secciones)) {
								foreach ($secciones as $valor) {
									$ocultar = "";
									if (!$valor->propia_del_profesor) {
										$ocultar = "disabled";
									}
									?>
										<option value="<?php echo $valor->id?>" <?php echo $ocultar; ?> ><?php echo $valor->nombre; ?></option>
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
						else { ?>
					<div class="controls ">
						<button class="btn" type="button" id="btn_descargar" onclick="descargarToArchivo()" disabled title="Debe seleccionar una sección para descargar su registro de asistencias de actividades">
							<i class="icon-download-alt"></i>
							&nbsp; Descargar a archivo
						</button>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		<div class="row-fluid" >
			<div class="span5" style="margin-left:0px; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaAsistenciaNombres" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span6" style="margin-left:0px; overflow-x:scroll; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaAsistencia" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			<div class="span1" style="margin-left:0px; overflow-x:scroll; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaAsistenciaPorcentaje" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group span6 offset6" style="margin-top:10px;">
				<?php if ($ONLY_VIEW !== TRUE) { ?>
				<div class="controls">
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
