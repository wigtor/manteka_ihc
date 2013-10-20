<script>
	var tiposFiltro = ["Nombre", "Descripción"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "modulo_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Modulos/getModulosTematicosAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/modulos") ?>";

	function editarModulo(){
		var form = document.forms["formEditar"];
		if ($('#id_moduloSeleccionado').val().trim() == '') {
			$('#tituloErrorDialog').html('Error, no ha seleccionado módulo temático');
			$('#textoErrorDialog').html('No ha seleccionado un módulo temático para editar');
			$('#modalError').modal();
			return;
		}
		if (form.checkValidity()) {
			$('#tituloConfirmacionDialog').html('Confirmación para guardar cambios');
			$('#textoConfirmacionDialog').html('¿Está seguro que desea guardar los cambios del módulo temático en el sistema?');
			$('#modalConfirmacion').modal();
		}
		else {
			$('#tituloErrorDialog').html('Error en la validación');
			$('#textoErrorDialog').html('Revise los campos del formulario e intente nuevamente');
			$('#modalError').modal();
		}
	}

	function resetearModulo() {
		$('#id_moduloSeleccionado').val("");

		$('#nombre').val("");
		$('#descripcion').val("");
		$('#id_requisitos').val("");
		$('#id_profesorLider').val("");
		$('#id_profesoresEquipo').val("");

		//Se limpia lo que está seleccionado en la tabla
		$('tbody tr').removeClass('highlight');
	}


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
				$("#descripcion").html(datos.nombre_modulo);
				$("#nombre").val(datos.nombre_modulo);
				$('#descripcion_modulo').val(datos.descripcion_modulo == '' ? 'Sin descripción' : $.trim(datos.descripcion_modulo));
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

		
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
</script>

<script type="text/javascript">
	

function nombreEnUso(){
	nombre_tentativo = document.getElementById("nombre_modulo");
	nombre_tentativo2 = document.getElementById("nombre_modulo2");
	
	var arreglo = new Array();
	var cont = 0;
	<?php
	$contadorE = 0;
	while($contadorE<count($nombre_modulos)){
		echo 'arreglo['.$contadorE.'] = "'.$nombre_modulos[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	for(cont=0;cont < arreglo.length;cont++){
		if(arreglo[cont].toLowerCase () == nombre_tentativo.value.toLowerCase() && nombre_tentativo.value != nombre_tentativo2.value){
				$('#NombreEnUso').modal();
				nombre_tentativo.value="";
				return;
		}

    }

}
function noPuedeEstar(rut,num_lista,nopuede){
		var lider = document.getElementsByName("cod_profesor_lider");
		var equipo = document.getElementsByName("profesores[]");
		var cont;
		var numS = -1;
		
		if(num_lista==1){//marco uno de equipo
			for(cont=0;cont < lider.length;cont++){
				if(lider[cont].checked == true){
					numS = cont;
					cont = lider.lenght;
				}
			}
			if(lider[numS].value == rut){
				$('#LiderDelEquipo').modal();
				document.getElementById(rut).checked = false;
				return;
			}
		}
		else{
			for(cont=0;cont < equipo.length;cont++){
				if(equipo[cont].checked == true && equipo[cont].value ==rut){
					$('#LiderDelEquipo').modal();
					document.getElementById(rut).checked = false;
					return;						
				}
			}
		}
		if(nopuede == 9){
			if(num_lista == 1){
				for(cont=0;cont < equipo.length;cont++){
					if(equipo[cont].checked == true && equipo[cont].value ==rut){
						$('#noDosequipos').modal();
						equipo[cont].checked = false;
						return;						
					}
				}			
			}
			else{
				for(cont=0;cont < lider.length;cont++){
					if(lider[cont].checked == true && lider[cont].value ==rut){
						$('#noDosequipos').modal();
						lider[cont].checked = false;
						return;						
					}
				}
			}
		}
	}
</script>

<fieldset style="min-width: 1000px;">
	<legend>Editar Módulo</legend>
	<div class="row-fluid">
		<div class="span6">
			<font color="red">* Campos Obligatorios</font>
			<div class="controls controls-row">
				<div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<p>1.- Seleccione el módulo temático a editar:</p>
		</div>
		<div class="span6">
			<p>2.- Complete los datos del formulario para modificar el módulo temático:</p>
		</div>
	</div>
	<div class="row-fluid" >
		<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
			<table id="listadoResultados" class="table table-hover">

			</table>
		</div>


		<div class="span6">
			<?php
				$attributes = array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Modulos/postEditarModulo', $attributes);
			?>
				<input name="id_moduloSeleccionado" type="hidden" id="id_moduloSeleccionado" maxlength="6">
				<!-- nombre modulo -->
				<div class="control-group">
					<label class="control-label" for="nombre">1.- <font color="red">*</font> Nombre módulo:</label>
					<div class="controls">
						<input class="span12" id="nombre" required type="text" name="nombre" maxlength="49"  placeholder="Ej: Comunicación no verbal" onblur="nombreEnUso()">
					</div>
				</div>
				<br>

				<!-- descripción módulo temático -->
				<div class="control-group">
					<label class="control-label" for="descripcion">2.- <font color="red">*</font> Ingrese una descripción del módulo:</label>
					<div class="controls">
						<textarea required id="descripcion" name="descripcion" placeholder="Ingrese una descripción para el módulo temático" maxlength="99" rows="5" style="resize: none;" class="span12"></textarea>
					</div>
				</div>
				
				<!-- Requisitos módulo temático -->
				<div class="control-group">
					<label class="control-label" for="id_requisitos">3.- Agregar requisitos existentes:</label>
					<div class="controls">
						<select id="id_requisitos" name="id_requisitos[]" class="span12" title="asigne profesor" multiple="multiple">
						<?php
						if (isset($requisitosModulo)) {
							foreach ($requisitosModulo as $req) {
								?>
									<option value="<?php echo $req->id; ?>"><?php echo $req->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				<!--profesor lider-->
				<div class="control-group">
					<label class="control-label" for="id_profesorLider" >4.- <font color="red">*</font> Asignar profesor lider:</label>
					<div class="controls">
						<select required id="id_profesorLider" name="id_profesorLider" class="span12" title="asigne profesor lider">
						<?php
						if (isset($posiblesProfesoresLider)) {
							foreach ($posiblesProfesoresLider as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>
				<br>
				
				<!--equipo profesores-->
				<div class="control-group">
					<label class="control-label" for="id_profesoresEquipo" >5.- <font color="red">*</font> Profesores del equipo:</label>
					<div class="controls">
						<select required id="id_profesoresEquipo" name="id_profesoresEquipo[]" class="span12" title="Escoja los profesores del equipo" multiple="multiple">
						<?php
						if (isset($posiblesProfesoresEquipo)) {
							foreach ($posiblesProfesoresEquipo as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				</br>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="editarModulo()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Guardar
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
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>
