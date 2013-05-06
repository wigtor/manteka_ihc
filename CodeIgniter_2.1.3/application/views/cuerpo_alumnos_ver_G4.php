
<script type="text/javascript">
	function hacerSubmitDetalleAlumno(rut_estudiante){
		var detalle = document.getElementById("formDetalle");
		detalle.action = "<?php echo site_url("Alumnos/VerPorBoton/") ?>/"+rut_estudiante;
		detalle.submit();
		
	}
</script>

<script type="text/javascript">
	function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera){
		
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


<fieldset>
	<legend>Ver Alumnos</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado Alumnos
			<div class="span12"></div>
			
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
			
			<div class="row-fluid" style="margin-left: 0%;">
			<div class="span9">
			
					<thead>
						<tr>
							<th style="text-align:left;"><br><b>Nombre Completo</b></th>
							
						</tr>
					</thead>
					<div style="border:grey 1px solid;overflow-y:scroll;height:400px" >
					<table class="table table-hover">
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
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle Alumnos:
	    <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombre uno:       <b id="nombreunoDetalle"></b>
Nombre dos:       <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>

		</div>
	</div>
</fieldset>
