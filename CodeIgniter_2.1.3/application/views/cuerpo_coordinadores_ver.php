<?php
/**
* Este Archivo corresponde al cuerpo central de la vista ver coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>

<script>
	function detalleCoordinador(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("coordinador_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/postDetallesCoordinador") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombre1Detalle");
				var nombre2Detalle = document.getElementById("nombre2Detalle");
				var apellido1Detalle = document.getElementById("apellido1Detalle");
				var apellido2Detalle = document.getElementById("apellido2Detalle");
				var moduloDetalle = document.getElementById("moduloDetalle");
				var fonoDetalle = document.getElementById("fonoDetalle");
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
				$(moduloDetalle).html(datos.modulo);
				$(fonoDetalle).html(datos.fono);
				$(seccionesDetalle).html(datos.secciones);
				$(correoDetalle).html(datos.correo);

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
		var selectorFiltro = document.getElementById('tipoDeFiltro');
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/postBusquedacoordinadores") ?>", /* Se setea la url del controlador que responderá */
			data: { textoFiltro: texto, tipoFiltro: valorSelector}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultados");
				var nodoTexto;
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				for (var i = 0, tr, td; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "coordinador_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "detalleCoordinador(this)");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	//Se cargan por ajax
	$(document).ready(cambioTipoFiltro);

</script>

<fieldset>
	<legend>Ver coordinadores</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado coordinadores
				</div>
			</div>
			<div class="row-fluid">
				<div class="span11">
					<div class="row-fluid">
						<div class="span6">
							<input id="filtroLista" type="text" onChange="cambioTipoFiltro()" placeholder="Filtro búsqueda" style="width:90%">
						</div>
						<div class="span6">
							<select id="tipoDeFiltro" onChange="cambioTipoFiltro()" title="Tipo de filtro" name="Filtro a usar">
								<option value="1">Filtrar por nombre</option>
								<option value="2">Filtrar por apellido paterno</option>
								<option value="3">Filtrar por apellido materno</option>
								<option value="4">Filtrar por módulo temático</option>
								<option value="5">Filtrar por seccion</option>
								<option value="6">Filtrar por bloque horario</option>
							</select> 
						</div>
					</div>
				</div>
			</div>

			
			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<b>Nombre Completo</b>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle coordinador:
	    <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombre1Detalle"></b> <b id="nombre2Detalle" ></b>
Apellido paterno: <b id="apellido1Detalle" ></b>
Apellido materno: <b id="apellido2Detalle"></b>
Módulo temático:  <b id="moduloDetalle"></b>
Fono:             <b id="fonoDetalle" ></b>
Secciones:        <b id="seccionesDetalle"></b>
Correo:           <b id="correoDetalle"></b>
		</pre>
		</div>
	</div>
</fieldset>
