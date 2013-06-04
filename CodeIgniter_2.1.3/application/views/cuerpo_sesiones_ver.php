<script>
	function detalleSesion(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		cod_clickeado = idElem.substring("sesion_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Sesiones/postDetallesSesiones") ?>", /* Se setea la url del controlador que responderá */
			data: { codigo: cod_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var codigoDetalle = document.getElementById("codigoDetalle");
				var nombreDetalle = document.getElementById("nombreDetalle");
				var fechaDetalle = document.getElementById("fechaDetalle");
				var descripcionDetalle = document.getElementById("descripcionDetalle");		
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(coddigoDetalle).html(datos.codigo);
				$(nombreDetalle).html(datos.nombre);
				$(fechaDetalle).html(datos.fecha);
				$(descripcionDetalle).html(datos.descripcion);
			

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
		//if (texto.trim() != "") {
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Sesiones/postBusquedaSesiones") ?>", /* Se setea la url del controlador que responderá */
				data: { textoFiltro: texto, tipoFiltro: valorSelector}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var tablaResultados = document.getElementById("listadoResultados");
					var nodoTexto;
					$(tablaResultados).empty();
					var arrayRespuesta = jQuery.parseJSON(respuesta);
					for (var i = 0, tr, td; i < arrayRespuesta.length; i++) {
						tr = document.createElement('tr');
						td = document.createElement('td');
						tr.setAttribute("id", "sesion_"+arrayRespuesta[i].codigo);
						tr.setAttribute("onClick", "detalleAlumno(this)");
						nodoTexto = document.createTextNode(arrayRespuesta[i].codigo);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
					}
					/*
					for (var i = 0, option, td; i < arrayRespuesta.length; i++) {
						option =  document.createElement('option');
						nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
						option.setAttribute("value", arrayRespuesta[i].rut);
						option.setAttribute("onClick", "detalleAlumno(this.value)");
						option.appendChild(nodoTexto);
						tablaResultados.appendChild(option);
					}
					*/

					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					}
			});

			/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
		//}
	}

	//Se cargan por ajax
	$(document).ready(cambioTipoFiltro);
</script>
<fieldset>
	<legend>Sesiones</legend>

	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado de Sesiones
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
								<option value="1">Filtrar por codigo de sesión</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			
			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<b>Codigo sesión</b>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
			2.-Detalle sesión:
			<pre style="margin-top: 2%; padding: 2%">
Codigo sesión:              <b id="codigoDetalle"></b>
Nombre del modulo temático:          <b id="nombreDetalle"></b>
Fecha: <b id="fechaDetalle" ></b>
Descripción: <b id="descripcionDetalle"></b>
			</pre>
		</div>
	</div>

</fieldset>