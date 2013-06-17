
<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>";

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

				if (datos.nombre1 == null) {
					datos.nombre1 = '';
				}
				if (datos.nombre2 == null) {
					datos.nombre2 = '';
				}
				if (datos.apellido1 == null) {
					datos.apellido1 = '';
				}
				if (datos.apellido2 == null) {
					datos.apellido2 = '';
				}

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(nombre1Detalle).html($.trim(datos.nombre1));
				$(nombre2Detalle).html($.trim(datos.nombre2));
				$(apellido1Detalle).html($.trim(datos.apellido1));
				$(apellido2Detalle).html($.trim(datos.apellido2));
				
				
				var nombre_completo_profe = $.trim(datos.nombre1_profe)+ " " +$.trim(datos.nombre2_profe)+  " " +$.trim(datos.apellido1_profe)+ " " +$.trim(datos.apellido2_profe); 
				$(profesorDetalle).html(nombre_completo_profe);
				var secciones = "";
				/* Esto no se implementa puesto no hay forma de relacionar un ayudante con una sección aún
				for (var i = 0; i < datos.secciones.length; i++) {
					secciones = secciones + ", " + datos.secciones[i];
				}
				*/
				$(seccionesDetalle).html($.trim(secciones));
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
	
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<fieldset>
	<legend>Ver ayudantes</legend>
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
		<div class="span6" >
			1.-Listado ayudantes
		</div>
		<div class="span6" >
			2.-Detalle ayudante:
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
Rut:                <b id="rutDetalle"></b>
Nombres:            <b id="nombre1Detalle"></b> <b id="nombre2Detalle"></b>
Apellido paterno:   <b id="apellido1Detalle"></b>
Apellido materno:   <b id="apellido2Detalle"></b>
Correo:             <b id="correoDetalle"></b>
Profesor guía:      <b id="profesorDetalle"></b>
Secciones:          <b id="seccionesDetalle"></b></pre>
		</div>
	</div>
</fieldset>
