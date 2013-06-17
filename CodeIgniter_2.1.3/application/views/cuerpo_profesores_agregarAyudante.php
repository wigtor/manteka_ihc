<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el ayudante");
				}
				else{
					alert("Error al agregar");
				}
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var alumno;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($profesores)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][0] = "'.$profesores[$contadorE][0].'";';//rut
		echo 'arreglo['.$contadorE.'][1] = "'.$profesores[$contadorE][1].'";';//nombre
		echo 'arreglo['.$contadorE.'][2] = "'.$profesores[$contadorE][2].'";';//apellido
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarTd=document.getElementById("profesoresTd_"+cont);
		ocultar =document.getElementById(arreglo[cont][0]);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultar.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>


		<fieldset>
			<legend>Agregar Ayudante</legend>
		<form id="formAgregar" type="post" action="<?php echo site_url("Ayudantes/insertarAyudante/")?>">
				<div class="row-fluid">
					<div class="span6">
						<font color="red">* Campos Obligatorios</font>
					</div>
				</div>
				
				<div class="row-fluid">
					<div class= "span6" >
						<p>Complete los datos del formulario para ingresar un ayudante</p>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span6">

						<div class="row-fluid" >
							<div class="span5">
								<div class="control-group">
							  		<label class="control-label" for="inputInfo" style="cursor: default">1-.<font color="red">*</font> RUT:</label>
							  	</div>
							 </div>
							 <div class="span5">	
							  	<div class="controls">
							    	<input name="rut_ayudante" maxlength="10" min="1" type="number"  placeholder="Ej:17785874" required>
							  	</div>
							</div>	
						</div>

						<div class="row-fluid">
							<div class="span5">
								<div class="control-group">
			  						<label class="control-label" for="inputInfo" style="cursor: default">2-.<font color="red">*</font> Primer nombre:</label>
			  					</div>
			  				</div>
			  				<div class="span5">	
			  					<div class="controls">
			    					<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre1_ayudante" maxlength="19" required >
			  					</div>
							</div>
						</div>

						<div class="row-fluid">
								<div class="span5">
									<div class="control-group">
			  							<label class="control-label" for="inputInfo" style="cursor: default">3-. Segundo nombre:</label>
			  						</div>
			  					</div>
			  					<div class="span5">	
			  							<div class="controls">
			    							<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="nombre2_ayudante" maxlength="19" >
			  							</div>
								</div>
						</div>
					
						<div class="row-fluid">
							<div class="span5">
								<div class="control-group">
			  						<label class="control-label" for="inputInfo" style="cursor: default">4-.<font color="red">*</font> Apellido Paterno:</label>
			  					</div>
			  				</div>
			  				<div class="span5">	
			  					<div class="controls">
			    					<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido_paterno" maxlength="19" required >
			  					</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span5">
								<div class="control-group">
			  						<label class="control-label" for="inputInfo" style="cursor: default">5-.<font color="red">*</font> Apellido Materno:</label>
			  					</div>
			  				</div>
			  				<div class="span5">	
			  					<div class="controls">
			    					<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" title="Use solo letras para este campo" name="apellido_materno" maxlength="19" required >
			  					</div>
							</div>

						</div>

						<div class="row-fluid">
							<div class="span5">
								<div class="control-group">
			  						<label class="control-label" for="inputInfo" style="cursor: default">6-.<font color="red">*</font>Correo:</label>
			  					</div>
			  				</div>
			  				<div class="span5">	
			  					<div class="controls">
			    					<input type="email" name="correo_ayudante" maxlength="199" placeholder="nombre_usuario@miemail.com" required >
			  					</div>
							</div>
						</div>

				</div> <!--fin primer segmento-->
				


				<div class="span6">
					
						<div class="row-fluid">
							<div class="span5">
								<div class="control-group">
									<label class="control-label" for="inputInfo" style="cursor: default">7-.<font color="red">*</font>Asignar profesor</label>
								</div>
							</div>
							<div  class="span6" >	
								<fieldset>
									<div class="span12">					
										<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">

											<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
											<option value="1">Filtrar por Nombre</option>
											<option value="2">Filtrar por Apellido paterno</option>
											<option value="0">Filtrar por RUT</option>
											</select> 
										
									
									</div>
								</fieldset>
							</div>
						</div>

						<div class="row-fluid" style="margin-top:2%">
							<div class="span7 offset5">
								<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
								
								
									<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										while ($contador<count($profesores)){
											echo '<tr>';
											echo '<td id="profesoresTd_'.$contador.'" ><input required id="'.$profesores[$contador][0].'" value="'.$profesores[$contador][0].'" name="cod_profesores" type="radio" >'.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

								
						<div class="row-fluid" style="margin-top:2%">
									
							<div class="span3 offset4" >
								<button type="submit" class="btn">
									<div class= "btn_with_icon_solo">Ã</div>
									&nbsp Agregar
								</button>
							</div>
							<div class="span3" >
								<button class="btn" type="reset">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
							
						</div>

				</div>
			</div>
			</div>
		</form>				
		</fieldset>
