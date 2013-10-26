<script type="text/javascript">
	var prefijo_tipoDato = "estudiante_";
	var listaColumnas = ["Rut", "Nombres", "Apellido paterno", "Apellido materno"];
	var ruts_estudiantes = new Array();
	var lista_idEvaluaciones = new Array();

	function resettablaCalificaciones() {
		var tablaResultados = document.getElementById("tablaCalificaciones");
		$(tablaResultados).find('tbody').remove();
		var tr, td;
		var tbody = document.createElement('tbody');
		tr = document.createElement('tr');
		td = document.createElement('td');
		$(td).html("No hay Calificaciones para la sección seleccionada en esa sesión de clase o no tiene estudiantes");
		$(td).attr('colspan', listaColumnas.length);
		tr.appendChild(td);
		tbody.appendChild(tr);
		tablaResultados.appendChild(tbody);
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

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Estudiantes/getCalificacionesEstudiantesBySeccionAjax") ?>",
			data: { id_seccion: id_seccion, only_view: only_view},
			success: function(respuesta) {
				var tablaResultados = document.getElementById("tablaCalificaciones");
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

				var nodo, tr, td, divTd, estaPresente, comentario, nodoComentario, nodoIconComentario, icono;


				//CARGO EL CUERPO DE LA TABLA
				if (arrayRespuesta.length == 0) {
					resettablaCalificaciones();
					return;
				}

				var tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) { //Cada iteración es una fila o un estudiante
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:default");


					for (j = 0; j < arrayRespuesta[i].length; j++) { //cada iteración es una columna (datos del estudiante o dias de Calificaciones)
						

						//Entonces se están cargando las columnas relacionadas con los datos del estudiante
						if (j < listaColumnas.length) {
							td = document.createElement('td'); //Creo la celda
							nodo = document.createTextNode(arrayRespuesta[i][j]);
							td.appendChild(nodo);
							tr.appendChild(td); //Agrego la celda a la fila
						}
						else { //Entonces se están cargando las columnas relacionadas con la Calificaciones
							//arrayRespuesta[i][j] = jQuery.parseJSON(arrayRespuesta[i][j]);
							for (var k = 0; (k < arrayObjectRespuesta[i].notas.length) && (k < lista_idEvaluaciones.length) ; k++) {
								td = document.createElement('td'); //Creo la celda
								divTd = document.createElement('div');
								divTd.setAttribute('class', 'row-fluid');

								nodo = document.createElement('input');
								nodo.setAttribute("type", 'text');
								nodo.setAttribute("pattern", "[1-6]([\.|,][0-9])|[1-7]([\.|,][0])|[1-7]?");
								nodo.setAttribute("class", 'input-mini');

								comentario = arrayObjectRespuesta[i].comentarios[k].comentario == null ? '' : arrayObjectRespuesta[i].comentarios[k].comentario; //paso a booleano
								nodoComentario = document.createElement('input');
								nodoComentario.setAttribute("type", 'hidden');
								nodoComentario.setAttribute("id", 'comentarioHidden_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]);
								nodoComentario.setAttribute("name", 'comentario['+arrayObjectRespuesta[i].rut+']['+lista_idEvaluaciones[k]+']');
								nodoComentario.setAttribute("value", comentario);
								nodoComentario.setAttribute("class", 'span1');
								divTd.appendChild(nodoComentario);


								nodoIconComentario = document.createElement('div');
								icono = document.createElement('i');
								icono.setAttribute('class', 'icon-comment');
								nodoIconComentario.appendChild(icono);
								
								nodoAsterisco = document.createElement('font');
								nodoAsterisco.setAttribute('color', 'red');
								if ($.trim(comentario) != '') {
									nodoComentario = document.createTextNode('*');
								}
								else {
									nodoComentario = document.createTextNode("\u00a0");
								}
								nodoAsterisco.appendChild(nodoComentario);
								nodoIconComentario.appendChild(nodoAsterisco);
							
								nodoIconComentario.setAttribute("class", 'btn btn-mini');
								nodoIconComentario.setAttribute("value", '*');
								
										
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								nodo.setAttribute("disabled", 'disabled');
										<?php
									}
								?>
								nodo.setAttribute("name", 'Calificaciones['+arrayObjectRespuesta[i].rut+']['+lista_idEvaluaciones[k]+']');
								nota = arrayObjectRespuesta[i].notas[k].nota == undefined ? "" : arrayObjectRespuesta[i].notas[k].nota;
								//nota = arrayObjectRespuesta[i].Calificaciones[k].nota == 1 ? true : false; //paso a booleano
								$(nodo).prop('value', nota);
								nodo.setAttribute("id", 'Calificaciones_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]);



								//Agrego el popover para poner comentarios
								var divBtnCerrar = '';// '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
								var divs = '<div ><input class="popovers" onChange="cambioComentario(this)" value="'+comentario+
								'" id="comentario_'+arrayObjectRespuesta[i].rut+'_'+lista_idEvaluaciones[k]+
								<?php 
									if ($ONLY_VIEW === TRUE) {
										?>
								'" disabled="disabled'+
										<?php
									}
								?>
								'" type="text" ></div>';
								$(nodoIconComentario).clickover({html:true, content: divs, onShown: copiarDeHidenToClickover, placement:'top', title:"Comentarios", indice1: arrayObjectRespuesta[i].rut, indice2: lista_idEvaluaciones[k]});
								
								divTd.appendChild(nodo);
								divTd.appendChild(nodoIconComentario);
								td.appendChild(divTd);
								tr.appendChild(td); //Agrego la celda a la fila
							}
							break; //Se mostró todo el listado de Calificacioness, esto no funciona si se agregan más atributos despues de las Calificacioness
						}
					}


					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);
			}
		});
	}


	function cambioComentario(inputComentario) {
		var valor = $.trim(inputComentario.value);
		var fontAsterisco = $(inputComentario).parent().parent().parent().siblings().find('font');
		if (valor != '') { //Pongo el asterisco rojo indicando que hay un comentario
			fontAsterisco.html('*');
		}
		else {
			fontAsterisco.html('\u00a0');
		}
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


		//Ahora recorro la lista de columnas para poner la Calificaciones, esto depende cuantas sesiones de clase existan
		var listaCalificaciones = getlistaCalificaciones();
		for (var i = 0; i < listaCalificaciones.length; i++) {
			th = document.createElement('th');

			//Agrego la fecha de la sesión
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
			<div class="span5">
				<font color="red">* Campos Obligatorios</font>
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
			<div class="span5">
				<div class="control-group">
					<label class="control-label" for="seccion">1.- <font color="red">*</font> Sección:</label>
					<div class="controls">
						<select id="seccion" name="seccion" class="span12" required onchange="cargarCalificaciones();">
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
				<?php 
				if ($IS_PROFESOR_LIDER == TRUE) {
					?>
					<div class="control-group">
						<label class="control-label" for="seccion">2.- <font color="red">*</font> Ver sólo mis secciones:</label>
						<div class="controls">
							<input type="checkbox" checked id="checkVerSoloMisSecciones"/>
						</div>
					</div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12" >
				<div style="border:#cccccc 1px solid; overflow-x:scroll; width:72em; -webkit-border-radius: 4px;">
				<table id="tablaCalificaciones" class="table table-hover">
					<thead>

					</thead>
					<tbody>

					</tbody>
				</table>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group offset7">
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
