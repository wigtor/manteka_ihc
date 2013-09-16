

<script>
	var tiposFiltro = ["Numero", "Capacidad", "Implementos"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro= ["[0-9]{3}", "[0-9]+", ""];
	var prefijo_tipoDato = "sala_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Salas/getSalasAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/salas") ?>";

	function verDetalle(elemTabla) {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		sala_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/getDetallesSalaAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { num_sala: sala_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#id_sala').val(datos.id_sala);
				$('#num_sala').val(datos.num_sala);
				$('#capacidad').val($.trim(datos.capacidad));
				$('#ubicacion').val($.trim(datos.ubicacion));
				
				$.ajax({
					type: "POST", /* Indico que es una petición POST al servidor */
					url: "<?php echo site_url("Salas/getImplementosBySalaAjax") ?>", /* Se setea la url del controlador que responderá */
					data: { id_sala: datos.id_sala }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
					success: function(respuesta2) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */				
						/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
						var datos = jQuery.parseJSON(respuesta2);
						var arreglo = new Array();

						for (var i = 0; i < datos.length; i++) {
							arreglo[i] = datos[i].id;
						}
						$("#id_implementos").val(arreglo);

						/* Quito el div que indica que se está cargando */
						$('#icono_cargando').hide();
					}
				});
			}
		});
	}

	function comprobarNum() {
		var num = $('#num_sala').val();
		var id_sala = $('#id_sala').val();

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/numSalaExisteEditarAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { id_sala_post:id_sala, num_post: num},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();

				var existe = jQuery.parseJSON(respuesta);
				if(existe == true){
					$('#tituloErrorDialog').html('Error en el número de sala');
					$('#textoErrorDialog').html('El N° de sala ingresado ya existe en el sistema');
					$('#modalError').modal();
					$('#num_sala').val('');
				}
			}
		});
	}
	
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<script type="text/javascript">
	function editarSala() {
		var form = document.forms["formEditar"];
		if ($('#id_sala').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado sala');
			$('#textoErrorDialog').html('No ha seleccionado una sala para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios de la sala en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	function resetearSala() {
		/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
		$('#id_sala').val("");
		$('#num_sala').val("");
		$('#capacidad').val("");
		$('#ubicacion').val("");

		// Limpiando el checklist de implementos		
		$("#id_implementos").val(new Array());

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');

	}

</script>

<fieldset>
	<legend>Editar Sala</legend>
	<div class="row-fluid">
		<div class="span6">
		<font color="red">* Campos Obligatorios</font>
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
			<p>1.- Seleccione la sala a editar:</p>
		</div>
		<div class="span6" >
			<p>2.- Complete los datos del formulario para modificar la sala:</p>
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
				$attributes = array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Salas/postEditarSala', $attributes);
			?>
				<input type="hidden" id="id_sala" name="id_sala" maxlength="3" min="1" readonly>

				<div class="control-group">
					<label class="control-label"for="num_sala">1.- <font color="red">*</font> Número sala</label>
					<div class="controls">
						<input type="text" onblur="comprobarNum()" id="num_sala" class="span12" name="num_sala" maxlength="3" title="Ingrese el número de la sala usando tres dígitos" pattern="[0-9]{3}" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="capacidad">2.- <font color="red">*</font> Capacidad</label>
					<div class="controls">
						<input id="capacidad" name="capacidad" maxlength="3" class="span12" title="Ingrese la capacidad de la sala" max="999" min="1" type="number" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="ubicacion">3.- <font color="red">*</font> Ubicación</label>
					<div class="controls">
						<textarea class="span12" title= "Ingrese la ubicación de la sala en no más de 100 carácteres" id="ubicacion" name="ubicacion"  maxlength="100" required="required" style="resize: none"></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" style="cursor: default"for="cod_sala">4.- Seleccione los implementos</br><em>(Los implementos marcados son los que tiene actualmente la sala)</em></label>
					<!--</br>
					<b>Si desea modificar los implementos de la sala, elija entre los siguientes:</b></br>
					(Los implementos marcados son los que tiene actualmente la sala)
				</div>-->
					<div class="controls">
						<select id="id_implementos" name="id_implementos[]" class="span12" title="asigne los implementos" multiple="multiple">
						<?php
						if (isset($implementos)) {
							foreach ($implementos as $impl) {
								?>
									<option value="<?php echo $impl->id; ?>"><?php echo $impl->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="editarSala()">
							<i class= "icon-pencil"></i>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearSala()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						if (isset($dialogos)) {
							echo $dialogos;
						}
					?>
				</div>
				<?php echo form_close(""); ?>
			</div>
		</div>
	</div>
</fieldset>