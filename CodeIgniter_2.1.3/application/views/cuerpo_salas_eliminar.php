<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1"){
				alert("Sala eliminada correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	function DetalleSala(cod_sala,num_sala,ubicacion,capacidad){
	
			document.getElementById("codEliminar").value = cod_sala;
			document.getElementById("cod_sala").innerHTML = cod_sala;
			document.getElementById("num_sala").innerHTML = num_sala;
			document.getElementById("capacidad").innerHTML = capacidad;
			document.getElementById("ubicacion").innerHTML = ubicacion;
			
			var imp= new Array();	
			<?php
				$contadorE = 0;
				while($contadorE<count($salaImplemento)){
					echo 'imp['.$contadorE.']=new Array();';
					echo 'imp['.$contadorE.'][0]= "'.$salaImplemento[$contadorE][0].'";';//sala
					echo 'imp['.$contadorE.'][1]= "'.$salaImplemento[$contadorE][2].'";';//nombre
					echo 'imp['.$contadorE.'][2]= "'.$salaImplemento[$contadorE][3].'";';//descripcion	
					$contadorE = $contadorE + 1;
				}
			?>
			var cont;
			var algo='';
			for(cont=0;cont < imp.length;cont++){
				if(imp[cont][0]==cod_sala){
					if(algo!=''){
						algo= algo+"\n"+"		"+imp[cont][1];
					}
					else {
						algo=imp[cont][1];
					}
				}
			}
			
			document.getElementById("impDetalle").innerHTML=algo; 	
			
	}
</script>
<script type="text/javascript">
	function eliminarSala(){
		
		var cod = document.getElementById("codEliminar").value;
		
		if(cod!=""){
					var answer = confirm("¿Está seguro de eliminar esta sala?")
					if (!answer){
						var dijoNO = DetalleSala("","","","","","","");
					}
					else{
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Salas/borrarSalas/") ?>/";
					borrar.submit();
					}
					
		}
		else{
				alert("Selecione una sala");
		}
		
	}
</script>
						
<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var sala;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($sala)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$sala[$contadorE][1].'";';
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

<div class="row-fluid">
<div class="span10">
<fieldset>
	<legend>Eliminar Sala</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado sala
				</div>
			</div>
			<div class="row-fluid">
				<div class="span11">
					<div class="row-fluid">	
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Número</option>
									</select>
								</div> 
							</div>
						</div>
						
				</div>
			</div>
			<div class="row-fluid" style="margin-left: 0%;">
				<!--<div class="span9">-->

					<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
							<tbody>
							
								<?php
								$contador=0;
								$comilla= "'";
								echo '<form id="formDetalle" type="post">';
								while ($contador<count($sala)){
									
									echo '<tr>';
									echo	'<td  id="'.$contador.'" onclick="DetalleSala('.$comilla.$sala[$contador][0].$comilla.','.$comilla. $sala[$contador][1].$comilla.','.$comilla. $sala[$contador][2].$comilla.','.$comilla. $sala[$contador][3].$comilla.')" 
												  style="text-align:left;">
												  '. $sala[$contador][1].'</td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								echo '</form>';
								?>
														
							</tbody>
						</table>
					</div>
				
			
				<!--</div>-->
			</div>
		</div>
		<div class="span6">
			<div style="margin-bottom:2%">
		2.-Detalle de la Sala:
		</div>
	   <form id="formBorrar" type="post" method="post" >
			<div class="row-fluid">
				<div>
			<pre style="margin-top: 0%; margin-left: 0%;">
Número sala:    <b id="num_sala"></b>
Capacidad:      <b id="capacidad" ></b>
Ubicación:      <b id="ubicacion"></b>
Implementos:    <b id="impDetalle"></b>
</pre>
<input id="cod_sala" type="text" name="cod_sala" value="" style="display:none">
<input id="codEliminar" type="text" name="codEliminar" value="" style="display:none">
				</div>		
			</div>
					<div class="row-fluid" style="margin-top: 4%; margin-left:49%">
		
							<button class ="btn" onclick="eliminarSala()" >
								<div class="btn_with_icon_solo">Ë</div>
								&nbsp Eliminar
							</button>
							<button class ="btn" type="reset" onclick="DetalleSala('','','','','','')"  >
								<div class="btn_with_icon_solo">Â</div>
								&nbsp Cancelar
							</button>
					</div>
								
		</form>
		</div>

	</div>
</fieldset>
</div>
</div>