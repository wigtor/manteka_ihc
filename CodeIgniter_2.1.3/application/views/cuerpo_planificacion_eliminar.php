<script type="text/javascript">
	var tiposFiltro = ["Sección", "Profesor", "Módulo temático", "Sala", "Bloque", "Hora", "Día", "Fecha"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", "", "", ""];
	var prefijo_tipoDato = "planificacion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Planificacion/getPlanificacionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/planificacion") ?>";

	function verDetalle(elemTabla){
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var id_planificacion = idElem.substring(prefijo_tipoDato.length, idElem.length);
		$('#id_planificacion').val(id_planificacion);
	}

	function resetearPlanificacion() {
		$('#id_planificacion').val('');
		$('#listadoResultados tbody tr').removeClass('highlight');
	}

	function eliminarPlanificacion(){
		if ($('#id_planificacion').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado planificación');
			$('#textoErrorDialog').html('No ha seleccionado una planificación para eliminar');
			$('#modalError').modal();
			return;
		}
		$('#tituloConfirmacionDialog').html('Confirmación para eliminar planificación');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea eliminar permanentemente la planificación del sistema?');
		$('#modalConfirmacion').modal();
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>


<fieldset>
	<legend>Eliminar planificación</legend>
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
		<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; overflow-x:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover">
			</table>
		</div>
	</div>

	<?php
		$atributos= array('id' => 'formEliminar');
		echo form_open('Planificacion/postEliminarPlanificacion/', $atributos);
	?>
		<input name="id_planificacion" type="hidden" id="id_planificacion" value="">
		<div class="control-group">
			<div class="controls pull-right">
				<button type="button" class="btn" onclick="eliminarPlanificacion()">
					<i class= "icon-trash"></i>
					&nbsp; Eliminar
				</button>
				<button class="btn" type="button" onclick="resetearPlanificacion()" >
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
</fieldset>
