
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

		var cod_sala=document.getElementById("cod_sala").value;
		var num_sala = document.getElementById("num_salaEditar").value;
		var ubicacion =	document.getElementById("ubicacionEditar").value;
		var capacidad=	document.getElementById("capacidadEditar").value;
		
		if(cod_sala!="" && num_sala!=""  && capacidad!="" && ubicacion!="" ){
					var answer = confirm("¿Está seguro de realizar cambios?")
					if (!answer){
						var dijoNO = datosEditarSala("","","","","","");
					}
					else{
					var editar = document.getElementById("FormEditar");
					editar.action = "<?php echo site_url("Salas/EditarSala/") ?>";
				
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
			
			
			document.getElementById("cod_salaEditar").value = cod_sala;
			document.getElementById("num_salaEditar").value = num_sala;
			document.getElementById("ubicacionEditar").value = ubicacion;
			document.getElementById("capacidadEditar").value = capacidad;
	}
</script>


<div class="row_fluid">
	<div class="span10">
		<fieldset>
			<legend>Editar Sala</legend>
			<div>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorio</font>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA SALA -->
						<div class="row-fluid">
							<div class="span6">
								Seleccione la sala a modificar
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
						<thead>
							<tr>
								<th style="text-align:left;"><br><b>Salas</b></th>
								
							</tr>
						</thead>
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
						<tbody>
						
							<?php
							$contador=0;
							$comilla= "'";
							echo '<form id="formDetalle" type="post">';
							while ($contador<count($rs_sala)){
								
								echo '<tr>';
								echo	'<td  id="'.$contador.'" onclick="datosEditarSala('.$comilla.$rs_sala[$contador][0].$comilla.','.$comilla. $rs_sala[$contador][1].$comilla.','.$comilla. $rs_sala[$contador][2].$comilla.','.$comilla. $rs_sala[$contador][3].$comilla.')" 
											  style="text-align:left;">
											  '. $rs_sala[$contador][1].' </td>';
								echo '</tr>';
															
								$contador = $contador + 1;
							}
							echo '</form>';
							?>
													
						</tbody>
						</table>
						</div>
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA SALAS -->
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar la sala
						</div>

					<form id="FormEditar" type="post" onsubmit="EditarSala()">
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">Codigo sala: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="cod_salaEditar" name="cod_sala" readonly>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Numero sala: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="num_salaEditar" name="num_sala" maxlength="19" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font>Capacidad: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="capacidadEditar" name="capacidad" maxlength="19" required>
		  							</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font>Ubicacion:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="ubicacionEditar" name="ubicacion" maxlength="19" required>
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
											echo '<td title="'.$implemento[$contador][2]. '" id="implementoTd_'.$contador.'" ><input id="'.$implemento[$contador][0].'" value="'.$implemento[$contador][0].'" name="cod_implemento[]" type="checkbox" >'.' '.$implemento[$contador][1].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
					</table>
						
					</div>
					</div>
		



						<div class="row-fluid">
							<div class="span10">
								<div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit" >Guardar</button>
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
		</fieldset>
	</div>
</div>