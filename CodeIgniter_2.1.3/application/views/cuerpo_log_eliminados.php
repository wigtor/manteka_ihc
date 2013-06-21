<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" />

<fieldset id="cuadroLog">
	<legend>&nbsp;Registro de Eventos Eliminados&nbsp;</legend>
<ul class="nav nav-pills">
	<li class="active" id="enviados">
		<a href="#" onclick="logEnviados()">Correos enviados</a>
	</li>
	<li id="recibidos">
		<a href="#" onclick="logRecibidos()">Correos recibidos</a>
	</li>
	<li id="borradores">
		<a href="#" onclick="logBorradores()">Borradores</a>
	</li>
</ul>
	<form name="formulario" id="formul" method="post">
			<table width="98%" align="center" height="30px" class="table table-hover " style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-top:4px; margin-bottom:0px">
				
			<tr class="info">
			<td width="5%" ><b></b></td>
			<td width="27%" ><b>Nombre</b></td>
			<td width="27%" ><b>Mensaje</b></td>
			<td width="8%" ><b>Fecha</b></td>
			<td width="8%" ><b>Hora</b></td>
			</tr>
			<tbody id="tabla">
		</tbody>
		</table>
</form>
</fieldset>
<script> 
/**
* Esta función muestra el log de los borradores eliminados cambiando además 
* los botones según el log que se este mostrando
* @author Diego Gómez (DGL)
*/
function logBorradores(){
	$('#borradores').addClass('active');
	$('#recibidos').removeClass('active');
	$('#enviados').removeClass('active');
	showLogTipo('borrador');
}
</script>
<script> 
/**
* Esta función muestra el log de los correos recibidos que han sido eliminados cambiando además 
* los botones según el log que se este mostrando
* @author Diego Gómez (DGL)
*/
function logRecibidos(){
	$('#recibidos').addClass('active');
	$('#borradores').removeClass('active');
	$('#enviados').removeClass('active');
	showLogTipo('recibidos');
}
</script>
<script> 
/**
* Esta función muestra el log de los correos enviados que han sido eliminados cambiando además 
* los botones según el log que se este mostrando
* @author Diego Gómez (DGL)
*/
function logEnviados(){
	$('#enviados').addClass('active');
	$('#recibidos').removeClass('active');
	$('#borradores').removeClass('active');
	showLogTipo('enviado');
}
 </script>

 <script>
 function showLogTipo(tipo){
 	$.ajax({
 		type: "POST",
 		url: "<?php echo site_url("Correo/postLogEliminados") ?>",
 		data: {tipo: tipo},
 		success: function(respuesta){
 			tablaResultados = document.getElementById('tabla');
 			//alert(respuesta);
 			listaLog = JSON.parse(respuesta);
 			$(tablaResultados).empty();
 			
 			var nodoTexto;
 			for(var i = 0; i<listaLog.length;i++){
 				var tr = document.createElement('tr');
 				td = document.createElement('td');
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto=document.createTextNode(listaLog[i].nombre+" "+listaLog[i].apellido1+" "+listaLog[i].apellido2);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i].asunto);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i].fecha);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i].hora);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				tablaResultados.appendChild(tr);

 			}
 			var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
 		}
 	});
 	/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
 }
</script>
