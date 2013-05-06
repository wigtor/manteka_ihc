
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
										<label class="control-label" for="inputInfo">1-.<font color="red">*</font> RUT</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input maxlength="10" type="number" name="rut_estudiante" placeholder="Ingrese rut sin dig. verificador" required>
										</div>
								</div>
							</div>
							<div class="row"> <!-- nombre uno-->
								<div class="span4">
									<div class="control-group">
										<label maxlength="20" class="control-label" for="inputInfo">2-.<font color="red">*</font>Primer nombre</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="nombre1_estudiante" maxlength="19" required >
										</div>
								</div>
							</div>							
							<div class="row"> <!-- nombre dos-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Nombre dos</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="nombre2_estudiante" maxlength="19" required>
										</div>
								</div>

							</div>
							
							<div class="row"> <!-- ape paterno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Apellido Paterno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="apellido_paterno" maxlength="19" required>
										</div>
								</div>

							</div>
							<div class="row"> <!-- ape materno-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido Materno</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="text" name="apellido_materno" maxlength="19" required>
										</div>
								</div>

							</div>
							<div class="row"> <!-- correo-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">5-.<font color="red">*</font>Correo</label>
									</div>
								</div>
								<div class="span5">	
										<div class="controls">
											<input type="email" name="correo_estudiante" maxlength="19" placeholder="ejemplo@usach.cl" required>
										</div>
								</div>

							</div>

						</div> 

						<div class="span6" >
							
							<div class="row"> <!-- carrera-->
								<div class="span5">
									<div class="control-group">
										<label class="control-label" for="inputInfo">6-.<font color="red">*</font>Asignar Carrera</label>
									</div>
								</div>
								<div  class="span6">
									<select required id="carreraAsignada" name="cod_carrera" title="asigne carrera" >
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
										<label class="control-label" for="inputInfo">7-.<font color="red">*</font>Asignar sección</label>
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
												echo '<td id="seccionTd_'.$contador.'" ><input required id="'.$secciones[$contador].'" value="'.$secciones[$contador].'" name="cod_seccion" type="radio" >'.$secciones[$contador].'</td>';
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
									<button class="btn" type="submit">Agregar</button>
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
