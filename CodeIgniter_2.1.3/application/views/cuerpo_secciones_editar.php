<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1" && "<?php echo $mensaje_confirmacion;?>"!="3"){
				alert("Sección editada correctamente");
			
		}
		else{
			if("<?php echo $mensaje_confirmacion;?>"=="-1"){
				alert("Error al editar la sección");
			}		
			else{
				if("<?php echo $mensaje_confirmacion;?>"=="3"){
				alert("No se puede editar,una sección con el mismo ya se ha ingresado");
				}
			}
		}
	}
</script>


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
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var sala;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($seccion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$seccion[$contadorE][0].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultar=document.getElementById(cont);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
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
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									</select>
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
                                <div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit"style="width:111px " >
											<div class="btn_with_icon_solo">Ã</div>
											&nbsp Modificar
										</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" onclick="DetalleSeccion('')" style="width:105px " >
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