<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion_borrar;?>"!="2"){
		if("<?php echo $mensaje_confirmacion_borrar;?>"!="-1"){
				alert("Alumno eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera){
			
			document.getElementById("rutEliminar").value = rut;
			document.getElementById("rutDetalle").innerHTML = rut;
			document.getElementById("nombreunoDetalle").innerHTML = nombre1;
			document.getElementById("nombredosDetalle").innerHTML = nombre2;
			document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
			document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
			document.getElementById("carreraDetalle").innerHTML = carrera;
		    document.getElementById("seccionDetalle").innerHTML = seccion;
			document.getElementById("correoDetalle").innerHTML = correo;
		
	}
</script>

<script type="text/javascript">
	function eliminarAlumno(){

		
		
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este estudiante?")
					if (!answer){
						var dijoNO = DetalleAlumno("","","","","","","","");
					}
					else{
		
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Alumnos/EliminarAlumno/") ?>/"+rut;
					borrar.submit();
					}
		}
		else{
				alert("Selecione un estudiante");
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
		alumno = document.getElementById(cont);
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


<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Borrar Alumno</legend>
			
				<div class= "row-fluid">
					
		<div class="span6">
			1.-Listado Alumnos
			<div class="span12"></div>
			
				<fieldset>
					<div class="span10">
					<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">
						<!--div class="btn-group" style="float: right;">
						  <a class="btn ">Filtrar por:</a>
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						  <ul id="tipoDeFiltro" class="dropdown-menu">
						    <li><a value="Primer nombre val">Primer nombre</a></li>
						  </ul>
						</div-->
						<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
						<option value="1">Filtrar por Nombre</option>
						<option value="3">Filtrar por Apellido paterno</option>
						<option value="4">Filtrar por Apellido materno</option>
						<option value="7">Filtrar por Carrera</option>
						<option value="6">Filtrar por Seccion</option>
						</select> 
					</div>
				</fieldset>
			
			<div class="row-fluid" style="margin-left: 0%;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="text-align:left;">Nombre Completo</th>
							
						</tr>
					</thead>
					<tbody>
					
						<?php
						$contador=0;
						$comilla= "'";
						echo '<form id="formDetalle" type="post">';
						while ($contador<count($rs_estudiantes)){
							
							echo '<tr>';
							echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
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


					<div class="span6">
						<div style="margin-bottom:0%">
							2.-Detalle del Alumno:
						</div>
						<form id="formBorrar" type="post">
							<div class="row-fluid">
								<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombre uno:       <b id="nombreunoDetalle"></b>
Nombre dos:       <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
								<input type="hidden" id="rutEliminar" value="">
								
							</div>
							<div class= "row-fluid" >
								<div class="row" style="width: 1052px; margin-top:10px">		
									<div class="span2" style="margin-left: 250px;">
										<button class="btn" onclick="eliminarAlumno()" >Eliminar</button>
									</div>

									<div class = "span2 ">
										<button  class ="btn" type="reset" onclick="DetalleAlumno('','','','','','','','')" >Cancelar</button>

									</div>
								</div>
							</div>
						</form>
					</div>	
				</div>

			
	

			
		</fieldset>
	</div>
	</div>
</div>