<script>

	function resetearAsignacion(){
		var seccion = document.getElementById("nombre_seccion");
		var modulo = document.getElementById("modulo");
		var profesorNombre = document.getElementById("profesor_nombre1");
		var profesorApellido1 = document.getElementById("profesor_apellido1");
		var profesorApellido2 = document.getElementById("profesor_apellido2");
		var sala = document.getElementById("sala_asig");
		var horario = document.getElementById("horario_asig");

		seccion.innerHTML="";
		modulo.innerHTML="";
		profesorNombre.innerHTML="";
		profesorApellido1.innerHTML="";
		profesorApellido2.innerHTML="";
		sala.innerHTML="";
		horario.innerHTML="";
		
					
			
	}

	function detalleSeccion(cod_seccion) {
		
		/* Defino el ajax que hará la petición al servidor */
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Secciones/postDetallesSeccion") ?>", /* Se setea la url del controlador que responderá */
				data: { seccion: cod_seccion }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */


				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					///console.log (respuesta);
					/* Obtengo los objetos HTML donde serán escritos los resultados */
					var seccion = document.getElementById("nombre_seccion");
					var modulo = document.getElementById("modulo");
					var profesorNombre = document.getElementById("profesor_nombre1");
					var profesorApellido1 = document.getElementById("profesor_apellido1");
					var profesorApellido2 = document.getElementById("profesor_apellido2");
					var sala = document.getElementById("sala_asig");
					var horario = document.getElementById("horario_asig");
					document.getElementById("codSeccion").value = cod_seccion;
					
					/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
					var datos = jQuery.parseJSON(respuesta);

					/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
					seccion.innerHTML = datos[0];//.nombre_seccion;
					modulo.innerHTML = datos[1];//.nombre_modulo;
					profesorNombre.innerHTML = datos[2];//.nombre_profesor;
					profesorApellido1.innerHTML = datos[3];
					profesorApellido2.innerHTML = datos[4];
					sala.innerHTML = datos[5];//.numero_sala;
					horario.innerHTML = datos[6];//.horario;

					if (datos[1] == null){
						modulo.innerHTML= "sin asignación";
					}
					if(datos[2]==null){
						profesorNombre.innerHTML = "sin asignación";//.nombre_profesor;
						profesorApellido1.innerHTML = "";
						profesorApellido2.innerHTML = "";

					}
					if (datos[5]==null){
						sala.innerHTML = "sin asignación";
					}
					if(datos[6]==null){
						horario.innerHTML= "sin asignación"; //
					}

					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();

				}
		}
		);
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

function eliminarAsignacion(){

		
		if(nombre_seccion.innerHTML==""){
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		else{
			if(modulo.innerHTML=="sin asignación"|| profesor_nombre1.innerHTML=="sin asignación" || profesor_apellido1.innerHTML=="sin asignación" || profesor_apellido2.innerHTML=="sin asignación" || sala_asig.innerHTML=="sin asignación" || horario_asig.innerHTML=="sin asignación"){
				$('#modalSinAsignacion').modal();
			}
			else{
				$('#modalConfirmacion').modal();
			}
			
			
		}
		
	}


</script>







<div class="row-fluid">
	<div class="span13">
		<fieldset>
			<legend>Borrar Asignación</legend>
			<?php
				$atributos= array('onsubmit' => 'return eliminarAsignacion()', 'id' => 'FormDetalle');
		 		echo form_open('Secciones/eliminarAsignacion/', $atributos);
			?>
			<div class="row-fluid">
					<div class="span6">
						<font color="red">* Campos Obligatorios</font>
					</div>
			</div>
			
			<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo" style="cursor: default">1.- <font color="red">*</font> Seleccione la sección:</label>
							</div>
						</div>
					</div>

					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table class="table table-hover">
							<tbody>
								<?php
								$contador=0;
								$comilla= "'";
								if(count($seccion)==0){
									echo '<tr><td style="cursor: default">No existen secciones asignadas</td></tr>';
								}else{
									while ($contador<count($seccion)){
										
										echo '<tr>';
										echo '<td   style="cursor: pointer"  onclick="detalleSeccion('.$comilla.$seccion[$contador][0].$comilla.')"> '.$seccion[$contador][1].' </td>';
										echo '</tr>';
																	
										$contador = $contador + 1;
									}
								}
								
								?>
														
							</tbody>
						</table>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo" style="cursor: default">2.- Datos de la asignación:</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">


						<pre style=" padding: 2%">
Sección:           <b id="nombre_seccion"></b>
Módulo:            <b id="modulo"></b>
Profesor Asignado: <b id="profesor_nombre1"></b> <b id="profesor_apellido1"></b> <b id="profesor_apellido2"></b> 
Sala asignada:     <b id="sala_asig"></b>
Horario:           <b id="horario_asig"></b></pre>
<input name="cod_seccion" type="hidden" id="codSeccion" value="">
					</div>

					<div class="control-group">
						<div class="controls pull-right">
						<!--<div class="span3 offset6">-->
							<button type="button" class="btn" style= "margin-right: 7px" onclick="eliminarAsignacion()">
								<i class= "icon-trash"></i>
								&nbsp; Eliminar
							</button>
						<!--</div>-->

						<!--<div class = "span3 ">-->
							<button  class ="btn"  type="button" onclick="resetearAsignacion()" style="width: 105px">
								<div class= "btn_with_icon_solo">Â</div>
								&nbsp; Cancelar
							</button>&nbsp;
						<!--</div>-->

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se va a eliminar la asignación seleccionada ¿Está seguro?</p>
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
								<h3>No ha seleccionado ninguna sección</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione una sección y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

						<!-- Modal de sinAsignacion -->
						<div id="modalSinAsignacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Sección sin asignaciones</h3>
							</div>
							<div class="modal-body">
								<p>Debe seleccionar una sección con asignaciones para una eliminación.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div><!---->
					</div>
				</div>
			</div>
			<?php echo form_close(''); ?>
			<!--</form>-->
		</fieldset>
	</div>
</div>