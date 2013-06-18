
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el estudiante");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}
</script>

<script>

	function comprobarRut() {
		var rut = document.getElementById("rut_estudiante").value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/rutExisteC") ?>", /* Se setea la url del controlador que responderá */
			data: { rut_post: rut},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == -1){
					alert("Rut en uso");
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
		var nombreUno =	document.getElementById("nombre1_estudiante").value;
		var nombreDos =	document.getElementById("nombre2_estudiante").value;
		var apellidoPaterno = document.getElementById("apellido_paterno").value;
		var apellidoMaterno = document.getElementById("apellido_materno").value;
		var correo = document.getElementById("correo_estudiante").value;
		var seccion = document.forms['FormEditar'].elements['seccion_seleccionada'].value;
	
		if(rut!="" && nombreUno!=""  && apellidoPaterno!="" && apellidoMaterno!="" && correo!=""){
					return true;
		}
		else {
				alert("Ingrese todos los datos");
				return false;
		}
	}

function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroSeccion").value;
	var arreglo = new Array();
	var ocultarInput;
	var ocultarTd;
	var cont;
	
	<?php
	/*
	$contadorE = 0;
	while($contadorE<count($secciones)){
		echo 'arreglo['.$contadorE.'] = "'.$secciones[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	*/
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		desmarcar=document.getElementById(arreglo[cont]);
		ocultarTd=document.getElementById("seccionTd_"+cont);
		if(0 > arreglo[cont].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			desmarcar.checked = false;
			ocultarTd.style.display='none';
		}
		else
		{
			
			ocultarTd.style.display='';
		}
    }
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
					

					td2 = document.createElement('td');
					radioInput = document.createElement('input');
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
				<?php
					$atributos= array('onsubmit' => 'return agregarEstudiante()', 'id' => 'formAgregar', 'name' => 'formAgregar');
					echo form_open('Alumnos/insertarAlumno/', $atributos);
				?>
				<font color="red">*Campos Obligatorios</font><br>
					<div class= "row-fluid">
						
						<div class= "span5" style="margin-bottom:2%">
							Ingrese datos del Alumno:
						</div>
					</div>
					
					<div  class= "row-fluid" >
						<div class= "span5">
							<div class="row-fluid"> <!-- rut-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">1-.<font color="red">*</font> RUT</label>
									
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input id="rut_estudiante" onblur="comprobarRut()" max="999999999" min="1" type="number" name="rut_estudiante" placeholder="Ingrese rut sin dig. verificador" required>
										</div>
								</div>
							</div>
							<div class="row-fluid"> <!-- nombre uno-->
								<div class="span4">
									<div class="control-group">
										<label  class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="nombre1_estudiante" name="nombre1_estudiante" maxlength="19" required >
										</div>
								</div>
							</div>							
							<div class="row-fluid"> <!-- nombre dos-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">3-.Segundo nombre</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo"  id="nombre2_estudiante" name="nombre2_estudiante" maxlength="19">
										</div>
								</div>

							</div>
							
							<div class="row-fluid"> <!-- ape paterno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido Paterno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellido_paterno" name="apellido_paterno" maxlength="19" required>
										</div>
								</div>

							</div>
							<div class="row-fluid"> <!-- ape materno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font>Apellido Materno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" id="apellido_materno" name="apellido_materno" maxlength="19" required>
										</div>
								</div>

							</div>
							<div class="row-fluid"> <!-- correo-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="email" id="correo_estudiante" name="correo_estudiante" maxlength="199" placeholder="ejemplo@usach.cl" required>
										</div>
								</div>

							</div>

						</div> 


						<!-- Segunda columna -->
						<div class="span6" >
							
							<div class="row-fluid"> <!-- carrera-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">7-.<font color="red">*</font>Asignar Carrera</label>
									</div>
								</div>
								<div  class="span6">
									<select required id="cod_carrera" name="cod_carrera" title="asigne carrera" >
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
							

							<div class="row-fluid"> <!-- seccion-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo" style="cursor: default">8-.<font color="red">*</font>Asignar sección</label>
									</div>
								</div>
								<div  class="span6" >
									<div class="controls">
										<input type="text" onkeyup="ordenarFiltro()" id="filtroSeccion" placeholder="Filtro de Sección">
									</div>
								</div>
							</div>
						
							<div class="row-fluid">
								<div class="span5 offset4">
									<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px; width: 127%" >
									
									
										<table class="table table-hover" id="listadoSecciones">
											<thead>

											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>


							<div class="row-fluid" style="margin-top:2%">
								<div class="span3 offset5">
									<button class="btn" type="submit" >
										<div class= "btn_with_icon_solo">Ã</div>
										&nbsp Agregar

									</button>
								</div>
								<div class="span3">
									<button class="btn" type="reset" >
										<div class= "btn_with_icon_solo">Â</div>
										&nbsp Cancelar

									</button>
								</div>

							</div>
							
						</div>
					</div>
			</form>
		</fieldset>
