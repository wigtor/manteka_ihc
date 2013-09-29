

<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var inputAllowedFiltro = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/getseccionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";

	function seccionOrigenSeleccionada(elemTabla) {
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

				//$('#id_seccion').val($.trim(datos.id_seccion));

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#nombreSeccionOrigen').html($.trim(datos.seccion));
				/*
				$('#modulo_tematico').html($.trim(datos.modulo));
				$('#profesor').html(datos.apellido1 == '' ? 'Sin asignación' : $.trim(datos.nombre1) + ' ' + $.trim(datos.apellido1));
				$('#dia').html(datos.dia == '' ? 'Sin asignación' : $.trim(datos.dia));
				$('#modulo_horario').html(datos.horario == "" ? 'Sin asignación' : $.trim(datos.horario));
				$('#hora').html(datos.hora_clase == "" ? 'Sin asignación' : $.trim(datos.hora_clase));
				*/
				cargarSeccionesMismoModulo(datos.id_seccion);
				limpiarListaEstudiantesSeccionDestino();

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function cargarSeccionesMismoModulo(idSeccion) {
		alert("cargando secciones del mismo módulo");
	}

	function cargarAlumnosSeccion(idSeccion) {
		
	}

	function limpiarListaEstudiantesSeccionDestino() {
		
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable('listadoResultados');
		escribirHeadTable('listadoResultados2');
		cambioTipoFiltro(undefined, 'listadoResultados', 'filtroLista', "seccionOrigenSeleccionada(this)");
	});

</script>





<fieldset>
	<legend>Cambio de sección</legend>
	<?php
		$attributes = array('id' => 'formS1');
		echo form_open("Estudiantes/postCambiarSeccionEstudiantes/", $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<div class="controls controls-row">
					<div class="input-append span7">
						<input id="filtroLista" class="span9" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
						<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
					</div>
					<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
				</div>
			</div>

			<div class="span6">
				<div class="controls controls-row">
					<div class="input-append span7">
						<input id="filtroLista2" class="span9" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
						<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
					</div>
					<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6" >
				1.- Seleccione una sección de origen
			</div>
			<div class="span6" >
				2.- Seleccione una sección de destino
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:300px; -webkit-border-radius: 4px;">
				<table id="listadoResultados" class="table table-hover">
					<thead>
						
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:300px; -webkit-border-radius: 4px;">
				<table id="listadoResultados2" class="table table-hover">
					<thead>
						
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<br>

		<div class="row-fluid">
			<div class="span5">
				3.- Estudiantes de la sección de origen <div id="nombreSeccionOrigen"></div>
			</div>
			<div class="span5 offset2">
				Estudiantes de la sección de destino <div id="nombreSeccionDestino"></div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span5">
				<select required id="id_alumnos" size="10" name="id_alumnos[]" class="span12" title="Seleccione los alumnos a cambiar de sección" multiple="multiple">
					
				</select>
			</div>
			<div class="span2">
				<button class="btn" type="submit">
					<i class="icon-chevron-right"></i>
					Mover estudiantes
				</button>
			</div>
			<div class="span5">
				<select required id="id_alumnos2" size="10" class="span12" title="Alumnos de la sección de destino" multiple="multiple" >
					
				</select>
			</div>
		</div>

		<?php echo form_close(""); ?>
</fieldset>
