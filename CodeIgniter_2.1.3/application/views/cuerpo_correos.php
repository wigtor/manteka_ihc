 <link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" /> 

<script type="text/javascript">
/** 
* Esta función se llama al clickear un correo de la bandeja de correos enviados, En primera instancia muestra el detalle
* de dicho correo y a la vez ocultando la bandeja de correos mostrando sólo el detalle del correo seleccionado. 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver en el evento onclick() en donde están contenidos los correos (bandeja) .
*/

var offset=0;

function DetalleCorreo(hora,fecha,asunto,id,de,codigo)
{		

	document.getElementById("fecha").innerHTML=fecha;
	document.getElementById("hora").innerHTML=hora;
	document.getElementById("asuntoDetalle").innerHTML=asunto;
	document.getElementById("de").innerHTML=de;
	document.getElementById("cuerpoMail").innerHTML=document.getElementById("c"+id).value;
	obtenerAdjunto(codigo);
	
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postLeido") ?>",
			
		data: {codigo:codigo},
		success: function(respuesta)
		{
			codigoBorrador = JSON.parse(respuesta);
			$(icono_cargando).hide();
		}
	});
	
	/* Muestra el "div" que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();

	$('#cuadroRecibidos').css({display:'none'});
	$('#cuadroDetalleCorreo').css({display:'block'});
}

/** 
* Esta función se llama al clickear el botón que se encuentra en el Detalle del Correo, para poder mostrar nuevamente la 
* bandeja de correos enviados y ocultar el detalle del correo que se estaba mostrando.
* Para ver como se configura esto se debe ver en el evento onclick() del botón que se encuentra en el Detalle de Correo.
*/
function volverCorreosRecibidos()
{	
	cambiarCorreos("volver",offset);
	$('#cuadroDetalleCorreo').css({display:'none'});
	$('#cuadroRecibidos').css({display:'block'});
}

//funcion que resalta el correo seleccionado

function oscurecerFondo(i,codigo){
	
	if(document.getElementById("check"+codigo).checked==1){
		document.getElementById("tr"+i).setAttribute("bgcolor","#e5e5e5");	
	}
	
else if(document.getElementById("tr"+i).getAttribute("noleido")=="true")
		document.getElementById("tr"+i).setAttribute("bgcolor","#E0f8f7")
	else
		document.getElementById("tr"+i).removeAttribute("bgcolor","#e5e5e5");
}

/** 
* Esta función se llama al hacer click en los botones < y > para cambiar los correos mostrados
* También se realiza una búsqueda
*/

function cambiarCorreos(direccion,offsetL)
{
	
	if (direccion=="ant") {
		offset=offsetL-20;
	}
	else if(direccion=="sig") {
		offset=offsetL+20;
	}
	
	var filtroBusqueda = document.getElementById("filtroLista");
	var textoBusqueda = $(filtroBusqueda).val();

	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postRecibidos") ?>",
		data: { offset: offset, textoBusqueda: textoBusqueda, textoFiltrosAvanzados: valorFiltrosJson},
		success: function(respuesta){
			var tablaResultados = document.getElementById('listadoResultados');
			var nodoTexto;
			$(tablaResultados).find('tbody').remove();
			listaRecibidos = JSON.parse(respuesta);

			
			tbody = document.createElement('tbody');
			tbody.setAttribute("style","overflow-y:scroll; height:295px;display:block;");
			if (listaRecibidos.length == 0) {
				tr = document.createElement('tr');
				td = document.createElement('td');
				$(td).html("No se encontraron resultados");
				$(td).attr('colspan',tiposFiltro.length);
				tr.appendChild(td);
				tbody.appendChild(tr);
			}
			for (var i = 0; i < listaRecibidos.length; i++) {

				var noLeido=listaRecibidos[i].no_leido;

				tr = document.createElement('tr');
				tr.setAttribute("id","tr"+i);
				td = document.createElement('td');
				td.setAttribute("width", "5%");
				td.setAttribute("id", i);
				td.setAttribute("style","padding-top:4px;padding-bottom:8px;");
				td.setAttribute("align","center");				

				check = document.createElement('input');
				check.type='checkbox';
				check.setAttribute("name", prefijo_tipoDato + listaRecibidos[i].codigo);
				check.setAttribute("id", "check" + listaRecibidos[i].codigo);
				check.checked=false;
				td.appendChild(check);
				td.setAttribute("onclick","oscurecerFondo("+i+","+listaRecibidos[i].codigo+")");
				var cuerpo = listaRecibidos[i].cuerpo_email;
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "23%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				var de=listaRecibidos[i].nombre+" "+listaRecibidos[i].apellido1+" "+listaRecibidos[i].apellido2;
				td.setAttribute("onclick","DetalleCorreo('"+listaRecibidos[i].hora+"','"+listaRecibidos[i].fecha+"','"+listaRecibidos[i].asunto+"',"+i+",'"+de+"',"+listaRecibidos[i].codigo+")");
				nodoTexto=document.createTextNode(de);

				if(noLeido==1){
					tr.setAttribute("bgcolor","#E0f8f7");
					tr.setAttribute("noLeido","true")
					b=document.createElement("b");
					b.appendChild(nodoTexto);
					td.appendChild(b);
				}else
					td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("id", "m"+i);
				td.setAttribute("width", "27%");
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaRecibidos[i].hora+"','"+listaRecibidos[i].fecha+"','"+listaRecibidos[i].asunto+"',"+i+",'"+de+"',"+listaRecibidos[i].codigo+")");
				
				var span="";
				
				if (listaRecibidos[i].adjuntos!="")
					span="<span  style='width: 15px; height: 15px; float:right; margin-right:8px;'><img src='/manteka/img/icons/glyphicons_062_paperclip' alt=':' ></span>";	
				if(noLeido==1){
					
					var largoAsunto=listaRecibidos[i].asunto.length; 
					if(listaRecibidos[i].asunto.length>30){
						var asuntoTmp = "<b>"+listaRecibidos[i].asunto.substr(0,30)+"</b>.....";	
						largoAsunto=30;
					}
					else
						var asuntoTmp = "<b>"+listaRecibidos[i].asunto+"</b>";	
					if(strip(cuerpo+"<a>").length>40-largoAsunto)
						var cuerpoTmp = strip(cuerpo+"<a>").substr(0,40-largoAsunto)+".....";	
					else
						var cuerpoTmp = strip(cuerpo+"<a>");	
					td.innerHTML = asuntoTmp+" - <font color='#999999'>"+cuerpoTmp+"</font>"+span;
				}else{
					var largoAsunto=listaRecibidos[i].asunto.length; 
					if(listaRecibidos[i].asunto.length>30){
						var asuntoTmp = listaRecibidos[i].asunto.substr(0,30)+".....";	
						largoAsunto=30;
					}
					else
						var asuntoTmp = listaRecibidos[i].asunto;	
					if(strip(cuerpo+"<a>").length>40-largoAsunto)
						var cuerpoTmp = strip(cuerpo+"<a>").substr(0,40-largoAsunto)+".....";	
					else
						var cuerpoTmp = strip(cuerpo+"<a>");	
					td.innerHTML = asuntoTmp+" - <font color='#999999'>"+cuerpoTmp+"</font>"+span;
						
				}
				//
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaRecibidos[i].hora+"','"+listaRecibidos[i].fecha+"','"+listaRecibidos[i].asunto+"',"+i+",'"+de+"',"+listaRecibidos[i].codigo+")");
				nodoTexto=document.createTextNode(listaRecibidos[i].fecha);
				if(noLeido==1){		
					b=document.createElement("b");			
					b.appendChild(nodoTexto);
					td.appendChild(b);
				}else
					td.appendChild(nodoTexto);
				
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaRecibidos[i].hora+"','"+listaRecibidos[i].fecha+"','"+listaRecibidos[i].asunto+"',"+i+",'"+de+"',"+listaRecibidos[i].codigo+")");
				
				nodoTexto=document.createTextNode(listaRecibidos[i].hora);
				if(noLeido==1){					
					b=document.createElement("b");
					b.appendChild(nodoTexto);
					td.appendChild(b);
				}else
					td.appendChild(nodoTexto);

				tr.appendChild(td);
				tbody.appendChild(tr);
				

				textarea=document.createElement('textarea');
				textarea.setAttribute("id","c"+i);
				textarea.setAttribute("style","display:none");
				textarea.value = cuerpo;
				tbody.appendChild(textarea);
			}

			tablaResultados.appendChild(tbody);

			var limite;
			if(<?php echo $cantidadCorreos;?><offset+20)
				limite=<?php echo $cantidadCorreos;?>;
			else
				limite=offset+20;

			
			
			document.getElementById("sig").setAttribute("onClick", "cambiarCorreos('sig',"+offset+")");
			document.getElementById("ant").setAttribute("onClick", "cambiarCorreos('ant',"+offset+")");
			if (direccion=="ant") {
					
					if(offset==0){
						document.getElementById("ant").className="disabled";
						document.getElementById("ant").removeAttribute('onClick');
					}
					document.getElementById("sig").removeAttribute('class');
			}else if(direccion=="sig"){
				
				if(offset+20>=<?php echo $cantidadCorreos;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
				document.getElementById("ant").removeAttribute('class');

			}else{
				if(offset+20>=<?php echo $cantidadCorreos;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
				if(offset==0)
					document.getElementById("ant").removeAttribute('onClick');
			}
			if (listaRecibidos.length == 0) {
				document.getElementById("mostrando").innerHTML="mostrando "+ (offset)+"-"+limite+ " de: "+<?php echo $cantidadCorreos;?>;
			}else

			document.getElementById("mostrando").innerHTML="mostrando "+ (offset+1)+"-"+limite+ " de: "+<?php echo $cantidadCorreos;?>;

			
			
			var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
		}
	});
	/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
	
}
/** 
* Esta función obtiene los archivos adjuntos de un correo.
*/
function obtenerAdjunto(codigo)
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/obtenerAdjuntos") ?>",
		data: { codigo: codigo},
		success: function(respuesta){
			listaAdjuntos = JSON.parse(respuesta);
			if(listaAdjuntos.length>0)
			{
				$('#destinosAdjuntos').css({display:'none'});
				var tablaResultados=document.getElementById("files");
				$(tablaResultados).find('tbody').remove();

				tbody = document.createElement('tbody');
				tbody.setAttribute("style","height:auto;width:100%;");
				for(num=0;num<listaAdjuntos.length;num++){

					document.getElementById("attach").setAttribute("style","display:'';");
					var tr= document.createElement('tr'); 
					tr.setAttribute("id","f"+num);
					tr.setAttribute("style","margin-left:0px;display:block;");
					var td=document.createElement("td");
					td.setAttribute("style","width:95%;display:inline-table;font-size:10px;");
					var span;
					var iconClass='icon icon-'+listaAdjuntos[num].logico.substring(listaAdjuntos[num].logico.lastIndexOf(".")+1);
					span="<span  class='"+iconClass+"''></span>";	
					var link="<a href='"+listaAdjuntos[num].fisico+"' download='"+listaAdjuntos[num].logico+"'>"+listaAdjuntos[num].logico+"</a>";
					td.innerHTML=span+" "+link;
					tr.appendChild(td);
					tbody.appendChild(tr);
					tr=document.createElement("tr");
					tr.setAttribute("id",'b'+num);
					tr.setAttribute("style","display:none");
					tbody.appendChild(tr);

				}
				tablaResultados.appendChild(tbody);
			}
			else
			{

				$('#destinosAdjuntos').css({display:'inline-block'});
			}
		}
	});
	/* Muestro el div que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}
/** 
* Esta función obtiene los archivos adjuntos de un correo.
*/
function obtenerAdjuntoOld(codigo)
{
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/obtenerAdjuntos") ?>",
		data: { codigo: codigo},
		success: function(respuesta){
			listaAdjuntos = JSON.parse(respuesta);
			if(listaAdjuntos.length>0)
			{
				$('#destinosAdjuntos').css({display:'none'});
				$('#xxx').css({float:'left'});
				$('#xxx').css({display:'block'});
				var fisicos = "";
				var logicos = "";
				for (var i = 0; i < listaAdjuntos.length; i++)
				{
					if(i==0)
					{
						fisicos = fisicos + listaAdjuntos[i].fisico;
						logicos = logicos + listaAdjuntos[i].logico;
					}
					else
					{
						fisicos = fisicos + "???" + listaAdjuntos[i].fisico;
						logicos = logicos + "???" + listaAdjuntos[i].logico;
					}
				}
				document.getElementById("adjuntosEmailFisico").value = fisicos;
				document.getElementById("adjuntosEmailLogico").value = logicos;
			}
			else
			{
				$('#xxx').css({display:'none'});
				$('#destinosAdjuntos').css({float:'left'});
				$('#destinosAdjuntos').css({display:'block'});
			}
		}
	});
	/* Muestro el div que indica que se está cargando... */
	var iconoCargado = document.getElementById("icono_cargando");
	$(icono_cargando).show();
}

/** 
* Esta función elimina los tags HTML
*/
function strip(html)
{
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent||tmp.innerText;
}

/** 
* Esta función permite eliminar el correo que se encuentre marcado con su checkbox, también es posible la eliminación en 
* grupo (varios checkbox marcados).
*/
function eliminarCorreo()
{
	$("#seleccion").val("");
	var temp, idCorreo;
	$(':checkbox').each(function()
	{
		if (this.checked) {
			if (this.id != 'selectorTodos') { //Evito que se incluya el checkbox que los marca a todos
				temp = $(this).attr('name');
				idCorreo = temp.substring(prefijo_tipoDato.length, temp.length);
				if ($("#seleccion").val()== '') {
					$("#seleccion").val(idCorreo);
				}
				else {
					$("#seleccion").val($("#seleccion").val()+idCorreo+";");
				}
			}
		}
	});

	if ($("#seleccion").val() == '') {
		$('#modalSeleccioneAlgo').modal();
		return;
	}
	$('#modalConfirmacion').modal();
}


function limpiarFiltrosCorreo() {
	var tam = valorFiltrosJson.length;
	for (var i = 0; i < tam; i++) {
		valorFiltrosJson[i] = "";
	}
	var inputTextoFiltro = document.getElementById('filtroLista');
	$(inputTextoFiltro).val("");

	//Luego de limpiar los filtros, se debe iniciar una nueva búsqueda
	cambiarCorreos('inicial', 0);
}

function cambioTipoFiltroCorreos(inputUsado) {
	if (inputUsado != undefined) {
		var idElem = inputUsado.id;
		var index = idElem.substring(prefijo_tipoFiltro.length, idElem.length);
		valorFiltrosJson[index] = inputUsado.value; //Copio el valor del input al array de filtros
	}
	cambiarCorreos("inicial", 0);
}

function evitarEnvioVacio() {
	$("#seleccion").val("");
	var temp, idCorreo;
	$(':checkbox').each(function()
	{
		if (this.checked) {
			if (this.id != 'selectorTodos') { //Evito que se incluya el checkbox que los marca a todos
				temp = $(this).attr('name');
				idCorreo = temp.substring(prefijo_tipoDato.length, temp.length);
				if ($("#seleccion").val() == '') {
					$("#seleccion").val(idCorreo);
				}
				else {
					$("#seleccion").val($("#seleccion").val()+";"+idCorreo);
				}
			}
		}
	});

	if ($("#seleccion").val() == '') {
		return false;
	}
	return true;
}

function escribirHeadTableCorreos() {

	var tablaResultados = document.getElementById("listadoResultados");
	$(tablaResultados).find('tbody').remove();
	var tr, td, th, thead, nodoTexto, nodoBtnFiltroAvanzado;
	thead = document.createElement('thead');
	thead.setAttribute('style', "cursor:default;width:100%;display:block;");
	tr = document.createElement('tr');
	tr.setAttribute("style","display:table;width:100%");

	// Se comprueba si existe el Array inputAllowedFiltro. Éste indica el tipo de texto aceptado para cada filtro.
	if( (typeof(inputAllowedFiltro) == 'undefined') || inputAllowedFiltro == null){
		inputAllowedFiltro = new Array(tiposFiltro.length);
		for(var i =0; i < tiposFiltro.length; i++)
			inputAllowedFiltro[i] = "";
	}

	//SE CREA LA CABECERA DE LA TABLA
	for (var i = 0; i < tiposFiltro.length; i++) {
			th = document.createElement('th');

			switch (i){
				case 0:
					th.setAttribute("style","width:7%");
					break;
				case 1:
					th.setAttribute("style","width:32%");
					break;
				case 2:
					th.setAttribute("style","width:37%");
					break;	
				case 3:
					th.setAttribute("style","width:12%");
					break;
				case 4:
					th.setAttribute("style","width:12%");
					break;							
			}

			if (tiposFiltro[i] != '') {
				nodoTexto = document.createTextNode(tiposFiltro[i]+" ");
				th.appendChild(nodoTexto);

				nodoBtnFiltroAvanzado = document.createElement('a');
				nodoBtnFiltroAvanzado.setAttribute('class', "btn btn-mini clickover");
				nodoBtnFiltroAvanzado.setAttribute('id', 'cabeceraTabla_'+tiposFiltro[i]);
				//$(nodoBtnFiltroAvanzado).attr('title', "Buscar por "+tiposFiltro[i]);
				nodoBtnFiltroAvanzado.setAttribute('style', "cursor:pointer;");
					span = document.createElement('i');
					span.setAttribute('class', "icon-filter clickover");
					//span.setAttribute('style', "vertical-align:middle;");
				nodoBtnFiltroAvanzado.appendChild(span);

				// Se comprueba que existe un elemento para dicha posición del Array inputAllowedFiltro. En caso de que no, se setea en string vacío
					inputAllowedFiltro[i] = typeof(inputAllowedFiltro[i]) == 'undefined' ? "" : inputAllowedFiltro[i];
					/// Se asigna el valor del atributo pattern que tendrá el input.
					var inputPattern = inputAllowedFiltro[i] != "" ? 'pattern="'+inputAllowedFiltro[i]+'"' : "";

			
				th.appendChild(nodoBtnFiltroAvanzado);

				
				// Se comprueba que existe un elemento para dicha posición del Array inputAllowedFiltro. En caso de que no, se setea en string vacío
				inputAllowedFiltro[i] = typeof(inputAllowedFiltro[i]) == 'undefined' ? "" : inputAllowedFiltro[i];
				/// Se asigna el valor del atributo pattern que tendrá el input.
				var inputPattern = inputAllowedFiltro[i] != "" ? 'pattern="'+inputAllowedFiltro[i]+'"' : "";

				var divBtnCerrar = '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
				
				var divs = divBtnCerrar+'<div class="input-append"><input class="span9 popovers" '+inputPattern+' id="'+ prefijo_tipoFiltro + i +'" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltroCorreos(this)" ><button class="btn" onClick="cambioTipoFiltroCorreos(this.parentNode.firstChild)" type="button"><i class="icon-search"></i></button></div>';
				

				$(nodoBtnFiltroAvanzado).clickover({html:true, content: divs, placement:'top', onShown: despuesDeMostrarPopOver, title:"Búsqueda sólo por " + tiposFiltro[i], rel:"clickover", indice: i});
			}
			else { //Esto es para el caso de los checkbox que marcan toda la tabla
				nodoCheckeable = document.createElement('input');
				nodoCheckeable.setAttribute('data-previous', "false,true,false");
				nodoCheckeable.setAttribute('type', "checkbox");
				nodoCheckeable.setAttribute('id', "selectorTodos");
				nodoCheckeable.setAttribute('title', "Seleccionar todos");
				th.appendChild(nodoCheckeable);
			}

			
		tr.appendChild(th);
	}
	thead.appendChild(tr);
	
	tablaResultados.appendChild(thead);
}

/**
 * Carga la información del correo a ver en su contexto.
 * 
 * @author Byron Lanas (BL)
 * @param int codigo Corresponde al código identificador del borrador.
 **/
function cargarCorreo(codigo)
{
	
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postCargarCorreo") ?>",	
		data: {codigo:codigo},
		success: function(respuesta)
		{
			detalles = JSON.parse(respuesta);
			var tablaResultados = document.getElementById('listadoResultados');
			$(tablaResultados).find('tbody').remove();
			
			if(detalles==""){
				alert("El mensaje que intenta ver fue eliminado o no posee los permisos para verlo");
			}else{
				//var tablaResultados = document.getElementById('tabla');
				var cuerpo=detalles[0].cuerpo_email;
				textarea=document.createElement('textarea');
				textarea.setAttribute("id","cc");
				textarea.setAttribute("style","display:none");
				tablaResultados.appendChild(textarea);
				document.getElementById("cc").value=cuerpo;
				var de=detalles[1].nombre+" "+detalles[1].apellido1+" "+detalles[1].apellido2;
				DetalleCorreo(detalles[0].hora,detalles[0].fecha,detalles[0].asunto,'c',de,codigo);
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



<?php
if(isset($msj))
{
	if($msj==1)
	{
		?>
		    <div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 Eliminación de correo(s) realizada satisfactoriamente !!!
    		</div>	
		<?php
	}
	else if($msj==0)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 La eliminación de correo(s) no se pudo realizar. Contacta al administrador del sistema.
    		</div>		

		<?php
	}else if($msj==2)
	{
		?>
		<div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 El mensaje fue enviado satisfactoriamente.
    		</div>
		<?php
	}else{
		$codigo=explode(":",$msj);
		
		?>

			<script type="text/javascript">
			cargarCorreo(<?php echo $codigo[1]; ?>)
			</script>
		<?php

	}
	unset($msj);
}
?>

<script>
	var tiposFiltro = ["", "De", "Mensaje", "Fecha", "Hora"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", ""]; //Esta es variable global que almacena el valor de los input de búsqueda en específico
	var inputAllowedFiltro = ["[A-Za-z]+", "[A-Za-z]+", "[A-Za-z]+","([1-9][0-9]{3}-(0\\d|1[0-2])-([0-2]\\d|3[0-1])|[1-9][0-9]{3}-(0\\d|1[0-2])|[1-9][0-9]{3}|(0\\d|1[0-2])|([0-2]\\d|3[0-1]))","(^(0{0,1}\\d|1\\d|2[0-3]):([0-5]\\d):([0-5]\\d)$|([0-5]\\d):([0-5]\\d)$|([0-5]\\d)$)"];
	var prefijo_tipoDato = "correo_rec_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Correos/postRecibidos") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/correos") ?>";

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTableCorreos();
		cambiarCorreos('inicial', 0);

		//Hace que se seleccionen todos los checkbox al presionar el selectorTodos
		$("#selectorTodos").click(function()				
		{
			var checked_status = this.checked;
			$(':checkbox').each(function()
			{
				this.checked = checked_status;
			});
		});
	});
</script>


<fieldset id="cuadroRecibidos">
	<legend>Correos recibidos</legend>
	<?php
		$contador=0;
		$offset=0;

		if($cantidadCorreos<$offset+20)
			$limite=$cantidadCorreos;
		else
			$limite=$offset+20;

		$comilla= "'";

	?>

	<div class="row-fluid">
		<div class="span6">
			<div class="controls controls-row">
			    <div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambiarCorreos('inicial', 0)" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambiarCorreos('inicial', 0)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltrosCorreo()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
		<div class="span6" >
			<button class ="btn pull-right" onclick="eliminarCorreo() "><div class="btn_with_icon_solo">Ë</div> Eliminar seleccionados</button><br><br>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6" >
			
		</div>
		<div class="span6" >
			<input type="hidden" id="adjuntosEmailFisico" name="adjuntosEmailFisico" value="">
			<input type="hidden" id="adjuntosEmailLogico" name="adjuntosEmailLogico" value="">
			<ul id="pager" class="pager" style="text-align:right; margin:0px" >
				<span id="mostrando">  mostrando <?php echo ($offset+1)."-".$limite. " de: ".$cantidadCorreos; ?></span>
				<li id="ant" class="disabled" ><a href="#"><div class="btn_with_icon_solo"><</div></a></li>
				<?php 
				if ($limite<$cantidadCorreos) {
					?>
					<li id ="sig" onClick="cambiarCorreos('sig',<?php echo $offset; ?>)"><a href="#"><div class="btn_with_icon_solo">=</div></a></li>
					<?php
				}
				else {
					?>
					<li id ="sig" onClick="cambiarCorreos('sig',<?php echo $offset; ?>)" class="disabled"><a href="#"><div class="btn_with_icon_solo">=</div></a></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>

	<?php
		
		$attributes = array('onsubmit' => 'return evitarEnvioVacio()', 'id' => 'formu', 'name' => "formulario");
		echo form_open('Correo/EliminarCorreoRecibido', $attributes);
		
	?>
		<div class="row-fluid">
			<div class="span12" style="border:#cccccc 1px solid; height:400px; -webkit-border-radius: 4px;">
				<table id="listadoResultados" class="table table-hover">
					
					<!-- Acá va el tbody cargado por ajax -->

				</table>
			</div>
		</div>
		

		<!-- Modal de confirmación -->
		<div id="modalConfirmacion" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Confirmación</h3>
			</div>
			<div class="modal-body">
				<p>Se van a eliminar los correos seleccionados ¿Está seguro?</p>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
				<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
			</div>
		</div>

		<!-- Modal de no ha seleccionado a nadie -->
		<div id="modalSeleccioneAlgo" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>No ha seleccionado un correo</h3>
			</div>
			<div class="modal-body">
				<p>Por favor seleccione un correo para eliminar y vuelva a intentarlo</p>
			</div>
			<div class="modal-footer">
				<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
			</div>
		</div>

		<input type="hidden" id="seleccion" name="seleccion" value="">
	</form>
</fieldset>




<fieldset id="cuadroDetalleCorreo" style="display:none; " >
	<legend>Correos recibidos ::: detalles</legend>
	<div class="row-fluid">
		<div class="span6">
			Detalles del correo seleccionado
		</div>
		<div class="span6">
			<button class="btn pull-right" onclick="volverCorreosRecibidos()" ><div class="btn_with_icon_solo"><</div> Volver</button>
		</div>
		
	</div>
	</br>
	<pre class="detallesEmail">
<div class="pull-right">Fecha: <b  id="fecha"> </b>  <b class="pull-right" id="hora"></b></div>
  De:       <b id="de"></b>
  Asunto:   <b id="asuntoDetalle"></b>
  Adjuntos: <b  class="txt"  style="display:none;" id="destinosAdjuntos">Sin archivos adjuntos</b> <!--<div id="xxx" href="#" rel="details2"  class="btn btn_with_icon_solo" style="width: 15px; height: 15px; align:left;"><img src="/<?php echo config_item('dir_alias') ?>/img/icons/glyphicons_062_paperclip.png" alt=":" ></div>-->
<fieldset id="attach" style="display:none"><table id="files" class="files" style="height:auto;width:100%;"><tbody  style="height:auto;width:100%;"></tbody></table></fieldset>
  Cuerpo:<fieldset id="cuerpoMail" style=" min-height:250px;"></fieldset></pre>
</fieldset>
<script type="text/javascript">
/*
  $(document).ready(function() {
  	$("[rel=details]").tooltip({
  		placement : 'bottom', 
  		html: 'true', 
  		title : '<div style="text-color:white;"><strong>Muestra archivos adjuntos</strong></div>',
  		trigger:'hover',
  	});
  	
  });
  
    $(window).load(function() {
  	  $("[rel=details]").popover({
	placement : 'bottom', 
    content: get_popover_content,
    html: true,
    trigger: 'click'
});
  	
  });
  
function get_popover_content() {
	var fisicos = document.getElementById("adjuntosEmailFisico").value;
	var logicos = document.getElementById("adjuntosEmailLogico").value;
	var fisicos2 = new Array();
	var logicos2 = new Array();
	fisicos2 = fisicos.split("???");
	logicos2 = fisicos.split("???");
	content = '<table id="tablaX">'
	content2 = '';
	for (var i = 0; i < fisicos2.length; i++)
	{
		content2= content2 + '<a href="/manteka/adjuntos/' + fisicos2[i] + '">' + logicos2[i] + '</a><br>';
	}
	content = content2 + '</table>'
	return content;
}*/
</script>
