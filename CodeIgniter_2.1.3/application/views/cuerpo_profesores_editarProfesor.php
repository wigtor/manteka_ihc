<script>

	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
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
				var rut = document.getElementById("runProfeEdit");
				var nombre1 = document.getElementById("nombreProfeEdit1");
				var nombre2 = document.getElementById("nombreProfeEdit2");
				var apellido1 = document.getElementById("apellidoPaternoProfeEdit");
				var apellido2 = document.getElementById("apellidoMaternoProfeEdit");
			//	var rut = document.getElementById("moduloProfeEdit").value = modulo;
				var telefono = document.getElementById("telefonoProfeEdit");
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
				$(telefono).val(datos.telefono == "" ? '' : $.trim(datos.telefono));

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

<script type="text/javascript">
	function EditarProfesor(){
							
		var rut = document.getElementById("runProfeEdit").value;
		var nombre1 =document.getElementById("nombreProfeEdit1").value;
		var nombre2 =document.getElementById("nombreProfeEdit2").value;
		var apellidoPaterno =document.getElementById("apellidoPaternoProfeEdit").value;
		var apellidoMaterno =document.getElementById("apellidoMaternoProfeEdit").value;
		//var correo = document.getElementById("mailProfeEdit").value;
		var telefono = document.getElementById("telefonoProfeEdit").value;
	//	var modulo = document.getElementById("moduloProfeEdit").value;
		//var seccion = document.getElementById("seccionProfeEdit").value;
	//	var tipo = document.getElementById("tipoProfeEdit").value;
		if(rut!="" && nombre1!="" && nombre2!="" && telefono!="" && apellidoPaterno!="" && apellidoMaterno!=""){
					var answer = confirm("¿Está seguro de realizar cambios?");
					if (!answer){
						var dijoNO = datosEditarProfesor("","","","","","");
					}
					else{
						var editar = document.getElementById("FormEditar");
						editar.action = "<?php echo site_url("Profesores/EditarProfesor/") ?>";
						editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				//var mantenerDatos = datosEditarProfesor(rut,nombre1,nombre2,apellidoPaterno,apellidoMaterno,telefono);
		}
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
			1.-Listado profesores
		</div>
		<div class="span6" >
			2.-Complete los datos del formulario para modificar el profesor:
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
			<div style="margin-bottom:2%">
				Complete los datos del formulario para modificar el profesor
			</div>
			<form id="FormEditar" type="post" onsubmit="EditarProfesor()">
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">1-.<font color="red">*</font>RUT:</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="runProfeEdit" name="run_profe" readonly>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre:</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="nombreProfeEdit1" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre_1" required>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">2-. Segundo nombre:</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="nombreProfeEdit2" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre_2" required>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">3-.<font color="red">*</font>Apellido Paterno:</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="apellidoPaternoProfeEdit" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellidoPaterno_profe" required>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido Materno:</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="apellidoMaternoProfeEdit" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellidoMaterno_profe" required>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font>Telefono</label>
						</div>
					</div>
					<div class="span5">	
						<div class="controls">
							<input type="text" id="telefonoProfeEdit" name="telefono_profe">
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span11" style="margin-top:2%">
						<div class="row-fluid">
							<div class="span4 offset4" >
								<button class="btn" type="submit">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Modificar
								</button>
							</div>
							<div class="span4">
								<button  class ="btn" type="reset" <?php $comilla= "'"; echo 'onclick="datosEditarProfesor('.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.')"';?> >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</fieldset>
