<script type="text/javascript">
	function Cancelar(){
		var borrar = document.getElementById("formAsignar");
		borrar.action ="<?php echo site_url("Secciones/asignarAsecciones/");?>"
		borrar.submit()	
	}

	function profesDelModulo(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var nombre_clickeado = elemTabla;
		//var rut_clickeado = elemTabla;

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

	function horariosDeLaSala(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var sala_clickeada = elemTabla;

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postDetalleSala") ?>", /* Se setea la url del controlador que responderá */
			data: { sala: sala_clickeada }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var dia = document.getElementById("dia");
				var bloque = document.getElementById("bloque");

				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				var dias = '<option value="" disabled selected>Día</option>';
				var bloques = '<option value="" disabled selected>Bloque</option>';

				var validacion_dias = [0,0,0,0,0,0,0];
				
				/*validacion_dias[0] = 0; //Lunes
				validacion_dias[1] = 0; //Martes
				validacion_dias[2] = 0; //Miercoles
				validacion_dias[3] = 0; //Jueves
				validacion_dias[4] = 0; //Viernes
				validacion_dias[5] = 0; //Sabado
				validacion_dias[6] = 0; //Domingo*/

				var validacion_horarios = [0,0,0,0,0,0,0,0,0]

				/*validacion_horarios[0] = 0; //08:00
				validacion_horarios[1] = 0; //09:40
				validacion_horarios[2] = 0; //11:20
				validacion_horarios[3] = 0; //13:50
				validacion_horarios[4] = 0; //15:30
				validacion_horarios[5] = 0; //17:10
				validacion_horarios[6] = 0; //19:00
				validacion_horarios[7] = 0; //20:20
				validacion_horarios[8] = 0; //22:00*/

				if(datos.length!=0){
					/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
					for (var i = 0; i < datos.length; i++) {

						//Se ve si el dia ya se encuentra ingresado como opcion
						if(datos[i]['COD_ABREVIACION_DIA']=="L" && validacion_dias[0] == 0){
							validacion_dias[0] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="M" && validacion_dias[1] == 0){
							validacion_dias[1] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="W" && validacion_dias[2] == 0){
							validacion_dias[2] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="J" && validacion_dias[3] == 0){
							validacion_dias[3] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="V" && validacion_dias[4] == 0){
							validacion_dias[4] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="S" && validacion_dias[5] == 0){
							validacion_dias[5] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}else if(datos[i]['COD_ABREVIACION_DIA']=="D" && validacion_dias[6] == 0){
							validacion_dias[6] = 1;
							dias = dias+'<option>'+datos[i]['NOMBRE_DIA']+'</option>';
						}

						//Se ve si el modulo ya se encuentra ingresado como opcion
						if(datos[i]['NUMERO_MODULO']=="08:00" && validacion_horarios[0] == 0){
							validacion_horarios[0] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="09:40" && validacion_horarios[1] == 0){
							validacion_horarios[1] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="11:20" && validacion_horarios[2] == 0){
							validacion_horarios[2] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="13:50" && validacion_horarios[3] == 0){
							validacion_horarios[3] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="15:30" && validacion_horarios[4] == 0){
							validacion_horarios[4] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="17:10" && validacion_horarios[5] == 0){
							validacion_horarios[5] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="19:00" && validacion_horarios[6] == 0){
							validacion_horarios[6] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="20:20" && validacion_horarios[7] == 0){
							validacion_horarios[7] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}else if(datos[i]['NUMERO_MODULO']=="22:00" && validacion_horarios[8] == 0){
							validacion_horarios[8] = 1;
							bloques = bloques+'<option>'+datos[i]['NUMERO_MODULO']+'</option>';
						}

					};
				}else{
					dias = dias+'<option disabled>La sala no tiene dias disponibles</option>';
					bloques = bloques+'<option disabled>La sala no tiene bloques disponibles</option>';
				}

				$(dia).html(dias);
				$(bloque).html(bloques);
				

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
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
		if(seccion == 0 || profesor == 0 || modulo == 0 || sala == 0 || dia == 0 || bloque == 0){
			$('#modalFaltaAlgo').modal();
		}else{
			$('#modalConfirmacion').modal();
			return;
		}
	}

</script>

<div class="row-fluid">
	<div class="span10">
		<!--<form id="formAsignar" type="post" method="post" onsubmit="AsignarSeccion();return false">-->
		<fieldset>
			<legend>Asignación de Sección</legend>
			<?php
				$atributos= array('onsubmit' => 'return AsignarSeccion()', 'id' => 'formAsignar');
		 		echo form_open('Secciones/HacerAsignarAsecciones/', $atributos);
			?>
			<div class="row-fluid">
				<div class= "span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Seleccione la sección para asignación</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table id="listadoSecciones" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody >

								<?php
									$contador=0;
										$comilla= "'";
										
										while ($contador<count($seccion)){
											
											echo '<tr>';
											echo '<td style="width:26px;"><input required type="radio" name="seccion_seleccionada" id="seccion_'.$contador.'" value="'.$seccion[$contador][0].'"> '.$seccion[$contador][1].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}
								?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="row-fluid" style="margin-top:2%">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">3-.<font color="red">*</font> Seleccione el profesor disponible del módulo</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;  margin-top:7%">
							<table id="profesores" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody id="profes" >
									
								</tbody>
							</table>
						</div>
					</div>
				</div>


				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Seleccione el módulo a asignar</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody >
									<?php
										$contador=0;
										$comilla= "'";
										
										while ($contador<count($modulos)){
											
											echo '<tr>';
											echo '<td><input required onclick="profesDelModulo('.$comilla.$modulos[$contador]['NOMBRE_MODULO'].$comilla.')" type="radio" name="modulo_seleccionado" id="modulo_'.$contador.'" value="'.$modulos[$contador]['COD_MODULO_TEM'].'"> '.$modulos[$contador]['NOMBRE_MODULO'].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}
									
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row-fluid" style="margin-top:2%">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">4-.<font color="red">*</font> Seleccione la sala y horario</label>
							</div>
						</div>
					</div>

					<div class="row-fluid" style="margin-left:3%">
						<div class="span6" >
							4.1- Sala
						</div>
						<div class="span6" >
							4.2- Horario
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
									<?php
										$contador=0;
										$comilla= "'";

										
										while ($contador<count($salas)){
											
											echo '<tr>';
											echo '<td style="width:26px;"><input required onclick="horariosDeLaSala('.$comilla.$salas[$contador]['NUM_SALA'].$comilla.')" type="radio" name="sala_seleccionada" id="sala_'.$contador.'" value="'.$salas[$contador]['COD_SALA'].'"> '.$salas[$contador]['NUM_SALA'].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}
									?>
								</tbody>
							</table>
						</div>

						<div class="row-fluid">
								<select id="dia" name="dia_seleccionado" class= "span4" style="margin-left: 2%">
									<option value="" disabled selected>Día</option>
									<option disabled>Elija una sala para ver sus dias disponibles</option>
								</select>
							

						
								<select id="bloque" name="bloque_seleccionado" class= "span4" style="margin-left: 2%; margin-top:5%">
									<option value="" disabled selected>Bloque</option>
									<option disabled>Elija una sala para ver sus bloques disponibles</option>
								</select>
							
						</div>

						<div class="row-fluid" style="margin-top:5%; margin-left: 35%">
							<div class="span3">
									<button class="btn" onClick="AsignarSeccion()" type="button" style="width:102px">
										<div class= "btn_with_icon_solo">Ã</div>
										&nbsp Asignar

									</button>
								</div>
								<div class="span3">
									<button class="btn" onClick="Cancelar()" type="reset" style="width:105px">
										<div class= "btn_with_icon_solo">Â</div>
										&nbsp Cancelar

									</button>
							</div>
						</div>

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se va a realizar asignación de la seccion ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
								
							</div>
						</div>

						<!-- Modal de faltaAlgo -->
						<div id="modalFaltaAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No se puede realizar la asignación</h3>
							</div>
							<div class="modal-body">
								<p>Debe seleccionar todos los datos requeridos para la asignación</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>

					</div>
				</div>
			</div>
			<?php echo form_close(''); ?>

		</fieldset>
	</div>
	</form>
</div>