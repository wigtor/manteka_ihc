

<script type="text/javascript">

	function editarEstudiante(){

		var rut = document.getElementById("rutEditar").value;
		var nombreUno =	document.getElementById("nombreunoEditar").value;
		var nombreDos =	document.getElementById("nombredosEditar").value;
		var apellidoPaterno = document.getElementById("apellidopaternoEditar").value;
		var apellidoMaterno = document.getElementById("apellidomaternoEditar").value;
		var correo = document.getElementById("correoEditar").value;
		var seccion = document.forms['FormEditar'].elements['seccion_seleccionada'].value;
	
		if(rut=="" && nombreUno==""  && apellidoPaterno=="" && apellidoMaterno=="" && correo==""){
					
					$('#modalSeleccioneAlgo').modal();
					
		}
		else if ((rut=="") || (nombreUno=="")  || (apellidoPaterno=="") || (apellidoMaterno=="") || (correo=="")){
				
				
				$('#modalFaltanCampos').modal();
		}
		else{
			$('#modalConfirmacion').modal();
		}
	}
</script>

<script type="text/javascript">
function ordenarFiltro2() {//No funcional
	var filtroLista = document.getElementById("filtroSeccion").value;
	var arreglo = new Array();
	var ocultarInput;
	var ocultarTd;
	var cont;
	
	<?php
	/*
	$contadorE = 0;
	while($contadorE<count($secciones)){
		echo 'arreglo['.$contadorE.'] = "'.$secciones[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	*/
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarInput=document.getElementById(arreglo[cont]);
		ocultarTd=document.getElementById("seccionTd_"+cont);
		if(0 > arreglo[cont].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultarInput.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultarInput.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>

<script type="text/javascript">
function ordenarFiltro(){ //No funcional
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var alumno;
	var ocultar;
	var cont;
	
	<?php
	/*
	$contadorE = 0;
	while($contadorE<count($rs_estudiantes)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_estudiantes[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_estudiantes[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_estudiantes[$contadorE][4].'";';
		echo 'arreglo['.$contadorE.'][7] = "'.$rs_estudiantes[$contadorE][7].'";';
		echo 'arreglo['.$contadorE.'][6] = "'.$rs_estudiantes[$contadorE][6].'";';
		$contadorE = $contadorE + 1;
	}
	*/
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		//alumno = document.getElementById(cont);
		ocultar =document.getElementById(cont);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
		}
		else
		{
			ocultar.style.display='';
		}
    }
}
</script>

<script type="text/javascript">
	function resetSeleccionado() {
		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var seccionDetalle = document.forms['FormEditar'].elements['seccion_seleccionada']
		var correoDetalle = document.getElementById("correoEditar");
		$(rutDetalle).val("");
		$(nombre1Detalle).val("");
		$(nombre2Detalle).val("");
		$(apellido1Detalle).val("");
		$(apellido2Detalle).val("");
		$(correoDetalle).val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}
</script>



<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido", "Carrera", "Seccion"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+", "[A-Za-z]+", "([A-Za-z]+-{1}[0-9]+|[0-9]+|[A-Za-z]+)"];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Alumnos/postBusquedaAlumnos") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/alumnos") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("ayudante_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/postDetallesAlumnos") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutEditar");
				var nombre1Detalle = document.getElementById("nombreunoEditar");
				var nombre2Detalle = document.getElementById("nombredosEditar");
				var apellido1Detalle = document.getElementById("apellidopaternoEditar");
				var apellido2Detalle = document.getElementById("apellidomaternoEditar");
				//var carreraDetalle = document.getElementById("carreraDetalle");
				var seccionDetalle = document.forms['FormEditar'].elements['seccion_seleccionada']
				var correoDetalle = document.getElementById("correoEditar");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				if (datos.nombre2 == null) {
					datos.nombre2 = '';
				}
				if (datos.nombre_seccion == null) {
					datos.nombre_seccion = '';
				}
				$(rutDetalle).val($.trim(datos.rut));
				$(nombre1Detalle).val($.trim(datos.nombre1));
				$(nombre2Detalle).val($.trim(datos.nombre2));
				$(apellido1Detalle).val($.trim(datos.apellido1));
				$(apellido2Detalle).val($.trim(datos.apellido2));
				//$(carreraDetalle).val(datos.carrera);
				setCheckedValue(seccionDetalle, datos.seccion);
				//$(seccionDetalle).val(datos.seccion);
				$(correoDetalle).val($.trim(datos.correo));

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}


	function cargarSecciones() {
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/postGetSecciones") ?>", /* Se setea la url del controlador que responderá */
			data: { }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoSecciones");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, td2, th, radioInput, nodoTexto;
				var name = "seccion_seleccionada";
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre);
					td.appendChild(nodoTexto);
					

					td2 = document.createElement('td');
					radioInput = document.createElement('input');
					radioInput.setAttribute('type', 'radio');
					radioInput.setAttribute('name', name);
					radioInput.setAttribute("id", "seccion_"+arrayRespuesta[i].cod);
					radioInput.setAttribute("value", arrayRespuesta[i].cod);
					td2.appendChild(radioInput);

					tr.appendChild(td2);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}
			}
		});
	}

	function setCheckedValue(radioObj, newValue) {
		if(!radioObj)
			return;
		var radioLength = radioObj.length;
		if(radioLength == undefined) {
			radioObj.checked = (radioObj.value == newValue.toString());
			return;
		}
		for(var i = 0; i < radioLength; i++) {
			radioObj[i].checked = false;
			if(radioObj[i].value == newValue.toString()) {
				radioObj[i].checked = true;
			}
		}
	}

	//Se cargan por ajax
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

	$(document).ready(cargarSecciones);
</script>


		<fieldset>
			<legend>Editar Alumno</legend>
			<div class= "row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
					<div class="controls controls-row">
						<div class="input-append span7">
							<input id="filtroLista" class="span9" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
							<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
						<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					1.- Seleccione el alumno a editar:
				</div>
				<div class="span6" >
						<p>Complete los datos del formulario para modificar el alumno</p>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; overflow-x:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover" style="width:600px !important; max-width:600px;">

					</table>
				</div>


				<!-- Segunda columna -->
				<div class="span6">
					<?php
						$atributos= array('onsubmit' => 'return editarEstudiante()', 'id' => 'FormEditar', 'name' => 'FormEditar', 'class' => 'form-horizontal');
						echo form_open('Alumnos/postEditarEstudiante/', $atributos);
					?>
						<div class="control-group">
							<label class="control-label" for="rutEditar" style="cursor: default">1.- RUT</label>
							<div class="controls">
								<input type="text" id="rutEditar" name="rutEditar" class="span12" readonly>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="nombreunoEditar" style="cursor: default">2.- <font color="red">*</font> Primer nombre</label>
							<div class="controls">
								<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="nombreunoEditar" name="nombreunoEditar" maxlength="19" required>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="nombredosEditar" style="cursor: default">3.- Segundo nombre</label>
							<div class="controls">
								<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="nombredosEditar" name="nombredosEditar" maxlength="19" >
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="apellidopaternoEditar" style="cursor: default">4.- <font color="red">*</font> Apellido paterno</label>
							<div class="controls">
								<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellidopaternoEditar" name="apellidopaternoEditar" maxlength="19" required>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="apellidomaternoEditar" style="cursor: default">5.- <font color="red">*</font> Apellido materno</label>
							<div class="controls">
								<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellidomaternoEditar" name="apellidomaternoEditar" maxlength="19" required>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="correoEditar" style="cursor: default">6.- <font color="red">*</font> Correo</label>
							<div class="controls">
								<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" placeholder="nombre_usuario@miemail.com" id="correoEditar" class="span12" name="correoEditar" maxlength="199" required>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">7.- <font color="red">*</font> Asignar sección</label>
							<div class="controls">
								<input type="text" onkeyup="ordenarFiltro2()" id="filtroSeccion" class="span12" placeholder="Filtro de Sección">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default"></label>
							<div class="controls">
								<div style="border:#cccccc 1px solid;overflow-y:scroll; height:200px; -webkit-border-radius: 4px;" >
									<table class="table table-hover" id="listadoSecciones">
										<thead>

										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						
						<div class="row" >
							<div class="controls pull-right">
								<button class ="btn" style= "margin-right: 4px"type="button" onclick="editarEstudiante()" >
									<div class= "icon-pencil"></div>
									&nbsp Guardar
								</button>
								<button  class ="btn" type="reset" onclick="resetSeleccionado()" >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>

						<!-- Modal de seleccionaAlgo -->
						<div id="modalSeleccioneAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No ha seleccionado ningun estudiante</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione un estudiante y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se va a modificar el estudiante seleccionado. ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
								
							</div>
						</div>

						<!-- Modal de faltan campos -->
						<div id="modalFaltanCampos" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Campos Obligatorios no completados</h3>
							</div>
							<div class="modal-body">
								<p>Por favor complete el campo vacío y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>	
					<?php echo form_close(''); ?>
				</div>



			</div>
		</fieldset>