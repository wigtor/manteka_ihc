<script>
	var tiposFiltro = ["Nombre", "Descripción"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "modulo_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Modulos/postBusquedaModulos") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/modulos") ?>";


	function verDetalle(elemTabla){
		/* Obtengo el código del módulo clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var codigo_modulo = idElem.substring(prefijo_tipoDato.length, idElem.length);

		var descripcion, cod_equipo, nombre_modulo; //Se setean en el primer ajax

		$.ajax({//AJAX PARA OBTENER LOS DETALLES DEL MÓDULO
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/postDetallesModulo") ?>", /* Se setea la url del controlador que responderá */
			async: false, //con esto se hace que el ajax sea sincrono con la función javascript
			data: { cod_modulo: codigo_modulo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var moduloRespuesta = jQuery.parseJSON(respuesta);
				cod_equipo = $.trim(moduloRespuesta.cod_equipo);
				descripcion = $.trim(moduloRespuesta.descripcion);
				nombre_modulo = $.trim(moduloRespuesta.nombre_mod);
				if ($.trim(moduloRespuesta.descripcion) =="") {
					moduloRespuesta.descripcion = "No tiene descripcion";
				}
			}
		});

		$("#nombre_modulo").html(nombre_modulo);
		$("#descripcion_modulo").html(descripcion);

		profesor_lider = document.getElementById("profesor_lider");
	
			$.ajax({//AJAX PARA SESIONES
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerSesionesVer") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_mod_post: codigo_modulo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("sesiones");
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, nodoTexto;
				tbody = document.createElement('tbody');

				for (var i = 0; i < arrayRespuesta.length; i++) {
					
						tr = document.createElement('tr');
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						td.setAttribute('title', arrayRespuesta[i].DESCRIPCION_SESION);
						nodoTexto = document.createTextNode(arrayRespuesta[i].NOMBRE_SESION);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);

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
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th,nodoTexto;
				tbody = document.createElement('tbody');

				for (var i = 0; i < arrayRespuesta.length; i++){
					if(arrayRespuesta[i].LIDER_PROFESOR ==0){
						tr = document.createElement('tr');
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						nodoTexto = document.createTextNode(arrayRespuesta[i].APELLIDO1_PROFESOR+" "+arrayRespuesta[i].APELLIDO2_PROFESOR+" "+arrayRespuesta[i].NOMBRE1_PROFESOR+" "+arrayRespuesta[i].NOMBRE2_PROFESOR);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tbody.appendChild(tr);
					}
					else{
						profesor_lider.innerHTML = arrayRespuesta[i].APELLIDO1_PROFESOR+" "+arrayRespuesta[i].APELLIDO2_PROFESOR+" "+arrayRespuesta[i].NOMBRE1_PROFESOR+" "+arrayRespuesta[i].NOMBRE2_PROFESOR;
					}
					
				}
				tablaResultados.appendChild(tbody);
			
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
				$(tablaResultados).find('tbody').remove();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th,nodoTexto;
				tbody = document.createElement('tbody');

				for (var i = 0; i < arrayRespuesta.length; i++) {
						tr = document.createElement('tr');
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						td.setAttribute('title', arrayRespuesta[i].DESCRIPCION_REQUISITO);
						nodoTexto = document.createTextNode(arrayRespuesta[i].NOMBRE_REQUISITO);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tbody.appendChild(tr);
				}
				tablaResultados.appendChild(tbody);

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
			<legend>Ver Módulo</legend>
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
					1.- Seleccione un módulo temático para ver sus detalles:
				</div>
				<div class="span6">
					2.- Detalle módulo temático
				</div>
			</div>
			<div class="row-fluid" >
				<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
					<table id="listadoResultados" class="table table-hover">

					</table>
				</div>
				
				<div class="span6">
					<div class ="row-fluid">
						<pre style="padding: 2%;">
Nombre del módulo:  <b id="nombre_modulo"></b>
Profesor lider:     <b id="profesor_lider"></b>
Descripción módulo: <b id="descripcion_modulo"></b></pre>
						
					</div>

					<div class="row-fluid">
						<div class="span7">
							3.- Sesiones del módulo temático
						</div>
					</div>

					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >																		
							<table id="sesiones" class="table table-hover">
								<thead>
									<tr>
										<th>
											Nombre sesiones
										</th>
									<tr>
								</thead>


							</table>
						</div>
					</div>

					<div class="row-fluid">
						<div class="row-fluid" style="margin-top:2%">
							<div class="span7">
								4.- Profesores del módulo temático
							</div>
						</div>
					</div>

					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >
							<table id="equipo" class="table table-hover">
								<thead>
									<tr>
										<th>
											Nombre profesores
										</th>
									<tr>
								</thead>


							</table>
						</div>
					</div>
					
					
					<div class="row-fluid">
						<div class="row-fluid" style="margin-top:2%">
							<div class="span7">
								5.- Requisitos del módulo temático
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >
							<table id="requisitos" class="table table-hover">
								<thead>
									<tr>
										<th>
											Nombre requisitos
										</th>
									<tr>
								</thead>


							</table>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
