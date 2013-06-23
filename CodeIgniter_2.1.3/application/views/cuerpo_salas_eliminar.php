<?php
if(isset($mensaje_confirmacion))
{
	if($mensaje_confirmacion==1)
	{
		?>
		    <div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Listo</h4>
				 Sala eliminada correctamente
    		</div>	
		<?php
	}
	else if($mensaje_confirmacion==-1)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Error</h4>
				 Error al eliminar sala
    		</div>		

		<?php
	}
	unset($mensaje_confirmacion);
}
?>

<script type="text/javascript">
	var tiposFiltro = ["Numero", "Capacidad", "Implementos"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "sala_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Salas/postBusquedaSalas") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/salas") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		sala_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/postDetallesSala") ?>", /* Se setea la url del controlador que responderá */
			data: { num_sala: sala_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var codSala = document.getElementById("cod_sala");
				var numSala = document.getElementById("num_sala");
				var capacidad = document.getElementById("capacidad");
				var ubicacion = document.getElementById("ubicacion");
				var impl = document.getElementById("impDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				if (datos.capacidad == null) {
					datos.capacidad = '';
				}

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(codSala).val(datos.codigo_sala);
				$(numSala).html(datos.num_sala);
				$(capacidad).html($.trim(datos.capacidad));
				$(ubicacion).html($.trim(datos.ubicacion));

				/*	Setear los Implementos	*/
				var length = datos.implementos.length,
					elemento = null, salidaImp = "";
				if (length == 0)
					salidaImp = "<b>No posee</b>";
				for(var i=0; i<length; i++){
					imp = datos.implementos[i];
					salidaImp += '<b title=\"'+imp["descr_implemento"]+'\">'+imp["nombre_implemento"] + "\n</b>"; 
				}
				
				$(impl).html(salidaImp);
				

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

<script type="text/javascript">
	function eliminarSala(){
		
		var cod = document.getElementById("cod_sala").value;
		

		if(cod==""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		else{
			
			$('#modalConfirmacion').modal();
		}
		
	}

	function resetearSala(){
		// Limpiando el checklist de implementos		
		$('input[id^=implemento_]').prop('checked',false);

		/* Obtengo los objetos HTML donde serán escritos los resultados */
		var codSala = document.getElementById("cod_sala");
		var numSala = document.getElementById("num_sala");
		var capacidad = document.getElementById("capacidad");
		var ubicacion = document.getElementById("ubicacion");
		var impl = document.getElementById("impDetalle");
		

		/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
		$(codSala).html("");
		$(numSala).html("");
		$(capacidad).html("");
		$(ubicacion).html("");
		$(impl).html("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}
</script>
						

<fieldset>
	<legend>Eliminar Sala</legend>
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
			1.-Listado salas
		</div>
		<div class="span6" >
			2.-Detalle de la Sala:
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
				$attributes = array('id' => 'formDetalle', 'class' => 'form-horizontal', 'onsubmit' => 'eliminarSala()');
				echo form_open('Salas/borrarSalas', $attributes);
			?>
			<input type="hidden" id="cod_sala" name="cod_sala" maxlength="3" min="1" readonly>
	  		<pre style="padding: 2%; cursor:default">
Número sala:    <b id="num_sala"></b>
Capacidad:      <b id="capacidad" ></b>
Ubicación:      <b id="ubicacion"></b>
Implementos:    <div style="display: inline-block; vertical-align: top;" id="impDetalle"></div>
			</pre>
			
			<div class="control-group">
				<div class="controls pull-right">
					<button type="button" class="btn" onclick="eliminarSala()">
						<i class= "icon-trash"></i>
						&nbsp; Eliminar
					</button>
					<button class="btn" type="button" onclick="resetearSala()" >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>&nbsp;
			</div>
			<!-- Modal Confirmación -->
			<div id="modalConfirmacion" class="modal hide fade">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Confirmación</h3>
				</div>
				<div class="modal-body">
					<p>Se va a eliminar la sala seleccionada ¿Está seguro?</p>
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
					<h3>No ha seleccionado ninguna sala</h3>
				</div>
				<div class="modal-body">
					<p>Por favor seleccione una sala y vuelva a intentarlo</p>
				</div>
				<div class="modal-footer">
					<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</fieldset>