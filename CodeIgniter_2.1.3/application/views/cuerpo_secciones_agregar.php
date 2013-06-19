<?php
if(isset($mensaje_confirmacion))
{
	if($mensaje_confirmacion==1)
	{
		?>
		    <div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Listo</h4>
				 Sección agregada correctamente
    		</div>	
		<?php
	}
	else{ if($mensaje_confirmacion==-1)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Error</h4>
				 Error al agregar sección
    		</div>		

		<?php
	}
		else if($mensaje_confirmacion==3)
		{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Error</h4>	 
				 Una sección con el mismo nombre ya se ha ingresado 
    		</div>		

		<?php
		}
	
	}
	unset($mensaje_confirmacion);
}
?>

<script type="text/javascript">
	function AgregarSeccion(){ 
		var agregar= document.getElementById("formDetalle");
		agregar.action = "<?php echo site_url("Secciones/agregarSecciones/") ?>/";
		agregar.submit();					
		
	}
</script>

<div class="row-fluid">
    <div class= "span11">
        <fieldset> 
		<legend>Agregar Sección</legend>
			<form id="formAgregar" type="post" method="post" onsubmit="AgregarSeccion();return false">
            <div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
			</div>
            
            <div class="row-fluid">
			
                
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span6">
                            Ingrese la información de la sección
                        </div>
                    </div>
					
					<input id="cod_seccion" type="text" name="cod_seccion" style="display:none">
                    <div class="row-fluid">
							<div class="span4">
								<div class="control-group">
									
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> 1.- Sección:</label>
									<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
		  						</div>	
							</div>
													
								<div class="span5">	
		  							<div class="controls">
									<tr>
									<td><input id="rs_seccion" name="rs_seccion"  maxlength="1" title=" Ingrese sólo una letra" pattern="^([A-Z]{1}|[a-z]{1})$" type="text" class="span2" required></td>
									</tr>	
									<td class="span2">-</td>
									<tr>
									<td><input id="rs_seccion2" name="rs_seccion2"  maxlength="2"  title=" Ingrese sólo dos dígitos" pattern="[0-9]{2}" type="text" class="span2" required></td>
									</tr>										
									
									</div>
							</div>
                      
                    </div>
					<br>
                    
                    

					<br>
						<div class="row-fluid" style="margin-top: 4%; margin-left:35%">
			
								<button class ="btn" type="submit" >
									<div class="btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								</button>
								<button class ="btn" type="reset" >
									<div class="btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
						</div>
					
                </div>
				
            </div>
         </form>
        </fieldset>
    </div>
</div>