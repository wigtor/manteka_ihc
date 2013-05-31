<div class= "row-fluid">
	<div class= "span10">	
		<fieldset>
			<legend>Agregar Sesion</legend>
		<form id="formAgregar" type="post" method="post" action="<?php echo site_url("Sesiones/AgregarSesion/")?>">
			
			
				<div>
					<div class= "row-fluid">
						<div class= "span6" style="margin-bottom:2%">
							Ingrese datos de la sesión:
						</div>
					</div>
					
					<div  class= "row-fluid" style="margin-left:2%">
						<div class= "span6">
							<div class="row"> <!-- codigo -->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Codigo  de sesión</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="cod_sesion" maxlength="19" required >
										</div>
								</div>
							</div>
							<div class="row"> <!-- cod seccion-->
								<div class="span4">
									<div class="control-group">
										<label  class="control-label" for="inputInfo">2-.<font color="red">*</font>Fecha</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="fecha_sesion" maxlength="19" required >
										</div>
								</div>
							</div>							
							<div class="row"> <!-- descipción -->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Descripción</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<textarea type="text" cols="40" rows="5" name="descripcion_sesion" maxlength="99" required></textarea>
										</div>
								</div>

							</div>
						

						</div> 

						<div class="span6" >
							
							
							<div class="row" style="margin-top:2%">
								<div class="span3 offset5">
									<button class="btn" type="submit" style="width:102px">
										<div class= "btn_with_icon_solo">Ã</div>
										&nbsp Agregar

									</button>
								</div>
								<div class="span3">
									<button class="btn" type="reset" style="width:105px">
										<div class= "btn_with_icon_solo">Â</div>
										&nbsp Cancelar

									</button>
								</div>
							</div>
							
						</div>
					</div>

				</div>
					
				</div> 
			</div>
		</form>
		</fieldset>
	</div>	
</div>