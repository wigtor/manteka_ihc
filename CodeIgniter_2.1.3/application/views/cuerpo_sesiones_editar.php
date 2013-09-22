<script>
	var tiposFiltro = ["Nombre sesión", "Descripción", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "sesion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Sesiones/getSesionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/sesiones") ?>";


	function comprobarNombre() {
		var nombre = document.getElementById("nombresesion").value;
		var codigo = document.getElementById("codigoSesion").value;
			$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Sesiones/nombreExisteEC") ?>", /* Se setea la url del controlador que responderá */
			data: { nombre_post: nombre, codigo_post: codigo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == 1){
					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalNombreUsado').modal();
					document.getElementById("nombresesion").value = "";

				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}


	function editarSesion(){
		var form = document.forms["formEditar"];
		if ($('#id_sesion').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado sesión');
			$('#textoErrorDialog').html('No ha seleccionado una sesión para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios de la sesión en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}


	function resetearSesion() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		$('#id_sesion').val("");

		/* Seteo los valores a string vacio */
		$('#nombre').val("");
		$('#moduloTematico').val("");
		$('#descripcion').val("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
	}

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		sesion_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			url: "<?php echo site_url("Sesiones/getDetallesSesionAjax") ?>",
			data: { id_sesion: sesion_clickeado }, 
			success: function(respuesta) {
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#id_sesion').val(datos.id);
				$('#nombre').val(datos.nombre == '' ? '' : $.trim(datos.nombre));
				$('#id_moduloTem').val(datos.id_moduloTematico == '' ? '' : $.trim(datos.id_moduloTematico));
				$('#descripcion').val(datos.descripcion == '' ? 'Sin descripción' : $.trim(datos.descripcion));
				
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
	<legend>Editar Sesión de clase</legend>
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
			1.- Seleccione la sesión a editar:
		</div>
		<div class="span6" >
			<p>Complete los datos del formulario para modificar la sesión</p>
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

		<!-- Segunda columna -->
		<div class="span6">
			<?php
				$attributes = array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Sesiones/postEditarSesion/', $attributes);
			?>
				<input type="hidden" readonly id="id_sesion" name="id_sesion" required >
				
				<div class="control-group">
					<label class="control-label" for="nombre" style="cursor: default">1.- <font color="red">*</font> Nombre de sesión</label>
					<div class="controls">
						<input type="text" id="nombre" onblur="comprobarNombre()" class="span12" name="nombre" title="Use solo letras para este campo" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" maxlength="99" required >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="descripcion" style="cursor: default">2.- Descripción</label>
					<div class="controls">
						<textarea type="text" class="span12" id="descripcion" cols="40" rows="5" title="Use solo letras para este campo" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" name="descripcion" maxlength="99" ></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="id_moduloTem" >3.- <font color="red">*</font> Asignar módulo temático:</label>
					<div class="controls">
						<select required id="id_moduloTem" name="id_moduloTem" class="span12" title="asigne módulo temático">
						<?php
						if (isset($modulosTematicos)) {
							foreach ($modulosTematicos as $moduloTem) {
								?>
									<option value="<?php echo $moduloTem->id; ?>"><?php echo $moduloTem->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>
				<div class="control-group" >
					<div class="controls">
						<button class ="btn" type="button" onclick="editarSesion()" >
							<div class= "icon-pencil"></div>
							&nbsp Guardar
						</button>
						<button  class ="btn" type="reset" onclick="resetearSesion()" >
							<div class= "btn_with_icon_solo">Â</div>
							&nbsp Cancelar
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
</fieldset>