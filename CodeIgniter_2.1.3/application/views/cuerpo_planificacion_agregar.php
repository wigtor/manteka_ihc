<script type="text/javascript">
	function Cancelar(){
		var borrar = document.getElementById("formAsignar");
		borrar.action ="<?php echo site_url("Secciones/asignarAsecciones/");?>"
		borrar.submit()	
	}

	function profesDelModulo(elemTabla) {

		/* Obtengo el nombre del modulo clickeado */
		var nombre_clickeado = elemTabla;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postDetalleModulos") ?>", /* Se setea la url del controlador que responderá */
			data: { nombre_modulo: nombre_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var profes = document.getElementById("profes");

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				if(datos.length!=0){
					for (var i = 0; i < datos.length; i++) {
						var profesores = profesores+'<tr><td style="width:26px;"><input required type="radio" name="profesor_seleccionado" id="profesor_'+i+'" value="'+datos[i].RUT_USUARIO2+'"> '+datos[i].NOMBRE1_PROFESOR+' '+datos[i].APELLIDO1_PROFESOR+'</td></tr>';
					}
				}else{
					var profesores = "";
				}
				
				$(profes).html(profesores);
				

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	function verificaHorario(){
		var dia = document.getElementById("dia").value;
		var bloque = document.getElementById("bloque").value;

		var retorno = -1;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postVerificaHorarios") ?>", /* Se setea la url del controlador que responderá */
			data: { dia_post: dia,bloque_post: bloque }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			async: false,
			success: function(respuesta){ /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var dato = jQuery.parseJSON(respuesta);
				retorno=dato;
			}
		});

		return retorno;
	}

	function AsignarSeccion(){
		var seccion = 0;
		var profesor = 0;
		var modulo = 0;
		var sala = 0;
		var dia = 0;
		var bloque = 0;
		for (var i = 0; i < document.getElementsByName('seccion_seleccionada').length; i++) {
			if(document.getElementById('seccion_'+i).checked==true){
				seccion = seccion + 1;
			}
		}
		for (var i = 0; i < document.getElementsByName('profesor_seleccionado').length; i++) {
			if(document.getElementById('profesor_'+i).checked==true){
				profesor = profesor + 1;
			}
		}
		for (var i = 0; i < document.getElementsByName('modulo_seleccionado').length; i++) {
			if(document.getElementById('modulo_'+i).checked==true){
				modulo = modulo + 1;
			}
		}
		for (var i = 0; i < document.getElementsByName('sala_seleccionada').length; i++) {
			if(document.getElementById('sala_'+i).checked==true){
				sala = sala + 1;
			}
		}
		if(document.getElementById("dia").value != ""){
			dia = dia + 1;
		}
		if(document.getElementById("bloque").value != ""){
			bloque = bloque + 1;
		}
		if(verificaHorario()==1){
			// No se puede hacer la asignacion por el horario, mostrar el MODAL
			$('#modalVerificaHorario').modal();
			return false;
		}else{
			if(seccion == 0 || profesor == 0 || modulo == 0 || sala == 0 || dia == 0 || bloque == 0){
				// Caso en que no se eligen todos los campos obligatorios, no se deberia llegar hasta esté
				return false;
			}else{
				return;
			}
		}
	}

</script>

<div class="row-fluid">
	<div class="span12">
		<fieldset>
			<legend>Agregar Planificación de Clase</legend>
			<div class="row-fluid">
				<div class="span6">
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" >
					<p>Complete los datos del formulario para agregar una asignacion:</p>
				</div>
			</div>
			<?php
				$atributos= array('id' => 'formAsignar', 'class' => 'form-horizontal');
		 		echo form_open('Secciones/HacerAsignarAsecciones/', $atributos);
			?>
			<div class="row-fluid">
				<div class= "span6">
					<div class="control-group">
						<label class="control-label" for="seccion">1.- <font color="red">*</font> Sección de curso a planificar:</label>
						<div class="controls">
							<select id="seccion" name="seccion" class="span12" title="Sección que desea planificar" required>
								<option value="" disabled selected>Seleccione sección de curso</option>
								<?php
								foreach ($listadoSecciones as $valor) {
									?>
										<option value="<?php echo $valor->id?>"><?php echo $valor->nombre?></option>
									<?php 
								}
								?>
							</select>
						</div>
					</div>

					<!-- Seleccion de módulo tematico y sesión de clase -->
					<div class="control-group">
						<div>2.- <font color="red">*</font> Sesión de clase a planificar</div>
					</div>
					
					<div class="control-group offset1" >
						<label class="control-label" for="moduloTematico">2.1.- <font color="red">*</font> Módulo temático:</label>
						<div class="controls">
							<select id="moduloTematico" name="moduloTematico" class="span12" required title="Módulo temático que se va a planificar para esa sección">
								<option value="" disabled selected>Seleccione módulos temático</option>

							</select>
						</div>
					</div>

					<!-- Variable según el módulo temático que se seleccione -->
					<div class="control-group offset1">
						<label class="control-label" for="sesion">2.2.- <font color="red">*</font> Sesión de clase:</label>
						<div class="controls">
							<select id="sesion" name="sesion" class="span12" required title="Sección que desea planificar">
								<option value="" disabled selected>Seleccione sesión de clase</option>

							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="profesor">3.- <font color="red">*</font> Profesor:</label>
						<div class="controls">
							<select id="profesor" name="profesor" class="span12" title="Sección que desea planificar">
								<option value="" disabled selected>Seleccione profesor</option>
								
							</select>
						</div>
					</div>
				</div>


				<div class="span6">
					<div class="row-fluid" >
						<div class="span9">
							<div class="control-group">
								<div>4.- <font color="red">*</font> Seleccione la sala y horario</div>
							</div>
						</div>
					</div>

					<div class="row-fluid" >
						<div class="span6" >
							4.1.- Sala
						</div>
						<div class="span6" >
							4.2.- Horario
						</div>
					</div>

					<div class="row-fluid">
						<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table id="listadoResultados" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody >
									
								</tbody>
							</table>
						</div>

						<div class="row-fluid">
								<select id="dia" name="dia_seleccionado" class= "span5" style="margin-left: 2%" required>
									<option value="" disabled selected>Seleccione día</option>
									<?php
									if (isset($listadoDias)) {
										foreach ($listadoDias as $valor) {
											?>
												<option value="<?php echo $valor->id?>"><?php echo $valor->nombre?></option>
											<?php 
										}
									}
									?>
								</select>
							

						
								<select id="bloque" name="bloque_seleccionado" class= "span5" style="margin-left: 2%; margin-top:5%" required>
									<option value="" disabled selected>Seleccione bloque horario</option>
									<?php
									if (isset($listadoBloquesHorario)) {
										foreach ($listadoBloquesHorario as $valor) {
											?>
												<option value="<?php echo $valor->id?>"><?php echo $valor->nombre?></option>
											<?php 
										}
									}
									?>
								</select>
							
						</div>

						<div class="control-group">
							<div class="controls">
								<button type="button" class="btn" onclick="agregarPlanificacion()" >
									<div class="btn_with_icon_solo">Ã</div>
									&nbsp; Agregar
								</button>
								<button class="btn" type="button" onclick="resetearPlanificacion()" >
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
						
					</div>
				</div>
			</div>
			<?php echo form_close(''); ?>

		</fieldset>
	</div>
	</form>
</div>