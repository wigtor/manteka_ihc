<script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>
<script>
	
	function comprobarRut() {
		var rut = document.getElementById("rut_estudiante").value;
		if(rut == ""){return null}
		dv = rut.charAt(rut.length-1);
		rut = rut.substring(0,rut.length-1);
		if(calculaDigitoVerificador(rut,dv) != 0){
			$('#modalRutIncorrecto').modal();
			document.getElementById("rut_estudiante").value = "";
			return;
		}
		
		
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/rutExisteC") ?>", /* Se setea la url del controlador que responderá */
			data: { rut_post: rut},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == -1){
					//alert("Rut en uso");
					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalRutUsado').modal();
					document.getElementById("rut_estudiante").value = "";

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

</script>

<script type="text/javascript">


	function agregarEstudiante(){
			var rut = document.getElementById("rut_estudiante").value;
			document.getElementById("rut_estudiante").value = rut.substring(0,rut.length-1);
			return true;
	}

function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroSeccion").value;
	var arreglo = new Array();
	var ocultarTr;
	var cont;
	
	$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: "<?php echo site_url("Alumnos/postGetSecciones") ?>", /* Se setea la url del controlador que responderá */
		data: { }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

		arreglo = jQuery.parseJSON(respuesta);
			for(cont=0;cont < arreglo.length;cont++){
				ocultarTr=document.getElementById("seccionTr"+cont);
				if(0 > arreglo[cont].nombre.toLowerCase().indexOf(filtroLista.toLowerCase ())){
					ocultarTr.style.display='none';
				}
				else
				{		
					ocultarTr.style.display='';
				}
			}
		}});
}


	function cargarSecciones() {
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/postGetSecciones") ?>", /* Se setea la url del controlador que responderá */
			data: { }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoSecciones");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, td2, th, radioInput, nodoTexto;
				var name = "seccion_seleccionada";
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre);
					td.appendChild(nodoTexto);
					tr.setAttribute("id", "seccionTr"+i);

					td2 = document.createElement('td');
					radioInput = document.createElement('input');
					radioInput.setAttribute('required');
					radioInput.setAttribute('type', 'radio');
					radioInput.setAttribute('name', name);
					radioInput.setAttribute("id", "seccion_"+arrayRespuesta[i].cod);
					radioInput.setAttribute("value", arrayRespuesta[i].cod);
					td2.appendChild(radioInput);

					tr.appendChild(td2);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}
			}
		});
	}

	//Se carga luego de cargar la página
	$(document).ready(cargarSecciones);
</script>


		<fieldset>
			<legend>Agregar Alumno</legend>
			<div class="row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					<p>Complete los datos del formulario para agregar el alumno:</p>
				</div>
			</div>

			<div class="row-fluid">
				<?php
					$atributos= array('onsubmit' => 'return agregarEstudiante()', 'id' => 'formAgregar', 'name' => 'formAgregar', 'class' => 'form-horizontal');
					echo form_open('Alumnos/insertarAlumno/', $atributos);
				?>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">1.- <font color="red">*</font> RUT</label>
						<div class="controls">
						<input id="rut_estudiante"  pattern="^\d{7,8}[0-9kK]{1}$" onblur="comprobarRut()" class="span12" min="1" type="text" maxlength="9" title="Ingrese su RUN sin puntos ni guion"  name="rut_estudiante" placeholder="Ej:177858741" required>						</div>
					</div>
					<div class="control-group">
						<label  class="control-label" for="inputInfo" style="cursor: default">2.- <font color="red">*</font> Primer nombre</label>
						<div class="controls">
							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="nombre1_estudiante" name="nombre1_estudiante" maxlength="19" required >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">3.- Segundo nombre</label>
						<div class="controls">
							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo"  id="nombre2_estudiante" name="nombre2_estudiante" maxlength="19">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">4.- <font color="red">*</font> Apellido paterno</label>
						<div class="controls">
							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellido_paterno" name="apellido_paterno" maxlength="19" required>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">5.- <font color="red">*</font> Apellido materno</label>
						<div class="controls">
							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellido_materno" name="apellido_materno" maxlength="19" required>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">6.- <font color="red">*</font> Correo</label>
						<div class="controls">
							<input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" id="correo_estudiante" class="span12" name="correo_estudiante" maxlength="199" placeholder="nombre_usuario@miemail.com" required>
						</div>
					</div>
				</div> 


				<!-- Segunda columna -->
				<div class="span6" >
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">7.- <font color="red">*</font> Asignar carrera</label>
						<div class="controls">
							<select required id="cod_carrera" name="cod_carrera" class="span12" title="asigne carrera" >
							<?php
							$contador=0;
							$comilla= "'";
							while ($contador<count($carreras)){
				
								echo '<option value="'.$carreras[$contador][0].'">'.$carreras[$contador][0].' - '.$carreras[$contador][1].'</option>';
								$contador = $contador + 1;
							}
							?>
							</select> 
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default">8.- <font color="red">*</font> Asignar sección</label>
						<div class="controls">
							<input type="text" onkeyup="ordenarFiltro()" class="span12" id="filtroSeccion" placeholder="Filtro de Sección">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputInfo" style="cursor: default"></label>
						<div class="controls">
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px;" >
								<table class="table table-hover" id="listadoSecciones">
									<thead>

									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>		
				
					<div class="row">
						<div class="controls pull-right">
							<button class="btn" type="submit" style="margin-right: 10px" >
								<div class="btn_with_icon_solo">Ã</div>
								&nbsp Agregar
							</button>
							<button class="btn" type="reset" >
								<div class="btn_with_icon_solo">Â</div>
								&nbsp Cancela
							</button>
						</div>
					</div>
					



					<!-- Modal de modalRutUsado -->
					<div id="modalRutUsado" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>RUT ingresado está en uso</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese otro rut y vuelva a intentarlo.</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
					
					<!-- Modal de modalRutIncorrecto -->
					<div id="modalRutIncorrecto" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Dígito verificador incorrecto</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese el rut nuevamente.</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>
							
				</div>
				<?php echo form_close(''); ?>
			</div>
		</fieldset>
