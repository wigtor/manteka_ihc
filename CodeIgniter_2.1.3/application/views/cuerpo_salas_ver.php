<script type="text/javascript">
	function DetalleSala(cod_sala,num_sala,ubicacion,capacidad){
		
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
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;

	
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
		if(0 > arreglo[cont][1].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
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
	<legend>Ver Sala</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="controls controls-row">
			    <div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
					<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
			
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			1.-Listado sala
		</div>
		<div class="span6">
			2.-Detalle de la Sala:
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:330px; -webkit-border-radius: 4px" ><!--  para el scroll-->
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
		<div class="span6" style="padding: 0%; ">
	  <pre style="margin-top: 0%; margin-left: 0%;">
Número sala:    <b id="num_sala"></b>
Capacidad:      <b id="capacidad" ></b>
Ubicación:      <b id="ubicacion"></b>
Implementos:    <b id="impDetalle"></b></pre>

		</div>

	</div>
			
			
		
		
</fieldset>
</div>
</div>