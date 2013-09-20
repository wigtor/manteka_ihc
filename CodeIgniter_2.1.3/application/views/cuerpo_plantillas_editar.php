<?php

/**
 * El presente archivo corresponde a la vista para editar plantillas en el sistema Manteka.
 *
 * @package Manteka
 * @subpackage Vistas
 * @author Diego García (DGM)
 **/
 
?>

<script type="text/javascript">
	var tiposFiltro = ["Nombre", "Asunto", "Cuerpo"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro = ["", "", ""];
	var prefijo_tipoDato = "plantilla_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Plantillas/getPlantillasAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/plantillas") ?>";

	/**
	* Hace que el cuerpo de la plantilla no sea de sólo lectura.
	* 
	* Cuando se carga la instancia de ckeditor, permite que el contenido del 'textarea' sea editable.
	* 
	* @author Diego García (DGM)
	**/
	var editor;
	CKEDITOR.on('instanceReady', function( ev )
	{
		editor = ev.editor;
		editor.setReadOnly(false);
	});

	function mostrarConsejosPlantilla() {
		$('#modalConsejosPlantilla').modal();
	}

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		id_plantilla = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Plantillas/getDetallesPlantillaAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { id_plantilla_post: id_plantilla }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#id_plantilla').val($.trim(datos.id));
				$('#txtNombrePlantilla').val($.trim(datos.nombre));
				$('#txtAsunto').val((datos.asunto == "" ? '' : $.trim(datos.asunto)));
				$('#editor').val(datos.cuerpo);
				CKEDITOR.instances.editor.setData(datos.cuerpo);

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function resetearPlantilla() {
		$('#id_plantilla').val("");
		$('#txtNombrePlantilla').val("");
		$('#nombre2').val("");
		$('#txtAsunto').val("");
		$('#editor').val("");
		CKEDITOR.instances.editor.setData("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
	}

	function editarPlantilla() {
		var form = document.forms["formEditar"];
		if ($('#id_plantilla').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado plantilla');
			$('#textoErrorDialog').html('No ha seleccionado una plantilla para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios de la plantilla en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<fieldset>
	<legend>Editar plantilla</legend>
		<div class="row-fluid">
			<div class="span12">
				La creación de plantillas permite definir variables cuyos valores serán asignados automáticamente por el sistema al momento de enviar un correo.
			</div>
			<div class="span12">
				Para obtener más información sobre el uso de variables haga clic <a onclick="mostrarConsejosPlantilla()" >acá</a>.
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
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
			<div class="span6" >
				<p>1.- Seleccione el profesor a editar:</p>
			</div>
			<div class="span6" >
				<p>2.- Complete los datos del formulario para modificar el profesor:</p>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
				<table id="listadoResultados" class="table table-hover">
					
				</table>
			</div>



			<div class="span6">
				<?php
					$atributos = array('class' => 'form', 'id' => 'formEditar');
					echo form_open('plantillas/postEditarPlantilla', $atributos);
				?>
				<input type="hidden" id="id_plantilla" name="id_plantilla" value="" required>

				<div class="control-group">
					<label class="control-label" for="txtNombrePlantilla">1-.<font color="red">*</font> Nombre de la plantilla:</label>
					<div class="controls">
						<input type="text" id="txtNombrePlantilla" name="txtNombrePlantilla" class="span12" placeHolder='Máximo 40 caracteres' maxlength="40" title="Ingrese el nombre de la plantilla" min="1" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="txtAsunto">2-.<font color="red">*</font> Asunto:</label>
					<div class="controls">
						<input type="text" id="txtAsunto" name="txtAsunto" class="span12" placeHolder='Máximo 40 caracteres' maxlength="40" title="Ingrese el asunto de la plantilla" min="1" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="editor">3-.<font color="red">*</font> Cuerpo del mensaje:</label>
					<div class="controls">
						<textarea id="editor" name="editor" class="span12 ckeditor" title="Ingrese el texto del mensaje que desea guardar como plantilla" required>
						</textarea>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="editarPlantilla()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearPlantilla()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Limpiar
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

		<?php
		/**
		* Ventana modal sobre el uso de variables en la creación de plantillas.
		* 
		* Muestra información relevante al usuario, sobre como incluir
		* variables en las plantillas.
		*
		* @author Diego García (DGM)
		**/
		?>
		<div id="modalConsejosPlantilla" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Consejos para realizar plantillas</h3>
			</div>
			<div class="modal-body">
				<div class="txtModal">
					Las variables predefinidas permiten definir segmentos de texto dentro de una plantilla, que tomarán distintos valores según las características del mensaje o la lista de destinatarios a utilizar.
					El valor de estas variables será asignado automáticamente al momento de realizar el envío de un correo electrónico.
				</div>
				<div class="txtModal">
					Para definir una variable anteponga los caracteres  <font color="blue">%%</font>  antes del nombre de dicha variable.
				</div>
				<div class="txtModal">
					<div id="salto">Las variables predefinidas que puede utilizar son:</div>
					<div class="txtLabel">%%nombre</div><div class="txtDescripcion">Asigna el nombre y apellido del receptor del correo electrónico.</div>
					<div class="txtLabel">%%rut</div><div class="txtDescripcion">Asigna el rut del receptor del correo electrónico.</div>
					<div class="txtLabel">%%carrera_estudiante</div><div class="txtDescripcion">Asigna la carrera a la que pertenece el estudiante receptor del correo electrónico.</div>
					<div class="txtLabel">%%seccion_estudiante</div><div class="txtDescripcion">Asigna la sección a la que pertenece el estudiante receptor del correo electrónico.</div>
					<div class="txtLabel">%%modulo_estudiante</div><div class="txtDescripcion">Asigna el módulo temático al que pertenece el estudiante receptor del correo electrónico.</div>
					<div class="txtLabel">%%hoy</div><div class="txtDescripcion">Asigna la fecha actual al momento de realizar el envío.</div>
					<div class="txtLabel">%%remitente</div><div class="txtDescripcion">Asigna el nombre del usuario que realiza el envío del correo electrónico.</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
			</div>
		</div>
</fieldset>
