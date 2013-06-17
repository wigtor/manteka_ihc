<script>
function detalleModulo(codigo_modulo,descripcion,cod_equipo,nombre_modulo){
	document.getElementById("nombre_modulo").innerHTML = nombre_modulo;
	document.getElementById("descripcion_modulo").innerHTML = descripcion;	
	profesor_lider = document.getElementById("profesor_lider");
	
			$.ajax({//AJAX PARA SESIONES
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerSesionesVer") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_mod_post: codigo_modulo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("sesiones");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);				
				var tr, td, th, thead,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre sesiones");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					
						tr = document.createElement('tr');
						td = document.createElement('td');
						td.setAttribute('title', arrayRespuesta[i].DESCRIPCION_SESION);
						nodoTexto = document.createTextNode(arrayRespuesta[i].NOMBRE_SESION);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});
		
		$.ajax({//AJAX PARA EQUIPO y lider
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerProfesVer") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_equipo_post: cod_equipo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
			//para equipo
			var tablaResultados = document.getElementById("equipo");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre profesores");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++){
					if(arrayRespuesta[i].LIDER_PROFESOR ==0){
						tr = document.createElement('tr');
						td = document.createElement('td');
						nodoTexto = document.createTextNode(arrayRespuesta[i].APELLIDO1_PROFESOR+" "+arrayRespuesta[i].APELLIDO2_PROFESOR+" "+arrayRespuesta[i].NOMBRE1_PROFESOR+" "+arrayRespuesta[i].NOMBRE2_PROFESOR);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
					}
					else{
						profesor_lider.innerHTML = arrayRespuesta[i].APELLIDO1_PROFESOR+" "+arrayRespuesta[i].APELLIDO2_PROFESOR+" "+arrayRespuesta[i].NOMBRE1_PROFESOR+" "+arrayRespuesta[i].NOMBRE2_PROFESOR;
					}
					
				}
			
				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
				
		});
		$.ajax({//AJAX PARA requisitos
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerRequisitosVer") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_mod_post: codigo_modulo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("requisitos");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre Requisitos");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					
						tr = document.createElement('tr');
						td = document.createElement('td');
						td.setAttribute('title', arrayRespuesta[i].DESCRIPCION_REQUISITO);
						nodoTexto = document.createTextNode(arrayRespuesta[i].NOMBRE_REQUISITO);
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
	function cargarModulos() {
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/verModulosEditar") ?>", /* Se setea la url del controlador que responderá */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("modulos");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre módulo");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				
				for (var i = 0; i < arrayRespuesta.length; i++){
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "modulo_"+arrayRespuesta[i].cod_mod);
					tr.setAttribute("onClick", "detalleModulo('"+arrayRespuesta[i].cod_mod+"','"+arrayRespuesta[i].descripcion+"','"+arrayRespuesta[i].cod_equipo+"','"+arrayRespuesta[i].nombre_mod+"')");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre_mod);
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
		
	$(document).ready(cargarModulos);


</script>

<div>
	<div class="span10">
		<fieldset>
			<legend>Ver Módulos</legend>
			<div class="row-fluid">
				<div class="span6">
					<div class="controls controls-row">
						<div class="input-append span7">
							<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda" title="no implementado aun, pega de G1" >
							<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			
	  		<div class="row-fluid">
				<div class="span6">
					1. Escoja un módulo de la lista
				</div>
				<div class="span6">
					2. Detalle Módulo Temático
				</div>
			</div>

			<div class="row-fluid" >
				<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
					<table id="modulos" class="table table-hover">
						<thead>

						</thead>
						<tbody>									
									
											
						</tbody>
					</table>
				</div>
				
				<div class="span6" style="padding: 0%; ">
					<div class ="row-fluid">
						<pre style="padding: 2%; height:6%">
Nombre del módulo:	<b id="nombre_modulo"></b>
Profesor lider: 	<b id="profesor_lider"></b>
Descripción módulo: <b id="descripcion_modulo"></b>
</pre>
						
					</div>
					<div class="row-fluid">
					
						<div class="span6">
							3. Sesiones del Módulo Temático
						</div>
						
					</div>
					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >																		
								<table id="sesiones" class="table table-hover">
									<thead>

									</thead>
									<tbody>									
												
														
									</tbody>
								</table>
						</div>
					</div>
					<div class="row-fluid">
						<div class="row-fluid" style="margin-top:2%">
								<div class="span7">
									4. Profesores del Módulo Temático
								</div>
						</div>
					</div>
					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >
											
								<table id="equipo" class="table table-hover">
									<thead>

									</thead>
									<tbody>									
												
														
									</tbody>
								</table>
						</div>
					</div>
					
					
					<div class="row-fluid">
						<div class="row-fluid" style="margin-top:2%">
								<div class="span7">
									5. Requisitos del Módulo Temático
								</div>
						</div>
					</div>
					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >
											
								<table id="requisitos" class="table table-hover">
									<thead>

									</thead>
									<tbody>									
												
														
									</tbody>
								</table>
						</div>
					</div>
					


				</div>
			</div>
		</fieldset>
	</div>
</div>