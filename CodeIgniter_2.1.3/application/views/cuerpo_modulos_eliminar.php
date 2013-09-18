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

				$('#id_moduloEliminar').val(datos.id_mod); //Se setea el inputo que almacena el módulo que se tiene seleccionado
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

				
				$.ajax({//AJAX PARA requisitos
					type: "POST",
					url: "<?php echo site_url("Modulos/getRequisitosByModuloTematicoAjax") ?>",
					data: { cod_mod_post: codigo_modulo},
					success: function(respuesta) {
						var tablaResultados = document.getElementById("requisitos");
						$(tablaResultados).find('tbody').remove();
						var arrayRespuesta = jQuery.parseJSON(respuesta);
						var tr, td, th,nodoTexto;
						tbody = document.createElement('tbody');

						for (var i = 0; i < arrayRespuesta.length; i++) {
								tr = document.createElement('tr');
								tr.setAttribute("style", "cursor:default");
								td = document.createElement('td');
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

	function resetearModulo() {
		$('#id_moduloEliminar').val("");

		$("#nombre_modulo").html("");
		$('#descripcion_modulo').html("");
		$('#profesor_lider').html("");

		$('#equipo').find('tbody').remove();
		$('#sesiones').find('tbody').remove();
		$('#requisitos').find('tbody').remove();

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}

	function eliminarModulo(){
		if ($('#id_moduloEliminar').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado módulo temático');
			$('#textoErrorDialog').html('No ha seleccionado un módulo temático para eliminar');
			$('#modalError').modal();
			return;
		}
		$('#tituloConfirmacionDialog').html('Confirmación para eliminar módulo temático');
		$('#textoConfirmacionDialog').html('¿Está seguro que desea eliminar permanentemente el módulo temático del sistema?');
		$('#modalConfirmacion').modal();
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
			<?php
				$atributos= array('id' => 'formEliminar');
				echo form_open('Modulos/postEliminarModulo/', $atributos);
			?>
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

			<input type="hidden" id="id_moduloEliminar" name="id_moduloEliminar" value="">
				<div class="control-group">
					<div class="controls pull-right">
						<button type="button" class="btn" onclick="eliminarModulo()">
							<i class= "icon-trash"></i>
							&nbsp; Eliminar
						</button>
						<button class="btn" type="button" onclick="resetearModulo()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						if (isset($dialogos)) {
							echo $dialogos;
						}
					?>
				</div>
			<?php echo form_close(''); ?>
		</div>
	</div>
</fieldset>
