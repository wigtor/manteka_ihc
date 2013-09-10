

<script>
	function comprobarNum() {
		var num = document.getElementById("num_sala").value;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Salas/NumExiste") ?>", /* Se setea la url del controlador que responderá */
			data: { num_post: num},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(existe == 1){

					var mensaje = document.getElementById("mensaje");
					$(mensaje).empty();
			
					$('#modalNum').modal();
					document.getElementById("num_sala").value = "";
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
		<fieldset>
			<legend>Agregar Sala</legend>
			
			<form  class="form-horizontal" id="formAgregar"  method="post" type="post" action="<?php echo site_url("Salas/ingresarSalas/")?>">
			
				<div class="row-fluid">
					<div class="span6">
						<font color="red">* Campos Obligatorios</font>
					</div>
				</div>
				<div class= "row-fluid">
					<div class= "span6" >
						Complete los datos del formulario para ingresar una sala:
					</div>
				</div>
				<div  class= "row-fluid">
					<div class= "span6">
						<div class="control-group">
		  					<label class="control-label" style="cursor: default" for="inputInfo" > 1.- <font color="red">*</font> Número de la sala:</label>
		  					<div class="controls">
		    					<input  id="num_sala"  class="span12" onblur="comprobarNum()" maxlength="3"  title=" Ingrese el número de la sala usando tres dígitos" pattern="[0-9]{3}" type="text"  name="num_sala" placeholder="Ej:258" required>
		  					</div>
						</div>
						<div class="control-group">
		  					<label class="control-label" style="cursor: default" for="inputInfo" > 2.- <font color="red">*</font> Capacidad:</label>
		  					<div class="controls">
		    					<input title="Ingrese la capacidad de la sala"  class="span12" id="inputInfo" max="999" type="number" min="1" name="capacidad" placeholder="Número de personas. Ej:80" required>
		  					</div>
						</div>
						<div class="control-group">
  							<label class="control-label" style="cursor: default" for="inputInfo">3.- <font color="red">*</font> Ubicación:</label>
  							<div class="controls">
    							<textarea  class="span12" title= "Ingrese la ubicación de la sala en no más de 100 carácteres" name="ubicacion" maxlength="100" required="required" style="resize: none;"></textarea>
  							</div>
						</div>
					</div>
					
					<!-- Segunda columna -->
					<div class="span6">
						<div class="control-group">
							<label class="control-label" style="cursor: default" style="width: 150px" for="run_profe">4.- Seleccione los implementos</label>
							<div class="controls">
								<div class="span12" style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
									<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
										<?php
										$contador=0;
										while ($contador<count($implemento)){
											echo '<tr>';
											echo '<td title="Descripción: '.$implemento[$contador][2]. '" id="implementoTd_'.$contador.'" ><input id="'.$implemento[$contador][0].'" value="'.$implemento[$contador][0].'" name="cod_implemento[]" type="checkbox" >'.' '.$implemento[$contador][1].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<div class="row">
						<div class="controls pull-right">
							<button class ="btn" type="submit" style= "margin-right: 7px" >
								<div class="btn_with_icon_solo">Ã</div>
								&nbsp Agregar
							</button>
							<button class ="btn" type="reset" >
								<div class="btn_with_icon_solo">Â</div>
								&nbsp Cancelar
							</button>
						</div>
					</div>
											<!-- Modal de modalNum -->
						<div id="modalNum" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Número de sala ingresado está en uso</h3>
							</div>
							<div class="modal-body">
								<p>Por favor ingrese otro número y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>		
					</div>


					
				</div>
			
			</form>
		</fieldset>
