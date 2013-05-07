<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Ayudante eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo){
			
			document.getElementById("rutEliminar").value = rut;
			document.getElementById("rutDetalle").innerHTML = rut;
			document.getElementById("nombreunoDetalle").innerHTML = nombre1;
			document.getElementById("nombredosDetalle").innerHTML = nombre2;
			document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
			document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
			document.getElementById("correoDetalle").innerHTML = correo;
		
	}
</script>

<script type="text/javascript">
	function eliminarAyudante(){

		
		
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este ayudante?")
					if (!answer){
						var dijoNO = DetalleAlumno("","","","","","");
					}
					else{
		
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Ayudantes/EliminarAyudante/") ?>/"+rut;
					borrar.submit();
					}
		}
		else{
				alert("Selecione un ayudante");
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


<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Borrar Ayudante</legend>
			<div class= "row-fluid">
					
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							1.-Listado Ayudantes
						</div>
					</div>
				<div class="row-fluid">
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
						

							<div class="span6">
									
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="0">Filtrar por Carrera</option>
									</select>
							</div> 
						</div>
					</div>
				</div>
				
			
					<div class="row-fluid" style="margin-left: 0%;">
						
							<thead>
								<tr>
									<th style="text-align:left;">Nombre Completo</th>
									
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
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
							</div>

					</div>
				</div>
			

				<div class="span6">
					<div style="margin-bottom:0%">
							2.-Detalle del Ayudante:
					</div>
					<form id="formBorrar" type="post">
					<div class="row-fluid">
						<div >
						<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
				  <input type="hidden" id="rutEliminar" value="">
								
						</div>
					</div>
					<div class= "row-fluid" >
						<div class="row-fluid" style=" margin-top:10px; margin-left:54%">		
							<div class="span3 ">
								<button class="btn" onclick="eliminarAyudante()" >Eliminar</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" type="reset" onclick="DetalleAlumno('','','','','','')" >Cancelar</button>
							</div>
						</div>
					</div>
					</form>
				</div>	
			</div>

			
		</fieldset>
	</div>
</div>
