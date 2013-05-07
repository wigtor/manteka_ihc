

<script type="text/javascript">
	function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo){
		
			document.getElementById("rutDetalle").innerHTML = rut;
			document.getElementById("nombreunoDetalle").innerHTML = nombre1;
			document.getElementById("nombredosDetalle").innerHTML = nombre2;
			document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
			document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
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
	while($contadorE<count($rs_ayudantes)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_ayudantes[$contadorE][1].'";';
		echo 'arreglo['.$contadorE.'][3] = "'.$rs_ayudantes[$contadorE][3].'";';
		echo 'arreglo['.$contadorE.'][4] = "'.$rs_ayudantes[$contadorE][4].'";';
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

<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
				<legend>Ver Ayudante</legend>
			<div>
				<div class="row-fluid">
					<div class="span6">
						<div style="margin-bottom:2%">
							1.-Listado coordinadores:
						</div>
						<div class="row-fluid">
							<fieldset>
								<div class="span10">
								<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">

									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									</select> 
								</div>
							</fieldset>
						</div>
						<div class="flow_fluid">
						
							<div class="span9">
							
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
										while ($contador<count($rs_ayudantes)){
											
											echo '<tr>';
											echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_ayudantes[$contador][0].$comilla.','.$comilla. $rs_ayudantes[$contador][1].$comilla.','.$comilla. $rs_ayudantes[$contador][2].$comilla.','.$comilla. $rs_ayudantes[$contador][3].$comilla.','.$comilla. $rs_ayudantes[$contador][4].$comilla.','.$comilla. $rs_ayudantes[$contador][5].$comilla.')" 
														  style="text-align:left;">
														  '. $rs_ayudantes[$contador][3].' '.$rs_ayudantes[$contador][4].' ' . $rs_ayudantes[$contador][1].' '.$rs_ayudantes[$contador][2].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}
										echo '</form>';
										?>
																
									</tbody>
									</table>
									</div><!-- div de estilo mio que pasa jiles-->
								
							
							</div>
						
						
						
						</div>	

					</div>
					<div class="span6">
	
<div class="span12" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle Coordinador:
	    <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Correo:           <b id="correoDetalle"></b>
</pre>
</div>
					</div>
				</div>
			</div>			
		</fieldset>
	</div>
</div>