<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1" && "<?php echo $mensaje_confirmacion;?>"!="3"){
				alert("Sección agregada correctamente");
			
		}
		else{
			if("<?php echo $mensaje_confirmacion;?>"=="-1"){
				alert("Error al agregar la sección");
			}		
			else{
				if("<?php echo $mensaje_confirmacion;?>"=="3"){
				alert("Una sección con el mismo nombre ya se ha ingresado");
				}
			}
		}
	}
</script>

<script type="text/javascript">
	function AgregarSeccion(){
		var rs=document.getElementById("rs_seccion").value;
		var rs2=document.getElementById("rs_seccion2").value;
		if(rs!="" && rs2!=""){ 
					var patron = "^[0-9]{2}$"; //dos números enteros positivos en la primera parte del nombre de la sección
					var patron2 = "^([A-Z]{1}|[a-z]{1})$"; //una letra en la primera parte del nombre de la sección
					if (document.getElementById("rs_seccion2").value.match(patron)) {    
						if (document.getElementById("rs_seccion").value.match(patron2)) {  
							var agregar= document.getElementById("formDetalle");
							agregar.action = "<?php echo site_url("Secciones/agregarSecciones/") ?>/";
							agregar.submit();
						}
						else {
							
							alert("Error:La sección no tiene la estructura Letra-Dígito Dígito");
							return false;
						}
					}
					else {
						alert("Error:La sección no tiene la estructura Letra-Dígito Dígito");
						return false;
					}
					
					
		}
		else{
				alert("No se han ingresado todos los datos");
		}
		
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
									<td><input id="rs_seccion" name="rs_seccion"  maxlength="1" min="1" type="text" class="span2"></td>
									</tr>	
									<td class="span2">-</td>
									<tr>
									<td><input id="rs_seccion2" name="rs_seccion2"  maxlength="2" min="2" type="text" class="span2"></td>
									</tr>										
									
									</div>
							</div>
                      
                    </div>
					<br>
                    
                    

					<br>
                                <div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit" style="width:102px ">
											<div class="btn_with_icon_solo">Ã</div>
											&nbsp Agregar
										</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" style="width: 105px">
											<div class="btn_with_icon_solo">Â</div>
											&nbsp Cancelar
										</button>
									</div>
								</div> 
					
                </div>
				
            </div>
         </form>
        </fieldset>
    </div>
</div>