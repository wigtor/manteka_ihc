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
		
					var borrar = document.getElementById("FormBorrar");
					borrar.action ="<?php echo site_url("Alumnos/eliminarAlumno/");?>"
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
		<form id="FormBorrar" type="post" onsubmit="eliminarAlumno()"  >
		<fieldset>
			<legend>Borrar Alumno</legend>
			<div class= "row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							1.-Listado Alumnos
						</div>
					</div>
				<div class="row-fluid">
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
						

							<div class="span6">
									
									<select id="tipoDeFiltro" title="Tipo de filtro" >
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Código Carrera</option>
									<option value="6">Filtrar por Seccion</option>
									</select>
							</div> 
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
										
										while ($contador<count($rs_estudiantes)){
											
											echo '<tr>';
											echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
														  style="text-align:left;">
														  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
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
					<div style="margin-bottom:0%">
							2.-Detalle del Alumno:
					</div>
					<div class="row-fluid">
						<div >
						<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
<input name="rut_estudiante" type="hidden" id="rutEliminar" value="">
								
						</div>
					</div>
					<div class="row" style="margin-top: 2%">
	
							<div class="span3 offset6">
								<button class="btn" type="submit" style="width: 93px">
									<div class= "btn_with_icon_solo">b</div>
									&nbsp Borrar
								</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" type="reset" style="width: 105px">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>

					</div>
					
				</div>	
			</div>

			
		</fieldset>
		</form>
	</div>
</div>
