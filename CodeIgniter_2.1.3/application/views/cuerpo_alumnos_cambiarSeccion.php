<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se han cambiado de sección a todos los alumnos correctamente");
				}
				else{
					alert("Error al realizar el cambio de sección");
				}
	}
</script>

<script type="text/javascript">
	function cambioSeccion(){
		var seccion1 = document.getElementsByName("cod_seccion1");
		var seccion2 = document.getElementsByName("cod_seccion2");
		var cont;
		var numS1;
		var numS2;
		for(cont=0;cont < seccion1.length;cont++){
			if(seccion1[cont].checked == true){
				numS1 = cont;
				cont = seccion1.lenght;
			}
		}
		for(cont=0;cont < seccion2.length;cont++){
			if(seccion2[cont].checked == true){
				numS2 = cont;
				cont = seccion2.lenght;
			}
		}
	
		if(seccion1[numS1].value == seccion2[numS2].value){
			alert("Debe escoger secciones distintas");
			return false;
		}
		
		var answer = confirm("¿Está seguro de realizar cambios? ")
		if (!answer){
			return false;//terminar
		}
		else{

		var cambio = document.getElementById("FormS1");
		cambio.action = "<?php echo site_url("Alumnos/HacerCambiarSeccionAlumnos/") ?>";				
		cambio.submit();
		}
		return false;
	
	}
</script>

<script type="text/javascript">
	function mostrarS(cod_seccion,tipo_lista){

	var arreglo = new Array();
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($rs_estudiantes)){
		echo 'arreglo['.$contadorE.']= "'.$rs_estudiantes[$contadorE][6].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	if(tipo_lista == "lista1_"){
		var checkboxlistaS1 = document.getElementsByName("seleccionadosS1[]");
		for(cont=0;cont < checkboxlistaS1.length;cont++){
			checkboxlistaS1[cont].checked = false;
		}
	}
	else{
		var checkboxlistaS2 = document.getElementsByName("seleccionadosS2[]");
		for(cont=0;cont < checkboxlistaS2.length;cont++){
			checkboxlistaS2[cont].checked = false;
		}
	}
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultar=document.getElementById(tipo_lista+cont);
		if(0 > arreglo[cont].toLowerCase().indexOf(cod_seccion.toLowerCase())){
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
			ocultarTd.style.display='none';
			//ocultarInput.checked = false;
		}
		else
		{
			ocultarTd.style.display='';
		}
    }
}
</script>


<script type="text/javascript">
function ordenarFiltro(tipo_lista){
	var filtroLista = document.getElementById(tipo_lista+"filtro").value;
	var tipoDeFiltro = document.getElementById(tipo_lista+"tipoDeFiltro").value;

	var arreglo = new Array();
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
		ocultar=document.getElementById(tipo_lista+cont);
		ocultarCb=document.getElementById("c_"+tipo_lista+cont);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
			ocultarCb.checked = false;
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
			<legend>Cambio de sección</legend>
			<div class= "row-fluid">
				<form id="FormS1" type="post" onsubmit="cambioSeccion() ;return false" method="post"><!--FORM PRIMERA SECCION-->
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
								<button class="btn" type="submit" name="botonCambio" value="1">   >   </button>
				
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
												$comilla= "'";
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro1_'.$contador.'" ><input required onclick="mostrarS('.$comilla.$secciones[$contador][0].$comilla.','.$comilla.'lista1_'.$comilla.')" required id="filtro1_'.$secciones[$contador][0].'" value="'.$secciones[$contador][0].'" name="cod_seccion1" type="radio" ></input> '.$secciones[$contador][1].'</td>';
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
										
										
										<select id="lista1_tipoDeFiltro" title="Tipo de filtro">
										<option value="1">Filtrar por Nombre</option>
										<option value="3">Filtrar por Apellido paterno</option>
										<option value="4">Filtrar por Apellido materno</option>
										<option value="7">Filtrar por Código carrera</option>
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
											echo	'<td  id="lista1_'.$contador.'"  style="text-align:left;display:none;">
													<input id="c_lista1_'.$contador.'" type="checkbox" name="seleccionadosS1[]" value="'.$rs_estudiantes[$contador][0].'">  '.$rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
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
									<button class="btn" type="submit" name="botonCambio" value="2">   <   </button>
				
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
												$comilla= "'";
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro2_'.$contador.'" ><input required onclick="mostrarS('.$comilla.$secciones[$contador][0].$comilla.','.$comilla.'lista2_'.$comilla.')" required id="filtro2_'.$secciones[$contador][0].'" value="'.$secciones[$contador][0].'" name="cod_seccion2" type="radio" >'.$secciones[$contador][1].'</td>';
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
									<select id="lista2_tipoDeFiltro" title="Tipo de filtro" >
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Código carrera</option>
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
											echo	'<td  id="lista2_'.$contador.'" style="text-align:left;display:none;" >
														  <input id="c_lista2_'.$contador.'" type="checkbox" name="seleccionadosS2[]" value="'.$rs_estudiantes[$contador][0].'">  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}								
										?>
																
									</tbody>
								</table>
							</div>

					</div>
				</div>
				</form><!--FORM SEGUNDA SECCION-->
			</div>

			
		</fieldset>
				
	</div>
</div>

<script type="text/javascript">
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		//para cargar la pagina con lo que quedo
		document.getElementById("filtro1_<?php echo $seccion1;?>").checked = true;
		document.getElementById("filtro2_<?php echo $seccion2;?>").checked = true;
		mostrarS('<?php echo $seccion1;?>','lista1_');
		mostrarS('<?php echo $seccion2;?>','lista2_');
	}
</script>
