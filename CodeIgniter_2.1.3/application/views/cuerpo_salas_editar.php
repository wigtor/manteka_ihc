

<script>
	function comprobarNum() {
		var num = document.getElementById("num_sala").value;
		var cod = document.getElementById("cod_sala").value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/NumExisteE") ?>", /* Se setea la url del controlador que responderá */
			data: { num_post: num, cod_post:cod},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == 1){

					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalNum').modal();
					document.getElementById("num_sala").value = "";
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
	
</script>

<script>

	var tiposFiltro = ["Numero", "Capacidad", "Implementos"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro= ["[0-9]{3}", "[0-9]+", ""];
	var prefijo_tipoDato = "sala_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Salas/postBusquedaSalas") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/salas") ?>";

	function verDetalle(elemTabla) {

		// Limpiando el checklist de implementos
		$('input[id^=implemento_]').prop('checked',false);
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
				$(numSala).val(datos.num_sala);
				$(capacidad).val($.trim(datos.capacidad));
				$(ubicacion).val($.trim(datos.ubicacion));

				/*	Setear los Implementos	*/
				var length = datos.implementos.length;
				for(var i=0; i<length; i++){
					imp = datos.implementos[i];
					$('#implemento_'+datos.implementos[i].codigo_implemento).prop('checked',true);
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
	
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<script type="text/javascript">
	function EditarSala(){
		var cod = document.getElementById("cod_sala").value;
		var num = document.getElementById("num_sala").value;
		var cap = document.getElementById("capacidad").value;
		var ubi = document.getElementById("ubicacion").value;
		if(cod==""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		else{
			if(num!="" && cap!="" && ubi!=""){
				$('#modalConfirmacion').modal();
			}
			else{
				$('#modalFaltanCampos').modal();
			}
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
		

		/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
		$(codSala).val("");
		$(numSala).val("");
		$(capacidad).val("");
		$(ubicacion).val("");

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
				$attributes = array('id' => 'formDetalle', 'class' => 'form-horizontal', 'onsubmit' => 'EditarSala()');
				echo form_open('Salas/modificarSalas', $attributes);
			?>
			<input type="hidden" id="cod_sala" name="cod_sala" maxlength="3" min="1" readonly>
			<div class="control-group">
					<label class="control-label" style="cursor: default" for="cod_sala">1.- <font color="red">*</font> Número sala</label>
					<div class="controls">
						<input type="text" onblur="comprobarNum()" id="num_sala" class="span12" name="num_sala" maxlength="3" title="Ingrese el número de la sala usando tres dígitos" pattern="[0-9]{3}" required>
					</div>
			</div>
			<div class="control-group">
					<label class="control-label" style="cursor: default" for="cod_sala">2.- <font color="red">*</font> Capacidad</label>
					<div class="controls">
						<input id="capacidad" name="capacidad" maxlength="3" class="span12" title="Ingrese la capacidad de la sala" max="999" min="1" type="number" required>
					</div>
			</div>
			<div class="control-group">
					<label class="control-label" style="cursor: default" for="cod_sala">3.- <font color="red">*</font> Ubicación</label>
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
					<div class="span12" style="border:#cccccc 1px solid;overflow-y:scroll; -webkit-border-radius: 4px; height: 230px" >
						<table class="table table-hover">
							<tbody>
				
								<?php
								foreach ($implementos as $implemento){
									echo '<tr>';
										echo '<td title = "Descripción: '. $implemento->descr_implemento.'">';
											echo '<input id="implemento_'.$implemento->codigo_implemento.'" value="'.$implemento->codigo_implemento.'" name="implementos[]" type="checkbox" >';
										echo '&nbsp'.$implemento->nombre_implemento.' </td>';
									echo '</tr>';

								}
								?>

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="controls pull-right">
					<button type="button" style= "margin-right: 4px" class="btn" onclick="EditarSala()">
						<i class= "icon-pencil"></i>
						&nbsp; Guardar
					</button>
					<button class="btn" type="button" onclick="resetearSala()" >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>&nbsp;
				</div>
			</div>

					<!-- Modal de confirmación -->
					<div id="modalConfirmacion" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Confirmación</h3>
						</div>
						<div class="modal-body">
							<p>Se van a guardar los cambios de la sala ¿Está seguro?</p>
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
							<h3>No ha seleccionado una sala</h3>
						</div>
						<div class="modal-body">
							<p>Por favor seleccione una sala y vuelva a intentarlo</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
					<!-- Modal de modalNum -->
					<div id="modalNum" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Número de sala ingresado está en uso</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese otro número y vuelva a intentarlo</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>	
											<!-- Modal de faltan campos -->
						<div id="modalFaltanCampos" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Campos Obligatorios no completados</h3>
							</div>
							<div class="modal-body">
								<p>Por favor complete el campo vacío y vuelva a intentarlo</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>	

				<!--</div>-->
			</div>
		</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>