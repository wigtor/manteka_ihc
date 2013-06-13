
<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Ayudantes/postDetallesAyudante") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombre1Detalle");
				var nombre2Detalle = document.getElementById("nombre2Detalle");
				var apellido1Detalle = document.getElementById("apellido1Detalle");
				var apellido2Detalle = document.getElementById("apellido2Detalle");
				var profesorDetalle = document.getElementById("profesorDetalle");
				var seccionesDetalle = document.getElementById("seccionesDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(nombre1Detalle).html(datos.nombre1);
				$(nombre2Detalle).html(datos.nombre2);
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				if (datos.nombre1_profe == null) {
					datos.nombre1_profe = '';
				}
				if (datos.nombre2_profe == null) {
					datos.nombre2_profe = '';
				}
				if (datos.apellido1_profe == null) {
					datos.apellido1_profe = '';
				}
				if (datos.apellido2_profe == null) {
					datos.apellido2_profe = '';
				}
				
				var nombre_completo_profe = datos.nombre1_profe+ " " +datos.nombre2_profe+  " " +datos.apellido1_profe+ " " +datos.apellido2_profe; 
				$(profesorDetalle).html(nombre_completo_profe);
				var secciones = "";
				/* Esto no se implementa puesto no hay forma de relacionar un ayudante con una sección aún
				for (var i = 0; i < datos.secciones.length; i++) {
					secciones = secciones + ", " + datos.secciones[i];
				}
				*/
				$(seccionesDetalle).html(secciones);
				$(correoDetalle).html($.trim(datos.correo));

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}


	function cambioTipoFiltro() {
		//var selectorFiltro = document.getElementById('tipoDeFiltro');
		var inputTextoFiltro = document.getElementById('filtroLista');
		//var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;
		var valorFiltrosJson = new Array();
		for (var i = 0; i < tiposFiltro.length; i++) {
			valorTemp = document.getElementById(prefijo_tipoFiltro + i); //Obtengo el input de cada filtro
			if (valorTemp == null) {
				valorTemp = "";
			}
			else {
				valorTemp = $.trim(valorTemp.value);
			}
			valorFiltrosJson[i] = valorTemp; //Agrego la palabra del filtro en la posición i-esima
		}

		/*
		var valorFiltrosJson = "["; var valorTemp;
		for (var i = 0; i < tiposFiltro.length; i++) {
			valorTemp = document.getElementById(prefijo_tipoFiltro + i); //Obtengo el input de cada filtro
			if (valorTemp == null) {
				valorTemp = "\"\"";
			}
			else {
				valorTemp = "\""+$.trim(valorTemp.value)+"\"";
			}
			valorFiltrosJson += valorTemp; //Agrego la palabra del filtro en la posición i-esima
			if (i != (tiposFiltro.length -1)) {
				valorFiltrosJson += ", ";
			}
		}
		valorFiltrosJson += "]";
		*/

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>", /* Se setea la url del controlador que responderá */
			data: { textoFiltroBasico: texto, textoFiltrosAvanzados: valorFiltrosJson}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultados");
				$(tablaResultados).find('tbody').remove();
				var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
				var arrayRespuesta = new Array();
				for (var i = 0; i < arrayObjectRespuesta.length; i++) {
					arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) {
						return value;
					});
				}

				
				//CARGO EL CUERPO DE LA TABLA
				tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:pointer");

					for (var j = 0; j < tiposFiltro.length; j++) {
						td = document.createElement('td');
						tr.setAttribute("id", prefijo_tipoDato+arrayObjectRespuesta[i].rut); //Da lo mismo en este caso los id repetidos en los div
						tr.setAttribute("onClick", "verDetalle(this)");
						nodoTexto = document.createTextNode(arrayRespuesta[i][j]);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
					}

					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	

	function getDataSource(inputUsado) {
		
	    $(inputUsado).typeahead({
	        minLength: 1,
	        source: function(query, process) {
	        	$.ajax({
		        	type: "POST", /* Indico que es una petición POST al servidor */
					url: "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>", /* Se setea la url del controlador que responderá */
					data: { letras : query }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
					success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
		            	//alert(respuesta)
		            	var arrayRespuesta = jQuery.parseJSON(respuesta);
		            	arrayRespuesta[arrayRespuesta.length] = query;
		            	process(arrayRespuesta);
		            }
	        	});
	        }
	    });
	}

	
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro();
	});

</script>

<fieldset>
	<legend>Ver ayudantes</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado ayudantes
			<div class="controls controls-row">
			    <div class="input-append span6">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro()" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambioTipoFiltro()" type="button"><i class="icon-search"></i></button>
				</div>
				
				<!--
				<select class="span6" id="tipoDeFiltro" onChange="cambioTipoFiltro()" title="Tipo de filtro" name="Filtro a usar">
					<option value="1">Filtrar por nombre</option>
					<option value="2">Filtrar por apellido paterno</option>
					<option value="3">Filtrar por apellido materno</option>
					<option value="4">Filtrar por correo electrónico</option>
				</select>
				-->
			</div>

			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle ayudante:
	    <pre style="margin-top: 2%; padding: 2%; cursor:default">
Rut:                <b id="rutDetalle"></b>
Nombres:            <b id="nombre1Detalle"></b> <b id="nombre2Detalle"></b>
Apellido paterno:   <b id="apellido1Detalle"></b>
Apellido materno:   <b id="apellido2Detalle"></b>
Correo:             <b id="correoDetalle"></b>
Profesor guía:      <b id="profesorDetalle"></b>
Secciones:          <b id="seccionesDetalle"></b>
		</pre>
		</div>
	</div>
</fieldset>