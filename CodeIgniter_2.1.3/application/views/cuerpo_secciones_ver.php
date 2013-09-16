<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/getSeccionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";

	function verDetalle(elemTabla){
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var cod_seccion = idElem.substring(prefijo_tipoDato.length, idElem.length);

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getDetallesSeccionAjax") ?>",
			data: { seccion: cod_seccion },
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				$('#id_seccion').val($.trim(datos.id_seccion));

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#nombre_seccion').html($.trim(datos.seccion));
				$('#modulo_tematico').html($.trim(datos.modulo));
				$('#dia').html((datos.dia == "" ? 'Sin asignación' : $.trim(datos.dia)));
				$('#modulo').html((datos.modulo_horario == "" ? 'Sin asignación' : $.trim(datos.modulo_horario)));

				/* Quito el div que indica que se está cargando */
				//$('#icono_cargando').hide();
			}
		});

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getEstudiantesBySeccionAjax") ?>",
			data: { seccion: cod_seccion},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultadosEstudiantes");
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);

				
				//CARGO EL CUERPO DE LA TABLA
				tbody = document.createElement('tbody');
				if (arrayRespuesta.length == 0) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					$(td).html("No se encontraron resultados");
					$(td).attr('colspan',tiposFiltro.length);
					tr.appendChild(td);
					tbody.appendChild(tr);
				}

				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					tr.setAttribute('style', "cursor:default"); //No es clickeable

					//Primera columna
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].carrera);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					//Segunda columna
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].rut);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					//Tercera columna
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].apellido1);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					//Cuarta columna
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].apellido2);
					td.appendChild(nodoTexto);
					tr.appendChild(td);

					//Quinta columna
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 + " " +(arrayRespuesta[i].nombre2 == null ? '' : arrayRespuesta[i].nombre2));
					td.appendChild(nodoTexto);
					tr.appendChild(td);
			

					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();

				
				$('tbody tr').on('click', function(event) {
					$(this).addClass('highlight').siblings().removeClass('highlight');
				});
			}
		});
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<fieldset>
<legend>Ver Sección</legend>
	<div class= "row-fluid">
		<div class="span5">
			<div class="controls controls-row">
				<div class="input-append span7">
					<input id="filtroLista" class="span9" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5" >
			1.- Seleccione una sección para ver sus detalles:
		</div>
		<div class="span7" >
			2.- Detalle sección:
		</div>
	</div>

	<div class="row-fluid">
		<div class="span5" style="border:#cccccc 1px solid; overflow-y:scroll; overflow-x:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover" style="max-width:600px;">
			</table>
		</div>

		<div class="span7">
			<pre style="margin-top: 0%; margin-left: 0%;">
Sección:         <b id="nombre_seccion"></b>
Módulo temático: <b id="modulo_tematico"></b>
Día:             <b id="dia"></b>
Bloque:          <b id="modulo_horario"></b></pre>
		
			<input name="id_seccion" type="hidden" id="id_seccion" value="">
		
			<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
				<table id="listadoResultadosEstudiantes" class="table table-bordered">
					<thead  bgcolor="#e6e6e6"  style="position:block">
						<tr>
							<th class="span2">Carrera</th>
							<th class="span2">RUT</th>
							<th class="span3">Apellido paterno</th>
							<th class="span3">Apellido materno</th>
							<th class="span9">Nombres</th>
						</tr>
					</thead>
					
					<tbody>
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</fieldset>
