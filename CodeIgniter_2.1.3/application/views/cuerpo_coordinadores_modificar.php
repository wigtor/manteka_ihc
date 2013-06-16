<?php
/**
* Este Archivo corresponde al cuerpo central de la vista modificar coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Editar coordinador</legend>
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
				echo form_open('Coordinadores/editarCoordinadores', $attributes);
			?>
				<div class="control-group">
					<label class="control-label" for="inputInfo">1-.RUT</label>
					<div class="controls">
						<input type="text" id="rutEditar" name="rutEditar" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Primer nombre</label>
					<div class="controls">
						<input type="text" id="nombreunoEditar" name="nombre1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombredosEditar" name="nombre2" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">4-.<font color="red">*</font> Apellido Paterno</label>
					<div class="controls">
						<input type="text" id="apellidopaternoEditar" name="apellido1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">5-.<font color="red">*</font> Apellido Materno</label>
					<div class="controls">
						<input type="text" id="apellidomaternoEditar" name="apellido2" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">6-.<font color="red">*</font> Correo</label>
					<div class="controls">
						<input type="email" id="correoEditar" name="correo1" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-.<font color="red">*</font> Correo secundario</label>
					<div class="controls">
						<input type="email" id="correoEditar2" name="correo2" maxlength="40" placeholder="nombre_usuario2@miemail.com" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">7-.<font color="red">*</font> Teléfono</label>
					<div class="controls">
						<input type="text" id="fono" name="fono" maxlength="10" placeholder="44556677" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo">8-. Resetear contraseña</label>
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
						</button>&nbsp;

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se van a guardar los cambios del coordinador ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary">Aceptar</button>
							</div>
						</div>

						<!-- Modal de confirmación -->
						<div id="modalSeleccioneAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No ha seleccionado un coordinador</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione un coordinador y vuelva a intentarlo</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>


<script type="text/javascript">
    var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "coordinador_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Coordinadores/postBusquedaCoordinadores") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/coordinadores") ?>";


	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("coordinador_".length, idElem.length);
		//var rut_clickeado = elemTabla;

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/postDetallesCoordinador") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutEditar");
				var nombre1Detalle = document.getElementById("nombreunoEditar");
				var nombre2Detalle = document.getElementById("nombredosEditar");
				var apellido1Detalle = document.getElementById("apellidopaternoEditar");
				var apellido2Detalle = document.getElementById("apellidomaternoEditar");
				var correoDetalle = document.getElementById("correoEditar");
				var fonoDetalle = document.getElementById("fono");
				var correoDetalle2 = document.getElementById("correoEditar2");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				if (datos.nombre1 == null) {
					datos.nombre1 = '';
				}
				if (datos.nombre2 == null) {
					datos.nombre2 = '';
				}
				if (datos.apellido1 == null) {
					datos.apellido1 = '';
				}
				if (datos.apellido2 == null) {
					datos.apellido2 = '';
				}

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).val($.trim(datos.rut));
				$(nombre1Detalle).val(datos.nombre1);
				$(nombre2Detalle).val(datos.nombre2);
				$(apellido1Detalle).val(datos.apellido1);
				$(apellido2Detalle).val(datos.apellido2);
				$(correoDetalle).val($.trim(datos.correo));
				$(correoDetalle2).val($.trim(datos.correo2));
				$(fonoDetalle).val($.trim(datos.fono));

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
			}
		});
	}
    
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

	function resetearCoordinador() {

		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var correoDetalle = document.getElementById("correoEditar");
		var fonoDetalle = document.getElementById("fono");
		var correoDetalle2 = document.getElementById("correoEditar2");
		$(rutDetalle).val("");
		$(nombre1Detalle).val("");
		$(nombre2Detalle).val("");
		$(apellido1Detalle).val("");
		$(apellido2Detalle).val("");
		$(correoDetalle).val("");
		$(correoDetalle2).val("");
		$(fonoDetalle).val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}

	function editarCoordinador(){
		rutAEliminar = $("#rutEditar").val();
		if(rutAEliminar == ""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		nombre1Detalle = $("#nombreunoEditar").val();
		nombre2Detalle = $("#nombredosEditar").val();
		apellido1Detalle = $("#apellidopaternoEditar").val();
		apellido2Detalle = $("#apellidomaternoEditar").val();
		correoDetalle = $("#correoEditar").val();
		correoDetalle2 = $("#correoEditar2").val();
		fonoDetalle = $("#fono").val();
		if ((rutAEliminar == "") || (nombre1Detalle == "") || (apellido1Detalle == "") || (apellido2Detalle == "") || (correoDetalle == "")) {
			return; //Faltan campos!!!
		}
		$('#modalConfirmacion').modal();
	}

jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
    return this.each(function() {
        var select = this;
        var options = [];
        $(select).find('option').each(function() {
            options.push({value: $(this).val(), text: $(this).text()});
        });
        $(select).data('options', options);
        $(textbox).bind('change keyup', function() {
        	$('option').attr("selected",false);
            var options = $(select).empty().data('options');
            var search = $(this).val().trim();
            var regex = new RegExp(search,"gi");
          
            $.each(options, function(i) {
                var option = options[i];
                if(option.text.match(regex) !== null) {
                    $(select).append(
                       $('<option>').text(option.text).val(option.value)
                    );
                }
            });
            if (selectSingleMatch === true && $(select).children().length === 1) {
                $(select).children().get(0).selected = true;
            }
        });            
    });
};

</script>