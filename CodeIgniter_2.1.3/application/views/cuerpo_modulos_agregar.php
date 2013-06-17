<?php
	if($mensaje_confirmacion != 2)	{
		if($mensaje_confirmacion==-1){
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
   			 <h4>Error</h4>
				 Error al agregar el módulo
    		</div>		

		<?php
		}
		else if($mensaje_confirmacion==1)
		{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Listo</h4>	 
				 Módulo agregado correctamente
    		</div>		

		<?php
 		}
 
}
?>


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
	
	var limpiarControlGroupRut = document.getElementById("groupNombreMod");
	$(limpiarControlGroupRut).removeClass("error") ;
	var spanError = document.getElementById("spanInputNombreModError");
	$(spanError).empty();
	
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
				var controlGroupRut = document.getElementById("groupNombreMod");
				$(controlGroupRut).addClass("error");
				var spanError = document.getElementById("spanInputNombreModError");
				$(spanError).html("El nombre ya está en uso, intente otro.");

				
				nombre_tentativo.value="";
				return;
		}

    }

}
	function validarMod(){
		var sesion = document.getElementsByName("cod_sesion[]");
		var equipo = document.getElementsByName("cod_profesor_equipo[]");
		var cont;
		var numS = 0;
		var numE = 0;
		for(cont=0;cont < sesion.length;cont++){
			if(sesion[cont].checked == true){
				numS = numS + 1;
			}
		}
		if(numS == 0){
			alert("Debe escoger por lo menos una sesión");
			return false;
		}
		for(cont=0;cont < equipo.length;cont++){
			if(equipo[cont].checked == true){
				numE = numE + 1;
			}
		}
		if(numE == 0){
			alert("Debe escoger por lo menos un equipo");
			return false;
		}
		
		var agregar = document.getElementById("formAgregar");
		agregar.action ="<?php echo site_url("Modulos/HacerAgregarModulo/")?>";
		agregar.submit();
}

</script>

<div class="row-fluid">
	<div class="span10">
		<fieldset>
			<legend>Agregar Módulos</legend>

			<form id="formAgregar" type="post" method="post" onsubmit="validarMod();return false">
			<div class="row-fluid">
				<div class="span6">
					<font color="red">*Campos Obligatorios</font>
				</div>
			</div>	
	  		<div class="row-fluid">
				<div class="span6">
					
					
					<div class="row-fluid"> <!-- nombre modulo-->
						<div class="span12">
								<div class="span4">
									<div class="control-group">
										<label  class="control-label" for="inputInfo">1-.<font color="red">*</font>Nombre Módulo</label>
									</div>
								</div>
								<div class="span7">	
									<div class="control-group" id="groupNombreMod">											
											<input id="nombre_modulo_in" required type="text" name="nombre_modulo" maxlength="49"  placeholder="Comunicación no verbal" onblur="nombreEnUso()">
											<span id="spanInputNombreModError" class="help-inline"></span>
									</div>
								</div>
						</div>
					</div>

					
					<div class="row-fluid" style="margin-top:7%">
						<div class= "row-fluid">
							<div class="span10" style="margin-top:2%">
								<div class="control-group">
									<label  class="control-label" for="inputInfo">2-.Agregar Sesiones Existentes</label>
								</div>
							</div>
						</div>
						<div class= "row-fluid">
							<div class="span11">
										<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
										<!--sesiones-->					
										<table class="table table-hover">
										<thead>

										</thead>
											<tbody>									
							
					
											<?php
											$contador=0;
											while ($contador<count($sesiones)){
												
													echo '<tr>';
													echo '<td id="sesion_'.$sesiones[$contador][0].'" title="'.$sesiones[$contador][2].'"><input value="'.$sesiones[$contador][0].'" name="cod_sesion[]" type="checkbox" ></input> '.$sesiones[$contador][3].'</td>';
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
								<div class="span7">
									<div class="control-group">
										<label  class="control-label" for="inputInfo">3-.<font color="red">*</font>Ingrese una descripción del módulo</label>
									</div>
								</div>
								

						</div>
						<div class="span12">		
								<div class="controls">
										<textarea required name="descripcion_modulo"  style ="margin-left:0%; width: 86%; "maxlength="99" rows="5" cols="100"></textarea>
								</div>
						</div>
						
					</div>
					
										
					<div class="row-fluid" >
						<div class= "row-fluid">
							<div class="span10" style="margin-top:2%">
								<div class="control-group">
									<label  class="control-label" for="inputInfo">4-.Agregar Requisitos Existentes</label>
								</div>
							</div>
						</div>
						<div class= "row-fluid">
							<div class="span11">
										<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
														
										<table class="table table-hover">
										<thead>

										</thead>
											<tbody>									
							
					
											<?php
											$contador=0;
											while ($contador<count($requisitos)){
												
													echo '<tr>';
													echo '<td id="requisito_'.$requisitos[$contador][0].'" title="'.$requisitos[$contador][2].'"><input value="'.$requisitos[$contador][0].'" name="cod_requisito[]" type="checkbox" > '.$requisitos[$contador][1].'</td>';
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
		
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
			<!--profesor lider-->
			<div class="row-fluid"> 
				<div class="span5">
					<div class="control-group">
						<label class="control-label" for="inputInfo">5-.<font color="red">*</font>Asignar profesor lider</label>
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
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
					
					
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
					
							<?php
							$contador=0;
							$comilla= "'";
							while ($contador<count($profesores)){
								echo '<tr>';
								echo '<td id="1profesores_'.$contador.'" ><input required  onclick="sacarDelEquipo('.$comilla.$contador.$comilla.')" value="'.$profesores[$contador][0].'" name="cod_profesor_lider" type="radio" ></input> '.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
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
						<label class="control-label" for="inputInfo">6-.<font color="red">*</font>Asignar equipo profesores</label>
					</div>
				</div>
				<div  class="span6" style="margin-top:6%" >	
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
					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
					
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
					
							<?php
							$contador=0;
							while ($contador<count($profesores)){
								echo '<tr>';
								echo '<td id="2profesores_'.$contador.'" ><input  id="cb_2profesores_'.$contador.'"  value="'.$profesores[$contador][0].'" name="cod_profesor_equipo[]" type="checkbox" ></input> '.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
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
			<div class="row-fluid" style="margin-top: 5%">
	
				<div class= "span4" style="margin-left:43%">
					<button class ="btn" type="submit" style="width: 102px" >
						<div class="btn_with_icon_solo">Ã</div>
						&nbsp Agregar
					</button>
				</div>
				<div class= "span3" style="margin-left:0%">
					<button class ="btn" type="reset" style="width:105px">
						<div class="btn_with_icon_solo">Â</div>
						&nbsp Cancelar
					</button>
				</div>
			</div>
			
		</div>
	  </div>

	</form>
	</fieldset>
	</div>
</div>