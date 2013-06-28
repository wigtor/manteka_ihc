<script>
	var tiposFiltro = ["Sesión", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "sesion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Sesiones/postBusquedaSesiones") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";


function EditarSesion(){
							
		var nombre = document.getElementById("nombresesion").value;
		var descripcion =document.getElementById("descripcionSesion").value;
		var cod =document.getElementById("codigoSesion").value;

		
	
		if(descripcion!="" && nombre!=""){
			
			$('#modalConfirmacion').modal();
			return;
		}
		else{
			if( descripcion=="" && nombre==""){
				$('#modalSeleccioneAlgo').modal();
			}
			else{
				$('#modalCamposVacios').modal();
			}
		}
}

function resetearSesion() {

	var nombreDetalle = document.getElementById("nombresesion");
	var descripcionDetalle = document.getElementById("descripcionSesion");
	var codigoDetalle = document.getElementById("codigoSesion");
	
	$(nombreDetalle).val("");
	$(codigoDetalle).val("");
	$(descripcionDetalle).val("");

	//Se limpia lo que está seleccionado en la tabla
	$('tbody tr').removeClass('highlight');
}

function verDetalle(elemTabla) {

	/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
	var idElem = elemTabla.id;
	sesion_clickeado = idElem.substring("sesion_".length, idElem.length);
	//var rut_clickeado = elemTabla;


	/* Defino el ajax que hará la petición al servidor */
	$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: "<?php echo site_url("Sesiones/postDetallesSesion") ?>", /* Se setea la url del controlador que responderá */
		data: { sesion: sesion_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

			/* Obtengo los objetos HTML donde serán escritos los resultados */
			var nombreDetalle = document.getElementById("nombresesion");
			var descripcionDetalle = document.getElementById("descripcionSesion");
			var codigoDetalle = document.getElementById("codigoSesion");
			//var descripcionDetalle = document.getElementById("descripcionDetalle");
			/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
			var datos = jQuery.parseJSON(respuesta);

			/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
			//$(codigoDetalle).html(datos.cod_sesion);
			$(nombreDetalle).val(datos.nombre);
			$(codigoDetalle).val(datos.codigo_sesion);
			$(descripcionDetalle).val(datos.descripcion);
		

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
	<legend>Editar Sesión</legend>
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
			1.-Listado sesiones
		</div>
		<div class="span6" >
			<font color="red">* Campos Obligatorios</font><br>
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
				$attributes = array('id' => 'FormEditar', 'class' => 'form-horizontal', 'onsubmit' => 'EditarProfesor()');
				echo form_open('Sesiones/editarSesiones/', $attributes);
			?>
			<input type="hidden" readonly id="codigoSesion" name="codigo_sesion" maxlength="99" required >
			
			<div class="control-group">
				<label class="control-label" for="inputInfo" style="cursor: default">1-.<font color="red">*</font> Nombre de sesión</label>
				<div class="controls">
					<input type="text" id="nombresesion" class="span12" name="nombre_sesion" title="Use solo letras para este campo" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" maxlength="99" required >
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font> Descripción</label>
				<div class="controls">
					<textarea type="text" class="span12" id="descripcionSesion" cols="40" rows="5" title="Use solo letras para este campo" pattern="[0-9a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" name="descripcion_sesion" maxlength="99" required></textarea>
				</div>
			</div>
			<div class="row">
				<div class="controls pull-right">
					<button type="button" class="btn" style= "margin-right: 4px" type="button" onClick="EditarSesion()">
						<i class= "icon-pencil"></i>
						&nbsp; Guardar
					</button>
					<button  class ="btn" type="button" onclick="resetearSesion()" >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>
				</div>
		</div>
	</div>
				<!-- Modal de confirmación -->
				<div id="modalConfirmacion" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Confirmación</h3>
					</div>
					<div class="modal-body">
						<p>Se van a guardar los cambios de la sesión ¿Está seguro?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
						<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
					</div>
				</div>

				<!-- Modal de aviso que no ha seleccionado algo -->
				<div id="modalSeleccioneAlgo" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>No ha seleccionado una sesión</h3>
					</div>
					<div class="modal-body">
						<p>Por favor seleccione una sesión y vuelva a intentarlo</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

				<!-- Modal de campos vacíos -->
				<div id="modalCamposVacios" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Campos Obligatorios Vacíos</h3>
					</div>
					<div class="modal-body">
						<p>Por favor  complete todos los campos obligatorios y vuelva a intentarlo</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
		
		<?php echo form_close(""); ?>



</fieldset>