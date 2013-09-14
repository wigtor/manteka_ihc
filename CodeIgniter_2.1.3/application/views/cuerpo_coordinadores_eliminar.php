
<?php
/**
* Este Archivo corresponde al cuerpo central de la vista eliminar coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>

<script>
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+"];
	var prefijo_tipoDato = "coordinador_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Coordinadores/getCoordinadoresElimAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/coordinadores") ?>";


function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		//var rut_clickeado = elemTabla;

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

				$('#rutEliminar').val($.trim(datos.rut));

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$('#rut').html($.trim(datos.rut));
				$('#nombre1').html($.trim(datos.nombre1));
				$('#nombre2').html((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$('#apellido1').html($.trim(datos.apellido1));
				$('#apellido2').html($.trim(datos.apellido2));
				$('#correo1').html(datos.correo1 == "" ? '' : $.trim(datos.correo1));
				$('#correo2').html(datos.correo2 == "" ? '' : $.trim(datos.correo2));
				$('#telefono').html(datos.telefono == "" ? '' : $.trim(datos.telefono));

				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	function eliminarCoordinador(){
		if ($('#rutEliminar').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado coordinador');
			$('#textoErrorDialog').html('No ha seleccionado un coordinador para eliminar');
			$('#modalError').modal();
			return;
		}
		$('#tituloConfirmacionDialog').html('Confirmación para eliminar coordinador');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea eliminar permanentemente el coordinador del sistema?');
		$('#modalConfirmacion').modal();
	}

    function resetearCoordinador(){
    	//ESTO ES DE QUIENES HICIERON EL BORRADO
		$('#rutEliminar').val("");

		/* Seteo los valores a string vacio */
		$('#rut').html("");
		$('#nombre1').html("");
		$('#nombre2').html("");
		$('#apellido1').html("");
		$('#apellido2').html("");
		$('#telefono').html("");
		$('#correo1').html("");
		$('#correo2').html("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
    }

    //Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
		
	});

</script>

<fieldset>
	<legend>Eliminar coordinador</legend>
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
			1.- Seleccione el coordinador que desea eliminar:
		</div>
		<div class="span6" >
			2.-Detalle coordinador:
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
			<table id="listadoResultados" class="table table-hover">

				
			</table>
		</div>
		<div class="span6">
			<?php
				$attributes = array('id' => 'formBorrar');
				echo form_open('Coordinadores/postEliminarCoordinador', $attributes);
			?>
				<pre style="padding: 2%; cursor:default">
Rut:              <b id="rut"></b>
Nombres:          <b id="nombre1"></b> <b id="nombre2" ></b>
Apellido paterno: <b id="apellido1" ></b>
Apellido materno: <b id="apellido2"></b>
Teléfono:         <b id="telefono" ></b>
Correo:           <b id="correo1"></b>
Correo secundario:<b id="correo2" ></b></pre>
				<input type="hidden" id="rutEliminar" name="rutEliminar" value="">
				<div class="control-group">
					<div class="controls pull-right">
						<button type="button" class="btn" onclick="eliminarCoordinador()">
							<i class= "icon-trash"></i>
							&nbsp; Eliminar
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
