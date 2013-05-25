<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el modulo");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}
</script>



<script type="text/javascript">
function ordenarFiltro(numeroLista){
	var filtroLista = document.getElementById(numeroLista+"filtroLista").value;
	var tipoDeFiltro = document.getElementById(numeroLista+"tipoDeFiltro").value;

	
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
		ocultarTd=document.getElementById(numeroLista+"profesores_"+cont);
		//ocultar =document.getElementById(arreglo[cont][0]);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			//ocultar.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			//ocultar.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>


<script type="text/javascript">
function sacarDelEquipo(contadorProfe){
	
	var numero_profesores =	<?php echo count($profesores);?>;
	var cont = 0;
	
	for(cont=0;cont < numero_profesores;cont++){	
		document.getElementById("2profesores_"+cont).style.display='';
	}
	document.getElementById("2profesores_"+contadorProfe).style.display='none';
	document.getElementById("cb_2profesores_"+contadorProfe).checked=false;
}
</script>

<script type="text/javascript">
function nombreEnUso(){
	nombre_tentativo = document.getElementById("nombre_modulo_in");
	
	var arreglo = new Array();
	var cont = 0;
	<?php
	$contadorE = 0;
	while($contadorE<count($nombre_modulos)){
		echo 'arreglo['.$contadorE.'] = "'.$nombre_modulos[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	for(cont=0;cont < arreglo.length;cont++){
		if(arreglo[cont].toLowerCase () == nombre_tentativo.value.toLowerCase ()){
				alert("Nombre en uso. Use otro nombre");
				nombre_tentativo.value="";
				return;
		}

    }

}
</script>

<div class="row-fluid">
	<div class="span10">
		<fieldset>
			<legend>Agregar Módulos</legend>

			<form id="formAgregar" type="post" action="<?php echo site_url("Ayudantes/HacerAgregarModulo/")?>">
	  		<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							<font color="red">*Campos Obligatorios</font>
						</div>
					</div>
					
					<div class="row-fluid"> <!-- nombre modulo-->
						<div class="span12">
								<div class="span4">
									<div class="control-group">
										<label  class="control-label" for="inputInfo">1-.<font color="red">*</font>Nombre Módulo</label>
									</div>
								</div>
								<div class="span7">	
										<div class="controls">
											<input id="nombre_modulo_in" required type="text" name="nombre_modulo" maxlength="19"  placeholder="Ejemplo Modulo Historia" onblur="nombreEnUso()">
										</div>
								</div>
						</div>
					</div>

					
					<div class="row-fluid" style="margin-top:9%">
						<div class= "row-fluid">
							<div class="span10" style="margin-top:2%">
								<div class="control-group">
									<label  class="control-label" for="inputInfo">2-.Agregar Sesiones Existentes</label>
								</div>
							</div>
						</div>
						<div class= "row-fluid">
							<div class="span11">
										<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
										<!--sesiones-->					
										<table class="table table-hover">
										<thead>

										</thead>
											<tbody>									
					
											<?php
											$contador=0;
											while ($contador<count($sesiones)){
												
													echo '<tr>';
													echo '<td id="sesion_'.$sesiones[$contador][0].'" title="'.$sesiones[$contador][2].'"><input required  value="'.$sesiones[$contador][0].'" name="cod_sesion[]" type="checkbox" > '.$sesiones[$contador][0].'</td>';
													echo '</tr>';
												$contador = $contador + 1;
											}
											?>
											</tbody>
										</table>

			
										<!---->

								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row-fluid"> <!-- descripción modulo-->
						<div class="span12">
								<div class="span4">
									<div class="control-group">
										<label  class="control-label" for="inputInfo">2-.<font color="red">*</font>Ingrese una descripción del modulo</label>
									</div>
								</div>
								

						</div>
						<div class="span12">		
								<div class="controls">
										<textarea required name="descripcion_modulo" maxlength="99" rows="5" cols="100"></textarea>
								</div>
						</div>
						
					</div>


				
			
		</div>
		
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
			<!--profesor lider-->
			<div class="row-fluid"> 
				<div class="span5">
					<div class="control-group">
						<label class="control-label" for="inputInfo">3-.<font color="red">*</font>Asignar profesor lider</label>
					</div>
				</div>
				<div  class="span6" >	
					<fieldset>
						<div class="span12">					
							<input id="1filtroLista"  onkeyup="ordenarFiltro('1')" type="text" placeholder="Filtro búsqueda">

								<select id="1tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
								<option value="1">Filtrar por Nombre</option>
								<option value="2">Filtrar por Apellido paterno</option>
								<option value="0">Filtrar por RUT</option>
								</select> 
							
						
						</div>
					</fieldset>
				</div>
			</div>

			<div class="row-fluid" style="margin-top:2%">
				<div class="span7 offset5">
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
					
					
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
					
							<?php
							$contador=0;
							$comilla= "'";
							while ($contador<count($profesores)){
								echo '<tr>';
								echo '<td id="1profesores_'.$contador.'" ><input required  onclick="sacarDelEquipo('.$comilla.$contador.$comilla.')" value="'.$profesores[$contador][0].'" name="cod_profesor_lider" type="radio" > '.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
								echo '</tr>';
								$contador = $contador + 1;
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!---->
			<br>
			<!--equipo profesores-->
			<div class="row-fluid"> 
				<div class="span5">
					<div class="control-group">
						<label class="control-label" for="inputInfo">4-.<font color="red">*</font>Asignar equipo profesores</label>
					</div>
				</div>
				<div  class="span6" >	
					<fieldset>
						<div class="span12">					
							<input id="2filtroLista"  onkeyup="ordenarFiltro('2')" type="text" placeholder="Filtro búsqueda">

								<select id="2tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
								<option value="1">Filtrar por Nombre</option>
								<option value="2">Filtrar por Apellido paterno</option>
								<option value="0">Filtrar por RUT</option>
								</select> 
						</div>
					</fieldset>
				</div>
			</div>

			<div class="row-fluid" style="margin-top:2%">
				<div class="span7 offset5">
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
					
					
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
					
							<?php
							$contador=0;
							while ($contador<count($profesores)){
								echo '<tr>';
								echo '<td id="2profesores_'.$contador.'" ><input required  id="cb_2profesores_'.$contador.'"  value="'.$profesores[$contador][0].'" name="cod_profesor_equipo[]" type="checkbox" > '.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
								echo '</tr>';
								$contador = $contador + 1;
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!---->
			<div class="row-fluid" style="margin-top: 2%">
	
				<div class= "span4" style="margin-left:4%">
					<button class ="btn" type="submit" >Crear Módulo</button>
				</div>
				<div class= "span3" style="margin-left:0%">
					<button class ="btn" type="reset" >Cancelar</button>
				</div>
			</div>
			
		</div>
	  </div>

	</form>
	</fieldset>
	</div>
</div>