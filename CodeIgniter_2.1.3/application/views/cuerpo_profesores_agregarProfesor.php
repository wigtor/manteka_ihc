
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado exitosamente el profesor");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}
</script>



		<fieldset>
			<legend>Agregar Profesor</legend>	
			<form id="formAgregar" type="post" action="<?php echo site_url("Profesores/insertarProfesor/")?>">
			
			<div class="row-fluid">
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
				<div class= "row-fluid">
					<div class= "span6" style="margin-bottom:2%">
						Complete los datos del formulario para ingresar un profesor:
					</div>
				</div>
				<div  class= "row-fluid" style="margin-left:2%">
					<div class= "span6">
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default" > 1-.*RUN:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="10" type="number" min="1" name="rut_profesor" placeholder="Ej:17785874" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font>Primer nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">3-. Segundo nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre2_profesor" maxlength="19" >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font>Apellido paterno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">5.<font color="red">*</font>Apellido materno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido2_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" name="correo_profesor" maxlength="199" placeholder="nombre1_usuario@miemail.com" required>
		  							</div>
							</div>

						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">7-.<font color="red">*</font>Correo Alternativo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" name="correo_profesor1" maxlength="199" placeholder="nombre2_usuario@miemail.com" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">8-.<font color="red">*</font>Telefono:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="7" minlength="7" type="number" name="telefono_profesor" placeholder="Ingrese solo numeros" required>

		  							</div>
							</div>

						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" style="cursor: default">9-.<font color="red">*</font>Tipo:</label>
		  						</div>
		  					</div>
		  					<div  class="span6">
									<div  class="span6">
									<select id="tipoDeFiltro" title="Tipo de contrato" name="tipo_profesor">
										<option value="1">Profesor Jornada Completa</option>
										<option value="2">Profesor Por hora</option>
								</select>
								</div>
								</div>
						</div>
						<!--<div class="row" style="">		
							<div class="span2" style="margin-left: 654px;">
								<button class="btn" type="submit" style="width:102px">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								</button>
							</div>
							<div class="span2" style="margin-left: -32px;">
								<button class="btn" type="reset" style="width: 105px">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>-->
					</div> 

					
				</div>
			</div> 
			<div class="row-fluid" style="">		
							<div class="span2 offset8" >
								<button class="btn" type="submit">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								</button>
							</div>
							<div class="span2" >
								<button class="btn" type="reset" >
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
			</form>
		</fieldset>			
