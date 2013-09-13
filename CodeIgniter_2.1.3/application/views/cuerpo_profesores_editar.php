<script>

	var tiposFiltro = ["Rut", "Nombre", "Apellido", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", "", ""];
	var inputAllowedFiltro = ["[0-9]+", "[A-Za-z]+", "[A-Za-z]+",""];
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
				var rut = document.getElementById("rutEditar");
				var nombre1 = document.getElementById("nombreunoEditar");
				var nombre2 = document.getElementById("nombredosEditar");
				var apellido1 = document.getElementById("apellidopaternoEditar");
				var apellido2 = document.getElementById("apellidomaternoEditar");
				var correo = document.getElementById("correoEditar");
				var correo2 = document.getElementById("correoEditar2");
			//	var rut = document.getElementById("moduloProfeEdit").value = modulo;
				var telefono = document.getElementById("fono");
				var tipo = document.getElementById("tipoProfesor");
			//	document.getElementById("moduloProfeEdit").value = modulo;
			//	document.getElementById("seccionProfeEdit").value = seccion;
				//var tipo = document.getElementById("tipoProfeEdit").value;	

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rut).val($.trim(datos.rut));
				$(nombre1).val($.trim(datos.nombre1));
				$(nombre2).val((datos.nombre2 == "" ? '' : $.trim(datos.nombre2)));
				$(apellido1).val($.trim(datos.apellido1));
				$(apellido2).val($.trim(datos.apellido2));
				if (datos.correo2 == null) {
					datos.correo2 = '';
				}
				$(correo).val($.trim(datos.correo));
				$(correo2).val($.trim(datos.correo2));
				$(telefono).val(datos.telefono == "" ? '' : $.trim(datos.telefono));
				$(tipo).val($.trim(datos.tipo));
				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
                saveState();

			}
		});
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>
<script>
	function correo() {
		var correo = document.getElementById("correoEditar").value;
		var correo1 = document.getElementById("correoEditar2").value;
		if(correo==correo1){
			if(correo!='' && correo1!=''){
				var mensaje = document.getElementById("mensaje");
				$(mensaje).empty();
				$('#modalCorreo').modal();
				document.getElementById("correoEditar").value = "";
				document.getElementById("correoEditar2").value = "";
			}
		}
	}

</script>
<script type="text/javascript">
	function editarProfesor(){
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

		if ((rutAEliminar == "") || (nombre1Detalle == "") || (apellido1Detalle == "") || (apellido2Detalle == "") || (correoDetalle == "") || (correoDetalle2 == "") || (fonoDetalle == "")) {
			$('#modalFaltanCampos').modal();
		}
		else{
			$('#modalConfirmacion').modal();
		}
		
		
		
		
	}



	function resetearProfesor() {

		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var correoDetalle = document.getElementById("correoEditar");
		var fonoDetalle = document.getElementById("fono");
		var correoDetalle2 = document.getElementById("correoEditar2");
		var correoDetalle2 = document.getElementById("resetContrasegna");
		
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
	
	function validar(form){
		if($('input[name="contrasena"]').val() != "" || $('input[name="contrasena2"]').val()!= ""){
			if ($('input[name="contrasena"]').val() != $('input[name="contrasena2"]').val()) {
				alert("Las contrase?as no coinciden.");
				return false;
			}else{
				return true;
			};
		}
		return true;
	}
</script>

<fieldset>
	<legend>Editar Profesor</legend>
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
				<thead>
					
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div class="span6">
			<?php
				$attributes = array('id' => 'FormEditar', 'class' => 'form-horizontal', 'onsubmit' => 'EditarProfesor()');
				echo form_open('Profesores/editarProfesores', $attributes);
			?>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="run_profe">1.- RUT</label>
					<div class="controls">
						<input type="text" id="rutEditar"class="span12" name="run_profe" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="nombre_1">2.- <font color="red">*</font> Primer nombre</label>
					<div class="controls">
						<input type="text"  class="span12" id="nombreunoEditar" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre_1" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  style="cursor: default" for="nombre_2">3.- Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombredosEditar"  class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre_2" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="apellidoPaterno_profe">4.- <font color="red">*</font> Apellido paterno</label>
					<div class="controls">
						<input type="text" id="apellidopaternoEditar" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellidoPaterno_profe" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="apellidoMaterno_profe">5.- <font color="red">*</font> Apellido materno</label>
					<div class="controls">
						<input type="text" id="apellidomaternoEditar" class="span12" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellidoMaterno_profe" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="correo1">6.- <font color="red">*</font> Correo</label>
					<div class="controls">
						<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" id="correoEditar" onblur = "correo()" class="span12" name="correo1" maxlength="40" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="correo2">7.- <font color="red">*</font> Correo secundario</label>
					<div class="controls">
						<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" id="correoEditar2" onblur = "correo()" class="span12" name="correo2" maxlength="40" placeholder="nombre_usuario2@miemail.com" required >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="telefono_profe">8.- <font color="red">*</font> Teléfono</label>
					<div class="controls">
						<input type="text" id="fono" title="Ingrese teléfono solo con números " class="span12" name="telefono_profe" maxlength="10" placeholder="44556677" required >
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" style="cursor: default" for="inputInfo" style="cursor: default">9.- <font color="red">*</font> Tipo:</label>	
					<div  class="controls">
						<select id="tipoProfesor" class="span12" title="Tipo de contrato" name="tipo_profesor">
							<option value="Planta">Profesor Jornada Completa</option>
							<option value="Hora">Profesor Por hora</option>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="span4"  for="resetContrasegna">10.- Resetear contraseña</label>
					<div class="controls">
						<input type="checkbox" id="resetContrasegna" name="resetContrasegna">
					</div>
				</div>
				<div class="row">
				<div class="controls pull-right">
						<button type="button" class="btn" style= "margin-right: 4px" onclick="editarProfesor()">
							<i class= "icon-pencil"></i>
							&nbsp; Guardar
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
								<p>Se van a guardar los cambios del profesor ¿Está seguro?</p>
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
								<h3>No ha seleccionado un profesor</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione un profesor y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
						<!-- Modal Correos iguales-->
						<div id="modalCorreo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>El correo secundario y principal son iguales</h3>
							</div>
							<div class="modal-body">
								<p>Por favor ingrese correos distintos y vuelva a intentarlo.</p>
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
								<p>Por favor complete el campo vacío y vuelva a intentarlo.</p>
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
