<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el estudiante");
				}
				else{
					alert("Error al agregar");
				}
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroSeccion").value;
	var arreglo = new Array();
	var ocultarInput;
	var ocultarTd;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($secciones)){
		echo 'arreglo['.$contadorE.'] = "'.$secciones[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarInput=document.getElementById(arreglo[cont]);
		ocultarTd=document.getElementById("seccionTd_"+cont);
		if(0 > arreglo[cont].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultarInput.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultarInput.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>


<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
		<form id="formAgregar" type="post" action="<?php echo site_url("Ayudantes/insertarAyudante/")?>">
			<legend>Agregar Ayudante</legend>
			<div class= "row-fluid">
					<div class= "span6" style="margin-bottom:2%">
						Complete los datos del formulario para ingresar un ayudante
					</div>
			</div>
			<div class="row_fluid" style="margin-left:2%">
				<div class="span6">
					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.*Nombre uno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre1_ayudante">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.*Nombre dos:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre2_ayudante">
		  							</div>
							</div>
					</div>
					
					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.*Apellido Paterno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido_paterno">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.*Apellido Materno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido_materno">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.*RUN:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="rut_ayudante">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5-.*Correo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="correo_ayudante">
		  							</div>
							</div>
					</div>

				</div>
				<div class="span6">
					<div class="row">
						<div class="row"> <!-- seccion-->
							<div class="span5">
								<div class="control-group">
									<label class="control-label" for="inputInfo">7-.*Asignar sección</label>
								</div>
							</div>
							<div  class="span6" >
							
								<div class="controls">
									<input type="text" onkeyup="ordenarFiltro()" id="filtroSeccion" placeholder="Filtro de Sección">
								</div>
								<div style="border:grey 1px solid;overflow-y:scroll;height:200px" >
								
								
									<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										while ($contador<count($secciones)){
											echo '<tr>';
											echo '<td id="seccionTd_'.$contador.'" ><input id="'.$secciones[$contador].'" value="'.$secciones[$contador].'" name="cod_seccion" type="radio" >'.$secciones[$contador].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row" style="width: 845px;">		
						<div class="span2" style="margin-left: 654px;">
								<input type="submit" value="Agregar">
							</div>
							<div class="span1" style="margin-left: -32px;">
								<button class="btn" type="reset">Cancelar</button>
							</div>
			</div>
		</form>				
		</fieldset>
	</div>
</div>