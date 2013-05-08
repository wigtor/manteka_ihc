
<script type="text/javascript">
	function EditarProfesor(){
							
		var rut = document.getElementById("runProfeEdit").value;
		var nombre =document.getElementById("nombreProfeEdit").value;
		var apellidoPaterno =document.getElementById("apellidoPaternoProfeEdit").value;
		var apellidoMaterno =document.getElementById("apellidoMaternoProfeEdit").value;
		//var correo = document.getElementById("mailProfeEdit").value;
		var telefono = document.getElementById("telefonoProfeEdit").value;
	//	var modulo = document.getElementById("moduloProfeEdit").value;
		//var seccion = document.getElementById("seccionProfeEdit").value;
		var tipo = document.getElementById("tipoProfeEdit").value;
		if(rut!="" && nombre!="" && telefono!="" && tipo!="" && apellidoPaterno!="" && apellidoMaterno!=""){
					var answer = confirm("¿Está seguro de realizar cambios?");
					if (!answer){
						var dijoNO = datosEditarProfesor("","","","","","","");
					}
					else{
						var editar = document.getElementById("FormEditar");
						editar.action = "<?php echo site_url("Profesores/EditarProfesor/") ?>";
						editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				var mantenerDatos = datosEditarProfesor(rut,nombre,nombre,apellidoPaterno,apellidoMaterno,telefono,tipo);
		}
	}
</script>
<script type="text/javascript">
// rut,nom1,nom2,ap1,ap2,tele,tipo
	function datosEditarProfesor(rut,nombre1,nombre2,apellido1,apellido2,telefono,tipo){
			
			
			document.getElementById("runProfeEdit").value = rut;
			document.getElementById("nombreProfeEdit").value = nombre1+" "+nombre2;
			document.getElementById("apellidoPaternoProfeEdit").value = apellido1;
			document.getElementById("apellidoMaternoProfeEdit").value = apellido2;
		//	document.getElementById("moduloProfeEdit").value = modulo;
			document.getElementById("telefonoProfeEdit").value = telefono;
		//	document.getElementById("moduloProfeEdit").value = modulo;
		//	document.getElementById("seccionProfeEdit").value = seccion;
			document.getElementById("tipoProfeEdit").value = tipo;	
		
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var profesor;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($rs_profesores)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_profesores[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_profesores[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_profesores[$contadorE][4].'";';
		
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
	
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

<div class="row_fluid">
	<div class="span10">
		<fieldset>
			<legend>Editar Profesor</legend>
			<div>
				<div class="row-fluid">
					<div class="span6">
						<div class="row-fluid">
							<div class="span6">
								1.-Listado Profesores
							</div>
						</div>
						<div class="row-fluid">
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">
								</div>
								<div class="span6 " >
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
										<option value="1">Filtrar por Nombre</option>
										<option value="3">Filtrar por Apellido paterno</option>
										<option value="4">Filtrar por Apellido materno</option>
									</select> 
								</div>
							</div>
						</div>
						<div class="row-fluid" style="margin-left: 0%;">
							<thead>
								<tr>
									<th style="text-align:left;"><br><b>Nombre Completo</b></th>
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover">
									<tbody>
										<?php
										$contador=0;
										$comilla= "'";
										echo '<form id="formDetalle" type="post">';
										while ($contador<count($rs_profesores)){
										echo '<tr>';
										echo	'<td  id="'.$contador.'" onclick="datosEditarProfesor('.$comilla.$rs_profesores[$contador][0].$comilla.','.$comilla. $rs_profesores[$contador][1].$comilla.','.$comilla. $rs_profesores[$contador][2].$comilla.','.$comilla. $rs_profesores[$contador][3].$comilla.','.$comilla. $rs_profesores[$contador][4].$comilla.','.$comilla. $rs_profesores[$contador][5].$comilla.','. $comilla.$rs_profesores[$contador][6].$comilla.')" 
										style="text-align:center;">
										'. $rs_profesores[$contador][3].' '.$rs_profesores[$contador][4].' ' . $rs_profesores[$contador][1].' '.$rs_profesores[$contador][2].'</td>';
										echo '</tr>';
										$contador = $contador + 1;
										}
										echo '</form>';
										?>
									</tbody> 
								</table>
							</div>
						</div>
					</div>
					<div class="span6">
						<div style="margin-bottom:2%">
							Complete los datos del formulario para modificar el profesor
						</div>
						<form id="FormEditar" type="post" onsubmit="EditarProfesor()">
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">1-.<font color="red">*</font>RUT:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="runProfeEdit" name="run_profe" readonly>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">2-.<font color="red">*</font>Nombre completo:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="nombreProfeEdit" name="nombre_profe" required>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Apellido Paterno:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="apellidoPaternoProfeEdit" name="apellidoPaterno_profe" required>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Apellido Materno:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="apellidoMaternoProfeEdit" name="apellidoMaterno_profe" required>
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
		    							<input type="email" placeholder="ejemplo@usach.cl" id="correoEditar" name="correo_estudiante" maxlength="19" required>
		  							</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">6-.<font color="red">*</font>Telefono</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="telefonoProfeEdit" name="telefono_profe">
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">7-.<font color="red">*</font>Modulo:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="moduloProfeEdit" name="modulo_profe">
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">8-.<font color="red">*</font>Tipo:</label>
									</div>
								</div>
								<div class="span5">	
									<div class="controls">
										<input type="text" id="tipoProfeEdit" name="tipo_profe">
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<div class="control-group">
										<label class="control-label" for="inputInfo">9-.<font color="red">*</font>Asignar sección:</label>
									</div>
								</div>
								<div class="span5">	
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
											<button class="btn" type="submit">Modificar</button>
										</div>
										<div class="span3">
											<button  class ="btn" type="reset" <?php $comilla= "'"; echo 'onclick="datosEditarProfesor('.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.','.$comilla.$comilla.')"';?> >Cancelar</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
