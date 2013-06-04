<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha actualizado la sesion");
				}
				else{
					alert("Error al actualizar");
				}
	}
</script>

<script type="text/javascript">
	function EditarSesion(){

		var cod_sesion = document.getElementById("cod_sesion").value;
		var cod_modulo_tem = document.getElementById("cod_modulo_tem").value;
		var fecha_sesion =	document.getElementById("fecha_sesion").value;
		var descripcion_sesion =	document.getElementById("descripcion_sesion").value;
		if( cod_sesion!=""  && fecha_sesion!="" && descripcion_sesion!="" ){
					var answer = confirm("¿Está seguro de realizar cambios?")
					if (!answer){
						var dijoNO = datosEditarSesion("","","","");
					}
					else{
					var editar = document.getElementById("FormEditar");
					editar.action = "<?php echo site_url("Sesion/editarSesion/") ?>/";
				
					editar.submit();
					}
		}
		else{
				alert("Inserte todos los datos");
				var mantenerDatos = datosEditarSesion(cod_sesion,cod_modulo_tem,fecha_sesion,descripcion_sesion);
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
	while($contadorE<count($rs_sesion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$rs_sesion[$contadorE][1].'";';
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

<script type="text/javascript">
	function datosEditarSesion(cod_seion,cod_modulo_tem,fecha_sesion,descripcion_sesion){
			document.getElementById("cod_sesion").value = '';
			document.getElementById("codEditar").value = cod_sesion;
			var editar = document.getElementById("formDetalle");
			editar.action = "<?php echo site_url("Sesion/editarSesion/") ?>/";
			editar.submit();

	}
</script>


<div class="row_fluid">
	<div class="span10">
		<fieldset>
		<legend>Editar Sala</legend>
		 <form id="formDetalle" type="post" method="post">
			
			<div>
				<div class="row-fluid">
					<div class="span6">
						<font color="red">*Campos Obligatorios</font>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6"><!--    INICIO LISTA SALA -->
						<div class="row-fluid">
							<div class="span6">
							1.-Seleccione la sesion a modificar
							</div>
						</div>
					
						
						<div class="row-fluid">	
							<div class="span11">
								<div class="span6">
									<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span6">
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Código</option>
									</select>
								</div> 
							</div>
						</div>
						
						
						<!--AQUÍ VA LA LISTA-->
						
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
						<tbody>
						<input id="codEditar" type="text" name="codEditar" style="display:none">
							<?php
							$contador=0;
							$com= "'";
					
							while ($contador<count($rs_sesion)){
								
								echo '<tr>';
								echo	'<td  id="'.$contador.'" onclick="datosEditarSesion('.$com.$rs_sesion[$contador][0].$com.','.$com. $rs_sesion[$contador][1].$com.','.$com. $rs_sesion[$contador][2].$com.','.$com. $rs_sesion[$contador][3].$com.')" 
											  style="text-align:left;">
											  '. $rs_sesion[$contador][1].' </td>';
								echo '</tr>';
															
								$contador = $contador + 1;
							}
							
							?>
													
						</tbody>
						</table>
						</div>
						<!--AQUÍ VA LA LISTA-->

					</div> <!--    FIN DE LISTA SALAS -->
					<div class="span6">
						<div style="margin-bottom:2%">
							2.- Complete los datos del formulario para modificar la sesion
							
						</div>

					<form id="FormEditar" type="post" method="post" onsubmit="EditarSala()">
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Código sesion: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
									<?php
									
									if(count($sesion)==1){
									
		    							echo '<tr>';
										echo '<td><input id="cod_sesion" name="cod_sesion" value="'.$sesion[0][0].'" maxlength="3" min="1" type="number" readonly>'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="cod_sesion" name="cod_sesion" value=" " maxlength="0" min="0" type="number" readonly>'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Codigo del modulo tematico: </label>
		  						</div> Número sala
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
									<?php
									
									if(count($sesion)==1){
									
		    							echo '<tr>';
										echo '<td><input id="cod_modulo_tematico" name="cod_modulo_tematico" value="'.$sesion[0][1].'" maxlength="3" min="1" type="number" readonly>'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="cod_modulo_tematico" name="cod_modulo_tematico" value=" " maxlength="0" min="0" type="number" readonly>'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>
						
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Fecha de la sesión: </label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  						<div class="controls">
									<?php
									if(count($sesion)==1){
		    							echo '<tr>';
										echo '<td><input id="fecha_sesion" name="fecha_sesion" value="'.$sesion[0][3].'" maxlength="3" min="1" type="number">'.'</td>';
										echo '</tr>';						
										}
									else{
									    echo '<tr>';
										echo '<td><input id="fecha_sesion" name="fecha_sesion" value=" " maxlength="0" min="0" type="number">'.'</td>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
						</div>

						

						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">

		  							<label class="control-label" for="inputInfo"><font color="red">*</font> Descripción de la sesión:</label>
		  						</div>
		  					</div>
							
							<div class="span5">	
		  						<div class="controls">
									<?php
									if(count($sesion)==1){
		    							echo '<tr>';
										echo '<td><textarea id="descripcion_sesion" name="descripcion_sesion"  maxlength="100" required>'.$sesion[0][2].'</textarea>'.'</td>';
										echo '</tr>';							
										}
									else{
									    echo '<tr>';
										echo '<textarea id="descripcion_sesion" name="descripcion_sesion"  maxlength="0" required> </textarea>';
										echo '</tr>';	
									}
		  							?>
									</div>
							</div>
							

						</div>	

						<br>
						<div class="row-fluid">
							<div class="span10">
								<div class="row-fluid">
									<div class="span3 offset6">
										<button class ="btn" type="submit" onclick="EditarSesion()" >Guardar</button>
										</div>
									<div class="span3">
										<button  class ="btn" type="reset" onclick="datosEditarAlumno('','','','','','')" >Cancelar</button>
									</div>
								</div>
							</div>
						</div>

					</form>	
					<!-- AQUI TERMINA  -->

					</div>
				</div>
			</div>
			</form>
		</fieldset>
	</div>
</div>