<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1"){
				alert("Profesor eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script>
	function eliminarProfesor(){
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este profesor?")
					if (!answer){
						var dijoNO = resetear();
						return false;
					}
					else{
						return true;
					}
		}
		else{
				alert("Selecione un profesor");
				return false;
		}
	}

	function resetear() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		var rutInputHidden = document.getElementById("rutEliminar");
		$(rutInputHidden).val("");

		/* Obtengo los objetos HTML donde serán escritos los resultados */
		var rutDetalle = document.getElementById("rutDetalle");
		var nombre1Detalle = document.getElementById("nombre1Detalle");
		var nombre2Detalle = document.getElementById("nombre2Detalle");
		var apellido1Detalle = document.getElementById("apellido1Detalle");
		var apellido2Detalle = document.getElementById("apellido2Detalle");
		var telefonoDetalle = document.getElementById("telefonoDetalle");
		var correoDetalle = document.getElementById("correoDetalle");
		var tipoDetalle = document.getElementById("tipoDetalle");
		
		/* Seteo los valores a string vacio */
		$(rutDetalle).html("");
		$(nombre1Detalle).html("");
		$(nombre2Detalle).html("");
		$(apellido1Detalle).html("");
		$(apellido2Detalle).html("");
		$(telefonoDetalle).html("");
		$(correoDetalle).html("");
		$(tipoDetalle).html("");
	}

	function detalleProfesor(elemTabla){

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("profesor_".length, idElem.length);
		//var rut_clickeado = elemTabla;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Profesores/postDetallesProfesor") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombre1Detalle");
				var nombre2Detalle = document.getElementById("nombre2Detalle");
				var apellido1Detalle = document.getElementById("apellido1Detalle");
				var apellido2Detalle = document.getElementById("apellido2Detalle");
				var telefonoDetalle = document.getElementById("telefonoDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				var tipoDetalle = document.getElementById("tipoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(nombre1Detalle).html(datos.nombre1);
				$(nombre2Detalle).html(datos.nombre2);
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				$(telefonoDetalle).html(datos.telefono);
				$(correoDetalle).html(datos.correo);
				$(tipoDetalle).html(datos.tipo);

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

	function cambioTipoFiltro() {
		var selectorFiltro = document.getElementById('tipoDeFiltro');
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Profesores/postBusquedaProfesores") ?>", /* Se setea la url del controlador que responderá */
			data: { textoFiltro: texto, tipoFiltro: valorSelector}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultados");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre Completo");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "profesor_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "detalleProfesor(this)");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
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
	}

	function getDataSource(inputUsado) {
		
	    $(inputUsado).typeahead({
	        minLength: 1,
	        source: function(query, process) {
	        	$.ajax({
		        	type: "POST", /* Indico que es una petición POST al servidor */
					url: "<?php echo site_url("HistorialBusqueda/buscar/profesores") ?>", /* Se setea la url del controlador que responderá */
					data: { letras : query }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
					success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
		            	//alert(respuesta)
		            	var arrayRespuesta = jQuery.parseJSON(respuesta);
		            	process(arrayRespuesta);
		            }
	        	});
	        }
	    });
	}

	//Se cargan por ajax
	$(document).ready(cambioTipoFiltro);
</script>




<fieldset>
	<legend>Borrar Profesor</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado profesores
			<div class="controls controls-row">
				<input class="span6" id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro()" placeholder="Filtro búsqueda">
				
				<select class="span6" id="tipoDeFiltro" onChange="cambioTipoFiltro()" title="Tipo de filtro" name="Filtro a usar">
					<option value="1">Filtrar por nombre</option>
					<option value="2">Filtrar por apellido paterno</option>
					<option value="3">Filtrar por apellido materno</option>
				</select>
			</div>

			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre Completo</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
				<?php
					$atributos= array('onsubmit' => 'return eliminarProfesor()', 'id' => 'formBorrar');
					echo form_open('Profesores/eliminarProfesores/', $atributos);
				?>
				<div class="span6" style="margin-left: 2%; padding: 0%; ">
				2.-Detalle Profesor:
	    <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombre1Detalle"></b> <b id="nombre2Detalle" ></b>
Apellido paterno: <b id="apellido1Detalle" ></b>
Apellido materno: <b id="apellido2Detalle"></b>
Telefono:         <b id="telefonoDetalle" ></b>
Correo:           <b id="correoDetalle" ></b>
Tipo:             <b id="tipoDetalle"></b>
		</pre>
		<input name="rutEliminar" type="hidden" id="rutEliminar" value="">
					<div class="row-fluid">
						<div class="span3 offset5">
							<button class="btn" type="submit">
								<div class="btn_with_icon_solo">b</div>
								&nbsp Borrar
							</button>
						</div>

						<div class="span3">
							<button  class="btn" type="reset" onclick="resetear()" >
								<div class="btn_with_icon_solo">Â</div>
								&nbsp Cancelar
							</button>
						</div>

					</div>
				</div>
				<?php echo form_close(''); ?>
			</div>
</fieldset>




