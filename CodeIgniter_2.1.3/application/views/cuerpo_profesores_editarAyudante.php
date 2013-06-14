<script type="text/javascript">
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>";

	
	function EditarEstudiante(){

		var rut = document.getElementById("rutEditar").value;
		var nombreUno =	document.getElementById("nombreunoEditar").value;
		var nombreDos =	document.getElementById("nombredosEditar").value;
		var apellidoPaterno = document.getElementById("apellidopaternoEditar").value;
		var apellidoMaterno = document.getElementById("apellidomaternoEditar").value;
		var correo = document.getElementById("correoEditar").value;
	
		if(rut!="" && nombreUno!=""  && apellidoPaterno!="" && apellidoMaterno!="" && correo!=""){
			var answer = confirm("¿Está seguro de realizar cambios?")
			if (!answer){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			alert("Inserte todos los datos");
			return false;
		}
	}
</script>


<script type="text/javascript">
	
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
			url: "<?php echo site_url("Ayudantes/postDetallesAyudante") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutEditar");
				var nombre1Detalle = document.getElementById("nombreunoEditar");
				var nombre2Detalle = document.getElementById("nombredosEditar");
				var apellido1Detalle = document.getElementById("apellidopaternoEditar");
				var apellido2Detalle = document.getElementById("apellidomaternoEditar");
				var correoDetalle = document.getElementById("correoEditar");
				
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
</script>


<fieldset>
	<legend>Editar ayudante</legend>
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
			1.-Listado ayudantes
		</div>
		<div class="span6" >
			2.-Complete los datos del formulario para modificar el ayudante:
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
				$attributes = array('onSubmit' => 'return EditarEstudiante()', 'id' => 'FormEditar', 'class' => 'form-horizontal');
				echo form_open('Ayudantes/EditarAyudante', $attributes);
			?>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">1-.RUT</label>
					<div class="controls">
						<input type="text" id="rutEditar" name="rut_ayudante" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre</label>
					<div class="controls">
						<input type="text" id="nombreunoEditar" name="nombre1_ayudante" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" id="nombredosEditar" name="nombre2_ayudante" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido Paterno</label>
					<div class="controls">
						<input type="text" id="apellidopaternoEditar" name="apellido_paterno" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font>Apellido Materno</label>
					<div class="controls">
						<input type="text" id="apellidomaternoEditar" name="apellido_materno" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo</label>
					<div class="controls">
						<input type="email" id="correoEditar" name="correo_ayudante" maxlength="20" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>

				<div class="control-group">
					<div class="controls ">
						<button class="btn" type="submit" >
							<i class= "icon-pencil"></i>
							&nbsp; Guardar
						</button>
						<button class="btn" type="button" onclick="resetearAyudante()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>&nbsp;
					</div>
				</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>