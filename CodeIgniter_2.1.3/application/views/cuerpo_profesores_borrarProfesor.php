<script type="text/javascript">
	var tiposFiltro = ["Rut", "Nombre", "Apellido", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Profesores/postBusquedaProfesores") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/profesores") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("ayudante_".length, idElem.length);
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Profesores/postDetallesProfesor") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombre1Detalle");
				var nombre2Detalle = document.getElementById("nombre2Detalle");
				var apellido1Detalle = document.getElementById("apellido1Detalle");
				var apellido2Detalle = document.getElementById("apellido2Detalle");
				var telefonoDetalle = document.getElementById("telefonoDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				var tipoDetalle = document.getElementById("tipoDetalle");
				var moduloTematicoDetalle = document.getElementById("moduloTematicoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);
				if (datos.nombre2 == null) {
					datos.nombre2 = '';
				}
				if (datos.correo2 == null) {
					datos.correo2 = '';
				}
				if (datos.moduloTem == null) {
					datos.moduloTem = '';
				}


				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html($.trim(datos.rut));
				$(nombre1Detalle).html($.trim(datos.nombre1));
				$(nombre2Detalle).html((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				$(telefonoDetalle).html(datos.telefono == "" ? '' : $.trim(datos.telefono));
				$(correoDetalle).html($.trim(datos.correo));
				$(tipoDetalle).html($.trim(datos.tipo));
				$(moduloTematicoDetalle).html($.trim(datos.moduloTem));

				var rutInputHidden = document.getElementById("rutEliminar");
				$(rutInputHidden).val(datos.rut);
				
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


<script>
	function eliminarProfesor(){
		rutAEliminar = $("#rutDetalle").html();
		if(rutAEliminar == ""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		$('#modalConfirmacion').modal();
	}

	function resetearProfesor() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		$('#rutEliminar').val("");

		/* Seteo los valores a string vacio */
		$('#rutDetalle').html("");
		$('#nombre1Detalle').html("");
		$('#nombre2Detalle').html("");
		$('#apellido1Detalle').html("");
		$('#apellido2Detalle').html("");
		$('#telefonoDetalle').html("");
		$('#correoDetalle').html("");
		$('#tipoDetalle').html("");
		$('#moduloTematicoDetalle').html("");

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
	}
</script>




<fieldset>
	<legend>Borrar Profesor</legend>
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
			1.-Listado profesores
		</div>
		<div class="span6" >
			2.-Detalle profesor:
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
			$atributos= array('onsubmit' => 'return eliminarProfesor()', 'id' => 'formBorrar');
			echo form_open('Profesores/eliminarProfesores/', $atributos);
		?>
	    <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombre1Detalle"></b> <b id="nombre2Detalle" ></b>
Apellido paterno: <b id="apellido1Detalle" ></b>
Apellido materno: <b id="apellido2Detalle"></b>
Telefono:         <b id="telefonoDetalle" ></b>
Correo:           <b id="correoDetalle" ></b>
Correo secundario:<b id="correoDetalle2" ></b>
Tipo:             <b id="tipoDetalle"></b>
Módulo temático:  <b id="moduloTematicoDetalle"></pre>
		<input name="rutEliminar" type="hidden" id="rutEliminar" value="">
			<div class="control-group">
				<div class="controls pull-right">
					<button type="button" class="btn" onclick="eliminarProfesor()">
						<i class= "icon-trash"></i>
						&nbsp; Eliminar
					</button>
					<button class="btn" type="button" onclick="resetearProfesor()" >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>&nbsp;


					<!-- Modal de confirmación -->
					<div id="modalConfirmacion" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Confirmación</h3>
						</div>
						<div class="modal-body">
							<p>Se va a eliminar el profesor ¿Está seguro?</p>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
							<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
						</div>
					</div>

					<!-- Modal de confirmación -->
					<div id="modalSeleccioneAlgo" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>No ha seleccionado un profesor</h3>
						</div>
						<div class="modal-body">
							<p>Por favor seleccione un profesor y vuelva a intentarlo</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(''); ?>
	</div>
</fieldset>




