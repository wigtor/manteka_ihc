<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1"){
				alert("Seccion editada correctamente");
			
		}	
		else{
			alert("Error al editar");
		}
	
	}
</script>


<div class="row-fluid">
    <div class= "span11">
        <fieldset> 
		<legend>Agregar Sección</legend>
			<form id="formDetalle" type="post" method="post">
            <div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
            
            <div class="row-fluid">
			
                
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span5">
                            1.-Información de la sección
                        </div>
                    </div>
					<form id="formEditar" type="post" method="post" onsubmit="editarSeccion()">
					<input id="cod_seccion" type="text" name="cod_seccion" style="display:none">
                    <div class="row-fluid">
							<div class="span4">
								<div class="control-group">
									
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Sección:</label>
		  						</div>	
							</div>
													
								<div class="span5">	
		  							<div class="controls">
									<tr>
									<td><input id="rs_seccion" name="rs_seccion"  maxlength="10" min="1" type="text" class="span2"></td>
									</tr>	
									<td class="span2">-</td>
									<tr>
									<td><input id="rs_seccion2" name="rs_seccion2"  maxlength="10" min="1" type="text" class="span2"></td>
									</tr>										
									
									</div>
							</div>
                      
                    </div>
					<br>
                    
                    

					<br>
                                <div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit" >Agregar</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" >Cancelar</button>
									</div>
								</div> 
					</form>	
                </div>
				
            </div>
         </form>
        </fieldset>
    </div>
</div>