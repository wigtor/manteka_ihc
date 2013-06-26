<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/postBusquedaSecciones") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";


	function verDetalle(elemTabla){
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var cod_seccion = idElem.substring(prefijo_tipoDato.length, idElem.length);

			/* Defino el ajax que hará la petición al servidor */
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Secciones/postVerSeccion") ?>", /* Se setea la url del controlador que responderá */
				data: { seccion: cod_seccion }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */


				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					//console.log (respuesta);
					/* Obtengo los objetos HTML donde serán escritos los resultados */
					var seccion = document.getElementById("nombre_seccion");
					var modulo = document.getElementById("modulo");
					var dia = document.getElementById("dia");
					
					document.getElementById("codSeccion").value = cod_seccion;
					
					/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
					var datos = jQuery.parseJSON(respuesta);

					/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
					seccion.innerHTML = datos[0];
					modulo.innerHTML = datos[1];
					dia.innerHTML = datos[2];
					

					if (datos[1] == null){
						modulo.innerHTML= "sin asignación";
					}
					if(datos[2]==null){
						dia.innerHTML = "sin asignación";
						
					}
					/*Para el caso de que se presione el botón Cancelar*/
					if (cod_seccion==""){
						seccion.innerHTML = "";
						modulo.innerHTML = "";
						dia.innerHTML = "";

					}

					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();

					$('tbody tr').on('click', function(event) {
					$(this).addClass('highlight').siblings().removeClass('highlight');
			});

				}
		}
		);

		$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: "<?php echo site_url("Secciones/AlumnosSeccion") ?>", // Se setea la url del controlador que responderá */
		data: { seccion: cod_seccion}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
			var tablaResultados = document.getElementById("listadoResultadosAlumnos");
			//var indicador = document.getElementById("ind");
			$(tablaResultados).find('tbody').remove();
			var arrayRespuesta = jQuery.parseJSON(respuesta);

			
			
			//CARGO EL CUERPO DE LA TABLA
			tbody = document.createElement('tbody');
			

			for (var i = 0; i < arrayRespuesta.length; i++) {
				tr = document.createElement('tr');
				tr.setAttribute('style', "cursor:default");
				for (var j = 0; j < 5; j++) {
					td = document.createElement('td');
					//tr.setAttribute("onClick", "verDetalle(this)");
					if(j==4){
						nodoTexto = document.createTextNode(arrayRespuesta[i][j]+" "+arrayRespuesta[i][j+1]);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						j=j+6;
					}
					else{

						nodoTexto = document.createTextNode(arrayRespuesta[i][j]);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
					}
				}
		

				tbody.appendChild(tr);
			}
			tablaResultados.appendChild(tbody);

			/* Quito el div que indica que se está cargando */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();

			
			$('tbody tr').on('click', function(event) {
				$(this).addClass('highlight').siblings().removeClass('highlight');
			});

			
		}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	function resetSecciones() {
		$('#codSeccion').val('');
		$('#listadoResultadosAlumnos').find('tbody').remove();
		$('#nombre_seccion').html('');
		$('#modulo').html('');
		$('#dia').html('');
		$('#listadoResultados tbody tr').removeClass('highlight');
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
	
</script>

<script type="text/javascript">
	function eliminarSeccion(){
		var cod=document.getElementById("codSeccion").value;
		
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/AlumnosSeccion") ?>", // Se setea la url del controlador que responderá */
			data: { seccion: cod}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var arrayRespuesta = jQuery.parseJSON(respuesta);

				if(cod=="") {
					$('#modalSeleccioneAlgo').modal();
					return;
				}
				else{
					if (arrayRespuesta!= ""){
						$('#modalNoEliminacion').modal();
						
					}
					else{
						$('#modalConfirmacion').modal();
					}
				}
			}
		});
	}
</script>

<fieldset>
<legend>Borrar Sección</legend>
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
			1.-Listado secciones:
		</div>
		<div class="span7" >
			2.-Detalle sección:
		</div>
	</div>

	<div class="row-fluid">
		<div class="span5" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover" style="max-width:600px;">
			</table>
		</div>

		<div class="span7">
			<?php
				$atributos= array('onsubmit' => 'return eliminarAsignacion()', 'id' => 'formBorrar');
				echo form_open('Secciones/eliminarSecciones/', $atributos);
			?>
			<pre style="margin-top: 0%; margin-left: 0%;">
Sección: <b id="nombre_seccion"></b>
Día:     <b id="dia"></b>
Bloque:  <b id="modulo"></b></pre>
		
			<input name="cod_seccion" type="hidden" id="codSeccion" value="">
		
			<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
				<table id="listadoResultadosAlumnos" class="table table-bordered">
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

			<div class="control-group">
				<div class="controls pull-right">
					<button class ="btn" type="button" onclick="eliminarSeccion()" >
						<i class= "icon-trash"></i>
						&nbsp; Eliminar
					</button>
					<button class ="btn" type="reset" onclick="resetSecciones()"  >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>
				</div>

				<div id="modalConfirmacion" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Confirmación</h3>
					</div>
					<div class="modal-body">
						<p>Se va a eliminar la sección seleccionada ¿Está seguro?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
						<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
						
					</div>
				</div>

				<!-- Modal de seleccionaAlgo -->
				<div id="modalSeleccioneAlgo" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>No ha seleccionado ninguna sección</h3>
					</div>
					<div class="modal-body">
						<p>Por favor seleccione una sección y vuelva a intentarlo</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

				<!-- Modal de noEliminacion -->
				<div id="modalNoEliminacion" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>No se pudo eliminar</h3>
					</div>
					<div class="modal-body">
						<p>La sección tiene alumnos asignados. Por favor seleccione una sección y vuelva a intentarlo</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
			<?php echo form_close(''); ?>
		</div>
	</div>
</fieldset>
