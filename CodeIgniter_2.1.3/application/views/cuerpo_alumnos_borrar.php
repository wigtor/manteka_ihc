<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Alumno eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	function detalleAlumno(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("estudiante_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/postDetallesAlumnos") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombreunoDetalle");
				var nombre2Detalle = document.getElementById("nombredosDetalle");
				var apellido1Detalle = document.getElementById("apellidopaternoDetalle");
				var apellido2Detalle = document.getElementById("apellidomaternoDetalle");
				var carreraDetalle = document.getElementById("carreraDetalle");
				var seccionDetalle = document.getElementById("seccionDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(nombre1Detalle).html(datos.nombre1);
				$(nombre2Detalle).html(datos.nombre2);
				$(apellido1Detalle).html(datos.apellido1);
				$(apellido2Detalle).html(datos.apellido2);
				$(carreraDetalle).html(datos.carrera);
				$(seccionDetalle).html(datos.nombre_seccion);
				$(correoDetalle).html(datos.correo);

				//ESTO ES DE QUIENES HICIERON EL BORRADO
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
			url: "<?php echo site_url("Alumnos/postBusquedaAlumnos") ?>", /* Se setea la url del controlador que responderá */
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
					tr.setAttribute("id", "estudiante_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "detalleAlumno(this)");
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
					url: "<?php echo site_url("HistorialBusqueda/buscar/alumnos") ?>", /* Se setea la url del controlador que responderá */
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

<script type="text/javascript">
	function eliminarAlumno(){

		
		
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este estudiante?")
					if (!answer){
						var dijoNO = resetear();
						return false;
					}
					else{
						return true;
					}
		}
		else{
				alert("Selecione un estudiante");
				return false;
		}
	}

	function resetear() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		var rutInputHidden = document.getElementById("rutEliminar");
		$(rutInputHidden).val("");
		/* Obtengo los objetos HTML donde serán escritos los resultados */
		var rutDetalle = document.getElementById("rutDetalle");
		var nombre1Detalle = document.getElementById("nombreunoDetalle");
		var nombre2Detalle = document.getElementById("nombredosDetalle");
		var apellido1Detalle = document.getElementById("apellidopaternoDetalle");
		var apellido2Detalle = document.getElementById("apellidomaternoDetalle");
		var carreraDetalle = document.getElementById("carreraDetalle");
		var correoDetalle = document.getElementById("correoDetalle");
		var seccionDetalle = document.getElementById("seccionDetalle");
		
		/* Seteo los valores a string vacio */
		$(rutDetalle).html("");
		$(nombre1Detalle).html("");
		$(nombre2Detalle).html("");
		$(apellido1Detalle).html("");
		$(apellido2Detalle).html("");
		$(carreraDetalle).html("");
		$(correoDetalle).html("");
		$(seccionDetalle).html("");
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var alumno;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($rs_estudiantes)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_estudiantes[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_estudiantes[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_estudiantes[$contadorE][4].'";';
		echo 'arreglo['.$contadorE.'][7] = "'.$rs_estudiantes[$contadorE][7].'";';
		echo 'arreglo['.$contadorE.'][6] = "'.$rs_estudiantes[$contadorE][6].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		alumno = document.getElementById(cont);
		ocultar=document.getElementById(cont);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
		}
		else
		{
			ocultar.style.display='';
		}
    }
}
</script>


		
		<!--<form id="FormBorrar" type="post" onsubmit="eliminarAlumno();return false" method="post">-->
		<fieldset>
			<legend>Borrar Alumno</legend>
			<div class= "row-fluid">
				<div class="span6">
					1.-Listado alumnos
					<div class="controls controls-row">
						<input autocomplete="off" class="span6" id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro()" placeholder="Filtro búsqueda">
						
						<select class="span6" id="tipoDeFiltro" onChange="cambioTipoFiltro()" title="Tipo de filtro" name="Filtro a usar">
							<option value="1">Filtrar por nombre</option>
							<option value="2">Filtrar por apellido paterno</option>
							<option value="3">Filtrar por apellido materno</option>
							<option value="4">Filtrar por carrera</option>
							<option value="5">Filtrar por seccion</option>
							<option value="6">Filtrar por bloque horario</option>
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
					$atributos= array('onsubmit' => 'return eliminarAlumno()', 'id' => 'FormBorrar');
					echo form_open('Alumnos/eliminarAlumno/', $atributos);
				?>
				<div class="span6" style="margin-left: 2%; padding: 0%; ">
					2.-Detalle alumno:
					<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
<input name="rut_estudiante" type="hidden" id="rutEliminar" value="">
					</pre>
				
					<div class="row" style="margin-top: 2%">
	
							<div class="span3 offset6">
								<button class="btn" type="submit" style="width: 93px">
									<div class= "btn_with_icon_solo">b</div>
									&nbsp Borrar
								</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" type="reset" onclick="resetear()" style="width: 105px">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>

					</div>
				</div>
				<?php echo form_close(''); ?>
			</div>
		</fieldset>
