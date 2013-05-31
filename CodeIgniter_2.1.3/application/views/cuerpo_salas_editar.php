<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha actualizado la sala");
				}
				else{
					alert("Error al actualizar");
				}
	}
</script>

<script type="text/javascript">
	function EditarSala(){

		var cod_sala = document.getElementById("cod_sala").value;
		var num_sala = document.getElementById("num_sala").value;
		var ubicacion =	document.getElementById("ubicacion").value;
		var capacidad =	document.getElementById("capacidad").value;
		if( num_sala!=""  && capacidad!="" && ubicacion!="" ){
					var answer = confirm("¿Está seguro de realizar cambios?")
					if (!answer){
						var dijoNO = datosEditarSala("","","","");
					}
					else{
					var editar = document.getElementById("FormEditar");
					editar.action = "<?php echo site_url("Salas/editarSalas/") ?>/";
				
					editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				var mantenerDatos = datosEditarSala(cod_sala,num_sala,ubicacion,capacidad);
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
	while($contadorE<count($rs_sala)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_sala[$contadorE][1].'";';
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

<script type="text/javascript">
	function datosEditarSala(cod_sala,num_sala,ubicacion,capacidad){
			document.getElementById("cod_sala").value = '';
			document.getElementById("codEditar").value = cod_sala;
			var editar = document.getElementById("formDetalle");
			editar.action = "<?php echo site_url("Salas/editarSalas/") ?>/";
			editar.submit();

	}
</script>


<div class="row_fluid">
	<div class="span10">
		<fieldset>
		<legend>Editar Sala</legend>
		 <form id="formDetalle" type="post" method="post">
			
			<div>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA SALA -->
						<div class="row-fluid">
							<div class="span6">
							1.-Seleccione la sala a modificar
							</div>
						</div>
					
						
						<div class="row-fluid">	
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Número</option>
									</select>
								</div> 
							</div>
						</div>
						
						
						<!--AQUÍ VA LA LISTA-->
						
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
						<tbody>
						<input id="codEditar" type="text" name="codEditar" style="display:none">
							<?php
							$contador=0;
							$comilla= "'";
					
							while ($contador<count($rs_sala)){
								
								echo '<tr>';
								echo	'<td  id="'.$contador.'" onclick="datosEditarSala('.$comilla.$rs_sala[$contador][0].$comilla.','.$comilla. $rs_sala[$contador][1].$comilla.','.$comilla. $rs_sala[$contador][2].$comilla.','.$comilla. $rs_sala[$contador][3].$comilla.')" 
											  style="text-align:left;">
											  '. $rs_sala[$contador][1].' </td>';
								echo '</tr>';
															
								$contador = $contador + 1;
							}
							
							?>
													
						</tbody>
						</table>
						</div>
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA SALAS -->
					<div class="span6">
						<div style="margin-bottom:2%">
							2.- Complete los datos del formulario para modificar la sala
							
						</div>

					<form id="FormEditar" type="post" method="post" onsubmit="EditarSala()">
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Código sala: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
									<?php
									
									if(count($sala)==1){
									
		    							echo '<tr>';
										echo '<td><input id="cod_sala" name="cod_sala" value="'.$sala[0][0].'" maxlength="3" min="1" type="number" readonly>'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="cod_sala" name="cod_sala" value=" " maxlength="0" min="0" type="number" readonly>'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Número sala: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
									<?php
									
									if(count($sala)==1){
									
		    							echo '<tr>';
										echo '<td><input id="num_sala" name="num_sala" value="'.$sala[0][1].'" maxlength="3" min="1" type="number">'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="num_sala" name="num_sala" value=" " maxlength="0" min="0" type="number">'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Capacidad: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  						<div class="controls">
									<?php
									if(count($sala)==1){
		    							echo '<tr>';
										echo '<td><input id="capacidad" name="capacidad" value="'.$sala[0][3].'" maxlength="3" min="1" type="number">'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="capacidad" name="capacidad" value=" " maxlength="0" min="0" type="number">'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">

		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Ubicación:</label>
		  						</div>
		  					</div>
							
							<div class="span5">	
		  						<div class="controls">
									<?php
									if(count($sala)==1){
		    							echo '<tr>';
										echo '<td><textarea id="ubicacion" name="ubicacion"  maxlength="100" required>'.$sala[0][2].'</textarea>'.'</td>';
										echo '</tr>';							
										}
									else{
									    echo '<tr>';
										echo '<textarea id="ubicacion" name="ubicacion"  maxlength="0" required> </textarea>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
							

						</div>
						

					<div class="row-fluid" style="width: 386px;">		
					<br>
					<h5>Si desea modificar los implementos de la sala, elija entre los siguientes:</h5>
					(los implementos marcados son los que tiene actualmente la sala)
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:105px; -webkit-border-radius: 4px" >
					
					
					<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										
										while ($contador<count($implemento)){
											echo '<tr>';
											echo '<td title="'.$implemento[$contador][3]. '" id="implementoTd_'.$contador.'" ><input id="'.$implemento[$contador][1].'" value="'.$implemento[$contador][1].'" name="cod_implemento[]" type="checkbox" checked>'.' '.$implemento[$contador][2].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										$contador=0;
										
										while ($contador<count($implementoA)){
											echo '<tr>';
											echo '<td title="'.$implementoA[$contador][3]. '" id="implementoATd_'.$contador.'" ><input id="'.$implementoA[$contador][1].'" value="'.$implementoA[$contador][1].'" name="cod_implementoA[]" type="checkbox">'.' '.$implementoA[$contador][2].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
								
								
										</tbody>
					</table>
						
					</div>

					</div>
		


						<br>
						<div class="row-fluid">
							<div class="span10">
								<div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit" onclick="EditarSala()" >Guardar</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" onclick="datosEditarAlumno('','','','','','')" >Cancelar</button>
									</div>
								</div>
							</div>
						</div>

					</form>	
					<!-- AQUI TERMINA  -->

					</div>
				</div>
			</div>
			</form>
		</fieldset>
	</div>
</div>