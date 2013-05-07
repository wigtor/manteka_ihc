
<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado exitosamente el profesor");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}
</script>

<!--<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroSeccion").value;
	var arreglo = new Array();
	var ocultarInput;
	var ocultarTd;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($secciones)){
		echo 'arreglo['.$contadorE.'] = "'.$secciones[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarInput=document.getElementById(arreglo[cont]);
		ocultarTd=document.getElementById("seccionTd_"+cont);
		if(0 > arreglo[cont].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultarInput.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultarInput.style.display='';
			ocultarTd.style.display='';
		}
    }
}
</script>
-->
<div class= "row-fluid">
	<div class= "span10">	
		<fieldset>
			<form id="formAgregar" type="post" action="<?php echo site_url("Profesores/insertarProfesor/")?>">
			<legend>Agregar Profesor</legend>
			<div>
				<div class= "row-fluid">
					<div class= "span6" style="margin-bottom:2%">
						Complete los datos del formulario para ingresar un profesor:
					</div>
				</div>
				<div  class= "row-fluid" style="margin-left:2%">
					<div class= "span6">
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo" > 1-.*RUN:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="10" minlength="7" type="number" name="rut_profesor" placeholder="Ingrese RUN sin dig. verificador" required>
		  							</div>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">2-.*Primer nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">3-.*Segundo nombre:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="nombre2_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">4-.*Apellido paterno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido1_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">5.*Apellido materno:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="text" name="apellido2_profesor" maxlength="19" required >
		  							</div>
							</div>

						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">6-.*Mail:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input type="email" name="correo_profesor" maxlength="30" placeholder="ejemplo@usach.cl" required>
		  							</div>
							</div>

						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">7-.*Telefono:</label>
		  						</div>
		  					</div>
		  					<div class="span5">	
		  							<div class="controls">
		    							<input id="inputInfo" maxlength="7" minlength="7" type="number" name="telefono_profesor" placeholder="Ingrese solo numeros" required>

		  							</div>
							</div>

						</div>
						<div class="row">
							<div class="span4">
								<div class="control-group">
		  							<label class="control-label" for="inputInfo">8-.*Tipo:</label>
		  						</div>
		  					</div>
		  					<div  class="span6">
									<div  class="span6">
									<select id="tipoDeFiltro" title="Tipo de contrato" name="tipo_profesor">
										<option value="Planta">Planta</option>
										<option value="Por hora">Por hora</option>
								</select>
								</div>
								</div>
						</div>
					<div class="row" style="width: 845px;">		
						<div class="span2" style="margin-left: 654px;">
								<button class="btn" type="submit">Agregar</button>
							</div>
							<div class="span1" style="margin-left: -32px;">
								<button class="btn" type="reset">Cancelar</button>
							</div>
						</div>
					</div> 

					
				</div>
			</div>
			</form>
		</fieldset>
	</div>
</div>					
