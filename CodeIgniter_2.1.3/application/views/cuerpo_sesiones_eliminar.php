<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1"){
				alert("Sesion eliminada correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	function DetalleSesion(cod_sesion,cod_modulo_tem,fecha_sesion,descripcion_sesion){
	
			document.getElementById("codEliminar").value = cod_sesion;
			document.getElementById("cod_sesion").innerHTML = cod_sesion;
			document.getElementById("cod_modulo_tem").innerHTML = cod_modulo_tem;
			document.getElementById("fecha_sesion").innerHTML = fecha_sesion;
			document.getElementById("descripcion_sesion").innerHTML = descripcion_sesion;			
				
			
	}
</script>
<script type="text/javascript">
	function eliminarSala(){
		
		var cod = document.getElementById("codEliminar").value;
		
		if(cod!=""){
					var answer = confirm("¿Está seguro de eliminar esta sesion?")
					if (!answer){
						var dijoNO = DetalleSala("","","","","","","");
					}
					else{
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Sesion/elimin/") ?>/";
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
	var sesion;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($sesion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$sesion[$contadorE][1].'";';
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
	<legend>Eliminar Sesion</legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado sesiones
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
									<option value="1">Filtrar por Codigo</option>
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
								$com= "'";
								echo '<form id="formDetalle" type="post">';
								while ($contador<count($sesion)){
									
									echo '<tr>';
									echo	'<td  id="'.$contador.'" onclick="DetalleSesion('.$com.$sesion[$contador][0].$com.','.$com. $sesion[$contador][1].$com.','.$com. $sala[$contador][2].$com.','.$com. $sesion[$contador][3].$com.')" 
												  style="text-align:left;">
												  '. $sesion[$contador][1].'</td>';
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
		2.-Detalle de la Sesión:
		</div>
	   <form id="formBorrar" type="post" method="post" >
			<div class="row-fluid">
				<div>
			<pre style="margin-top: 0%; margin-left: 0%;">
Código sesión:    <b id="cod_sesion"></b>
Código del modulo tematico:    <b id="num_modulo_tem"></b> 
Fecha de la sesión: 	<b id="fecha_sesion"></b>
Descripcion de la sesión:	<b id="descripcion_sesion"></b>
<input id="codEliminar" type="text" name="codEliminar" value="" style="display:none">
				</div>		
			</div>
								<div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" onclick="eliminarSesion()" >Eliminar</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" onclick="DetalleSesion('','','','','','')" >Cancelar</button>
									</div>
								</div>
		</form>
		</div>

	</div>
</fieldset>
</div>
</div>