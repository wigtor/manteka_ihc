
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
	
		if(rut!="" && nombreUno!="" && nombreDos!="" && apellidoPaterno!="" && apellidoMaterno!="" && correo!=""){
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
				var mantenerDatos = datosEditarAlumno(rut,nombreUno,nombreDos,apellidoPaterno,apellidoMaterno,correo);
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
	function datosEditarAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo){
			
			
			document.getElementById("rutEditar").value = rut;
			document.getElementById("nombreunoEditar").value = nombre1;
			document.getElementById("nombredosEditar").value = nombre2;
			document.getElementById("apellidopaternoEditar").value = apePaterno;
			document.getElementById("apellidomaternoEditar").value = apeMaterno;
			document.getElementById("correoEditar").value = correo;
		
	}
</script>


<div class="row_fluid">
	<div class="span10">
		<fieldset>
			<div>
			<legend>Editar Alumno</legend>
			</div>
			<div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA DE ALUMNOS -->
					
						<fieldset>
							<div class="span10">
							<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">

								<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
								<option value="1">Filtrar por Nombre</option>
								<option value="3">Filtrar por Apellido paterno</option>
								<option value="4">Filtrar por Apellido materno</option>
								<option value="7">Filtrar por Carrera</option>
								<option value="6">Filtrar por Seccion</option>
								</select> 
							</div>
						</fieldset>
						
						<!--AQUÍ VA LA LISTA-->
						<thead>
							<tr>
								<th style="text-align:left;"><br><b>Nombre Completo</b></th>
								
							</tr>
						</thead>
						<div style="border:grey 1px solid;overflow-y:scroll;height:400px" ><!--  para el scroll-->
						<table class="table table-hover">
						<tbody>
						
							<?php
							$contador=0;
							$comilla= "'";
							echo '<form id="formDetalle" type="post">';
							while ($contador<count($rs_estudiantes)){
								
								echo '<tr>';
								echo	'<td  id="'.$contador.'" onclick="datosEditarAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.')" 
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
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA DE ALUMNOS -->
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar el alumno
						</div>
					<!-- AQUI EMPIEZA EL MAMBO-->
					<form id="FormEditar" type="post">
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.*RUT</label>
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
		  							<label class="control-label" for="inputInfo">2-.*Nombre uno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="nombreunoEditar" name="nombre1_estudiante">
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.*Nombre dos</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="nombredosEditar" name="nombre2_estudiante">
		  							</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.*Apellido Paterno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="apellidopaternoEditar" name="apellido_paterno">
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.*Apellido Materno</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="apellidomaternoEditar" name="apellido_materno">
		  							</div>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5-.*Correo</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="correoEditar" name="correo_estudiante">
		  							</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span10">
								<div class="row-fluid">
									<div class="span3 offset6">
										<input type="submit" onclick="EditarEstudiante()" value="Guardar">
									</div>
									<div class="span3">
										<button  class ="btn" type="reset" onclick="datosEditarAlumno('','','','','','')" >Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</form>	
					<!-- AQUI TERMINA EL MAMBO... marco qliao pierdete un div xz -->

					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>