<script type="text/javascript">
	var tiposFiltro = ["Sección", "Profesor", "Módulo temático", "Bloque", "Día", "Hora", "Sala", "Fecha"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", "", "", "", ""];
	var prefijo_tipoDato = "planificacion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Planificacion/getPlanificacionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/planificacion") ?>";

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>


<fieldset>
	<legend>Ver Planificación</legend>
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
</fieldset>
