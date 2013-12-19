<script src="/<?php echo config_item('dir_alias') ?>/javascripts/descargaByJquery.js"></script>
<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["N°", "Rut", "Nombres"];
	var ruts_estudiantes = new Array();
	var lista_idEvaluaciones = new Array();
	var LARGO_MAXIMO_NOMBRE = 19;

	function resetTablaCalificaciones() {
		var tablaResultados = document.getElementById("tablaCalificaciones");
		$(tablaResultados).find('tbody').remove();
		var tr, td, nodoAsterisco;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("No hay Calificaciones para la sección seleccionada en esa sesión de clase o no tiene estudiantes");
		$(td).attr('colspan', listaColumnas.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
	}

	function buscarCalificacion(arrayCalificaciones, id_evaluacion_buscada) {
		for (var i = 0; i < arrayCalificaciones.length; i++) {
			if (arrayCalificaciones[i].id_evaluacion == id_evaluacion_buscada) {
				return i;
			}
		};
		return -1;
	}

	//Carga una matriz con los datos del estudiante y sus Calificacioness
	function cargarDatosCalificaciones() {
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
		
		var tablaResultados = document.getElementById("tablaCalificaciones");
		var tablaNombres = document.getElementById("tablaCalificacionesNombres");
		$(tablaResultados).find('tbody').remove();
		$(tablaNombres).find('tbody').remove();
		
		
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getCalificacionesEstudiantesBySeccionAjax") ?>",
			data: { id_seccion: id_seccion, only_view: only_view},
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaCalificaciones");
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

				var nodo, tr, td, divTd, estaPresente, comentario, nodoComentario, nodoIconComentario, icono, tbodyNombres, trNombres, stringTemp;


				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resetTablaCalificaciones();
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
					for (j = 0; j < cantidadAtributos; j++) { //cada iteración es una columna (datos del estudiante o dias de Calificaciones)
						
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
						else { //Entonces se están cargando las columnas relacionadas con la Calificaciones
							//arrayRespuesta[i][j] = jQuery.parseJSON(arrayRespuesta[i][j]);
							for (var k = 0; k < lista_idEvaluaciones.length ; k++) {
								//ACÁ ESTÁ EL
								//Busco si viene esa asistencia en la respuesta del servidor
								var indiceEncontrado = buscarCalificacion(arrayObjectRespuesta[i].notas, lista_idEvaluaciones[k]);
								if (indiceEncontrado >= 0) {
									comentario = arrayObjectRespuesta[i].comentarios[indiceEncontrado].comentario == null ? '' : arrayObjectRespuesta[i].comentarios[indiceEncontrado].comentario; //paso a booleano
									nota = arrayObjectRespuesta[i].notas[indiceEncontrado].nota == undefined ? "" : arrayObjectRespuesta[i].notas[indiceEncontrado].nota;
								}
								else { //Si se encontró -1
									comentario = '';
									nota = '';
								}


								td = document.createElement('td'); //Creo la celda
								divTd = document.createElement('div');
								divTd.setAttribute('class', 'row-fluid');

								nodo = document.createElement('input');
								nodo.setAttribute("type", 'text');
								nodo.setAttribute("autocomplete", "off");
								nodo.setAttribute("class", 'popover-input');
								nodo.setAttribute("style", 'width:25px;');

								if (lista_idEvaluaciones[k] != -1) {
									nodo.setAttribute("pattern", "[1-6]([\.][0-9])|[1-7]([\.][0])|[1-7]?");

									nodoComentario = document.createElement('input');
									nodoComentario.setAttribute("type", 'hidden');
									nodoComentario.setAttribute("id", 'comentarioHidden_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]);
								
									nodoComentario.setAttribute("name", 'comentario['+arrayObjectRespuesta[i].rut+']['+lista_idEvaluaciones[k]+']');
								
									nodoComentario.setAttribute("value", comentario);
									nodoComentario.setAttribute("class", 'span1');
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
								}
										
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
									nodo.setAttribute("readOnly", 'readOnly');
										<?php
									}
									else { ?>
										if (lista_idEvaluaciones[k] == -1) {
									nodo.setAttribute("readOnly", 'readOnly');
										}
										else {
											//nodo.setAttribute("placeholder", "4.0");//Confunde
									divTd.setAttribute("title", "Ingrese la nota utilizando un . (punto) para separar los decimales");
										}
								<?php
									}
								?>
								if (lista_idEvaluaciones[k] != -1) { //La nota promedio no es editable y no se guarda en DB
									nodo.setAttribute("name", 'Calificaciones['+arrayObjectRespuesta[i].rut+']['+lista_idEvaluaciones[k]+']');
								}
								
								//nota = arrayObjectRespuesta[i].Calificaciones[k].nota == 1 ? true : false; //paso a booleano
								$(nodo).prop('value', nota);
								nodo.setAttribute("id", 'Calificaciones_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]);

								//Agrego el popover para poner comentarios
								var divBtnCerrar = '';// '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
								var divs;
								if (lista_idEvaluaciones[k] != -1) { //La nota promedio no lleva comentarios
									divs = '<div ><input class="popovers" onChange="cambioComentario(this)" title="Ingrese comentario" value="'+comentario+
									'" id="comentario_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]+
									<?php 
										if ($ONLY_VIEW === TRUE) {
											?>
									'" readonly="readonly'+
											<?php
										}
									?>
									'" type="text" ></div>';

									nodo.setAttribute("indice1", arrayObjectRespuesta[i].rut);
									nodo.setAttribute("indice2", lista_idEvaluaciones[k]);
									$(nodo).dblclick(function(evento){ //mostrar popover
										//evento.stopPropagation();
										//$('.popover-input').not('#'+evento.currentTarget.id).popover('hide');
										$(evento.currentTarget).popover('show');
										copiarDeHidenToClickover(evento.currentTarget.getAttribute("indice1"), evento.currentTarget.getAttribute("indice2"));
									});
									$(nodo).popover({html:true, trigger:'manual', content: divs, onShown: copiarDeHidenToClickoverMasquerade, placement:'top', title:"Comentarios", indice1: arrayObjectRespuesta[i].rut, indice2: lista_idEvaluaciones[k]});
										
									//divTd.appendChild(nodoIconComentario);
								}

								divTd.appendChild(nodo);
								divTd.appendChild(nodoAsterisco);
								td.appendChild(divTd);
								tr.appendChild(td); //Agrego la celda a la fila
							}
							break; //Se mostró todo el listado de Calificacioness, esto no funciona si se agregan más atributos despues de las Calificacioness
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


	function getlistaCalificaciones() {
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
			url: "<?php echo site_url("Estudiantes/getEvaluacionesBySeccionAndProfesorAjax") ?>",
			data: { seccion: idElem, only_view: only_view},
			success: function(respuesta) {

			}
		});
		var arrayRespuesta = jQuery.parseJSON(respuesta.responseText);
		lista_idEvaluaciones = new Array();
		for (var i = 0; i < arrayRespuesta.length; i++) {
			lista_idEvaluaciones[i] = arrayRespuesta[i].id;
		}
		return arrayRespuesta;
	}


	function cargarHeadTabla() {
		var tablaResultados = document.getElementById("tablaCalificaciones");
		var tablaNombres = document.getElementById("tablaCalificacionesNombres");
		$(tablaResultados).find('thead').remove();
		$(tablaNombres).find('thead').remove();
		
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
		//Ahora recorro la lista de columnas para poner la Calificaciones, esto depende cuantas sesiones de clase existan
		var listaCalificaciones = getlistaCalificaciones();
		for (var i = 0; i < listaCalificaciones.length; i++) {
			th = document.createElement('th');
			th.setAttribute('style', "min-width:80px");

			//Agrego el nombre de la evaluación
			nodoTexto = document.createTextNode(listaCalificaciones[i].nombre);
			th.appendChild(nodoTexto);
			tr.appendChild(th);
		}

		thead.appendChild(tr);
		
		tablaResultados.appendChild(thead);
	}

	function cargarCalificaciones() {
		$('#icono_cargando').show();
		cargarHeadTabla();
		cargarDatosCalificaciones();
		
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
		url =  "<?php echo site_url("Estudiantes/generateCSVCalificacionesBySeccionAjax") ?>";
		parametros = 'id_seccion='+id_seccion+'&only_view='+only_view;
		$.download(url, parametros);
		$('#icono_cargando').hide();
	}

<?php
	if ($ONLY_VIEW !== TRUE) {
?>

	function guardarCalificaciones() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar calificaciones');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar el registro de calificaciones en el sistema?');
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
	<legend>Ver calificaciones</legend>
	<?php
		} else {
	?>
	<legend>Agregar calificaciones</legend>
	<?php
	}
		$atributos= array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Estudiantes/postAgregarCalificaciones/', $atributos);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">*</font> indica que se han ingresado comentarios
			</div>
		</div>
		<div class="row-fluid">
			<?php 
				if ($ONLY_VIEW === FALSE) {
					?>
				<p><font color="red">Atención: </font>Sólo puede ver las notas que le corresponde poner a la sección</p>
					<?php
				}
			?>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="seccion">1.- Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="cargarCalificaciones();">
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
				<?php 
				if ($IS_PROFESOR_LIDER == TRUE) {
					?>
					<div class="control-group">
						<label class="control-label" for="seccion">2.- <font color="red">*</font> Ver sólo mis secciones:</label>
						<div class="controls">
							<input type="checkbox" checked id="checkVerSoloMisSecciones" onchange="verSoloMisSeccionesClicked()"/>
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<div class="span5 offset1">
				<div class="control-group">
					<?php if ($ONLY_VIEW !== TRUE) { ?>
					<div class="controls ">
						<button class="btn" type="button" onclick="guardarCalificaciones()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearCalificaciones()">
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						}
						else { ?>
					<div class="controls ">
						<button class="btn" type="button" id="btn_descargar" onclick="descargarToArchivo()" disabled title="Debe seleccionar una sección para descargar su registro de calificaciones">
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
		<div class="row-fluid">
			
			<div class="span5" style="margin-left:0px; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaCalificacionesNombres" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			
			<div class="span7" style="margin-left:0px; overflow-x:scroll; max-width:100%; -webkit-border-radius: 4px; border:#cccccc 1px solid;">
				<table id="tablaCalificaciones" class="table table-striped" >
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group span5 offset7" style="margin-top:10px;">
				<?php if ($ONLY_VIEW !== TRUE) { ?>
				<div class="controls ">
					<button class="btn" type="button" onclick="guardarCalificaciones()">
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp; Guardar
					</button>
					<button class="btn" type="button" onclick="resetearCalificaciones()">
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
