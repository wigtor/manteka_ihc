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
		<form id="formAgregar" type="post" action="<?php echo site_url("Alumnos/insertarAlumno/")?>">
			<legend>Agregar Alumno</legend>
			
				<div>
					<div class= "row-fluid">
						<div class= "span6" style="margin-bottom:2%">
							Ingrese datos del Alumno:
						</div>
					</div>
					
					<div  class= "row-fluid" style="margin-left:2%">
						<div class= "span6">
							<div class="row"> <!-- rut-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">1-.*RUT</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="rut_estudiante">
										</div>
								</div>
							</div>
							<div class="row"> <!-- nombre uno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">2-.*Nombre uno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="nombre1_estudiante">
										</div>
								</div>
							</div>							
							<div class="row"> <!-- nombre dos-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">2-.*Nombre dos</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="nombre2_estudiante">
										</div>
								</div>

							</div>
							
							<div class="row"> <!-- ape paterno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">3-.*Apellido Paterno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="apellido_paterno">
										</div>
								</div>

							</div>
							<div class="row"> <!-- ape materno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">4-.*Apellido Materno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="apellido_materno">
										</div>
								</div>

							</div>
							<div class="row"> <!-- correo-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">5-.*Correo</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="correo_estudiante">
										</div>
								</div>

							</div>

						</div> 

						<div class="span6" >
							
							<div class="row"> <!-- carrera-->
								<div class="span5">
									<div class="control-group">
										<label class="control-label" for="inputInfo">6-.*Asignar Carrera</label>
									</div>
								</div>
								<div  class="span6">
									<select id="carreraAsignada" name="cod_carrera" title="asigne carrera">
									<?php
									$contador=0;
									$comilla= "'";
									while ($contador<count($carreras)){
						
										echo '<option value="'.$carreras[$contador][0].'">'.$carreras[$contador][0].' - '.$carreras[$contador][1].'</option>';
										$contador = $contador + 1;
									}
									?>
									</select> 
								</div>
							</div>
							
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
					<div class="row" style="width: 845px; margin-top:10px">		
							<div class="span2" style="margin-left: 654px;">
									<input type="submit" value="Agregar">
								</div>
								<div class="span1" style="margin-left: -32px;">
									<button class="btn" type="reset">Cancelar</button>
								</div>
							</div>
				</div> 
			</div>
		</form>
		</fieldset>
	</div>	
</div>
