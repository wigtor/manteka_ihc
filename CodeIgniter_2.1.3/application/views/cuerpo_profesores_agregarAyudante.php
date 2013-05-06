<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el ayudante");
				}
				else{
					alert("Error al agregar");
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
	while($contadorE<count($profesores)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][0] = "'.$profesores[$contadorE][0].'";';//rut
		echo 'arreglo['.$contadorE.'][1] = "'.$profesores[$contadorE][1].'";';//nombre
		echo 'arreglo['.$contadorE.'][2] = "'.$profesores[$contadorE][2].'";';//apellido
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarTd=document.getElementById("profesoresTd_"+cont);
		ocultar =document.getElementById(arreglo[cont][0]);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultar.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>

<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
		<form id="formAgregar" type="post" action="<?php echo site_url("Ayudantes/insertarAyudante/")?>">
			<legend>Agregar Ayudante</legend>
			<div class= "row-fluid">
					<div class= "span6" style="margin-bottom:2%">
						Complete los datos del formulario para ingresar un ayudante
					</div>
			</div>
			<div class="row_fluid" style="margin-left:2%">
				<div class="span6">
					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.*Nombre uno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre1_ayudante">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">1-.*Nombre dos:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre2_ayudante">
		  							</div>
							</div>
					</div>
					
					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.*Apellido Paterno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido_paterno">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.*Apellido Materno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido_materno">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.*RUN:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="rut_ayudante">
		  							</div>
							</div>
					</div>

					<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5-.*Correo:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="correo_ayudante">
		  							</div>
							</div>
					</div>

				</div>
				<div class="span6">
					<div class="row">
						<div class="row"> <!-- seccion-->
							<div class="span5">
								<div class="control-group">
									<label class="control-label" for="inputInfo">7-.*Asignar profesor</label>
								</div>
							</div>
							<div  class="span6" >	
								<fieldset>
									<div class="span12">					
										<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">

											<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
											<option value="1">Filtrar por Nombre</option>
											<option value="2">Filtrar por Apellido paterno</option>
											<option value="0">Filtrar por RUT</option>
											</select> 
										
									
									</div>
								</fieldset>
								<div style="border:grey 1px solid;overflow-y:scroll;height:200px" >
								
								
									<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										while ($contador<count($profesores)){
											echo '<tr>';
											echo '<td id="profesoresTd_'.$contador.'" ><input id="'.$profesores[$contador][0].'" value="'.$profesores[$contador][0].'" name="cod_profesores" type="radio" >'.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row" style="width: 845px;">		
						<div class="span2" style="margin-left: 654px;">
								<input type="submit" value="Agregar">
							</div>
							<div class="span1" style="margin-left: -32px;">
								<button class="btn" type="reset">Cancelar</button>
							</div>
			</div>
		</form>				
		</fieldset>
	</div>
</div>