<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Alumno eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
function ordenarFiltroSeccion(tipo_seccion){
	var filtroLista = document.getElementById(tipo_seccion).value;
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
		ocultarInput=document.getElementById(tipo_seccion+arreglo[cont]);
		ocultarTd=document.getElementById(tipo_seccion+cont);
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


<script type="text/javascript">
function ordenarFiltro(tipo_lista){
	var filtroLista = document.getElementById(tipo_lista+"filtro").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	var arreglo = new Array();
	var alumno;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($rs_estudiantes)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_estudiantes[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_estudiantes[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_estudiantes[$contadorE][4].'";';
		echo 'arreglo['.$contadorE.'][7] = "'.$rs_estudiantes[$contadorE][7].'";';
		echo 'arreglo['.$contadorE.'][6] = "'.$rs_estudiantes[$contadorE][6].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		alumno = document.getElementById(cont);
		ocultar=document.getElementById(tipo_lista+cont);
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


<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Cambiar de sección</legend>
			<div class= "row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span6"> 
							1.-Seleccione una sección:
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								Mover de sección:
									<button class="btn" type="reset">   >   </button>
				
						</div>
						<div class="span6" style="align:right">
							
							<div class="controls">
								<input type="text" onkeyup="ordenarFiltroSeccion('filtro1_')" id="filtro1_" placeholder="Filtro de Sección" style="width: 93%">
							</div>
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px;-webkit-border-radius: 4px" >
								<table class="table table-hover">
									<thead>
									</thead>
										<tbody>									
											<?php
												$contador=0;
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro1_'.$contador.'" ><input id="filtro1_'.$secciones[$contador].'" value="'.$secciones[$contador].'" name="cod_seccion" type="radio" >'.$secciones[$contador].'</td>';
												echo '</tr>';
												$contador = $contador + 1;
												}
											?>
										</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<br>
						Estudiantes de la sección:
						 
						<br>
						<br>
						<div class="span11">
						
							<div class="row-fluid">
								<div class="span6">
									
									
									<input id="lista1_filtro"  onkeyup="ordenarFiltro('lista1_')" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
							

								<div class="span6">
										
										
										<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
										<option value="1">Filtrar por Nombre</option>
										<option value="3">Filtrar por Apellido paterno</option>
										<option value="4">Filtrar por Apellido materno</option>
										<option value="7">Filtrar por Carrera</option>
										<option value="6">Filtrar por Seccion</option>
										</select>
								</div> 
							</div>
						</div>
					</div>
				
			
					<div class="row-fluid" style="margin-left: 0%;">
						
							<thead>
								<tr>
									<th style="text-align:left;">Nombre Completo</th>
									
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover">
									<tbody>
									
										<?php
										$contador=0;
										$comilla= "'";
										
										while ($contador<count($rs_estudiantes)){
											
											echo '<tr>';
											echo	'<td  id="lista1_'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
														  style="text-align:left;">
														  <input type="checkbox" name="option1" value="Milk">&nbsp;&nbsp; '.$rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}
										
										?>
																
									</tbody>
								</table>
							</div>

					</div>
				</div>
			

				<div class="span6">
					<div class="row-fluid">
						<div class="span6"> 
							2.-Seleccione una segunda sección:
							
								<br>
								<br>
								<br>
								<br>
								<br>
								Mover de sección:
									<button class="btn" type="reset">   <   </button>
				
						</div>
						<div class="span6">
							
							<div class="controls">
								<input type="text" onkeyup="ordenarFiltroSeccion('filtro2_')" id="filtro2_" placeholder="Filtro de Sección" style:"width:93%">
							</div>
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px;-webkit-border-radius: 4px" >
								<table class="table table-hover">
									<thead>
									</thead>
										<tbody>									
											<?php
												$contador=0;
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro2_'.$contador.'" ><input id="filtro2_'.$secciones[$contador].'" value="'.$secciones[$contador].'" name="cod_seccion" type="radio" >'.$secciones[$contador].'</td>';
												echo '</tr>';
												$contador = $contador + 1;
												}
											?>
										</tbody>
								</table>
							</div>
						</div>
					</div>
				<div class="row-fluid">
					<br>
					Estudiantes de la sección:
					<br>
					<br>
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="lista2_filtro"  onkeyup="ordenarFiltro('lista2_')" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
							<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Carrera</option>
									<option value="6">Filtrar por Seccion</option>
									</select>
							</div> 
						</div>
					</div>
				</div>
					<div class="row-fluid" style="margin-left: 0%;">
							<thead>
								<tr>
									<th style="text-align:left;">Nombre Completo</th>
									
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover">
									<tbody>
									
										<?php
										$contador=0;
										$comilla= "'";
										
										while ($contador<count($rs_estudiantes)){
											
											echo '<tr>';
											echo	'<td  id="lista2_'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
														  style="text-align:left;">
														  <input type="checkbox" name="option1" value="Milk">&nbsp;&nbsp; '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
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

			
		</fieldset>
	</div>
</div>
