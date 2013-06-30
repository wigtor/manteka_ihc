<script type="text/javascript">
	var tiposFiltro = ["Numero", "Capacidad", "Implementos"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro= ["[0-9]{3}", "", ""];
	var prefijo_tipoDato = "sala_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Salas/postBusquedaSalas") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/salas") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		sala_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/postDetallesSala") ?>", /* Se setea la url del controlador que responderá */
			data: { num_sala: sala_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var numSala = document.getElementById("num_sala");
				var capacidad = document.getElementById("capacidad");
				var ubicacion = document.getElementById("ubicacion");
				var impl = document.getElementById("impDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				if (datos.capacidad == null) {
					datos.capacidad = '';
				}

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(numSala).html(datos.num_sala);
				$(capacidad).html($.trim(datos.capacidad));
				$(ubicacion).html($.trim(datos.ubicacion));

				/*	Setear los Implementos	*/
				var length = datos.implementos.length,
					elemento = null, salidaImp = "";
				if (length == 0)
					salidaImp = "<b>No posee</b>";
				for(var i=0; i<length; i++){
					imp = datos.implementos[i];
					salidaImp += '<b title=\"'+imp["descr_implemento"]+'\">'+imp["nombre_implemento"] + "\n</b>"; 
				}
				
				$(impl).html(salidaImp);
				

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
Implementos:    <div style="display: inline-block; vertical-align: top;" id="impDetalle"></div></pre>

		</div>

	</div>
</fieldset>