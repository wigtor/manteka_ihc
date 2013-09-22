<script>
	var tiposFiltro = ["Nombre sesión", "Descripción", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "sesion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Sesiones/getSesionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/sesiones") ?>";

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
				$('#id_sesionEliminar').val(datos.id);
				$('#nombre').html(datos.nombre == '' ? '' : $.trim(datos.nombre));
				$('#nombre_moduloTematico').html(datos.nombre_moduloTematico == '' ? '' : $.trim(datos.nombre_moduloTematico));
				$('#descripcion').html(datos.descripcion == '' ? 'Sin descripción' : $.trim(datos.descripcion));
				
				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();

			}
		});
	}

	function resetearSesion() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		$('#id_sesionEliminar').val("");

		/* Seteo los valores a string vacio */
		$('#nombre').html("");
		$('#nombre_moduloTematico').html("");
		$('#descripcion').html("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
	}

	function eliminarSesion() {
		if ($('#id_sesionEliminar').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado sesión de clase');
			$('#textoErrorDialog').html('No ha seleccionado un profesor para eliminar');
			$('#modalError').modal();
			return;
		}
		$('#tituloConfirmacionDialog').html('Confirmación para eliminar la sesión de clase');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea eliminar permanentemente la sesión de clase del sistema?');
		$('#modalConfirmacion').modal();
	}
	
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
</script>
<fieldset>
	<legend>Eliminar Sesión de clase</legend>

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
			1.- Seleccione una sesión para ver sus detalles:
		</div>
		<div class="span6" >
			2.- Detalle sesión:
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
				$atributos= array('id' => 'formEliminar');
				echo form_open('Sesiones/postEliminarSesion', $atributos);
			?>
			<pre style="padding: 2%; cursor:default">
Nombre de la sesión:        <b id="nombre"></b>
Nombre del módulo temático: <b id="nombre_moduloTematico"></b>
Descripción:                <b id="descripcion"></b></pre>
			<input name="id_sesionEliminar" type="hidden" id="id_sesionEliminar" value="" required>
			<div class="control-group">
				<div class="controls">
					<button type="button" class="btn" onclick="eliminarSesion()">
						<i class= "icon-trash"></i>
						&nbsp; Eliminar
					</button>
					<button class="btn" type="button" onclick="resetearSesion()" >
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
			<?php echo form_close(''); ?>
		</div>
	</div>

</fieldset>