<script type="text/javascript">
	var tiposFiltro = ["Numero", "Capacidad", "Ubicación", "Implementos"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", ""];
	var inputAllowedFiltro= ["[0-9]{3}", "[0-9]+", "", ""];
	var prefijo_tipoDato = "sala_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Salas/getSalasAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/salas") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		sala_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("Salas/getDetallesSalaAjax") ?>",
			data: { num_sala: sala_clickeado }, 
			success: function(respuesta) { 
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#num_sala').html((datos.num_sala == "" ? '' : $.trim(datos.num_sala)));
				$('#capacidad').html((datos.capacidad == "No especificada" ? '' : $.trim(datos.capacidad)));
				$('#ubicacion').html((datos.ubicacion == "No especificada" ? '' : $.trim(datos.ubicacion)));
				$('#implementos').html((datos.implementos == "No especificados" ? '' : $.trim(datos.implementos)));

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
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
	<legend>Ver Sala</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="controls controls-row">
			    <div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			1.- Seleccione una sala para ver sus detalles:
		</div>
		<div class="span6">
			2.- Detalle de la sala:
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover">
				<thead>
					
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div class="span6">
  		<pre style="padding: 2%; cursor:default">
Número sala:    <b id="num_sala"></b>
Capacidad:      <b id="capacidad" ></b>
Ubicación:      <b id="ubicacion"></b>
Implementos:    <div style="display: inline-block; vertical-align: top;" id="implementos"></div></pre>

		</div>

	</div>
</fieldset>