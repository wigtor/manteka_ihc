<?php
/**
* Este Archivo corresponde al cuerpo central de la vista modificar coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>

<script type="text/javascript">
    var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+"];
	var prefijo_tipoDato = "coordinador_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Coordinadores/getCoordinadoresAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/coordinadores") ?>";


	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/getDetallesCoordinadorAjax") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#rut').val($.trim(datos.rut));
				$('#nombre1').val($.trim(datos.nombre1));
				$('#nombre2').val((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$('#apellido1').val($.trim(datos.apellido1));
				$('#apellido2').val($.trim(datos.apellido2));
				$('#correo1').val(datos.correo1 == "" ? '' : $.trim(datos.correo1));
				$('#correo2').val(datos.correo2 == "" ? '' : $.trim(datos.correo2));
				$('#telefono').val(datos.telefono == "" ? '' : $.trim(datos.telefono));
				$('#tipo').val($.trim(datos.id_tipo));

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
				saveState();
			}
		});
	}
    
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

	function resetearCoordinador() {
		$('#rut').val("");
		$('#nombre1').val("");
		$('#nombre2').val("");
		$('#apellido1').val("");
		$('#apellido2').val("");
		$('#correo1').val("");
		$('#correo2').val("");
		$('#telefono').val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}

	function editarCoordinador(){
		var form = document.forms["formEditar"];
		if ($('#rut').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado coordinador');
			$('#textoErrorDialog').html('No ha seleccionado un coordinador para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios del coordinador en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

</script>

<fieldset>
	<legend>Editar coordinador</legend>
	<div class="row-fluid">
		<div class="span6">
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
			1.-Listado coordinadores
		</div>
		<div class="span6" >
			<font color="red">* Campos Obligatorios</font>
			<p>2.-Complete los datos del formulario para modificar el coordinador:</p>
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
				$attributes = array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Coordinadores/postEditarCoordinador', $attributes);
			?>
				<div class="control-group">
					<label class="control-label" for="rut">1-.<font color="red">*</font> RUT:</label>
					<div class="controls">
						<input type="text" id="rut" name="rut" class="span12" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre1">2-.<font color="red">*</font> Primer nombre:</label>
					<div class="controls">
						<input type="text" id="nombre1" name="nombre1" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Juan" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre2">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombre2" name="nombre2" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Mario" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido1">4-.<font color="red">*</font> Apellido Paterno:</label>
					<div class="controls">
						<input type="text" id="apellido1" name="apellido1" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido2">5-.<font color="red">*</font> Apellido Materno:</label>
					<div class="controls">
						<input type="text" id="apellido2" name="apellido2" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" placeholder="Perez" maxlength="20" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="correo1">6-.<font color="red">*</font> Correo:</label>
					<div class="controls">
						<input type="email" id="correo1" name="correo1" class="span12" onblur="comprobarCorreos(correo1, correo2)" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="correo2">7-. Correo secundario:</label>
					<div class="controls">
						<input type="email" id="correo2" name="correo2" class="span12" onblur="comprobarCorreos(correo1, correo2)" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" maxlength="40" placeholder="nombre_usuario2@miemail.com" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="telefono">7-. Teléfono:</label>
					<div class="controls">
						<input type="text" id="telefono" name="telefono" class="span12" maxlength="10" pattern="[0-9]+" placeholder="44556677" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="resetContrasegna">9-. Resetear contraseña</label>
					<div class="controls">
						<input type="checkbox" id="resetContrasegna" name="resetContrasegna">
					</div>
				</div>

				<div class="control-group">
					<div class="controls ">
						<button type="button" class="btn" onclick="editarCoordinador()">
							<i class= "icon-pencil"></i>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearCoordinador()" >
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
	</div>
</fieldset>
