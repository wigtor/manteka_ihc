<script>
	var tiposFiltro = ["Nombre"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "actividad_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("ActividadesMasivas/getActividadesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/actividades") ?>";


	function verDetalle(elemTabla) {
		/* Obtengo el código del módulo clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var id_act = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		$('#idEliminar').val(id_act);

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({//AJAX PARA instancias
			type: "POST",
			url: "<?php echo site_url("ActividadesMasivas/getInstanciasActividadMasivaAjax") ?>",
			data: { id_actividad: id_act},
			success: function(respuesta) {
				var tablaResultados = document.getElementById("instancias");
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th,nodoTexto;
				tbody = document.createElement('tbody');
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					tr.setAttribute("style", "cursor:default");
					
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].fecha);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].lugar);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					
					tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);
				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}
	
		function eliminarActividad(){
		if ($('#idEliminar').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado actividad');
			$('#textoErrorDialog').html('No ha seleccionado una actividad masiva para eliminar');
			$('#modalError').modal();
			return;
		}
		$('#tituloConfirmacionDialog').html('Confirmación para eliminar actividad');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea eliminar permanentemente la actividad masiva del sistema?');
		$('#modalConfirmacion').modal();
	}

    function resetearActividad(){
    	//ESTO ES DE QUIENES HICIERON EL BORRADO
		$('#idEliminar').val("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
    }

	//Se carga todo por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<fieldset>
	<legend>Eliminar Actividad Masiva</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="controls controls-row">
				<div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda" title="no implementado aun, pega de G1" >
					<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			1.- Seleccione un actividad masiva para ver sus detalles:
		</div>
		<div class="span6">
			2.- Instancias de la actividad masiva
		</div>
	</div>
	<div class="row-fluid" >
		<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
			<table id="listadoResultados" class="table table-hover">

			</table>
		</div>
		
		<div class="span6">
			<div class="row-fluid">
				<div style="border:#cccccc 1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" >
					<table id="instancias" class="table table-hover">
						<thead>
							<tr>
								<th>
									Fecha
								</th>
								<th>
									Lugar
								</th>
							<tr>
						</thead>


					</table>
				</div>
			</div>
		</div>
		
		<?php
			$attributes = array('id' => 'formBorrar');
			echo form_open('ActividadesMasivas/postEliminarActividad', $attributes);
		?>
			<input type="hidden" id="idEliminar" name="idEliminar" value="">
			<div class="control-group">
				<div class="controls pull-right">
					<button type="button" class="btn" onclick="eliminarActividad()">
						<i class= "icon-trash"></i>
						&nbsp; Eliminar
					</button>
					<button class="btn" type="button" onclick="resetearActividad()" >
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
</fieldset>
