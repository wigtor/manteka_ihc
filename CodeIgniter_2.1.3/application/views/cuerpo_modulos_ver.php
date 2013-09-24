<script>
	var tiposFiltro = ["Nombre", "Descripción"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "modulo_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Modulos/getModulosTematicosAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/modulos") ?>";


	function verDetalle(elemTabla) {
		/* Obtengo el código del módulo clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var codigo_modulo = idElem.substring(prefijo_tipoDato.length, idElem.length);

		/* Muestro el div que indica que se está cargando... */
		$('#icono_cargando').show();

		$.ajax({//AJAX PARA OBTENER LOS DETALLES DEL MÓDULO
			type: "POST",
			url: "<?php echo site_url("Modulos/getDetallesModuloTematicoAjax") ?>",
			data: { cod_modulo: codigo_modulo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var datos = jQuery.parseJSON(respuesta);
				$("#nombre_modulo").html(datos.nombre_modulo);
				$('#descripcion_modulo').html(datos.descripcion_modulo == '' ? 'Sin descripción' : $.trim(datos.descripcion_modulo));
				$('#profesor_lider').html(datos.rut_profe_lider == '' ? '' : $.trim(datos.rut_profe_lider)+' - '+$.trim(datos.nombre1_profe_lider)+' '+$.trim(datos.apellido1_profe_lider)+' '+$.trim(datos.apellido2_profe_lider));
				var codigo_modulo = datos.id_mod;

				$.ajax({//AJAX PARA SESIONES
					type: "POST",
					url: "<?php echo site_url("Modulos/getSesionesByModuloTematicoAjax") ?>",
					data: { id_mod_post: codigo_modulo},
					success: function(respuesta) {
						var tablaResultados = document.getElementById("sesiones");
						$(tablaResultados).find('tbody').remove();
						var arrayRespuesta = jQuery.parseJSON(respuesta);
						var tr, td, th, nodoTexto;
						tbody = document.createElement('tbody');

						for (var i = 0; i < arrayRespuesta.length; i++) {
								tr = document.createElement('tr');
								tr.setAttribute("style", "cursor:default");
								td = document.createElement('td');
								if ((arrayRespuesta[i].descripcion == null) || $.trim(arrayRespuesta[i].descripcion) == '') {
									arrayRespuesta[i].descripcion = 'Sin descripción';
								}
								td.setAttribute('title', arrayRespuesta[i].descripcion);
								nodoTexto = document.createTextNode(arrayRespuesta[i].nombre);
								td.appendChild(nodoTexto);
								tr.appendChild(td);
								tbody.appendChild(tr);
						}
						tablaResultados.appendChild(tbody);

					}
				});


				$.ajax({//AJAX PARA EQUIPO y lider
					type: "POST",
					url: "<?php echo site_url("Modulos/getProfesoresByModuloTematicoAjax") ?>",
					data: { id_mod_post: codigo_modulo},
					success: function(respuesta) {
						//para equipo
						var tablaResultados = document.getElementById("equipo");
						$(tablaResultados).find('tbody').remove();
						var arrayRespuesta = jQuery.parseJSON(respuesta);
						var tr, td, th,nodoTexto;
						tbody = document.createElement('tbody');

						for (var i = 0; i < arrayRespuesta.length; i++) {
							tr = document.createElement('tr');
							tr.setAttribute("style", "cursor:default;");
							td = document.createElement('td');
							var asterisco = "";
							if(arrayRespuesta[i].esLider == true) {
								asterisco = "* ";
								tr.setAttribute("style", "cursor:default; font-weight:bold;");
							}
							nodoTexto = document.createTextNode(asterisco+arrayRespuesta[i].rut+" - "+arrayRespuesta[i].nombre1+" "+arrayRespuesta[i].apellido1+" "+arrayRespuesta[i].apellido2);
							
							td.appendChild(nodoTexto);
							tr.appendChild(td);
							tbody.appendChild(tr);
							
						}
						tablaResultados.appendChild(tbody);
					}	
				});

				
				$.ajax({//AJAX PARA implementos
					type: "POST",
					url: "<?php echo site_url("Modulos/getImplementosByModuloTematicoAjax") ?>",
					data: { id_mod_post: codigo_modulo},
					success: function(respuesta) {
						var tablaResultados = document.getElementById("implementos");
						$(tablaResultados).find('tbody').remove();
						var arrayRespuesta = jQuery.parseJSON(respuesta);
						var tr, td, th,nodoTexto;
						tbody = document.createElement('tbody');

						for (var i = 0; i < arrayRespuesta.length; i++) {
								tr = document.createElement('tr');
								tr.setAttribute("style", "cursor:default");
								td = document.createElement('td');
								if ((arrayRespuesta[i].descripcion == null) || $.trim(arrayRespuesta[i].descripcion) == '') {
									arrayRespuesta[i].descripcion = 'Sin descripción';
								}
								td.setAttribute('title', arrayRespuesta[i].descripcion);
								nodoTexto = document.createTextNode(arrayRespuesta[i].nombre);
								td.appendChild(nodoTexto);
								tr.appendChild(td);
								tbody.appendChild(tr);
						}
						tablaResultados.appendChild(tbody);				
					}
				});


				/* Quito el div que indica que se está cargando */
				$('#icono_cargando').hide();
			}
		});
	}

	//Se carga todo por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<fieldset>
	<legend>Ver Módulo Temático</legend>
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
						5.- Implementos necesarios del módulo temático
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div style="border:#cccccc 1px solid;overflow-y:scroll;height:100px; -webkit-border-radius: 4px" >
					<table id="implementos" class="table table-hover">
						<thead>
							<tr>
								<th>
									Nombre implemento
								</th>
							<tr>
						</thead>


					</table>
				</div>
			</div>
		</div>
	</div>
</fieldset>
