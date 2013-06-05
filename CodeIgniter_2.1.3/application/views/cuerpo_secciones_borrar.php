<script type="text/javascript">
	
	if("<?php echo $mensaje_confirmacion;?>"!="2"){
		if("<?php echo $mensaje_confirmacion;?>"!="-1"){
			if("<?php echo $mensaje_confirmacion;?>"!="3"){
				alert("Sección eliminada correctamente");
			}
			else{alert("Sección con alumnos,no se puede eliminar");}	
		}
		else{
			alert("Error al eliminar");
		}
	
	}
</script>

<script type="text/javascript">
	function DetalleSeccion(cod_seccion){
			document.getElementById("rs_seccion").value = '';
			document.getElementById("cod_seccion").value = cod_seccion;
			var borrar = document.getElementById("formDetalle");
			borrar.action = "<?php echo site_url("Secciones/borrarSecciones/") ?>/";
			borrar.submit();
			
	}
</script>

<script type="text/javascript">
	function eliminarSeccion(){
		var cod=document.getElementById("rs_seccion").value;
		
		if(cod!=""){ 
					var answer = confirm("¿Está seguro de eliminar esta sección?")
					if (!answer){
						var dijoNO = DetalleSeccion("");
					}
					else{
					var borrar = document.getElementById("formBorrar");
					borrar.action = "<?php echo site_url("Secciones/borrarSecciones/") ?>/";
					borrar.submit();
					}
					
		}
		else{
				alert("Selecione una sección");
		}
		
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
	var arreglo = new Array();
	var seccion;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($seccion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$seccion[$contadorE][1].'";';
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
    <div class= "span11">
        <fieldset> 
		<form id="formDetalle" type="post" method="post">
		<legend>Borrar Sección</legend>
            
           
            
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span6">
                            1.-Seleccionar sección
                        </div>
					</div>
						<div class="row-fluid">	
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									</select>
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
								
								while ($contador<count($seccion)){
									
									echo '<tr>';
									echo '<td  id="rs_seccionTd_'.$contador.'"   onclick="DetalleSeccion('.$comilla.$seccion[$contador][0].$comilla.')"> '.$seccion[$contador][1].' </td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								
								?>
														
							</tbody>
						</table>
					</div>
				
			
				<!--</div>-->
			</div>

                </div>
				
                <div class="span6">
				
                    <div class="row-fluid">
                        <div class="span5">
                            2.-Información de la sección
                        </div>
                    </div>
				<form id="formBorrar" type="post" method="post" onsubmit="eliminarSeccion()">
				<input id="cod_seccion" type="text" name="cod_seccion" style="display:none">
                    <div class="row-fluid">
	<pre style="margin-top: 0%; margin-left: 0%;">
	<?php
	$contador=0;
	$comilla= "'";					
while ($contador<count($secc)){
echo '<tr>';
echo '<td><input id="rs_seccion" name="rs_seccion" value="'.$secc[0][3].'" maxlength="3" min="1" type="hidden">
Sección: '.$secc[0][0].'</td>';
echo '<td id="rs_dia"> 
Día:     '.$secc[0][2].'</td>';
echo '<td id="rs_modulo"> 
Módulo:  '.$secc[0][1].'</td>';
echo '</tr>'; 
$contador =count($secc) ;
}								
?>
</pre>
                    

                    <div class="row-fluid">
                        <div class="span5">
                            3.-Lista de Alumnos
                        </div>
                    </div>
                    
                    
                    <div class="row-fluid">
                        <div class="span13">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
                            <table class="table table-bordered">
                                <thead  bgcolor="#e6e6e6">
                                    <tr>
                                        <th class="span2">Carrera</th>
                                        <th class="span2">RUT</th>
                                        <th class="span3">Apellido paterno</th>
                                        <th class="span3">Apellido materno</th>
                                        <th class="span9">Nombres</th>
                                    </tr>
                                </thead>
                                    <!-- esta fila es solo de ejemplo-->
                                <tbody>
                                    	<?php
										$contador=0;
										while ($contador<count($rs_estudiantes)){
											echo '<tr>';
											echo '<td id="rs_estudiantesTd_'.$contador.'" > '.$rs_estudiantes[$contador][7].' </td>';
											echo '<td id="rs_estudiantesTd_'.$contador.'" > '.$rs_estudiantes[$contador][0].' </td>';
											echo '<td id="rs_estudiantesTd_'.$contador.'" > '.$rs_estudiantes[$contador][3].' </td>';
											echo '<td id="rs_estudiantesTd_'.$contador.'" > '.$rs_estudiantes[$contador][4].' </td>';
											echo '<td id="rs_estudiantesTd_'.$contador.'" > '.$rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].' </td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
									
                                </tbody>
                                
                            </table>
						</div>
                        </div>
                    </div>
					<br>
					</div>
                                <div class="row-fluid">
									<div class="span4" style="margin-left: 45%; width:28%">
										<button class ="btn" type="submit" onclick="eliminarSeccion()" style="width:108px">
											<div class="btn_with_icon_solo">Ë</div>
											&nbsp Eliminar
										</button>
									</div>
									<div class="span3"> 
										<button  class ="btn" type="reset" onclick="DetalleSeccion('')"  style="width:105px">
											<div class="btn_with_icon_solo">Â</div>
											&nbsp Cancelar
										</button>
									</div>
								</div> 
                </div>
				</form>
			
				
            </div>
         </form>
        </fieldset>
    </div>
</div>