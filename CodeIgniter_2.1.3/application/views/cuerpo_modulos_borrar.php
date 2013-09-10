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
		
		$('#cod_modulo_eliminar').val(codigo_modulo); //Se setea el inputo que almacena el módulo que se tiene seleccionado


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

	function resetModulos(){
		$('#nombre_modulo').html("");
		$('#descripcion_modulo').html("");
		$('#profesor_lider').html("");
		$('#cod_modulo_eliminar').val("");
		$('#sesiones tbody').remove();
		$('#equipo tbody').remove();
		$('#prof_lider tbody').remove();
		$('#requisitos tbody').remove();

		//Se limpia lo que está seleccionado en la tabla
		$('#listadoResultados tbody tr').removeClass('highlight');
		
		return false;
	}

	function eliminarModulo(){
		if($('#cod_modulo_eliminar').val() == ""){
			$('#modalSeleccioneAlgo').modal();
		}
		else{
			$('#modalConfirmacion').modal();
		}
	}

	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

		<fieldset>
			<legend>Borrar Módulo</legend>
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
					<?php
						$atributos= array('onsubmit' => 'return eliminarModulo()', 'id' => 'FormBorrar');
						echo form_open('Modulos/hacerBorrarModulos/', $atributos);
					?>
					<div class ="row-fluid">
						<pre style="padding: 2%;">
Nombre del módulo:  <b id="nombre_modulo"></b>
Profesor lider:     <b id="profesor_lider"></b>
Descripción módulo: <b id="descripcion_modulo"></b></pre>
						<input value="" id="cod_modulo_eliminar" type="hidden" name="cod_modulo_eliminar">	
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
							<div class="span8" style="min-width:400px">
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
							<div class="span8" style="min-width:300px">
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
					<div class="row-fluid">
						<div class="controls pull-right" style="margin-top:5px;">
							<button class="btn" type="button" onclick="eliminarModulo()">
								<i class="icon-trash"></i>
								&nbsp; Eliminar
							</button>
							<button  class ="btn" type="button" onclick="resetModulos()">
								<div class= "btn_with_icon_solo">Â</div>
								&nbsp; Cancelar
							</button>
						</div>
					</div>

					<!-- Modal de Confirmación -->
					<div id="modalConfirmacion" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Confirmación</h3>
						</div>
						<div class="modal-body">
							<p>Se va a eliminar un módulo ¿Está seguro?</p>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
							<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
							
						</div>
					</div>

					<!-- Modal de seleccionaAlgo -->
					<div id="modalSeleccioneAlgo" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>No ha seleccionado ningun módulo</h3>
						</div>
						<div class="modal-body">
							<p>Por favor seleccione un módulo y vuelva a intentarlo.</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>

					<?php echo form_close(''); ?>
				</div>
			</div>
		</fieldset>
