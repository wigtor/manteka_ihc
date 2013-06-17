<script type="text/javascript">
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>";

	function editarAyudante(){
		rutAEditar = $("#rutEditar").val();
		if(rutAEditar == ""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		$('#modalConfirmacion').modal();
	}
	
	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("ayudante_".length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Ayudantes/postDetallesAyudante") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutEditar");
				var nombre1Detalle = document.getElementById("nombreunoEditar");
				var nombre2Detalle = document.getElementById("nombredosEditar");
				var apellido1Detalle = document.getElementById("apellidopaternoEditar");
				var apellido2Detalle = document.getElementById("apellidomaternoEditar");
				var correoDetalle = document.getElementById("correoEditar");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
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
				$(rutDetalle).val($.trim(datos.rut));
				$(nombre1Detalle).val(datos.nombre1);
				$(nombre2Detalle).val(datos.nombre2);
				$(apellido1Detalle).val(datos.apellido1);
				$(apellido2Detalle).val(datos.apellido2);
				$(correoDetalle).val($.trim(datos.correo));

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
	}

	function resetearAyudante() {

		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var correoDetalle = document.getElementById("correoEditar");
		$(rutDetalle).val("");
		$(nombre1Detalle).val("");
		$(nombre2Detalle).val("");
		$(apellido1Detalle).val("");
		$(apellido2Detalle).val("");
		$(correoDetalle).val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
</script>


<fieldset>
	<legend>Editar ayudante</legend>
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
			<font color="red">* Campos Obligatorios</font>
			<p>2.-Complete los datos del formulario para modificar el ayudante:</p>
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
			<?php
				$attributes = array('id' => 'FormEditar', 'class' => 'form-horizontal');
				echo form_open('Ayudantes/EditarAyudante', $attributes);
			?>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">1-.RUT</label>
					<div class="controls">
						<input type="text" id="rutEditar" name="rutEditar" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="nombreunoEditar" name="nombre1_ayudante" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="nombredosEditar" name="nombre2_ayudante" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido Paterno</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellidopaternoEditar" name="apellido_paterno" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font>Apellido Materno</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellidomaternoEditar" name="apellido_materno" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo</label>
					<div class="controls">
						<input type="email" id="correoEditar" name="correo_ayudante" maxlength="199" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>

				<div class="control-group">
					<div class="controls ">
						<button type="button" class="btn" onclick="editarAyudante()">
							<i class= "icon-pencil"></i>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearAyudante()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>&nbsp;


						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se van a guardar los cambios del ayudante ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary">Aceptar</button>
							</div>
						</div>

						<!-- Modal de confirmación -->
						<div id="modalSeleccioneAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No ha seleccionado un ayudante</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione un ayudante y vuelva a intentarlo</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>