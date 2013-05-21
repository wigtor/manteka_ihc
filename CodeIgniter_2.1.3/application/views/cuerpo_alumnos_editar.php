
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha actualizado el estudiante");
				}
				else{
					alert("Error al actualizar");
				}
	}
</script>

<script type="text/javascript">
	function EditarEstudiante(){

		var rut = document.getElementById("rutEditar").value;
		var nombreUno =	document.getElementById("nombreunoEditar").value;
		var nombreDos =	document.getElementById("nombredosEditar").value;
		var apellidoPaterno = document.getElementById("apellidopaternoEditar").value;
		var apellidoMaterno = document.getElementById("apellidomaternoEditar").value;
		var correo = document.getElementById("correoEditar").value;
		var seccion = document.getElementById("<?php $secciones[0]?>");
	
		if(rut!="" && nombreUno!=""  && apellidoPaterno!="" && apellidoMaterno!="" && correo!=""){
					var answer = confirm("¿Está seguro de realizar cambios?")
					if (!answer){
						var dijoNO = datosEditarAlumno("","","","","","");
					}
					else{
					var editar = document.getElementById("FormEditar");
					editar.action = "<?php echo site_url("Alumnos/EditarEstudiante/") ?>";
				
					editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				var mantenerDatos = datosEditarAlumno(rut,nombreUno,nombreDos,apellidoPaterno,apellidoMaterno,correo,seccion);
		}
	}
</script>

<script type="text/javascript">
function ordenarFiltro2(){
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
		//alumno = document.getElementById(cont);
		ocultar =document.getElementById(cont);
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
	function datosEditarAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion){
			
			
			document.getElementById("rutEditar").value = rut;
			document.getElementById("nombreunoEditar").value = nombre1;
			document.getElementById("nombredosEditar").value = nombre2;
			document.getElementById("apellidopaternoEditar").value = apePaterno;
			document.getElementById("apellidomaternoEditar").value = apeMaterno;
			document.getElementById("correoEditar").value = correo;
			document.getElementById(seccion).checked=true;	
		
	}
</script>


<div class="row_fluid">
	<div class="span10">
		<fieldset>
			<legend>Editar Alumno</legend>
			<div>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>

				</div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA DE ALUMNOS -->
						<div class="row-fluid">
							<div class="span6">
								1.-<font color="red">*</font>Seleccionar Alumno
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Código Carrera</option>
									<option value="6">Filtrar por Seccion</option>
									</select> 
								</div>
							</div>
						</div>
						
						
						<!--AQUÍ VA LA LISTA-->
						<div class="row-fluid" style="margin-left: 0%;">
							<thead>
								<tr>
									<th style="text-align:left;"><br><b>Nombre Completo</b></th>
									
								</tr>
							</thead>
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
							<table class="table table-hover">
							<tbody>
							
								<?php
								$contador=0;
								$comilla= "'";
								echo '<form id="formDetalle" type="post">';
								while ($contador<count($rs_estudiantes)){
									
									echo '<tr>';
									echo	'<td  id="'.$contador.'" onclick="datosEditarAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','.$comilla. $rs_estudiantes[$contador][6].$comilla.')" 
												  style="text-align:left;">
												  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								echo '</form>';
								?>
														
							</tbody>
							</table>
							</div>
						</div>
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA DE ALUMNOS -->
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar el alumno
						</div>
					<!-- AQUI EMPIEZA EL MAMBO-->
					<form id="FormEditar" type="post" onsubmit="EditarEstudiante()">

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.RUT</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="rutEditar" name="rut_estudiante" readonly>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Primer nombre</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="nombreunoEditar" name="nombre1_estudiante" maxlength="19" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.Segundo nombre</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="nombredosEditar" name="nombre2_estudiante" maxlength="19" >
		  							</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido Paterno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="apellidopaternoEditar" name="apellido_paterno" maxlength="19" required>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5-.<font color="red">*</font>Apellido Materno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="apellidomaternoEditar" name="apellido_materno" maxlength="19" required>
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">6-.<font color="red">*</font>Correo</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" placeholder="ejemplo@usach.cl" id="correoEditar" name="correo_estudiante" maxlength="19" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid"> <!-- seccion-->
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">7-.<font color="red">*</font>Asignar sección</label>
									</div>
								</div>
								<div  class="span5" >
								
									<div class="controls">
										<input type="text" onkeyup="ordenarFiltro2()" id="filtroSeccion" placeholder="Filtro de Sección">
									</div>

								</div>
						</div>
						
							<div class="row-fluid">
								<div class="span5 offset4">
									<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px; width: 127%" >
									
									
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
							
							
						
						
						<div class="row-fluid">
							<div class="span11" style="margin-top:2%; margin-left:43%">
								<div class="row-fluid">
									<div class="span3">
										<button class ="btn" type="submit" >Guardar</button>
									</div>
									<div class="span3">
										<button  class ="btn" type="reset" <?php $comilla= "'"; echo 'onclick="datosEditarAlumno('.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$secciones[0].$comilla.')"';?> >Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</form>	
				</div>
					<!-- AQUI TERMINA -->

					</div>
				</div>
			</div>
		</fieldset>
	</div>
