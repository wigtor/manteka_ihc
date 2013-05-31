
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



<div class= "row-fluid">
	<div class= "span10">

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
		  							<label class="control-label" for="inputInfo" > 1-.*RUN:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="10" type="number" min="1" name="rut_profesor" placeholder="Ingrese RUN sin dig. verificador" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Primer nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-. Segundo nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre2_profesor" maxlength="19" >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido paterno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5.<font color="red">*</font>Apellido materno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido2_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">6-.<font color="red">*</font>Correo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" name="correo_profesor" maxlength="30" placeholder="ejemplo1@usach.cl" required>
		  							</div>
							</div>

						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">7-.<font color="red">*</font>Correo Alternativo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" name="correo_profesor1" maxlength="30" placeholder="ejemplo2@usach.cl" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">8-.<font color="red">*</font>Telefono:</label>
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
		  							<label class="control-label" for="inputInfo">9-.<font color="red">*</font>Tipo:</label>
		  						</div>
		  					</div>
		  					<div  class="span6">
									<div  class="span6">
									<select id="tipoDeFiltro" title="Tipo de contrato" name="tipo_profesor">
										<option value="1">Planta</option>
										<option value="2">Por hora</option>
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
							<div class="span2 offset8" style="width:11%" >
								<button class="btn" type="submit" style="width:102px">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								</button>
							</div>
							<div class="span2" >
								<button class="btn" type="reset" style="width: 105px">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
						</div>
			</form>
		</fieldset>
	</div>
</div>					
