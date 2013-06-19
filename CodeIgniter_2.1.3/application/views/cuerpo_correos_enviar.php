<?php

/**
 * El presente archivo corresponde a la vista para enviar correos electrónicos.
 *
 * @package Manteka
 * @subpackage Vistas
 * @author Grupo 3
 **/
 
?>

<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/enviarCorreo.css" type="text/css" media="all" />

<script type='text/javascript'>
/**
 * Función que se encarga de evitar el envío de emails sin destinatario(s) o sin asunto ni cuerpo del mensaje.
 * En caso de no ingresar un asunto se solicita confirmación antes del envío.
 * 
 * Esta función se llama al hacer clic en el botón enviar.
 * Por convención las funciones que utilizan document.getElementById() deben ser definidas en la misma vista
 * en que son utilizadas, para evitar así, conflictos de identificadores.
 * Para ver como se configura se debe ver como es "seteado" el evento onsubmit() en el formulario.
 * 
 * @author Diego Gómez (DGL) 
 **/ 
var arrayRespuesta;
var arrayCarreras;
var myVar;
var codigoBorrador=-1;

function validacionSeleccion()
{
	var rutRecept = $.trim(document.getElementById("rutRecept").value);
	var texto = $.trim(CKEDITOR.instances.editor.getData());
	if (rutRecept!="" && texto !="")
	{
		var asunto = $.trim(document.getElementById("asunto").value);
		
		if (asunto=="")
		{
			if (confirm("¿Desea enviar este correo sin indicar asunto?"))
			{
				clearInterval(myVar);
				return true;
			}	
			else 
				return false;
		}
		clearInterval(myVar);
		return true;
	}
	else
	{
		if(texto=="")
			alert("Debe completar el cuerpo del mensaje para continuar.")
        return false;
	}
	return false;
}
</script>

<script type="text/javascript">
/**
 * Carga una plantilla.
 * 
 * Carga los datos de la plantilla seleccionada en los campos que conforman el mensaje a enviar.
 * Se invoca al seleccionar una plantilla de la lista de plantillas existentes en el sistema.
 * 
 * @author Diego García (DGM)
 * @param string asunto Corresponde al asunto de la plantilla seleccionada.
 * @param string cuerpo Corresponde al mensaje principal o cuerpo de la plantilla seleccionada.
 * @param int id Corresponde al número identificador o clave primaria de la plantilla seleccionada.
 **/
function CargarPlantilla(asunto, cuerpo, id)
{
	if(confirm('Se sobreescribirá el contenido del mensaje actual.\n¿Realmente desea continuar?'))
	{
		document.getElementById('idPlantilla').value=id;
		document.getElementById('asunto').value=asunto;
		CKEDITOR.instances.editor.setData (cuerpo);
	}
}
</script>

<script type="text/javascript">
/**
 * Inicia el envío de un correo electrónico.
 * 
 * Muestra el mensaje "Realizando envío" y envía el formulario al controlador para realizar el
 * envío del correo electrónico a la lista de destinatarios seleccionada.
 * Antes de realizar el envío se comprueba que el usuario haya sido ingresado el cuerpo del mensaje, mediante
 * la función "validacionSeleccion".
 * 
 * @author Diego García (DGM)
 **/
function enviarCorreo()
{
	if(validacionSeleccion())
	{
		$('#contenedorEnvio').css({display:'none'});
		var pb = document.getElementById("enviando");
		var pb2 = document.getElementById("enviando2");
		pb.innerHTML = '<img src="/<?php echo config_item('dir_alias') ?>/img/procesando.gif">';
		pb2.innerHTML = '<img src="/<?php echo config_item('dir_alias') ?>/img/mensaje.png">';
		$('#enviando').css({display:'block'});
		$('#enviando2').css({display:'block'});
		if($('#enviando').css({display:'block'}) && $('#enviando2').css({display:'block'})) 
		{
			setTimeout(document.formEnviar.submit(), 2000);
		}
	}
}
</script>

<script type="text/javascript">
/**
 * Filtra las plantillas existentes en el sistema según los criterios ingresados por el usuario. 
 *
 * Filtra las plantillas que cumplen los siguientes criterios: 
 * 1. Contienen un campo que coincide con el texto de búsqueda ingresado por el usuario.
 * 2. El campo que coincide con el texto de búsqueda, es del mismo tipo que el especificado en el 'select' para filtrar resultados.   
 * 
 * @author Diego García (DGM) (Función extraida y modificada a partir de la vista para editar alumnos creada por el grupo 4)
 **/
function filtrarPlantillas()
{
	var busqueda = document.getElementById('busquedaPlantilla').value;
	var tipoBusqueda = document.getElementById('tipoBusqueda').value;	
	var resultados = new Array();
	var plantilla;
	var ocultar2;
	var count;
	<?php
	$countPlantilla = 0;
	while( $countPlantilla < count($plantillas) )
	{
		echo 'resultados['.$countPlantilla.']=new Array();';
		echo 'resultados['.$countPlantilla.'][0] = "'.$plantillas[$countPlantilla]->ID_PLANTILLA.'";';
		echo 'resultados['.$countPlantilla.'][1] = "'.$plantillas[$countPlantilla]->NOMBRE_PLANTILLA.'";';
		echo 'resultados['.$countPlantilla.'][2] = "'.$plantillas[$countPlantilla]->ASUNTO_PLANTILLA.'";';
		echo 'resultados['.$countPlantilla.'][3] = "'.htmlentities($plantillas[$countPlantilla]->CUERPO_PLANTILLA).'";';
		$countPlantilla=$countPlantilla+1;
	}
	?>
	for( count=0; count < resultados.length; count++ )
	{
		plantilla = document.getElementById('p'+resultados[count][0]);
		ocultar2=document.getElementById('p'+resultados[count][0]);
		if( 0 > resultados[count][Number(tipoBusqueda)].toLowerCase().indexOf(busqueda.toLowerCase()) )
		{
			ocultar2.style.display='none';
		}
		else
		{
			ocultar2.style.display='block';
		}
	}	
}
</script>

<script type='text/javascript'>
/**
 * Muestra y oculta las plantillas al hacer clic sobre los "divs" con el texto "Mostrar plantillas" y "Ocultar plantillas" respectivamente.
 *
 * Al cargar el DOM de la página, es posible hacer clic sobre los textos "Mostrar plantillas" y "Ocultar plantillas"
 * para desplegar u ocultar la selección de plantillas respectivamente.
 * 
 * @author Diego García (DGM)
 **/
$(document).ready(function()
{
	$("#ocultarPlantillas").click(function ()
	{
		$("#ocultarPlantillas").slideUp();
		$("#mostrarPlantillas").show("slow");
		$("#seleccionPlantilla").slideUp();
	});
	$("#mostrarPlantillas").click(function ()
	{
		$("#mostrarPlantillas").slideUp();
		$("#ocultarPlantillas").show("slow");
		$("#seleccionPlantilla").show("slow");
	});
});
</script>

<script type='text/javascript'>
/**
 * Carga la información del borrador seleccionado para ser enviado.
 * 
 * @author Byron Lanas (BL)
 * @param int codigo Corresponde al código identificador del borrador.
 **/
function cargarBorrador(codigo)
{
	codigoBorrador=codigo;	
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postCargarBorrador") ?>",	
		data: {codigo:codigo},
		success: function(respuesta)
		{
			borrador = JSON.parse(respuesta);
			$('#cuadroDestinatario').css({display:'none'});
			$('#cuadroEnvio').css({display:'block'}); 
			document.getElementById("asunto").value=borrador[0][0].asunto;
			CKEDITOR.instances.editor.setData(""+borrador[0][0].cuerpo_email);
			var rutRecept=[];
			
			for(var i=0;i<borrador[1].length;i++)
			{
				rutRecept.push(borrador[1][i].rutRecept);
			}
				
			document.getElementById("rutRecept").value=rutRecept;
			document.getElementById("codigoBorrador").value=codigoBorrador;
			var correoRecept=[];

			for(var i=0;i<borrador[2].length;i++)
			{
				correoRecept.push(borrador[2][i].correo);
			}
			var to="";
			to=correoRecept.join(", ");
			document.getElementById("to").value=to;

			myVar=setInterval(function(){timerBorradores()},20*1000);
			timerBorradores();
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type='text/javascript'>
/**
 * Guarda y actualiza el borrador del correo actual.
 * 
 * La función actualiza el borrador cada 20 segundos o cuando el usuario
 * lo solicita mediante el botón "Guardar borrador".
 * 
 * @author Byron Lanas (BL)
 **/
function timerBorradores()
{
	var d=new Date();
	var t=d.toLocaleTimeString();
	
	editor=CKEDITOR.instances.editor.getData();
	asunto=document.getElementById("asunto").value;
	to=document.getElementById("to").value;
	rutRecept= document.getElementById("rutRecept").value;
	
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postGuardarBorradores") ?>",
			
		data: {codigoBorrador:codigoBorrador,to:to,rutRecept:rutRecept,editor:editor,asunto:asunto},
		success: function(respuesta)
		{
			codigoBorrador = JSON.parse(respuesta);						
			document.getElementById("guardado").innerHTML="Se ha guardado un borrador a las: "+t;
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type='text/javascript'>
/**
 * Muestra el paso 1 y oculta el pasos 2 del proceso para enviar correos.
 * 
 * Se ejecuta al presionar el botón "anterior" del paso 2 del envío de correos.
 * Además cancela el timer utilizado para el guardado automático de borradores.
 * 
 * @author Diego García (DGM)
 **/
function pasoDosUno()
{
	$('#cuadroEnvio').css({display:'none'});
	$('#cuadroDestinatario').css({display:'block'});
	clearInterval(myVar);
}
</script>

<script type='text/javascript'>
/**
 * Asigna los destinatarios al formulario de envío de un correo, muestra el paso 2
 * y oculta el paso 1 del proceso para enviar correos.
 * 
 * Se ejecuta al presionar el botón "siguiente" del paso 1 del envío de correos.
 * Además inicia el timer utilizado para el guardado automático de borradores.
 *
 * @author Byron Lanas (BL)
 **/
function pasoUnoDos()
{
	var rutRecept = [];
	var to = "";
	for(var i =0;i < tbody2.getElementsByTagName('tr').length;i++)
	{
		if(tbody2.getElementsByTagName('tr')[i].getElementsByTagName('input')[0].checked)
		{
			rutRecept.push(tbody2.getElementsByTagName('tr')[i].getAttribute("rut"));
			if(to=="")
			{
				to = tbody2.getElementsByTagName('tr')[i].getAttribute("correo");
			}
			else
			{
				to = to + ", " + tbody2.getElementsByTagName('tr')[i].getAttribute("correo");
			}
		}
	}
	
	if (rutRecept=="")
	{
		alert("Seleccione al menos un destinatario para continuar.");
	}
	else 
	{
		document.getElementById("to").value=to;
		document.getElementById("rutRecept").value=rutRecept;
		$('#cuadroDestinatario').css({display:'none'});
		$('#cuadroEnvio').css({display:'block'});
		myVar=setInterval(function(){timerBorradores()},20*1000);
		timerBorradores();
	}
}
</script>

<script type='text/javascript'>
/**
 *
 * @author
 **/
function selectAll(value)
{
	var tabla = document.getElementById('tabla');
	var tbody = tabla.childNodes[1];
	var flag;
	if(value.checked)
	{
		flag=true;
	}
	else
	{
		flag=false;
	}
	for(var i = 0;i<tbody.childNodes.length;i++)
	{
		if(document.getElementById(i).style.display!='none')
		{
			document.getElementById('check'+i).checked=flag;
		}
	}
}
</script>

<script type='text/javascript'>
/**
 *
 * @author
 **/
function ordenarFiltro(filtroLista)
{
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
	for (cont = 0; cont < arrayRespuesta.length; cont++)
	{
		ocultar=document.getElementById(cont);
		if(arregloOcultados[cont]=='ocultado')
		{
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


<script type="text/javascript">
/**
 *
 * @author
 **/
function seleccionar_todo()
{	
	/* Se obtienen todos los controles del tipo Input de la tabla de destinatarios disponibles. */
    var checkboxes=document.getElementById('tbody1').getElementsByTagName('input');
	/* Se recorren todos los controles. */
	for(var i=0;i<checkboxes.length;i++)
	{
		/* Sólo si el control es un checkbox entramos. */
		if(checkboxes[i].type == "checkbox")
		{
			/* Si es un checkbox se le da el valor del checkbox padre que lo llamó (Marcar/Desmarcar Todos) */
			checkboxes[i].checked=this.checked;
		}
	}
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function seleccionar_segundo_check(source)
{	
	/* Se obtienen todos los controles del tipo Input de la tabla de destinatarios seleccionados. */
    var checkboxes=document.getElementById('tbody2').getElementsByTagName('input');
	/* Se recorren todos los controles. */
	for(var i=0;i<checkboxes.length;i++)
	{
		/* Sólo si el control es un checkbox entramos. */
		if(checkboxes[i].type == "checkbox")
		{
			/* Si es un checkbox se le da el valor del checkbox padre que lo llamó (Marcar/Desmarcar Todos). */
			checkboxes[i].checked=source.checked;
		}
	}   
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
var prefijo= '';
function muestraTabla(respuesta)
{
	prefijo = prefijo.concat('x');
	var tablaResultados = document.getElementById('tabla');
	var nodoTexto;
	$(tablaResultados).empty();		
	arrayRespuesta = JSON.parse(respuesta);
	var thead = document.createElement('thead');
	thead.setAttribute("style","width:100%");
	var tbody = document.createElement('tbody');
	tbody.id="tbody1";
	var tr = document.createElement('tr');
	tr.id='trTodos';
	var th = document.createElement('th');
	th.id='allcheck';
	var check = document.createElement('input');
	check.id='todos';
	check.type='checkbox';
	check.checked=false;					
	th.appendChild(check);
	thead.appendChild(th);
	th = document.createElement('th');
	th.id = 'txtTodos';
	nodoTexto =document.createTextNode('Destinatarios disponibles');
	th.appendChild(nodoTexto);
	thead.appendChild(th);
	tablaResultados.appendChild(thead);
	tbody.setAttribute("style","width:100%");
	for (var i = 0; i < arrayRespuesta.length; i++)
	{
		tr = document.createElement('tr');
		td = document.createElement('td');
		td.id='check';
		check = document.createElement('input');
		check.type='checkbox';
		check.checked=false;
		check.id='check'+i;
		$('#todos').click(seleccionar_todo);
		td.appendChild(check);
		tr.appendChild(td);
		td = document.createElement('td');
		td.id='opcion';
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

	/* Se oculta el "div" que indica que se está cargando. */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).hide();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showDestinatarios(value)
{
	var destinatario = value;
	$.ajax({
		/* Indica al servidor, que se trata de una petición POST. */
		type: "POST",
		/* Se "setea" la url del controlador que responderá. */
		url: "<?php echo site_url("Correo/postBusquedaTipoDestinatario") ?>",
		/* Se codifican los datos que se enviarán al servidor usando el formato JSON. */
		data: { destinatario: destinatario},
		/* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio. */
		success: function(respuesta)
		{
			muestraTabla(respuesta);
			if(destinatario==1)
			{
				showCarreras();
				showProfesores();
				showSecciones();
				showHorarios();
				showModulosTematicos();
				document.getElementById('filtroPorBloqueHorario').disabled=false;
				document.getElementById('filtroPorModuloTematico').disabled=false;
				document.getElementById('filtroPorCarrera').disabled=false;
				document.getElementById('filtroPorProfesorEncargado').disabled=false;
				document.getElementById('filtroPorSeccion').disabled=false;
			}
			else if(destinatario ==2)
			{
				showSecciones();
				showHorarios();
				showModulosTematicos();
				document.getElementById('filtroPorModuloTematico').selectedIndex=0;
				document.getElementById('filtroPorModuloTematico').disabled=false;
				document.getElementById('filtroPorBloqueHorario').selectedIndex=0;
				document.getElementById('filtroPorBloqueHorario').disabled=false;
				document.getElementById('filtroPorProfesorEncargado').selectedIndex=0;
				document.getElementById('filtroPorProfesorEncargado').disabled=true;
				document.getElementById('filtroPorCarrera').selectedIndex=0;
				document.getElementById('filtroPorCarrera').disabled=true;
				document.getElementById('filtroPorSeccion').disabled=false;
			}
			else if(destinatario==3)
			{
				showProfesores();
				showSecciones();
				showHorarios();
				showModulosTematicos();
				document.getElementById('filtroPorBloqueHorario').disabled=false;
				document.getElementById('filtroPorModuloTematico').disabled=false;
				document.getElementById('filtroPorProfesorEncargado').disabled=false;
				document.getElementById('filtroPorSeccion').disabled=false;
			}
			else
			{
				document.getElementById('filtroPorModuloTematico').selectedIndex=0;
				document.getElementById('filtroPorModuloTematico').disabled=true;
				document.getElementById('filtroPorBloqueHorario').selectedIndex=0;
				document.getElementById('filtroPorBloqueHorario').disabled=true;
				document.getElementById('filtroPorProfesorEncargado').selectedIndex=0;
				document.getElementById('filtroPorProfesorEncargado').disabled=true;
				document.getElementById('filtroPorCarrera').selectedIndex=0;
				document.getElementById('filtroPorCarrera').disabled=true;
				document.getElementById('filtroPorSeccion').selectedIndex=0;
				document.getElementById('filtroPorSeccion').disabled=true;
			}
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showCarreras()
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postCarreras") ?>",
		data:{},
		success: function(respuesta)
		{
			var filtroCarrera = document.getElementById("filtroPorCarrera");
			arrayCarreras = JSON.parse(respuesta);
			filtroCarrera.selectedIndex=0;
			$('#filtroPorCarrera').empty();
			filtroCarrera.add(new Option("Todos",""));
			for(var i=0;i<arrayCarreras.length;i++){
				filtroCarrera.add(new Option(arrayCarreras[i].carrera,arrayCarreras[i].codigo));
			}
			var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showProfesores()
{
	var destinatario = 2;
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postBusquedaTipoDestinatario") ?>",
		data:{destinatario: destinatario},
		success: function(respuesta)
		{
			var filtroProfesor = document.getElementById("filtroPorProfesorEncargado");
			arrayProfesores = JSON.parse(respuesta);
			filtroProfesor.selectedIndex=0;
			$('#filtroPorProfesorEncargado').empty();
			filtroProfesor.add(new Option("Todos",""));
			for (var i = 0; i < arrayProfesores.length; i++)
			{
				filtroProfesor.add(new Option(arrayProfesores[i].nombre1+" "+arrayProfesores[i].apellido2,arrayProfesores[i].rut));
			}
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
function showSecciones()
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postSecciones") ?>",
		data:{},
		success: function(respuesta)
		{
			var filtroSeccion = document.getElementById("filtroPorSeccion");
			arraySecciones = JSON.parse(respuesta);
			filtroSeccion.selectedIndex=0;
			$('#filtroPorSeccion').empty();
			filtroSeccion.add(new Option("Todos",""));
			for (var i = 0; i < arraySecciones.length; i++)
			{
				filtroSeccion.add(new Option(arraySecciones[i].nombre,arraySecciones[i].codigo));
			}
			var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showHorarios()
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postHorarios") ?>",
		data:{},
		success: function(respuesta)
		{
			var filtroHorario = document.getElementById("filtroPorBloqueHorario");
			arrayHorarios = JSON.parse(respuesta);
			filtroHorario.selectedIndex=0;
			$('#filtroPorBloqueHorario').empty();
			filtroHorario.add(new Option("Todos",""));
			for (var i = 0; i < arrayHorarios.length; i++)
			{
				filtroHorario.add(new Option(arrayHorarios[i].nombre,arrayHorarios[i].codigo));
			}
			var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showModulosTematicos()
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postModulosTematicos") ?>",
		data:{},
		success: function(respuesta)
		{
			var filtroModuloTematico = document.getElementById("filtroPorModuloTematico");
			arrayModulosTematicos = JSON.parse(respuesta);
			filtroModuloTematico.selectedIndex=0;
			$('#filtroPorModuloTematico').empty();
			filtroModuloTematico.add(new Option("Todos",""));
			for (var i = 0; i < arrayModulosTematicos.length; i++)
			{
				filtroModuloTematico.add(new Option(arrayModulosTematicos[i].nombre,arrayModulosTematicos[i].codigo));
			}
			var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function showDestinatarioByFiltro()
{
	var destinatario = document.getElementById('filtroPorTipoDeDestinatario').value;
	var codigo = document.getElementById('filtroPorCarrera').value;
	var profesor = document.getElementById('filtroPorProfesorEncargado').value;
	var seccion = document.getElementById('filtroPorSeccion').value;
	var modulo_tematico = document.getElementById('filtroPorModuloTematico').value;
	var bloque = document.getElementById('filtroPorBloqueHorario').value;
	if(destinatario==1)
	{
		if(codigo=="" && profesor=="" && seccion=="" && modulo_tematico=="" && bloque=="")
		{
			showDestinatarios(1);
		}
		else 
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("Correo/postAlumnosByFiltro") ?>",
				data:{ codigo: codigo, profesor: profesor, seccion: seccion, modulo_tematico: modulo_tematico, bloque: bloque},
				success: function(respuesta)
				{
					muestraTabla(respuesta);
				}
			});
		}
	}
	else if(destinatario==2)
	{
		if(seccion=="" && modulo_tematico=="" && bloque == "") {
			showDestinatarios(2);
		}
		else
		{
			$.ajax({
	 			type: "POST",
				url: "<?php echo site_url("Correo/postProfesoresByFiltro") ?>",
				data:{ seccion: seccion, modulo_tematico:modulo_tematico, bloque: bloque},
				success: function(respuesta)
				{
					muestraTabla(respuesta);
				}
			});
		}
	}
	else 
	{
		if(seccion=="" && modulo_tematico=="" && bloque == "" && profesor == "")
		{
			showDestinatarios(3);
		}
		else 
		{
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("Correo/postAyudantesByFiltro") ?>",
				data:{ profesor: profesor, seccion: seccion, modulo_tematico: modulo_tematico, bloque: bloque},
				success: function(respuesta)
				{
					muestraTabla(respuesta);
				}
			});
		}
	}
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function pasarContactos()
{
	var tbody = document.getElementById('tbody1');
	var tbody2 = document.getElementById('tbody2');
	var cont = 0;
	var total=tbody.getElementsByTagName('tr').length;
	
	for (var x=0; x < total; x++)
	{		
		if (tbody.getElementsByTagName('tr')[x].getElementsByTagName('input')[0].checked)
		{
			if(revisarRut(tbody.getElementsByTagName('tr')[x].getAttribute("rut")))
			{
				tbody2.appendChild(tbody.getElementsByTagName('tr')[x]);
				total--;
				x--;
			}
			else
				tbody.getElementsByTagName('tr')[x].getElementsByTagName('input')[0].checked=false;				
		}
	}
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function quitarContactos()
{
	var tbody = document.getElementById('tbody1');
	var tbody2 = document.getElementById('tbody2');
	var cont = 0;
	var total=tbody2.getElementsByTagName('tr').length;
	
	for (var x=0; x < total; x++)
	{		
		if (tbody2.getElementsByTagName('tr')[x].getElementsByTagName('input')[0].checked)
		{
			if(revisarRut2(tbody2.getElementsByTagName('tr')[x].getAttribute("rut")))
			{
				tbody.appendChild(tbody2.getElementsByTagName('tr')[x]);
				total--;
				x--;
			}
			else
				tbody2.getElementsByTagName('tr')[x].getElementsByTagName('input')[0].checked=false;				
		}
	}
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function revisarRut(rut)
{
	var tbody2 = document.getElementById('tbody2');
	for(var i=0; i < tbody2.getElementsByTagName('tr').length; i++)
	{
		if(tbody2.getElementsByTagName('tr')[i].getAttribute("rut")== rut )
		{
			return false;	
		}
	}
	return true;	
}
</script>

<script type="text/javascript">
/**
 *
 * @author
 **/
function revisarRut2(rut)
{
	var tbody = document.getElementById('tbody');
	for(var i=0; i < tbody.getElementsByTagName('tr').length; i++)
	{
		if(tbody.getElementsByTagName('tr')[i].getAttribute("rut")== rut )
		{
			return false;	
		}
	}
	return true;	
}
</script>

<script type='text/javascript'>
/**
 * Muestra el paso 1 y oculta el paso 2 del proceso para enviar correos.
 * También oculta el selector de plantillas.
 * 
 * Al cargar la página actual, muestra el paso 1 para el envío de correos.
 * Además se carga la lista de destinatarios disponibles por defecto.
 * 
 * @author Diego García (DGM)
 **/
$(document).ready(function() {
	$('#enviando').css({display:'none'});
	$('#enviando2').css({display:'none'});
	$("#ocultarPlantillas").slideUp();
	$("#mostrarPlantillas").show("slow");
	$("#seleccionPlantilla").slideUp();
	$('#cuadroEnvio').css({display:'none'});
	showDestinatarios(0);
	$('#cuadroDestinatario').css({display:'block'});
});
</script>

<!-- Carga de borrador cuando corresponde. -->
<?php
if(isset($codigo))
{
	?>
	<script type="text/javascript">
	cargarBorrador(<?php echo $codigo; ?>)
	</script>
	<?php
	unset($codigo);
}
?>

<!-- Paso 1 del envío de correos: Selección de destinatarios. -->
<fieldset id="cuadroDestinatario">	
	
	<legend>&nbsp;Enviar correo&nbsp;</legend>
	
	<div class="contenedor">
	
		<div class="bloque" title="Paso 1: Seleccione destinatario">
			Paso 1: Seleccione destinatario(s).
		</div>
		
		<!-- Búsqueda, filtrado y selección de destinatarios. -->
		<div id="filtrosSelect">
		
			<!-- Búsqueda por nombre de destinatario. -->
			<label class="control-label" for="filtroLista">
				Ingrese el nombre de quien busca o parte de su nombre.
			</label>
			<div class="controls">
				<input id="filtroLista" maxlength="80" name="filtroLista" onkeyup="ordenarFiltro(this.value)" type="text" placeholder="Máximo 80 caracteres">
			</div>
			
			<div class="row-fluid">
			
				<!-- Filtro por tipo de destinatario. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorTipoDeDestinatario">
						Filtrar por tipo de destinatario
					</label>
					<div class="controls">
						<select class="filtro-primario" id="filtroPorTipoDeDestinatario" title="Tipo de destinatario"  onChange="showDestinatarios(this.value)">
							<option value="0">Todos</option>
							<option value="1">Alumnos</option>
							<option value="2">Profesores</option>
							<option value="3">Ayudantes</option>
							<option value="4">Coordinadores</option>
						</select>
					</div>
				</div>
				
				<!-- Filtro por profesor encargado. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorProfesorEncargado">Filtrar por profesor encargado</label>
					<div class="controls">
						<select id="filtroPorProfesorEncargado" title="Tipo de destinatario" class="filtro-primario" onChange="showDestinatarioByFiltro()">
							<option  value="0">Todos</option>
						</select>
					</div>
				</div>
				
				<!-- Filtro por carrera. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorCarrera" >Filtrar por carrera</label>
					<div class="controls">
						<select id="filtroPorCarrera" title="Tipo de destinatario" class="filtro-secundario" onChange="showDestinatarioByFiltro()">
							<option value="0">Todos</option>
						</select>
					</div>
				</div>
			
			</div>

			<div class="row-fluid">
			
				<!-- Filtro por módulo temático. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorModuloTematico">Filtrar por módulo temático</label>
					<div class="controls">
						<select id="filtroPorModuloTematico" title="Tipo de destinatario" class="filtro-secundario" onChange="showDestinatarioByFiltro()">
							<option value="0">Todos</option>
						</select>
					</div>
				</div>

				<!-- Filtro por sección. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorSeccion">Filtrar por sección</label>
					<div class="controls">
						<select id="filtroPorSeccion" title="Tipo de destinatario" class="filtro-secundario" onChange="showDestinatarioByFiltro()">
							<option value="0">Todas</option>
						</select>
					</div>
				</div>

				<!-- Filtro por bloque de horario. -->
				<div class="control-group span4">
					<label class="control-label" for="filtroPorBloqueHorario">Filtrar por bloque de horario</label>
					<div class="controls">
						<select id="filtroPorBloqueHorario" title="Tipo de destinatario" class="filtro-secundario" onChange="showDestinatarioByFiltro()">
							<option value="0">Todos</option>
						</select>
					</div>
				</div>
			
			</div>
		
		</div>
		
		<!-- Lista de destinatarios disponibles. -->
		<div id="listasDeDestinatarios" class="row-fluid">
			<div id="listaResultadosFiltro" class="span5">
				<table id="tabla" name="tabla" class="table table-hover table-bordered">
				</table>
			</div>
		
			<div id="botoneraCentral" class="span2 text-center">
				<div class="btn abc" type="button" onclick="pasarContactos()">
				Agregar
				</div>
				<div class="btn abc" type="button" onclick="quitarContactos()">
				Quitar
				</div>
			</div>
		
			<!-- Lista de destinatarios seleccionados. -->
			<div id="listaDestinatarios" class="span5">
				<table id="tabla2" class="table table-hover table-bordered">
					<thead>
						<tr>
							<th id="allcheck">
								<input type="checkbox" id="seleccionarTodosDelFiltro" onClick="seleccionar_segundo_check(this)" checked="true">
							</th>
							<th id="txtTodosDestino">
								Destinatarios seleccionados
							</th>
						</tr>
					</thead>
					<tbody id="tbody2">
					</tbody>
				</table>
			</div>
			
		</div>
		
		<!-- Formulario para crear grupo de contactos. -->
		<div id="group">
			<?php
			$attributes = array('onSubmit' => 'return validar(this)', 'id'=>'form_contactos');
			echo form_open('Grupo/agregarGrupo',$attributes);
			?>
			<input type="hidden" name="QUERY_FILTRO_CONTACTO">
			<div id="btnGrupo">
				<input type="text" name="NOMBRE_FILTRO_CONTACTO" placeholder="Nombre grupo contactos">
				<button class ="btn btnX grupo" type="submit" title="Guardar grupo de contactos para reutilizarlos en el futuro." >Guardar grupo</button>
			</div>
			<?php echo form_close(""); ?>
		</div>
		
		<!-- Botón para avanzar hacia el paso 2 del envío de correo. -->
		<div class="row-fluid boton">
			<div class ="btn btnX" type="button" title="Avanzar a paso 2" onclick="pasoUnoDos()" >Siguiente <div class="btn_with_icon_solo">=</div></div>
		</div>
		
	</div>
	
</fieldset>

<!-- Paso 2 del envío de correos: Ingreso del mensaje. -->
<fieldset id="cuadroEnvio">

	<legend>&nbsp;Enviar correo&nbsp;</legend>
	
	<!-- "Divs" que muestran el mensaje "Realizando envío" cuando se realiza el envío de un correo. -->
	<div id="enviando">
		<img src="/<?php echo config_item('dir_alias') ?>/img/procesando.gif">
    </div>
	<div id="enviando2">
		<img src="/<?php echo config_item('dir_alias') ?>/img/mensaje.png">
    </div>
	
	<div id="contenedorEnvio">
	
		<div class="inicio bloque" title="Paso 2: Ingrese el mensaje">
			Paso 2: Ingrese el mensaje.
		</div>
		
		<!-- Muestra al usuario un mensaje indicando que se ha guardado un borrador. -->
		<div class="alert alert-success" id="msjOk">
			<p id="guardado">
			</p>
		</div>
		
		<!-- Al hacer clic muestra el selector de plantillas. -->
		<div id="mostrarPlantillas" class="txt3">
			<div class="letras">
				Mostrar plantillas
			</div>
			<div class="icono">
				<img src="/<?php echo config_item('dir_alias') ?>/img/down_blue.png">
			</div>
		</div>
		
		<!-- Al hacer clic oculta el selector de plantillas. -->
		<div id="ocultarPlantillas" class="txt3">
			<div class="letras">
				Ocultar plantillas
			</div>
			<div class="icono">
				<img src="/<?php echo config_item('dir_alias') ?>/img/up_blue.png">
			</div>
		</div>
		
		<!--
		- Lista de plantillas existentes en el sistema. 
		- 
		- En la lista se muestra sólo el nombre de las plantillas.	
		- 
		- @author Diego García (DGM)
		-->
		<div id="seleccionPlantilla">
		
			<div id="contenedorLista">
		
				<div class="txt4">
					Seleccione la plantilla a cargar
				</div>
		
				<div id="lista">
					<table class="table table-hover">
						<tbody>
							<?php
							$noVacio=true;
							$comilla="'";
							if(count($plantillas) === 0)
							{
								$noVacio=false;
								?>
								<div id="sinPlantillas">
									No existen plantillas guardadas.
								</div>
								<?php
							}
							else
							{
								foreach($plantillas as $plantilla)
								{
									echo '<tr>';
									echo '<td id="p'.$plantilla->ID_PLANTILLA.'" onclick="javascript:CargarPlantilla('.$comilla.$plantilla->ASUNTO_PLANTILLA.$comilla.', '.$comilla.htmlentities($plantilla->CUERPO_PLANTILLA).$comilla.', '.$comilla.$plantilla->ID_PLANTILLA.$comilla.');" style="text-align:left;">'.$plantilla->NOMBRE_PLANTILLA.'</td>';
									echo '</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
				
			</div>
			
			
			<!-- Este código sólo se ejecuta cuando existe al menos una plantilla almacenada en el sistema. -->
			<?php
			if($noVacio===true)
			{
				?>
			   <!--
				- Muestra los elementos necesarios para realizar la búsqueda de una plantilla y filtrar los resultados. 
				- 
				- Para la búsqueda de la plantilla el usuario puede ingresar cualquier texto.
				- La búsqueda puede ser filtrada por nombre, asunto o cuerpo de la plantilla.
				- 
				- @author Diego García (DGM) (Código extraido y modificado a partir de la vista para editar alumnos creada por el grupo 4)
				-->
				<div id="contenedorBusquedaFiltro">
				
					<div class="txt">
						Búsqueda
					</div>
				
					<div id="busqueda">
						<input id="busquedaPlantilla" maxlength="40" onkeyup="filtrarPlantillas()" type="text" placeholder="Ingrese el texto a buscar">
					</div>
				
					<div class="txt">
						Filtrar resultados
					</div>
				
					<div id="filtroBusqueda">
						<select id="tipoBusqueda" size="1" onchange="filtrarPlantillas()" title="Filtrar resultados" >
							<option value="1" selected>Filtrar por nombre</option>
							<option value="2"><b>Filtrar por asunto</b></option>
							<option value="3">Filtrar por cuerpo</option>
						</select>
					</div>
				
				</div>
				
				<div class="separador">
				</div>
				
				<?php
			}
			else
			{
				?>
				<div class="espacio">
				</div>
				<?php
			}
			?>
			
		</div>
		
		<!-- Formulario para el envío de un correo. -->
		<?php
		$attributes = array('onSubmit'=>'return validacionSeleccion();', 'id'=>'formEnviar', 'name'=>'formEnviar');
		echo form_open('Correo/enviarPost',$attributes);
		?>
		
		<!-- Correos de los destinatarios seleccionados y asunto del correo a enviar. -->
		<div class="row-fluid">
			<div class="span12" > 
				<div class="txt2">
					Para:
				</div>
				<input id="to" name="to" type="text" value="<?php set_value('to'); ?>" readonly><br>
				<div class="txt2">
					Asunto:
				</div>
				<input id="asunto" name="asunto" type="text" value="<?php set_value('asunto'); ?>">		
				<div class="txt2">
					Adjunto:
				</div>
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="input-append">
						<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Seleccionar archivo</span><span class="fileupload-exists">Cambiar</span><input type="file" name = "userfile"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Eliminar</a>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Cuerpo del mensaje del correo. -->
		<div class="row-fluid fila">
			<div class="span12 control-group">
			
			<div class="txt5">
				Cuerpo del mensaje:
			</div>

			<!-- Botón para que el usuario guardar borradores en cualquier momento. -->
			<button type="button" class="btn btnXX" id="btn2" onclick="timerBorradores()" style="float:right" >Guardar borrador</button>	
			
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span12 control-group">
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
				<input type="hidden" name="codigoBorrador" id="codigoBorrador" value="<?php set_value('codigoBorrador');?>"/>
				<input name="idPlantilla" type="hidden" id="idPlantilla" maxlength="6">
			</div>
		</div>
		
		<!-- Botones para volver al paso 1 o enviar el correo. -->
		<div class="row-fluid btns">
			<div class="pager pull-right control-group botonera">
				<button type="button" title="Enviar correo" onclick="enviarCorreo()" class="btn btnX btn-primary">Enviar&nbsp;&nbsp;<div class="btn_with_icon_solo">M</div></button>
				<button class="btn btnX" type="button" id="btnAnterior" title="Volver a paso 2" onclick="pasoDosUno()"><div class="btn_with_icon_solo"><</div> Anterior</button>
			</div>
		</div>
		
		<?php echo form_close(""); ?>
		
	</div>
	
</fieldset>

<script type="text/javascript">
/**
 *
 * @author
 **/
function validar(form)
{
	event.preventDefault();
	var answer = confirm("¿Está seguro que desea agregar este grupo de contactos?");
	if (answer)
	{
		var string = "";
		var total=tbody2.getElementsByTagName('tr').length;
		var help = 0;
		for (var x=0; x < total; x++)
		{
			if (tbody2.getElementsByTagName('tr')[x].getElementsByTagName('input')[0].checked)
			{
				if(help== 0)
				{
					string=tbody2.getElementsByTagName('tr')[x].getAttribute("rut");
					help = 1;
				}
				else
				{
					string=string+","+tbody2.getElementsByTagName('tr')[x].getAttribute("rut");
				}			
			}
		}
		if(!string.length)
		{
			alert('Debe seleccionar al menos un destinatario de la tabla de destinatarios disponibles.')
		}
		else
		{
			if($('input[name=NOMBRE_FILTRO_CONTACTO]').val().length == 0 )
			{
				alert("Debe ingresar un nombre para el grupo de contactos");
			}
			else
			{
				$('input[name=QUERY_FILTRO_CONTACTO]').val(string);
				
				/* Se envía el formulario usando AJAX. */
				$.ajax({
					type: 'POST',
					url: "<?php echo site_url("Grupo/agregarGrupo") ?>",
					data: $('#form_contactos').serialize(),	
					
					/* Se muestra un mensaje con la respuesta de PHP. */
					success: function(data)
					{
					}
				})	
				alert('Grupo de contactos agregado satisfactoriamente.');
			}
		}	
		return false;		
	}
}
</script>