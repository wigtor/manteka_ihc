<script>

	var tiposFiltro = ["Rut", "Nombre", "Apellido", "Módulo temático", "Sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+", "", ""];
	var prefijo_tipoDato = "profesor_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Profesores/getProfesoresAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/profesores") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var rut_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Profesores/getDetallesProfesorAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#rut').html($.trim(datos.rut));
				$('#nombre1').html($.trim(datos.nombre1));
				$('#nombre2').html((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$('#apellido1').html($.trim(datos.apellido1));
				$('#apellido2').html($.trim(datos.apellido2));
				$('#correo1').html(datos.correo1 == "" ? '' : $.trim(datos.correo1));
				$('#correo2').html(datos.correo2 == "" ? '' : $.trim(datos.correo2));
				$('#telefono').html(datos.telefono == "" ? '' : $.trim(datos.telefono));
				$('#tipo_profesor').html($.trim(datos.tipo_profesor));
				$('#moduloTematico').html(datos.moduloTematico == "" ? '' : $.trim(datos.moduloTematico));

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


<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">Ver Profesor</h4>
	</div>
	<div class="panel-body">
		
		<div class="row">
			<div class="col-md-6">
				<div class="input-group col-md-9">
					<input id="filtroLista" class="form-control" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
					<span class="input-group-btn">
						<button class="btn btn-default" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
				<div class="col-md-3">
					<button class="btn btn-default btn-xs" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><span class="caca-clear-filters"></span></button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-7" >
				<p>1.- Seleccione un profesor para ver sus detalles:</p>
			</div>
			<div class="col-md-5" >
				<p>2.- Detalle profesor:</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-7">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="table-responsive" style="overflow-y:scroll;">
							<table id="listadoResultados" class="table table-striped">
								<thead>
									
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<dl>
					<dt>Rut:</dt>
					<dd id="rut"></dd>

					<dt>Nombres:</dt>
					<dd><span id="nombre1"></span> <span id="nombre2"></span></dd>

					<dt>Apellidos:</dt>
					<dd><span id="apellido1"></span> <span id="apellido2"></span></dd>

					<dt>Telefono:</dt>
					<dd id="telefono"></dd>

					<dt>Correo:</dt>
					<dd id="correo1"></dd>

					<dt>Correo secundario:</dt>
					<dd id="correo2"></dd>

					<dt>Tipo de profesor:</dt>
					<dd id="tipo_profesor"></dd>

					<dt>Módulo temático:</dt>
					<dd id="moduloTematico"></dd>
				</dl>

			</div>
		</div>
	</div>
</div>




