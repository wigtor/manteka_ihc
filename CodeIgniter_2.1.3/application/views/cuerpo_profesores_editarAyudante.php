
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha actualizado el ayudante");
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
					editar.action = "<?php echo site_url("Ayudantes/EditarAyudante/") ?>";
				
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
	while($contadorE<count($rs_ayudantes)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_ayudantes[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_ayudantes[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_ayudantes[$contadorE][4].'";';
		echo 'arreglo['.$contadorE.'][7] = "'.$rs_ayudantes[$contadorE][0].'";';

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
			<legend>Editar Ayudante</legend>
			<div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA DE AYUDANTES -->
						<div class="row-fluid">
							<div class="span6">
								Seleccione ayudante a modificar
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
									<option value="0">Filtrar por RUT</option>
									</select>
								</div> 
							</div>
						</div>
						
						
						<!--AQUÍ VA LA LISTA-->
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
							while ($contador<count($rs_ayudantes)){
								
								echo '<tr>';
								echo	'<td  id="'.$contador.'" onclick="datosEditarAlumno('.$comilla.$rs_ayudantes[$contador][0].$comilla.','.$comilla. $rs_ayudantes[$contador][1].$comilla.','.$comilla. $rs_ayudantes[$contador][2].$comilla.','.$comilla. $rs_ayudantes[$contador][3].$comilla.','.$comilla. $rs_ayudantes[$contador][4].$comilla.','.$comilla. $rs_ayudantes[$contador][5].$comilla.')" 
											  style="text-align:left;">
											  '. $rs_ayudantes[$contador][3].' '.$rs_ayudantes[$contador][4].' ' . $rs_ayudantes[$contador][1].' '.$rs_ayudantes[$contador][2].'</td>';
								echo '</tr>';
															
								$contador = $contador + 1;
							}
							echo '</form>';
							?>
													
						</tbody>
						</table>
						</div>
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA DE AYUDANTES -->
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar el ayudante
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
		    							<input type="text" id="rutEditar" name="rut_ayudante" readonly>
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
		    							<input type="text" id="nombreunoEditar" name="nombre1_ayudante" maxlength="19" required>
		  							</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Segundo nombre</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" id="nombredosEditar" name="nombre2_ayudante" maxlength="19" required>
		  							</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Apellido Paterno</label>
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
		  							<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido Materno</label>
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
		  							<label class="control-label" for="inputInfo">5-.<font color="red">*</font>Correo</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" id="correoEditar" name="correo_ayudante" maxlength="19" placeholder="ejemplo@usach.cl" required>
		  							</div>
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