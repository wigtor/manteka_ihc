<script>
	var tiposFiltro = ["Sesión", "Módulo temático"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "sesion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Sesiones/postBusquedaSesiones") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";


function EditarSesion(){
							
		var rut = document.getElementById("nombresesion").value;
		var nombre1 =document.getElementById("descripcionSesion").value;
		var cod =document.getElementById("codigoSesion").value;
		alert(cod);
	//var apellidoPaterno =document.getElementById("apellidoPaternoProfeEdit").value;
	//	var apellidoMaterno =document.getElementById("apellidoMaternoProfeEdit").value;
		//var correo = document.getElementById("mailProfeEdit").value;
	//	var telefono = document.getElementById("telefonoProfeEdit").value;
	//	var modulo = document.getElementById("moduloProfeEdit").value;
		//var seccion = document.getElementById("seccionProfeEdit").value;
	//	var tipo = document.getElementById("tipoProfeEdit").value;
		if(rut!="" && nombre1!="" && cod!=""){
					var answer = confirm("¿Está seguro de realizar cambios?");
					if (!answer){
						return false;
					}
					else{
						var editar = document.getElementById("FormEditar");
						editar.action = "<?php echo site_url("Sesiones/editarSesiones/") ?>";
						editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				return false;
		}
}
function verDetalle(elemTabla) {

	/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
	var idElem = elemTabla.id;
	sesion_clickeado = idElem.substring("sesion_".length, idElem.length);
	//var rut_clickeado = elemTabla;


	/* Defino el ajax que hará la petición al servidor */
	$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: "<?php echo site_url("Sesiones/postDetallesSesion") ?>", /* Se setea la url del controlador que responderá */
		data: { sesion: sesion_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

			/* Obtengo los objetos HTML donde serán escritos los resultados */
			var nombreDetalle = document.getElementById("nombresesion");
			var descripcionDetalle = document.getElementById("descripcionSesion");
			var codigoDetalle = document.getElementById("codigoSesion");
			//var descripcionDetalle = document.getElementById("descripcionDetalle");
			/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
			var datos = jQuery.parseJSON(respuesta);

			/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
			//$(codigoDetalle).html(datos.cod_sesion);
			$(nombreDetalle).val(datos.nombre);
			$(codigoDetalle).val(datos.cod_sesion);
			$(descripcionDetalle).val(datos.descripcion);
		

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
<fieldset>
	<legend>Editar Sesión</legend>
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
			1.-Listado sesiones
		</div>
		<div class="span6" >
			2.-Detalle sesión:
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
			<form id="FormEditar" type="post" method="post" onsubmit="EditarSesion();return false">
			<div class="control-group">
				<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Código de sesión</label>
				<div class="controls">
					<input type="text" readonly id="codigoSesion" name="codigo_sesion" maxlength="99" required >
				</div>

			</div>
			<div class="control-group">
				<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Nombre de sesión</label>
				<div class="controls">
					<input type="text" id="nombresesion" name="nombre_sesion" maxlength="99" required >
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputInfo">3-.<font color="red">*</font> Descripción</label>
				<div class="controls">
					<textarea type="text" id="descripcionSesion" cols="40" rows="5" name="descripcion_sesion" maxlength="99" ></textarea>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls ">
					<button type="button" class="btn"  type="submit">
						<i class= "icon-pencil"></i>
						&nbsp; Guardar
					</button>
					<button  class ="btn" type="button" 'onclick="datosEditarProfesor("","","","","","")"' >
						<div class="btn_with_icon_solo">Â</div>
						&nbsp; Cancelar
					</button>
				</div>
			</div>
		</div>
			</form>
	</div>
</fieldset>