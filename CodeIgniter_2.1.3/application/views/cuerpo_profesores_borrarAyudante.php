<script type="text/javascript">
function detalleAyudante(elemTabla) {

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
				var rutEliminar = document.getElementById("rutEliminar");
				var nombre1Detalle = document.getElementById("nombreunoDetalle");
				var nombre2Detalle = document.getElementById("nombredosDetalle");
				var apellido1Detalle = document.getElementById("apellidopaternoDetalle");
				var apellido2Detalle = document.getElementById("apellidomaternoDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(rutEliminar).val(datos.rut);
				$(nombre1Detalle).html(datos.nombre1);
				$(nombre2Detalle).html(datos.nombre2);
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				$(correoDetalle).html(datos.correo);

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
}
</script>

<script type="text/javascript">
	function eliminarAyudante(){
		
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este ayudante?")
					if (!answer){
						var dijoNO = DetalleAlumno("","","","","","");
					}
					else{
		
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Ayudantes/EliminarAyudante/") ?>/"+rut;
					borrar.submit();
					}
		}
		else{
				alert("Selecione un ayudante");
		}
	}
</script>

<script type="text/javascript">

function cambioTipoFiltro() {
		var selectorFiltro = document.getElementById('tipoDeFiltro');
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Ayudantes/postBusquedaAyudantes") ?>", /* Se setea la url del controlador que responderá */
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
					tr.setAttribute("id", "ayudante_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "detalleAyudante(this)");
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
	}

	function getDataSource(inputUsado) {
			$(inputUsado).typeahead({
	        minLength: 1,
	        source: function(query, process) {
	        	$.ajax({
		        	type: "POST", /* Indico que es una petición POST al servidor */
					url: "<?php echo site_url("HistorialBusqueda/buscar/ayudantes") ?>", /* Se setea la url del controlador que responderá */
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


<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Borrar Ayudante</legend>
			<div class= "row-fluid">
					
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							1.-Listado Ayudantes
						</div>
					</div>
				<div class="row-fluid">
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="filtroLista" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
							<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" onChange="cambioTipoFiltro()" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="2">Filtrar por Apellido paterno</option>
									<option value="3">Filtrar por Apellido materno</option>
									<option value="4">Filtrar por Correo Electrónico</option>
									</select>
							</div> 
						</div>
					</div>
				</div>
				<!--AQUÍ VA LA LISTA-->
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
					<!--AQUÍ VA LA LISTA-->
				</div>
			

				<div class="span6">
					<div style="margin-bottom:0%">
							2.-Detalle del Ayudante:
					</div>
					<form id="formBorrar" type="post">
					<div class="row-fluid">
						<div >
						<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
				  <input type="hidden" id="rutEliminar" value="">
								
						</div>
					</div>
					<div class= "row-fluid" >
						<div class="row-fluid" style=" margin-top:10px; margin-left:50%">		
							<div class="span3 ">
								<button class="btn" style="width: 93px" onclick="eliminarAyudante()" >
									<div class= "btn_with_icon_solo">b</div>
									&nbsp Borrar
								</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" style="width: 105px" type="reset" onclick="DetalleAlumno('','','','','','')" >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
					</div>
					</form>
				</div>	
			</div>

			
		</fieldset>
	</div>
</div>
