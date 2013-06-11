<script type="text/javascript">
	function Cancelar(){
		var borrar = document.getElementById("Cancelar");
		borrar.action ="<?php echo site_url("Secciones/asignarAsecciones/");?>"
		borrar.submit()	
	}
</script>

<div class="row-fluid">
	<div class="span10">
		<form id="Cancelar" method="post">
		<fieldset>
			<legend>Asignaciones de Sección</legend>
			<div class="row-fluid">
				<div class= "span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Seleccione la sección para asignación</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table id="" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody>

								<?php
								$contador=0;
								$comilla= "'";
								
								while ($contador<count($seccion)){
									
									echo '<tr>';
									echo '<td   onclick="detalleSeccion('.$comilla.$seccion[$contador][0].$comilla.')"> '.$seccion[$contador][1].' </td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								
								?>

								</tbody>
							</table>
						</div>
					</div>
					<div class="row-fluid" style="margin-top:2%">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">3-.<font color="red">*</font> Seleccione el profesor disponible del módulo</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;  margin-top:7%">
							<table id="" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody>


								</tbody>
							</table>
						</div>
					</div>
				</div>


				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">2-.<font color="red">*</font> Seleccione el módulo a asignar</label>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody>
									


								</tbody>
							</table>
						</div>
					</div>
					<div class="row-fluid" style="margin-top:2%">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">4-.<font color="red">*</font> Seleccione la sala y horario</label>
							</div>
						</div>
					</div>

					<div class="row-fluid" style="margin-left:3%">
						<div class="span6" >
							4.1- Sala
						</div>
						<div class="span6" >
							4.2- Horario
						</div>
					</div>

					<div class="row-fluid">
						<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table id="listadoResultados" class="table table-hover">
								<thead>
									<tr>
										
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>

						<div class="row-fluid">
								<select class= "span4" style="margin-left: 2%">
									<option value="" disabled selected>Día</option>
	  								<option>Lunes</option>
									<option>Martes</option>
									<option>Miercoles</option>
									<option>Jueves</option>
									<option>Viernes</option>
									<option>Viernes</option>
								</select>
							

						
								<select class= "span4" style="margin-left: 2%; margin-top:5%" >
									<option value="" disabled selected>Bloque</option>
	  								<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
								</select>
							
						</div>

						<div class="row-fluid" style="margin-top:5%; margin-left: 35%">
							<div class="span3">
									<button class="btn"  style="width:102px">
										<div class= "btn_with_icon_solo">Ã</div>
										&nbsp Asignar

									</button>
								</div>
								<div class="span3">
									<button class="btn" onClick="Cancelar()" type="reset" style="width:105px">
										<div class= "btn_with_icon_solo">Â</div>
										&nbsp Cancelar

									</button>
							</div>
						</div>



					</div>
				</div>
			</div>

		</fieldset>
	</div>
	</form>
</div>