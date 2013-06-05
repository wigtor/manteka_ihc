<script>
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
	function detalleSesion(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		cod_clickeado = idElem.substring("sesion_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Sesiones/postDetallesSesiones") ?>", /* Se setea la url del controlador que responderá */
			data: { codigo: cod_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
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
				$(descripcionDetalle).html(datos.descipcion);
			

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}
	function cambioTipoFiltro() {
		var selectorFiltro = document.getElementById('tipoDeFiltro');
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;
		//if (texto.trim() != "") {
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Sesiones/postBusquedaSesiones") ?>", /* Se setea la url del controlador que responderá */
				data: { textoFiltro: texto, tipoFiltro: valorSelector}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var tablaResultados = document.getElementById("listadoResultados");
					var nodoTexto;
					$(tablaResultados).empty();
					var arrayRespuesta = jQuery.parseJSON(respuesta);
					for (var i = 0, tr, td; i < arrayRespuesta.length; i++) {
						tr = document.createElement('tr');
						td = document.createElement('td');
						tr.setAttribute("id", "sesion_"+arrayRespuesta[i].cod_sesion);
						tr.setAttribute("onClick", "detalleSesion(this)");
						nodoTexto = document.createTextNode(arrayRespuesta[i].nombre);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
					}
					
					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					}
			});

			/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
		//}
	}

	//Se cargan por ajax
	$(document).ready(cambioTipoFiltro);
</script>
<fieldset>
	<legend>Editar Sesión</legend>
	<div class="row-fluid">
		<div class="span6">
			<font color="red">*Campos Obligatorios</font>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Seleccione una sesión para editar
				</div>
			</div>
			<div class="row-fluid">
				<div class="span11">
					<div class="row-fluid">
							<div class="span6">
							<input id="filtroLista" type="text" onChange="cambioTipoFiltro()" placeholder="Filtro búsqueda" style="width:90%">
						</div>
						<div class="span6">
							<select id="tipoDeFiltro" onChange="cambioTipoFiltro()" title="Tipo de filtro" name="Filtro a usar">
								<option value="1">Filtrar por nombre</option>
								<option value="2">Filtrar por código de sesión</option>

							</select>
						</div>
					</div>
				</div>
			</div>

			
			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div  class= "row-fluid" style="margin-left:2%">

			<div class= "span6" style = "margin-left: 43px">
				<form id="FormEditar" type="post" method="post" onsubmit="EditarSesion();return false">
					<div class="row"> <!-- descipción -->
						<div class="row-fluid">
				<div class="span6" style ="width: 400px">
					Complete el formulario para poder modificar una sesión
				</div>
			</div>
					</div>	
					<div class="row"> <!-- descipción -->
						<div class="span4">
							<div class="control-group">
								<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Código de sesión</label>
							</div>
						</div>
						<div class="span5">	
								<div class="controls">
									<input type="text" readonly id="codigoSesion" name="codigo_sesion" maxlength="99" required >
								</div>
						</div>

					</div>	
					<div class="row"> <!-- codigo -->
						<div class="span4">
							<div class="control-group">
								<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Nombre de sesión</label>
							</div>
						</div>
						<div class="span5">	
								<div class="controls">
									<input type="text" id="nombresesion" name="nombre_sesion" maxlength="99" required >
								</div>
						</div>
					</div>
					<div class="row"> <!-- descipción -->
						<div class="span4">
							<div class="control-group">
								<label class="control-label" for="inputInfo">3-.<font color="red">*</font> Descripción</label>
							</div>
						</div>
						<div class="span5">	
								<div class="controls">
									<textarea type="text" id="descripcionSesion" cols="40" rows="5" name="descripcion_sesion" maxlength="99" ></textarea>
								</div>
						</div>

					</div>	
				
				<div class="row-fluid">
								<div class="span11" style="margin-top:2%">
									<div class="row-fluid">
										<div class="span4 " style="margin-left:37%; width: 27%">
											<button class="btn" style="width: 108px" type="submit">
												<div class= "btn_with_icon_solo">Ã</div>
												&nbsp Modificar
											</button>
										</div>
										<div class="span4">
											<button  class ="btn" style="width:106px" type="reset" <?php $comilla= "'"; echo 'onclick="datosEditarProfesor('.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.')"';?> >
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
	</div>

</fieldset>