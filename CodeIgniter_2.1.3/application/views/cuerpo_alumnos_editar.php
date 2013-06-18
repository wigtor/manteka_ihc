
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha actualizado el estudiante");
				}
				else{
					alert("Error al actualizar");
				}
	}
</script>

<script type="text/javascript">

	function editarEstudiante(){

		var rut = document.getElementById("rutEditar").value;
		var nombreUno =	document.getElementById("nombreunoEditar").value;
		var nombreDos =	document.getElementById("nombredosEditar").value;
		var apellidoPaterno = document.getElementById("apellidopaternoEditar").value;
		var apellidoMaterno = document.getElementById("apellidomaternoEditar").value;
		var correo = document.getElementById("correoEditar").value;
		var seccion = document.forms['FormEditar'].elements['seccion_seleccionada'].value;
	
		if(rut!="" && nombreUno!=""  && apellidoPaterno!="" && apellidoMaterno!="" && correo!=""){
					var answer = confirm("¿Está seguro que desea aplicar los cambios?")
					if (!answer){
						return false;
					}
					else{
						return true;
					}
		}
		else {
				alert("Ingrese todos los datos");
				return false;
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
	}
</script>



<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
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
				$(rutDetalle).val(datos.rut);
				$(nombre1Detalle).val(datos.nombre1);
				$(nombre2Detalle).val(datos.nombre2);
				$(apellido1Detalle).val(datos.apellido1);
				$(apellido2Detalle).val(datos.apellido2);
				//$(carreraDetalle).val(datos.carrera);
				setCheckedValue(seccionDetalle, datos.seccion);
				//$(seccionDetalle).val(datos.seccion);
				$(correoDetalle).val(datos.correo);

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
					<div class="controls controls-row">
						<div class="input-append span7">
							<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
							<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
						<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					1.-Listado alumnos:
				</div>
				<div class="span6" >
					2.-Detalle alumno:
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<!-- Segunda columna -->
				<div class="span6">

					<font color="red">*Campos Obligatorios</font><br>
					<div style="margin-bottom:2%">
						Complete los datos del formulario para modificar el alumno
					</div>
					<?php
						$atributos= array('onsubmit' => 'return editarEstudiante()', 'id' => 'FormEditar', 'name' => 'FormEditar');
						echo form_open('Alumnos/postEditarEstudiante/', $atributos);
					?>
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">1-.RUT</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="rutEditar" name="rutEditar" readonly>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="nombreunoEditar" name="nombreunoEditar" maxlength="19" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">3-.Segundo nombre</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="nombredosEditar" name="nombredosEditar" maxlength="19" >
		  							</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido Paterno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellidopaternoEditar" name="apellidopaternoEditar" maxlength="19" required>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font>Apellido Materno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellidomaternoEditar" name="apellidomaternoEditar" maxlength="19" required>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" placeholder="nombre_usuario@miemail.com" id="correoEditar" name="correoEditar" maxlength="199" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid"> <!-- seccion-->
							<div class="span4">
								<div class="control-group">
									<label class="control-label" for="inputInfo" style="cursor: default">7-.<font color="red">*</font>Asignar sección</label>
								</div>
							</div>
							<div  class="span5" >
								<div class="controls">
									<input type="text" onkeyup="ordenarFiltro2()" id="filtroSeccion" placeholder="Filtro de Sección">
								</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span5 offset4">
								<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px; width: 127%" >
								
								
									<table class="table table-hover" id="listadoSecciones">
										<thead>

										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row" style= "margin-top:2%">
							<div class="span3" style="margin-left:37%">
								<button class ="btn" type="submit" >
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Modificar
								</button>
							</div>
							<div class="span3">
								<button  class ="btn" type="reset" onclick="resetSeleccionado()" >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
					<?php echo form_close(''); ?>
				</div>



			</div>
		</fieldset>