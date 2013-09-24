<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/getSeccionesAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";


	function verDetalle(elemTabla) {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var cod_seccion = idElem.substring(prefijo_tipoDato.length, idElem.length);

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url("Secciones/getDetallesSeccionAjax") ?>",
			data: { seccion: cod_seccion },
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				$('#id_seccion').val($.trim(datos.id_seccion));

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#letra_seccion').val($.trim(datos.letra_seccion));
				$('#numero_seccion').val($.trim(datos.numero_seccion));
				$('#dia').val($.trim(datos.id_dia));
				$('#bloque').val($.trim(datos.id_modulo_horario));

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function comprobarSeccion() {
		//POR ALGUNA RAZÓN NO FUNCIONA
		var letra = $.trim($("#letra_seccion").val());
		var num = $.trim($("#numero_seccion").val());
		var id_seccion_edit = $.trim($("#id_seccion").val());

		if((letra != "") & (num != "")) {

			/* Muestro el div que indica que se está cargando... */
			$('#icono_cargando').show();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url("Secciones/secExisteEditarAjax") ?>",
				data: { id_seccion:id_seccion_edit, letra_post:letra, num_post: num},
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var existe = jQuery.parseJSON(respuesta);
					
					if(existe == true) {
						$('#tituloErrorDialog').html('Error en el nombre de la sección');
						$('#textoErrorDialog').html('La sección '+letra+'-'+num+' que ha ingresado ya se encuentra en el sistema');
						$('#modalError').modal();
						$('#letra_seccion').val("");
						$('#numero_seccion').val("");
					}
				
					/* Quito el div que indica que se está cargando */
					$('#icono_cargando').hide();
				}
			});
		}
	}
    
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

	function editarSeccion() {
		var form = document.forms["formEditar"];
		if ($('#id_seccion').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado sección');
			$('#textoErrorDialog').html('No ha seleccionado una sección para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios de la sección en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	function resetearSeccion() {
		$('#letra_seccion').val("");
		$('#numero_seccion').val("");
		$('#id_seccion').val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}

</script>


<fieldset> 
<legend>Editar Sección</legend>
	<div class="row-fluid">
		<div class="span5">
		<font color="red">* Campos Obligatorios</font>
			<div class="controls controls-row">
				<div class="input-append span9">
					<input id="filtroLista" class="span8" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
					<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
		<div class="span7" >
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5" >
			1.- Seleccione la sección a editar:
		</div>
		<div class="span7" >
			<p>2.- Complete los datos del formulario para modificar la sección:</p>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover">
				
			</table>
		</div>
	
		<!-- Segunda columna -->
		<div class="span7">
			<?php
				$atributos= array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Secciones/postEditarSeccion/', $atributos);
			?>
				<input id="id_seccion" type="text" name="id_seccion" style="display:none">
				
				<div class="control-group">
					<label class="control-label" for="letra_seccion">1.- <font color="red">*</font> Sección:<br>
						<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
					</label>
					
					<div class="controls">
						<input id="letra_seccion" name="letra_seccion" onblur="comprobarSeccion(letra_seccion, numero_seccion)" maxlength="1" title=" Ingrese sólo una letra" pattern="^([A-Z]{1}|[a-z]{1})$" type="text" class="span1" required>
						-<input id="numero_seccion" name="numero_seccion"  onblur="comprobarSeccion(letra_seccion, numero_seccion)" maxlength="2"  title=" Ingrese sólo dos dígitos" pattern="[0-9]" type="text" class="span2" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dia">2.- <font color="red">*</font> Horario:</label>
					<div class="controls">
						<select id="dia" name="dia" class="span4" required>
							<option value="" disabled selected>Día</option>
							<?php
							if (isset($listadoDias)) {
								foreach ($listadoDias as $valor) {
									?>
										<option value="<?php echo $valor->id?>"><?php echo $valor->nombre; ?></option>
									<?php 
								}
							}
							?>
						</select>

						<select id="bloque" name="bloque" class="span4" required>
							<option value="" disabled selected>Hora</option>
							<?php
							if (isset($listadoBloquesHorario)) {
								foreach ($listadoBloquesHorario as $valor) {
									?>
										<option value="<?php echo $valor->id?>"><?php echo $valor->id.' - '.$valor->inicio.'-'.$valor->fin; ?></option>
									<?php 
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="button" onclick="editarSeccion()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearSeccion()">
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
