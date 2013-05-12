<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/enviarCorreo.css" type="text/css" media="all" />

<script type='text/javascript'>

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
	var rutRecept = document.getElementById("rutRecept").value;
	if (rutRecept=="")
	{
		alert("Debe seleccionar un destinatario para continuar");
	}
	else
	{
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

function ordenarFiltro(filtroLista)
{
	var tipoDeDestinatario = document.getElementById("tipoDeDestinatario").value;
	var arreglo = new Array();
	var receptor;
	var ocultar;
	var cont;

	<?php
	$contadorE = 0;
	$rs_receptor=$rs_estudiantes;
	while($contadorE<count($rs_receptor))
	{
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_receptor[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_receptor[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_receptor[$contadorE][4].'";';
		echo 'arreglo['.$contadorE.'][7] = "'.$rs_receptor[$contadorE][7].'";';
		echo 'arreglo['.$contadorE.'][6] = "'.$rs_receptor[$contadorE][6].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	for(cont=0;cont < arreglo.length;cont++)
	{
		receptor = document.getElementById(cont);
		ocultar=document.getElementById(cont);
		if(0 > arreglo[cont][3].toLowerCase ().indexOf(filtroLista.toLowerCase ())&
			0 > arreglo[cont][4].toLowerCase ().indexOf(filtroLista.toLowerCase ())&
			0 > arreglo[cont][1].toLowerCase ().indexOf(filtroLista.toLowerCase ()))
		{
			ocultar.style.display='none';
		}
		else
		{
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

function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera)
{
	document.getElementById("rutDetalle").innerHTML = rut;
	document.getElementById("to").value=correo;
	document.getElementById("rutRecept").value=rut;
	document.getElementById("nombreunoDetalle").innerHTML = nombre1;
	document.getElementById("nombredosDetalle").innerHTML = nombre2;
	document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
	document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
	document.getElementById("carreraDetalle").innerHTML = carrera;
	document.getElementById("seccionDetalle").innerHTML = seccion;
	document.getElementById("correoDetalle").innerHTML = correo;
	  
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
	<div class="texto2">
	Paso 2: Seleccione destinatario.
	</div>
	
	<div id="contenedorFilter">
	<div id="contenedorFiltro1">
	<div id="pcs" class="seleccion">
	<input id="filtroLista" name="filtroLista" style="font-size:9pt;font-weight:bold;"onkeyup="ordenarFiltro(this.value)" type="text" placeholder="Filtro búsqueda">
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
	<tbody>
                                
	<?php
	$rs_receptor=$rs_estudiantes;
	$contador=0;
	$comilla= "'";
	echo '<form id="formDetalle" type="post">';
                                    
	while ($contador<count($rs_receptor))
	{
		echo '<tr>';
		echo '<td id="'.$contador.'
		"onclick="DetalleAlumno('.$comilla.$rs_receptor[$contador][0].
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
	?>
	</tbody>
	</table>
	<script type="text/javascript">
	addTableRolloverEffect('tabla','tableRollOverEffect1','tableRowClickEffect1');
	</script> 
	</fieldset>
	</div>
	</div>
	</div>
	
	<div class="span5" style="margin-left: 2%; padding: 0%;">
	<div class="texto22">
	Destinatario:
	</div>
	</br>
	<pre style="margin-top:2%; padding-top:10%;padding-bottom:6%">
	Rut: <b id="rutDetalle"></b>
	Primer nombre: <b id="nombreunoDetalle"></b>
	Segundo nombre: <b id="nombredosDetalle"></b>
	Apellido paterno: <b id="apellidopaternoDetalle"></b>
	Apellido materno: <b id="apellidomaternoDetalle"></b>
	Carrera: <b id="carreraDetalle"></b>
	Sección: <b id="seccionDetalle"></b>
	Correo: <b id="correoDetalle"></b>
	</pre>
	</div>
	<div class="menu">
	<button class ="btn" title="Avanzar a paso 2" onclick="pasoDosTres()" >Siguiente</button>
	<button class ="btn" title="Volver a paso 1" onclick="pasoDosUno()" >Anterior</button>
	</div>
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
	<?php
	echo form_hidden('tipo', 'CARTA_ESTUDIANTE');?>
	<input type="hidden" name="rutRecept" id="rutRecept" value="<?php set_value('rutRecept');?>"/>
	</div>
	<div class="menu2">
	<button type="submit" title="Enviar correo" class="btn btn-primary" style="margin-left: 1%; margin-top: 2%">Enviar</button>
	<button class="btn" style="margin-top:2%" title="Volver a paso 2" onclick="pasoTresDos()" >Anterior</button>
	</div>
	<?php echo form_close("");?>
	</div>
</fieldset>