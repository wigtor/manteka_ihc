<script type="text/javascript">
	function DetalleProfesor(rut,nombre1,nombre2,apePaterno,apeMaterno,telefono,tipo){
		
			document.getElementById("rutDetalle").innerHTML = rut;
			document.getElementById("nombreunoDetalle").innerHTML = nombre1;
			document.getElementById("nombredosDetalle").innerHTML = nombre2;
			document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
			document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
			document.getElementById("telefonoDetalle").innerHTML = telefono;
		    document.getElementById("tipoDetalle").innerHTML = tipo;
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






<fieldset>
	<legend>Ver Profesor</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado Profesores
				</div>
			</div>

			<div class="row-fluid">
				
					<div class="span11">
						<div class="row-fluid">
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
				
			</div>
			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span11">
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
							echo	'<td  id="'.$contador.'" onclick="DetalleProfesor('.$comilla.$rs_profesores[$contador][0].$comilla.','.$comilla. $rs_profesores[$contador][1].$comilla.','.$comilla. $rs_profesores[$contador][2].$comilla.','.$comilla. $rs_profesores[$contador][3].$comilla.','.$comilla. $rs_profesores[$contador][4].$comilla.','.$comilla. $rs_profesores[$contador][5].$comilla.','. $comilla.$rs_profesores[$contador][6].$comilla.')" 
										  style="text-align:left;">
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
		</div>

		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle Profesor:
	    <pre style="margin-top: 2%; padding: 2%">
 Rut: 				<b id="rutDetalle"></b>
 Nombres:			<b id="nombreunoDetalle"></b> <b id="nombredosDetalle"></b>
 Apellido Paterno: 		<b id="apellidopaternoDetalle" ></b>
 Apellido Materno: 		<b id="apellidomaternoDetalle" ></b>
 Correo:           	<b id="mailDetalle" ></b>
 Telefono: 			<b id="telefonoDetalle" ></b>
 Tipo: 				<b id="tipoDetalle"></b></pre>

		</div>
	</div>
</fieldset>