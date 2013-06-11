
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
				var mantenerDatos = datosEditarProfesor(rut,nombre1,nombre2,apellidoPaterno,apellidoMaterno,telefono);
		}
	}
</script>
<script type="text/javascript">
// rut,nom1,nom2,ap1,ap2,tele,tipo
	function datosEditarProfesor(elemTabla){
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
				$(rut).val(datos.rut);
				$(nombre1).val(datos.nombre1);
				$(nombre2).val((datos.nombre2 == "" ? '' : datos.nombre2));
				$(apellido1).val(datos.apellido1);
				$(apellido2).val(datos.apellido2);
				$(telefono).val(datos.telefono);
				//$(tipo).val(datos.fono);

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});	
		}
</script>

<script>
	function seleccionar_filtro(option){
    	var selectorFiltro = option;
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

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
					tr.setAttribute("id", "coordinador_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "datosEditarProfesor(this)");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}

				$(option).prevent;
				$('#select-filtro li').removeClass("active");
				$(option).addClass("active");
				$("#show-filtro").empty().append($('#select-filtro li.active').text());

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}

		});

		
    }
    $("ul#select-filtro li a").click(function(event) {
	    event.preventDefault();
	});

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
	//$(document).ready(cambioTipoFiltro);

	$(document).ready(function(){
    	//$("form.span9, #visualizar-coordinador").hide();
    	$("#select-filtro li.active").click();

    });

</script>
		<fieldset>
			<legend>Editar Profesor</legend>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<div class="row-fluid">
							<div class="span6">
								1.-Listado Profesores
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<div class="span6">
									<input class="span11" id="filtroLista" type="text" placeholder="Filtro" onkeypress="getDataSource(this)" onChange="seleccionar_filtro(document.getElementById('select-filtro').getElementsByClassName('active')[0])" >
									<div class="btn-group">
										<button class="btn dropdown-toggle" data-toggle="dropdown">
											<span id="show-filtro">Filtrar por</span>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" id="select-filtro">
											<li onclick="seleccionar_filtro(this)" id="filtro1" class="active" value="1">
												<a href>Nombre</a>
											</li>
											<li onclick="seleccionar_filtro(this)" id="filtro2" class="passive" value="2" >
												<a href>Apellido Paterno</a>
											</li>
											<li onclick="seleccionar_filtro(this)" id="filtro3" class="passive" value="3">
												<a href>Apellido Materno</a>
											</li>
											<li onclick="seleccionar_filtro(this)" id="filtro4" class="passive" value="4">
												<a href>Correo Electrónico</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
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
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar el profesor
						</div>
						<form id="FormEditar" type="post" onsubmit="EditarProfesor()">
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">1-.<font color="red">*</font>RUT:</label>
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
										<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Primer nombre:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="nombreProfeEdit1" name="nombre_1" required>
									</div>
								</div>
							</div>
														<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Segundo nombre:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="nombreProfeEdit2" name="nombre_2" required>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Apellido Paterno:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="apellidoPaternoProfeEdit" name="apellidoPaterno_profe" required>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido Materno:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="apellidoMaternoProfeEdit" name="apellidoMaterno_profe" required>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">5-.<font color="red">*</font>Telefono</label>
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
