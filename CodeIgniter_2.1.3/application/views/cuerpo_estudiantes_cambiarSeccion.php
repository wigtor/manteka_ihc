

<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var inputAllowedFiltro = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/getseccionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";

	function seccionOrigenSeleccionada(selector) {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = selector.value;

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getDetallesSeccionAjax") ?>",
			data: { seccion: idElem },
			success: function(respuesta) {
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#nombreSeccionOrigen').html($.trim(datos.seccion));
				cargarSeccionesMismoModulo(datos.id_seccion);
				cargarAlumnosSeccion(datos.id_seccion, "id_alumnos", true);
				$("#id_alumnos2").empty();

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function seccionDestinoSeleccionada(selector) {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = selector.value;

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getDetallesSeccionAjax") ?>",
			data: { seccion: idElem },
			success: function(respuesta) {
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#nombreSeccionDestino').html($.trim(datos.seccion));
				cargarAlumnosSeccion(datos.id_seccion, "id_alumnos2", false);

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function cargarAllSecciones() {
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getseccionesAjax") ?>",
			data: { textoFiltroBasico: "", textoFiltrosAvanzados: ""},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				$("#selectSeccionOrigen").empty();
				var opcionDefault;
				if (arrayRespuesta.length == 0) {
					opcionDefault = new Option("No hay secciones registradas en el sistema", "");
				}
				else {
					opcionDefault = new Option("Seleccione sección", "");
				}
				opcionDefault.setAttribute("disabled","disabled");
				opcionDefault.setAttribute("selected","selected");
				$("#selectSeccionOrigen").append(opcionDefault);

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$("#selectSeccionOrigen").append(new Option(arrayRespuesta[i].nombre, arrayRespuesta[i].id));
				}
				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function cargarSeccionesMismoModulo(idSeccion) {
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getSeccionesSameModuloTematicoAjax") ?>",
			data: { seccion: idSeccion},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				$('#selectSeccionDestino').empty();
				var opcionDefault;
				if (arrayRespuesta.length == 0) {
					opcionDefault = new Option("No hay secciones de destino posibles", "");
				}
				else {
					opcionDefault = new Option("Seleccione la sección de destino", "");
				}
				opcionDefault.setAttribute("disabled","disabled");
				opcionDefault.setAttribute("selected","selected");
				$('#selectSeccionDestino').append(opcionDefault);

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$('#selectSeccionDestino').append(new Option(arrayRespuesta[i].nombre, arrayRespuesta[i].id));
				}

			}
		});
	}

	function cargarAlumnosSeccion(idSeccion, idSelectElementHTML, cargarAccionDefault) {
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getEstudiantesBySeccionAjax") ?>",
			data: { seccion: idSeccion},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				$('#'+idSelectElementHTML).empty();
				var opcionDefault;
				if (arrayRespuesta.length == 0) {
					opcionDefault = new Option("La sección no tiene estudiantes", "");
					opcionDefault.setAttribute("disabled","disabled");
					opcionDefault.setAttribute("selected","selected");
					$('#'+idSelectElementHTML).append(opcionDefault);
				}
				else {
					if (cargarAccionDefault == true) {
						opcionDefault = new Option("Seleccione los estudiantes a cambiar de sección", "");
						opcionDefault.setAttribute("disabled","disabled");
						opcionDefault.setAttribute("selected","selected");
						$('#'+idSelectElementHTML).append(opcionDefault);
					}
				}

				for (var i = 0; i < arrayRespuesta.length; i++) {
					$('#'+idSelectElementHTML).append(new Option(arrayRespuesta[i].rut+"-"+arrayRespuesta[i].nombre1+" "+arrayRespuesta[i].apellido1, arrayRespuesta[i].rut));
				}
			}
		});
	}

	//Se cargan por ajax
	$(document).ready(function() {
		cargarAllSecciones();
	});

</script>





<fieldset>
	<legend>Cambio de sección</legend>
	<?php
		$attributes = array('id' => 'formS1');
		echo form_open("Estudiantes/postCambiarSeccionEstudiantes/", $attributes);
	?>
		<div class="row-fluid">
			<div class="span6" >
				1.- Seleccione una sección de origen
			</div>
			<div class="span6" >
				2.- Seleccione una sección de destino
			</div>
		</div>
		<div class="row-fluid">
			<div class="span5">
				<select required id="selectSeccionOrigen" name="selectSeccionOrigen" class="span12" onchange="seccionOrigenSeleccionada(this)" title="Seleccione la sección de origen">
					
				</select>
			</div>
			<div class="span5 offset2">
				<select required id="selectSeccionDestino" name="selectSeccionDestino" class="span12" onchange="seccionDestinoSeleccionada(this)" title="Seleccione la sección de destino">
					
				</select>
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
				<select id="id_alumnos2" size="10" class="span12" title="Alumnos de la sección de destino" >
					
				</select>
			</div>
		</div>

		<?php echo form_close(""); ?>
</fieldset>
