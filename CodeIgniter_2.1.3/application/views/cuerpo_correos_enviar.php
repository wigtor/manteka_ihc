<!--
<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/enviarCorreo.css" type="text/css" media="all" />
-->

<script type='text/javascript'>
var arrayRespuesta;
var arrayCarreras;
/** 
* Esta función se llama al hacer click en el botón enviar, 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver como es seteado el evento onsubmit() en el formulario.
* Esta función se encarga de evitar el envio de mails sin destinatario o sin asunto ni cuerpo de correo
* en caso de no contar con solo asunto o cuerpo decuerpo de correo pide confirmacion 
*/
function validacionSeleccion()
{

	var rutRecept = document.getElementById("rutRecept").value;
	
	if (rutRecept!="")
	{
		var texto = document.getElementById("editor").value;
		var asunto = document.getElementById("asunto").value;

		 if (asunto=="")
		{
			if (confirm("¿Desea enviar este correo sin indicar asunto?"))
				return true;
			else 
				return false;
		}
		return true;
	}
	else
	{
        return false;
	}
	return false;
}
</script>

<script type='text/javascript'>


/** 
* Esta función muestra el segundo paso para mandar un correo
*/

function pasoUnoDos()
{
	$('#cuadroEnviar').css({display:'none'});
	$('#cuadroEnvio').css({display:'none'});
	$('#cuadroDestinatario').css({display:'block'});
	document.getElementById('filtroPorCarrera').disabled=true;
}

/** 
* Esta función devuelve al primer paso para mandar un correo
*/

</script>

<script type='text/javascript'>
function pasoDosUno()
{
	$('#cuadroDestinatario').css({display:'none'});
	$('#cuadroEnvio').css({display:'none'});
	$('#cuadroEnviar').css({display:'block'});
}
</script>

<script type='text/javascript'>

/** 
* Esta función muestra el tercer paso para mandar un correo
*/

function pasoDosTres()
{
	var rutRecept = [];
	var to = "";
	//var rutRecept = document.getElementById("rutRecept").value;
	for(var i =0;i < arrayRespuesta.length;i++){
		var tr = document.getElementById(i);
		var check = tr.childNodes[0].childNodes[0].checked;
		if(check){
			rutRecept.push(tr.getAttribute("rut"));
			if(to==""){
				to = tr.getAttribute("correo");
			}else{
				to = to + ", " + tr.getAttribute("correo");
			}
		}
	}

	if (rutRecept=="")
	{
		alert("Debe seleccionar un destinatario para continuar");
	}
	else
	{
		document.getElementById("to").value=to;
		document.getElementById("rutRecept").value=rutRecept;
		$('#cuadroDestinatario').css({display:'none'});
		$('#cuadroEnviar').css({display:'none'});
		$('#cuadroEnvio').css({display:'block'});
	}
}
</script>

<script type='text/javascript'>


/** 
* Esta función devuelve al segundo paso para mandar un correo
*/

function pasoTresDos()
{
	$('#cuadroEnvio').css({display:'none'});
	$('#cuadroEnviar').css({display:'none'});
	$('#cuadroDestinatario').css({display:'block'});
}
</script>

<script type='text/javascript'>

/**
* Esta función se llama al escribir en el filtro de busqueda, 
* Esta función elimina los resultados que no coincidan con el filtro de busqueda
*/

function ordenarFiltro(filtroLista){
	var arreglo = new Array();
	var arregloOcultados = new Array();
	var receptor;
	var ocultar;
	var cont;
	var filtroListaSplit = filtroLista.split(" ");
	for(cont=0;cont < arrayRespuesta.length;cont++)
	{
		ocultar=document.getElementById(cont);
		for(contadorF = 0;contadorF < filtroListaSplit.length;contadorF++){
				if(0 > arrayRespuesta[cont].nombre1.toLowerCase ().indexOf(filtroListaSplit[contadorF].toLowerCase ())&
				0 > arrayRespuesta[cont].apellido1.toLowerCase ().indexOf(filtroListaSplit[contadorF].toLowerCase ())&
				0 > arrayRespuesta[cont].apellido2.toLowerCase ().indexOf(filtroListaSplit[contadorF].toLowerCase ()))
				{
					arregloOcultados[cont]='ocultado';
				}
		}
	}
	for (cont = 0; cont < arrayRespuesta.length; cont++) {
		ocultar=document.getElementById(cont);
		if(arregloOcultados[cont]=='ocultado'){
			ocultar.style.display='none';
		}else{
			ocultar.style.display='block';
		}
	}
}
</script>

<script type='text/javascript'>


/**
* Esta función se llama al hacer click en el botón enviar, 
* Esta función muestra los detalles de la persona seleccinada y guarda su rut y correo para el envio
*/ 
//,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera
function detalleAlumno(elemtable)
{	
	//document.getElementById("rutDetalleEstudiante").innerHTML = rut;
	var idElem = elemtable.id;
	rut = document.getElementById(idElem).getAttribute("rut");
	correo = document.getElementById(idElem).getAttribute("correo");
	document.getElementById("to").value=correo;
	document.getElementById("rutRecept").value=rut;
	/*document.getElementById("nombreunoDetalleEstudiante").innerHTML = nombre1;
	document.getElementById("nombredosDetalleEstudiante").innerHTML = nombre2;
	document.getElementById("apellidopaternoDetalleEstudiante").innerHTML = apePaterno;
	document.getElementById("apellidomaternoDetalleEstudiante").innerHTML = apeMaterno;
	document.getElementById("carreraDetalleEstudiante").innerHTML = carrera;
	document.getElementById("seccionDetalleEstudiante").innerHTML = seccion;
	document.getElementById("correoDetalleEstudiante").innerHTML = correo;*/
	  
}
</script>
<script type='text/javascript'>


/**
* Esta función se llama al hacer click en el botón enviar, 
* Esta función muestra los detalles de la persona seleccinada y guarda su rut y correo para el envio
*/ 

function DetalleProfesor(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera)
{
	document.getElementById("rutDetalleProfesor").innerHTML = rut;
	document.getElementById("to").value=correo;
	document.getElementById("rutRecept").value=rut;
	document.getElementById("nombreunoDetalleProfesor").innerHTML = nombre1;
	document.getElementById("nombredosDetalleProfesor").innerHTML = nombre2;
	document.getElementById("apellidopaternoDetalleProfesor").innerHTML = apePaterno;
	document.getElementById("apellidomaternoDetalleProfesor").innerHTML = apeMaterno;
	document.getElementById("correoDetalleProfesor").innerHTML = correo;
	  
}
</script>
<script type='text/javascript'>


/**
* Esta función se llama al hacer click en el botón enviar, 
* Esta función muestra los detalles de la persona seleccinada y guarda su rut y correo para el envio
*/ 

function DetalleAyudante(rut,nombre1,nombre2,apePaterno,apeMaterno,correo)
{
	document.getElementById("rutDetalleAyudante").innerHTML = rut;
	document.getElementById("to").value=correo;
	document.getElementById("rutRecept").value=rut;
	document.getElementById("nombreunoDetalleAyudante").innerHTML = nombre1;
	document.getElementById("nombredosDetalleAyudante").innerHTML = nombre2;
	document.getElementById("apellidopaternoDetalleAyudante").innerHTML = apePaterno;
	document.getElementById("apellidomaternoDetalleAyudante").innerHTML = apeMaterno;
	document.getElementById("correoDetalleAyudante").innerHTML = correo;
	  
}
</script>

<script type="text/javascript">
/************************************************************************************************************

(C) www.dhtmlgoodies.com, November 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.   
    
Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!
    
www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/   
var arrayOfRolloverClasses = new Array();
var arrayOfClickClasses = new Array();
var activeRow = false;
var activeRowClickArray = new Array();
    
function showDestinatarios(value){
	var destinatario = value;
		//if (texto.trim() != "") {
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Correo/postBusquedaAlumnosTipo") ?>", /* Se setea la url del controlador que responderá */
				data: { destinatario: destinatario}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var tablaResultados = document.getElementById('tabla');
					var nodoTexto;
					$(tablaResultados).empty();		
					arrayRespuesta = JSON.parse(respuesta);
					var thead = document.createElement('thead');
					thead.setAttribute("style","width:100%");
					var tbody = document.createElement('tbody');
					var tr = document.createElement('tr');
					var th = document.createElement('th');
					var check = document.createElement('input');
					check.type='checkbox';
					check.checked=false;
					th.appendChild(check);
					thead.appendChild(th);
					th = document.createElement('th');
					nodoTexto =document.createTextNode('Nombre Completo');
					th.appendChild(nodoTexto);
					thead.appendChild(th);
					tablaResultados.appendChild(thead);
					tbody.setAttribute("style","width:100%");
					for (var i = 0; i < arrayRespuesta.length; i++) {
						tr = document.createElement('tr');
						td = document.createElement('td');
						check = document.createElement('input');
						check.type='checkbox';
						check.checked=false;
						td.appendChild(check);
						tr.appendChild(td);
						td = document.createElement('td');
						tr.setAttribute("id", i);
						tr.setAttribute("style","width:100%");
						nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
						tr.setAttribute('rut',arrayRespuesta[i].rut);
						tr.setAttribute('correo',arrayRespuesta[i].correo);
						td.appendChild(nodoTexto);
						td.setAttribute("style","width:100%");
						tr.appendChild(td);
						tbody.appendChild(tr);
					}
					tablaResultados.appendChild(tbody);

					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					if(destinatario==1){
						document.getElementById('filtroPorCarrera').disabled=false;
						showCarreras();
					}
					}
			});

			/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
		//}
}

function showCarreras(){
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postCarreras") ?>",
		data:{},
		success: function(respuesta){
			var filtroCarrera = document.getElementById("filtroPorCarrera");
			arrayCarreras = JSON.parse(respuesta);
			for(var i=0;i<arrayCarreras.length;i++){
				filtroCarrera.add(new Option(arrayCarreras[i].carrera,arrayCarreras[i].carrera));
			}
		}
	});
}

$(document).ready(showDestinatarios(0));
function highlightTableRow()
{
	var tableObj = this.parentNode;
	if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

	if(this!=activeRow)
	{
		this.setAttribute('origCl',this.className);
		this.origCl = this.className;
	}
	this.className = arrayOfRolloverClasses[tableObj.id];
        
	activeRow = this;
}

function clickOnTableRow()
{
	var tableObj = this.parentNode;
	if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;        
        
	if(activeRowClickArray[tableObj.id] && this!=activeRowClickArray[tableObj.id])
	{
		activeRowClickArray[tableObj.id].className='';
	}
	
	this.className = arrayOfClickClasses[tableObj.id];
	activeRowClickArray[tableObj.id] = this;            
}

function resetRowStyle()
{
	var tableObj = this.parentNode;
	if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

	if(activeRowClickArray[tableObj.id] && this==activeRowClickArray[tableObj.id])
	{
		this.className = arrayOfClickClasses[tableObj.id];
		return; 
	}
	
	var origCl = this.getAttribute('origCl');
	if(!origCl)origCl = this.origCl;
		this.className=origCl;
}

function addTableRolloverEffect(tableId,whichClass,whichClassOnClick)
{
	arrayOfRolloverClasses[tableId] = whichClass;
	arrayOfClickClasses[tableId] = whichClassOnClick;
        
	var tableObj = document.getElementById(tableId);
	var tBody = tableObj.getElementsByTagName('TBODY');
	if(tBody)
	{
		var rows = tBody[0].getElementsByTagName('TR');
	}
	else
	{
		var rows = tableObj.getElementsByTagName('TR');
	}
	
	for(var no=0;no<rows.length;no++)
	{
		rows[no].onmouseover = highlightTableRow;
		rows[no].onmouseout = resetRowStyle;
            
		if(whichClassOnClick)
		{
			rows[no].onclick = clickOnTableRow; 
		}
	}
}
</script>


<fieldset id="cuadroEnviar">
    <legend>&nbsp;Enviar correo&nbsp;</legend>
	<div class="inicio" title="Paso 1: Selección de plantilla">
	<div class="texto1">
	Paso 1: Seleccione una plantilla.
	</div>
	<div class="seleccion">
	<select id="tipoDePantilla" title="Nombre de la plantilla" name="Plantilla a usar">
	<option value="1">No utilizar plantilla</option>
	</select>
	</div>
	
	<pre class="prePlantilla">
	<div class="plantilla">
	Actualmente sólo es posible enviar correos sin el uso de plantillas.
	La selección de plantillas será implementada en las próximas entregas.
	</div>
	</pre>
	<button class ="btn"  title="Avanzar a paso 2" onclick="pasoUnoDos()" >Siguiente</button>
	</div>
</fieldset>
	

<fieldset id="cuadroDestinatario" style="display:none;">
	<legend>&nbsp;Enviar correo&nbsp;</legend>
	<div class="bloque" title="Paso 2: Seleccionar destinatario(s)">
		<h5>
			Paso 2: Seleccione destinatario.
		</h5>
	</div>
	<div id="filtrosSelect">
		<div class="row-fluid">
			 <div class="control-group span9">
				<label class="control-label" for="filtroLista">Ingrese el nombre de quien busca o parte de su nombre</label>
				<div class="controls">
					<input id="filtroLista" name="filtroLista" style="font-size:9pt;font-weight:bold;" onkeyup="ordenarFiltro(this.value)" type="text" placeholder="Filtro búsqueda">
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="control-group span4">
				<label class="control-label" for="filtroPorTipoDeDestinatario">Filtrar por tipo destinatario</label>
				<div class="controls">
					<select id="filtroPorTipoDeDestinatario" title="Tipo de destinatario" class="input-large" onChange="showDestinatarios(this.value)">
						<option  value="0">Todos</option>
						<option  value="1">Alumnos</option>
						<option  value="2">Profesore</option>
						<option value="3">Ayudantes</option>
						<option value="4">Coordinadores</option>
					</select>
				</div>
			</div>


			<div class="control-group span4">
				<label class="control-label" for="filtroPorProfesorEncargado">Filtrar por profesor encargado</label>
				<div class="controls">
					<!-- Este debe ser cargado dinámicamente por php -->
					<select id="filtroPorProfesorEncargado" title="Tipo de destinatario" class="input-large">
						<option  value="0">Todos</option>
						<option  value="1">profe1</option>
						<option  value="2">profe2</option>
						<option value="3">profe3</option>
						<option value="4">profe4</option>
					</select>
				</div>
			</div>

			<div class="control-group span4">
				<label class="control-label" for="filtroPorCarrera">Filtrar por carrera</label>
				<div class="controls">
					<!-- Este debe ser cargado dinámicamente por php -->
					<select id="filtroPorCarrera" title="Tipo de destinatario" class="input-large">
						<option  value="0">Todos</option>
						<!--<option  value="1">Ing civil informática</option>
						<option  value="2">Ing civil en minas</option>
						<option value="3">Ing civil elétrica</option>
						<option value="4">Ing  industrial</option> -->
					</select>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="control-group span4">
				<label class="control-label" for="filtroPorModuloTematico">Filtrar por módulo temático</label>
				<div class="controls">
					<!-- Este debe ser cargado dinámicamente por php -->
					<select id="filtroPorModuloTematico" title="Tipo de destinatario" class="input-large">
						<option  value="0">Todos</option>
						<option  value="1">Unidad 1</option>
						<option  value="2">Unidad 2</option>
						<option value="3">Unidad 3</option>
						<option value="4">Unidad 4</option>
						<option value="5">Unidad 5</option>
					</select>
				</div>
			</div>

			<div class="control-group span4">
				<label class="control-label" for="filtroPorSeccion">Filtrar por sección</label>
				<div class="controls">
					<!-- Este debe ser cargado dinámicamente por php -->
					<select id="filtroPorSeccion" title="Tipo de destinatario" class="input-large">
						<option  value="0">Todas</option>
						<option  value="a1">A-01</option>
						<option  value="b2">B-02</option>
						<option value="c3">C-03</option>
						<option value="d4">D-04</option>
						<option value="e5">E-05</option>
					</select>
				</div>
			</div>

			<div class="control-group span4">
				<label class="control-label" for="filtroPorBloqueHorario">Filtrar por bloque horario</label>
				<div class="controls">
					<!-- Este debe ser cargado dinámicamente por php -->
					<select id="filtroPorBloqueHorario" title="Tipo de destinatario" class="input-large">
						<option  value="0">Todos</option>
						<option  value="1">Unidad 1</option>
						<option  value="2">Unidad 2</option>
						<option value="3">Unidad 3</option>
						<option value="4">Unidad 4</option>
						<option value="5">Unidad 5</option>
					</select>
				</div>
			</div>
		</div>
	</div>


	<!-- Este es el listado de resultados del filtro -->
	<div id="listasDeDestinatarios" class="row-fluid">
		<div id="listaResultadosFiltro" class="span5">
			<table id="tabla" name="tabla" class="table table-hover table-bordered" style="width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-bottom:0px">
				<thead>
					<tr>
						<th >
							<input type="checkbox" id="seleccionarTodosDelFiltro">
						</th>
						<th>
							Resultados del filtro
						</th>
					</tr>
				</thead>


				<tbody>
					<form id="formDetalle" type="post">
					<tr>
						<td >
							<input type="checkbox" id="seleccionarTodosDelFiltro">
						</td>
						<td>
							Juan Perez Torres
						</td>
					</tr>
					</form>
				</tbody>
			</table>
		</div>
<script>
//addTableRolloverEffect('tabla','tableRollOverEffect1','tableRowClickEffect1');
</script>
		<!-- Este es el botón que está entremedio de los dos listados -->
		<div class="span2 text-center">
			<div class="btn">Agregar</div>
		</div>

		<!-- Este es el listado de destinatarios seleccionados para el envío -->
		<div id="listaDestinatarios" class="span5">
			<table id="tabla" class="table table-hover table-bordered" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-bottom:0px">
				<thead>
					<tr>
						<th>
							Destinatarios seleccionados
						</th>
						<th >
							<input type="checkbox" id="seleccionarTodosDelFiltro">
						</th>
					</tr>
				</thead>
				<tbody>
					


				</tbody>
			</table>
		</div>
	</div>

	<!-- Botones atrás y siguiente -->
	<div class="row-fluid">
		<ul class="pager pull-right">
			<li>
				<div class ="btn" title="Volver a paso 1" onclick="pasoDosUno()" >Anterior</div>
			</li>
			<li>
				<div class ="btn" title="Avanzar a paso 2" onclick="pasoDosTres()" >Siguiente</div>
			</li>
		</ul>
	</div>
</fieldset>




<!-- PARTE ANTIGUA DE LA PARTE DE LA SELECCIÓN DE DESTINATARIOS -->
<fieldset id="cuadroDestinatario_old" style="display:none;">
	<legend>&nbsp;Enviar correo&nbsp;</legend>
	<div class="bloque" title="Paso 2: Seleccionar destinatario(s)">
		<div class="texto2">
			Paso 2: Seleccione destinatario.
		</div>
	
		<div id="contenedorFilter">
			<div id="contenedorFiltro1">
				<div id="pcs" class="seleccion">
					<input id="filtroLista" name="filtroLista" style="font-size:9pt;font-weight:bold;" onkeyup="ordenarFiltro(this.value)" type="text" placeholder="Filtro búsqueda">
					<select id="tipoDeDestinatario" title="Tipo de destinatario" >
						<option  value="1">Estudiantes</option>
						<option  value="2">Profesores</option>
						<option value="3">Ayudantes</option>
					</select>
				</div>
			</div>
			

			<div id="contenedorFiltro2">
				<fieldset id="lista">
				<table id="tabla" class="table table-hover" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-bottom:0px">
				<thead>
				<tr>
				<th style="text-align:left;width:600px;">Nombre Completo</th>
				</tr>
				</thead>
				<tbody id="test">
			                                
				<?php
				//TD DEL ESTUDIANTE
				$rs_receptor=$rs_estudiantes;
				$contador=0;
				$comilla= "'";
				echo '<form id="formDetalleEstudiante" type="post">';    
				while ($contador<count($rs_receptor))
				{
					echo '<tr>';
					echo '<td id="'.$contador.'" class="td_estudiante" onclick="DetalleAlumno('.$comilla.$rs_receptor[$contador][0].
					$comilla.','.$comilla. $rs_receptor[$contador][1].$comilla.
					','.$comilla. $rs_receptor[$contador][2].$comilla.','.$comilla. 
					$rs_receptor[$contador][3].$comilla.','.$comilla. 
					$rs_receptor[$contador][4].$comilla.','.$comilla. $rs_receptor[$contador][5].$comilla.
					','. $comilla.$rs_receptor[$contador][6].$comilla.','.$comilla. $rs_receptor[$contador][7].$comilla.
					')"style="text-align:left;">'. $rs_receptor[$contador][3].
					' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].
					'</td>';
					echo '</tr>';
					$contador = $contador + 1;
				}
				
				echo '</form>';
				//TD DEL PROFESOR                                
				$rs_receptor=$rs_profesores;
				$contador=0;
				$comilla= "'";
				echo '<form id="formDetalleProfesor" type="post">';
			                                    
				while ($contador<count($rs_receptor))
				{
					echo '<tr>';
					echo '<td id="'.$contador.'" class="td_profesor" style="display:none" onclick="DetalleProfesor('.$comilla.$rs_receptor[$contador][0].
					$comilla.','.$comilla. $rs_receptor[$contador][1].$comilla.
					','.$comilla. $rs_receptor[$contador][2].$comilla.','.$comilla. 
					$rs_receptor[$contador][3].$comilla.','.$comilla. 
					$rs_receptor[$contador][4].$comilla.')"style="text-align:left;">'. $rs_receptor[$contador][3].
					' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].
					'</td>';
					echo '</tr>';
					$contador = $contador + 1;
				}
				
				echo '</form>';

				//TD DEL AYUDANTE

				$rs_receptor=$rs_ayudantes;
				$contador=0;
				$comilla= "'";
				echo '<form id="formDetalleAyudante" type="post">';
			                                    
				while ($contador<count($rs_receptor))
				{
					echo '<tr>';
					echo '<td id="'.$contador.'" class="td_ayudante" style="display:none" onclick="DetalleAyudante('.$comilla.$rs_receptor[$contador][0].
					$comilla.','.$comilla. $rs_receptor[$contador][1].$comilla.
					','.$comilla. $rs_receptor[$contador][2].$comilla.','.$comilla. 
					$rs_receptor[$contador][3].$comilla.','.$comilla. 
					$rs_receptor[$contador][4].$comilla.','.$comilla. $rs_receptor[$contador][5].$comilla.
					')"style="text-align:left;">'. $rs_receptor[$contador][3].
					' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].
					'</td>';
					echo '</tr>';
					$contador = $contador + 1;
				}
				
				echo '</form>';
				?>
				</tbody>
				</table>
				<script type="text/javascript">
						//addTableRolloverEffect('tabla','tableRollOverEffect1','tableRowClickEffect1');
				</script>



		</div>
	</div>
	
	<div class="span5" style="margin-left: 2%; padding: 0%;">
	<div class="texto22">
	Destinatario:
	</div>
	</br>
	<pre id="preest" style="margin-top:2%; padding-top:10%;padding-bottom:6%; display:block">
	Rut: <b id="rutDetalleEstudiante" class="detalle"></b>
	Primer nombre: <b id="nombreunoDetalleEstudiante" class="detalle"></b>
	Segundo nombre: <b id="nombredosDetalleEstudiante" class="detalle"></b>
	Apellido paterno: <b id="apellidopaternoDetalleEstudiante" class="detalle"></b>
	Apellido materno: <b id="apellidomaternoDetalleEstudiante" class="detalle"></b>
	Carrera: <b id="carreraDetalleEstudiante" class="detalle"></b>
	Sección: <b id="seccionDetalleEstudiante" class="detalle"></b>
	Correo: <b id="correoDetalleEstudiante" class="detalle"></b>
	</pre>
	<pre id="preprof" style="margin-top:2%; padding-top:10%;padding-bottom:6%; display:none">
	Rut: <b id="rutDetalleProfesor" class="detalle"></b>
	Primer nombre: <b id="nombreunoDetalleProfesor" class="detalle"></b>
	Segundo nombre: <b id="nombredosDetalleProfesor" class="detalle"></b>
	Apellido paterno: <b id="apellidopaternoDetalleProfesor" class="detalle"></b>
	Apellido materno: <b id="apellidomaternoDetalleProfesor" class="detalle"></b>
	Correo prof: <b id="correoDetalleProfesor" class="detalle"></b>
	</pre>
	<pre id="preayud" style="margin-top:2%; padding-top:10%;padding-bottom:6%; display:none">
	Rut: <b id="rutDetalleAyudante" class="detalle"></b>
	Primer nombre: <b id="nombreunoDetalleAyudante" class="detalle"></b>
	Segundo nombre: <b id="nombredosDetalleAyudante" class="detalle"></b>
	Apellido paterno: <b id="apellidopaternoDetalleAyudante" class="detalle"></b>
	Apellido materno: <b id="apellidomaternoDetalleAyudante" class="detalle"></b>
	Correo: <b id="correoDetalleAyudante" class="detalle"></b>
	</pre>
	</div>
	<div class="menu">
		<button class ="btn" title="Avanzar a paso 2" onclick="pasoDosTres()" >Siguiente</button>
		<button class ="btn" title="Volver a paso 1" onclick="pasoDosUno()" >Anterior</button>
	</div>
</fieldset>

<fieldset id="cuadroEnvio" style="display:none;margin-top:-260px;">
	<legend>&nbsp;Enviar correo&nbsp;</legend>
	<div class="final" title="Paso 3: Escribir correo">
	<div class="texto3">
	Paso 3: Escriba el correo
	</div>
	<?php 
	$attributes = array('onSubmit'=>'return validacionSeleccion();', 'id'=>'formEnviar');
	echo form_open('Correo/enviarPost',$attributes);?>
	<div class="span4 x" style="margin-left: 1%; margin-top=2%; clear:both;"> 
	Para: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="to" name="to" type="text" value="<?php set_value('to'); ?>" readonly><br>
	Asunto: &nbsp;<input id="asunto" name="asunto" type="text" value="<?php set_value('asunto'); ?>">
	<input id="ed" name="ed" type="hidden" value="<?php set_value('editor'); ?>">
	</div>
	<div class="span14" width="90%" style="margin-left:1%;margin-top:2%;">
	<?php 
	$data = array(
		'name'=>'editor',
		'id'=>'editor',
		'value'=>set_value('editor'),
		'class'=>'ckeditor',
	);
	?>
	<div id="ck">
	<?php
	echo form_textarea($data);
	?>
	</div>
	<input type="hidden" name="rutRecept" id="rutRecept" value="<?php set_value('rutRecept');?>"/>
	</div>
	<div class="menu2">
	<button type="submit" title="Enviar correo" class="btn btn-primary" style="margin-left: 1%; margin-top: 2%">Enviar</button>
	<button class="btn" style="margin-top:2%" title="Volver a paso 2" onclick="pasoTresDos()" >Anterior</button>
	</div>
	<?php echo form_close("");?>
	</div>
</fieldset>