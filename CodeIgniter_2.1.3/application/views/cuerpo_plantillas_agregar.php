<?php

/**
 * El presente archivo corresponde a la vista para agregar plantillas al sistema Manteka.
 *
 * @package Manteka
 * @subpackage Vistas
 * @author Grupo 3
 **/
 
?>

<script type='text/javascript'>

	/**
	* Se le da un valor por defecto como texto a la plantilla para ejemplificar su uso ante el usuario.
	* @author Diego García (DGM)
	**/
	$(document).ready(function(){
		<?php
			$ejemplo = '<p><span style=\"color:#FF0000\"><strong><u>Ejemplo de plantilla:</u></strong></span><br /><br />Estimado %%nombre<br /><br />Te informamos que hoy %%hoy se han suspendido las clases dictadas por el profesor Edmundo Leiva, <span style=\"color:#666666;font-size:12pt\"><strong>debido a motivos de fuerza mayor.</strong></span><br /><br /><span style=\"color:blue\">Cordialmente<br />Coordinador %%remitente </span></p>';
		?>
		$('#editor').val("<?php echo $ejemplo; ?>");
	});

	/**
	* Borra el contenido del cuerpo de la plantilla.
	* 
	* Borra el contenido del 'textarea' de la instancia de ckeditor en la vista.
	* La instancia de ckeditor se utiliza para ingresar el cuerpo o mensaje principal
	* de la plantilla.
	* Se invoca al presionar el botón "Limpiar plantilla" del formulario.
	* 
	* @author Diego García (DGM)
	**/
	function borrarCKEditor() {
		 CKEDITOR.instances.editor.setData ("");
	}

	/**
	* Borra el contenido por defecto (ejemplo) del cuerpo de la plantilla.
	* 
	* Este contenido se borra cuando se hace clic en el 'textarea' donde se
	* ingresa el cuerpo de la plantilla, cuando el clic se realiza por primera
	* vez luego de cargada la página. 
	* 
	* @author Diego García (DGM)
	**/
	var inicio=true;
	CKEDITOR.on('currentInstance', function(e)
	{
		if(inicio==true && <?php echo !isset($msj[3]) ?>)
		{
			CKEDITOR.instances.editor.setData ("");
			inicio=false;
		}
	});

	function mostrarConsejosPlantilla() {
		$('#modalConsejosPlantilla').modal();
	}

	function agregarPlantilla() {
		var form = document.forms["formAgregar"];
		if (form.checkValidity() ) {
			$('#tituloConfirmacionDialog').html('Confirmación para agregar plantilla');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea agregar la plantilla al sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

</script>

	
<?php
/**
* Contenido de la vista para agregar plantillas.
* 
* Muestra el formulario para agregar plantillas y los
* mensajes de errores o éxito que correspondan, según
* el resultado de la validación del formulario y el
* resultado de la creación de la plantilla en la base
* de datos del sistema.
* 
* @author Diego García (DGM)
**/
?>
<fieldset>
	<legend>Agregar plantilla</legend>

	<?php
		$atributos = array('class' => 'form', 'id' => 'formAgregar');
		echo form_open('plantillas/postAgregarPlantilla', $atributos);
	?>
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
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="control-group">
					<label class="control-label" for="editor">3-.<font color="red">*</font> Cuerpo del mensaje:</label>
					<div class="controls">
						
						<textarea id="editor" name="editor" class="span12 ckeditor" title="Ingrese el texto del mensaje que desea guardar como plantilla" required>
						</textarea>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarPlantilla()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="borrarCKEditor()" >
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
	<?php echo form_close(""); ?>
</fieldset>
