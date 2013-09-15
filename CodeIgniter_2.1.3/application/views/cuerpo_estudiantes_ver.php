<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido", "Carrera", "Seccion"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+", "[A-Za-z]+", "([A-Za-z]+-{1}[0-9]+|[0-9]+|[A-Za-z]+)"];
	var prefijo_tipoDato = "estudiante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Estudiantes/getEstudiantesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/alumnos") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$("#icono_cargando").show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Estudiantes/getDetallesEstudianteAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				$('#rut').html($.trim(datos.rut));
				$('#nombre1').html($.trim(datos.nombre1));
				$('#nombre2').html((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$('#apellido1').html($.trim(datos.apellido1));
				$('#apellido2').html($.trim(datos.apellido2));
				$('#correo1').html(datos.correo1 == "" ? '' : $.trim(datos.correo1));
				$('#correo2').html(datos.correo2 == "" ? '' : $.trim(datos.correo2));
				$('#telefono').html(datos.telefono == "" ? '' : $.trim(datos.telefono));
				$('#carrera').html(datos.carrera == "" ? '' : $.trim(datos.carrera));
				$('#seccion').html(datos.seccion == "" ? '' : $.trim(datos.seccion));

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
			<legend>Ver Estudiante</legend>
			<div class= "row-fluid">
				<div class="span6">
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
				<div class="span6" >
					1.- Seleccione un estudiante para ver sus detalles:
				</div>
				<div class="span6" >
					2.- Detalle estudiante:
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" style="border:#cccccc 1px solid; overflow-x:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover" style="width:600px !important; max-width:600px;">
					</table>
				</div>
				<div class="span6">
					<pre style="padding: 2%">
Rut:              <b id="rut"></b>
Nombres:          <b id="nombre1"></b> <b id="nombre2" ></b>
Apellido paterno: <b id="apellido1" ></b>
Apellido materno: <b id="apellido2"></b>
Teléfono:         <b id="telefono" ></b>
Correo:           <b id="correo1"></b>
Correo secundario:<b id="correo2" ></b>
Carrera:          <b id="carrera" ></b>
Sección:          <b id="seccion"></b></pre>
				</div>
			</div>
		</fieldset>

