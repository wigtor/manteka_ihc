<?php
if(isset($mensaje_confirmacion))
{
	if($mensaje_confirmacion==1)
	{
		?>
		    <div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Listo</h4>
				 Sección editada correctamente
    		</div>	
		<?php
	}
	else{ if($mensaje_confirmacion==-1)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Error</h4>
				 Error al editar sección
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
	function DetalleSeccion(cod_seccion){
			document.getElementById("cod_seccion").value = cod_seccion;
			var imp= new Array();	
			<?php
			$contadorE = 0;
				while($contadorE<count($seccion)){
				
					echo 'imp['.$contadorE.']=new Array();';
					echo 'imp['.$contadorE.'][0]= "'.$seccion[$contadorE][0].'";';//codigo
					echo 'imp['.$contadorE.'][1]= "'.$seccion[$contadorE][1].'";';//nombre
					$contadorE = $contadorE + 1;
				}
			?>
			var cont;
			var algo='';
			for(cont=0;cont < imp.length;cont++){
				if(imp[cont][0]==cod_seccion ){
					algo= imp[cont][1];				
				}
			}
			var cadena=algo.split('-');
			document.getElementById("rs_seccion").value = cadena[0];
			document.getElementById("rs_seccion2").value = cadena[1];
	}
</script>

<script type="text/javascript">
	function EditarSeccion(){
		var cod=document.getElementById("cod_seccion").value;
		if(cod!=""){ 
					var answer = confirm("¿Está seguro de editar esta sección?")
					if (!answer){
						var dijoNO = DetalleSeccion("");
					}
					else{
					var patron = "^[0-9]{2}$"; //dos números enteros positivos en la primera parte del nombre de la sección
					var patron2 = "^([A-Z]{1}|[a-z]{1})$"; //una letra en la primera parte del nombre de la sección
					if (document.getElementById("rs_seccion2").value.match(patron)) {    
						if (document.getElementById("rs_seccion").value.match(patron2)) {  
							var editar = document.getElementById("FormEditar");
							editar.action = "<?php echo site_url("Secciones/editarSecciones/") ?>/";
							editar.submit();
						}
						else {
							alert("Error:La sección no tiene la estructura Letra-Dígito Dígito");
						}
					}
					else {
						alert("Error:La sección no tiene la estructura Letra-Dígito Dígito");
					}
					}
					
		}
		else{
				alert("Selecione una sección");
		}
		
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var arreglo = new Array();
	var sala;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($seccion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$seccion[$contadorE][1].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultar=document.getElementById("rs_seccionTd_"+cont);
		if(0 > arreglo[cont][1].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
		}
		else
		{
			ocultar.style.display='';
		}
    }
}
</script>

<div class="row-fluid">
    <div class= "span11">
        <fieldset> 
		<legend>Editar Sección</legend>
			<form id="FormEditar" type="post" method="post" onsubmit="EditarSeccion();return false">
            <div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
            
            <div class="row-fluid">
			
                <div class="span5">
                    <div class="row-fluid">
                        <div class="span7">
                            1.-Seleccionar sección
                        </div>
					</div>
				<div class="row-fluid">
				<div class="span11">
					<div class="row-fluid">	
							<div class="span11">
								<div class="controls controls-row">
			    					<div class="input-append span7">
										<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
										<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
									</div>
			
								</div>
							</div>
						</div>
						
				</div>
			</div>
			<div class="row-fluid" style="margin-left: 0%;">
				<!--<div class="span9">-->

					<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
							<tbody>
							
								<?php
								$contador=0;
								$comilla= "'";
								
								while ($contador<count($seccion)){
									
									echo '<tr>';
									echo '<td  id="rs_seccionTd_'.$contador.'"   onclick="DetalleSeccion('.$comilla.$seccion[$contador][0].$comilla.')"> '.$seccion[$contador][1].' </td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								
								?>
														
							</tbody>
						</table>
					</div>
				
			
				<!--</div>-->
			</div>

                </div>
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span5">
                            2.-Información de la sección
							
                        </div>
                    </div>
					
					<input id="cod_seccion" type="text" name="cod_seccion" style="display:none">
                    <div class="row-fluid">
							<div class="span4">
								<div class="control-group">
									
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Sección:</label>
									<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
		  						</div>	
							</div>
													
								<div class="span5">	
		  							<div class="controls">
									<tr>
									<td><input id="rs_seccion" name="rs_seccion"  maxlength="10" min="2" maxlength="1" type="text" class="span2"></td>
									</tr>	
									<td class="span2">-</td>
									<tr>
									<td><input id="rs_seccion2" name="rs_seccion2"  maxlength="10" min="2" maxlength="2" type="text" class="span2"></td>
									</tr>										
									
									</div>
							</div>
                      
                    </div>
					<br>
                    
                    

					<br>
						<div class="row-fluid" style="margin-top: 4%; margin-left:35%">
		
							<button class ="btn" type="submit" >
								<div class="btn_with_icon_solo">Ã</div>
								&nbsp Modificar
							</button>
							<button class ="btn" type="reset" onclick="DetalleSeccion('')"  >
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