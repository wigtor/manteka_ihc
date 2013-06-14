<script type="text/javascript">
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>";


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
				var rutDetalle = document.getElementById("rutDetalle");
				var rut_ayudante = document.getElementById("rut_ayudante");
				var nombre1Detalle = document.getElementById("nombreunoDetalle");
				var nombre2Detalle = document.getElementById("nombredosDetalle");
				var apellido1Detalle = document.getElementById("apellidopaternoDetalle");
				var apellido2Detalle = document.getElementById("apellidomaternoDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				var profesorDetalle = document.getElementById("profesorDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				if (datos.nombre1_profe == null) {
					datos.nombre1_profe = '';
				}
				if (datos.nombre2_profe == null) {
					datos.nombre2_profe = '';
				}
				if (datos.apellido1_profe == null) {
					datos.apellido1_profe = '';
				}
				if (datos.apellido2_profe == null) {
					datos.apellido2_profe = '';
				}
				$(rutDetalle).html($.trim(datos.rut));
				$(rut_ayudante).val($.trim(datos.rut));
				$(nombre1Detalle).html(datos.nombre1);
				$(nombre2Detalle).html(datos.nombre2);
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				$(correoDetalle).html($.trim(datos.correo));
				
				var nombre_completo_profe = datos.nombre1_profe+ " " +datos.nombre2_profe+  " " +datos.apellido1_profe+ " " +datos.apellido2_profe; 
				$(profesorDetalle).html(nombre_completo_profe);
				var secciones = "";
				/* Esto no se implementa puesto no hay forma de relacionar un ayudante con una sección aún
				for (var i = 0; i < datos.secciones.length; i++) {
					secciones = secciones + ", " + datos.secciones[i];
				}
				*/

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
}
</script>

<script type="text/javascript">
	function eliminarAyudante(){
		
		var rut = document.getElementById("rut_ayudante").value;
		
		if(rut!=""){
			var answer = confirm("¿Está seguro de eliminar este ayudante?")
			if (!answer){
				var dijoNO = resetear();
				return false;
			}
			else{
				return true;
			}
		}
		else {
			alert("Selecione un ayudante");
			return false;
		}
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
</script>

<fieldset>
	<legend>Borrar ayudantes</legend>
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
			2.-Detalle ayudante:
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
				$attributes = array('onSubmit' => 'return eliminarAyudante()', 'id' => 'formBorrar');
				echo form_open('Ayudantes/EliminarAyudante', $attributes);
			?>
				<pre style="padding: 2%; cursor:default">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle" ></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle" ></b>
Correo:           <b id="correoDetalle" ></b>
Profesor guía:    <b id="profesorDetalle" ></b>
Secciones:        <b id="seccionesDetalle" ></b></pre>
				<input type="hidden" id="rut_ayudante" name="rut_ayudante" value="">
				<div class="control-group">
					<div class="controls pull-right">
						<button class="btn" type="submit" >
							<i class= "icon-trash"></i>
							&nbsp; Eliminar
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
