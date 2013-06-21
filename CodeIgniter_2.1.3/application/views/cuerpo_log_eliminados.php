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
			<table   class="table table-hover " style="cursor:pointer;overflow-y:scroll;margin-top:4px; margin-bottom:0px">
			<thead>	
			<tr class="info">
			<th width="5%" ></th>
			<th width="27%" >Nombre</th>
			<th width="27%" >Mensaje</th>
			<th width="8%" >Fecha</th>
			<th width="8%" >Hora</th>
			</tr>
		</thead>
			<tbody id="tabla">
				<tr>
				<td colspan="5"> No se encontraron resultados </td>
			</tr>
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
	showLogTipo('recibido');
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
 /**
 * Función que muestra las auditorías en la tabla de logs según el tipo especificado, ya sea correos recibidos, correos enviados o borradores, y en su defecto todos
 * @author Diego Gómez (DGL)
 * @param string tipo, tipo de auditoría que se desea mostrar
 */
 function showLogTipo(tipo){
 	$.ajax({
 		type: "POST",
 		url: "<?php echo site_url("Correo/postLogEliminados") ?>",
 		data: {tipo: tipo},
 		success: function(respuesta){
 			tablaResultados = document.getElementById('tabla');
 			//alert(respuesta);
 			listaLog = JSON.parse(respuesta);
 			if (listaLog.length == 0) {
 				$(tablaResultados).empty();
				tr = document.createElement('tr');
				td = document.createElement('td');
				$(td).html("No se encontraron resultados");
				$(td).attr('colspan',5);
				tr.appendChild(td);
				tablaResultados.appendChild(tr);
			}else{
 			$(tablaResultados).empty();
 			
 			var nodoTexto;
 			for(var i = 0; i<listaLog.length;i++){
 				var tr = document.createElement('tr');
 				td = document.createElement('td');
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto=document.createTextNode(listaLog[i][1].nombre+" "+listaLog[i][1].apellido1+" "+listaLog[i][1].apellido2);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i][0].asunto);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i][0].fecha);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				td = document.createElement('td');
 				nodoTexto = document.createTextNode(listaLog[i][0].hora);
 				td.appendChild(nodoTexto);
 				tr.appendChild(td);
 				tablaResultados.appendChild(tr);

 			}
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
<script>
if($(document).ready){
	showLogTipo('enviado');
}
</script>