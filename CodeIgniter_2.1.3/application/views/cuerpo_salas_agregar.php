
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado exitosamente la sala");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}
</script>



<div class= "row-fluid">
	<div class= "span10">	
		<fieldset>
			<legend>Agregar Sala</legend>
			<form id="formAgregar" type="post" action="<?php echo site_url("Salas/agregarSalas/")?>">
			
			<div>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
				<div class= "row-fluid">
					<div class= "span6" style="margin-bottom:2%">
						Complete los datos del formulario para ingresar una sala:
					</div>
				</div>
				<div  class= "row-fluid" style="margin-left:2%">
					<div class= "span6">
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" > 1-.*Numero de la sala:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="3" type="number" min="1" name="num_sala" placeholder="Ej:258" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" > 2-.*Capacidad:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="3" type="number" min="1" name="capacidad" placeholder="Numero de personas. Ej:80" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">

		  							<label class="control-label" for="inputInfo">3-.*Ubicacion:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<textarea name="ubicacion" rows="5" cols="30" required>
										</textarea>
		  							</div>
							</div>

						</div>




					<div class="row" style="width: 386px;">		

					<br>
					Seleccione los implementos que tiene la sala:
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
					
					<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										while ($contador<count($implemento)){
											echo '<tr>';
											echo '<td title="'.$implemento[$contador][2]. '" id="implementoTd_'.$contador.'" ><input id="'.$implemento[$contador][0].'" value="'.$implemento[$contador][0].'" name="cod_implemento" type="checkbox" >'.' '.$implemento[$contador][1].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
									
					</div>
					</div>
					<div class="row-fluid" style="margin-top: 2%">
		
						<div class= "span4" style="margin-left:4%">
							<button class ="btn" type="submit" >Agregar</button>
						</div>
						<div class= "span3" style="margin-left:0%">
							<button class ="btn" type="reset" >Cancelar</button>
						</div>
					</div>
					</div> 

					
				</div>
			</div>
			</form>
		</fieldset>
	</div>
</div>					








