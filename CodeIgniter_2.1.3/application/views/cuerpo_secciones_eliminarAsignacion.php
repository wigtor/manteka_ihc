



<div class="row-fluid">
	<div class="span10">
		<fieldset>
			<legend>Borrar Asignación</legend>
			<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Seleccione la sección </label>
							</div>
						</div>
					</div>

					<div class="row-fluid">
						<div class="span10" style="border:#cccccc 1px solid; overflow-y:scroll; height:200px; -webkit-border-radius: 4px;">
							<table class="table table-hover">
							<tbody>
								<input id="seccion" type="text" name="cod_seccion" style="display:none">
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
					</div>
				</div>
				<div class="span6">
					<div class="row-fluid">
						<div class="span9">
							<div class="control-group">
								<label class="control-label" for="inputInfo">2-. Datos de la asignación </label>
							</div>
						</div>
					</div>
					<div class="row-fluid">


						<pre style=" padding: 2%">
Sección:           <b id="nombreSeccion"></b>         
Módulo Actual:               
Profesor Lider:          
Profesor Asignado: 
Sala Asignada:     
Horario Asignado:  
						</pre>
					</div>

					<div class="row-fluid">
						<div class="span3 offset6">
							<button class="btn" type="submit" style="width: 93px">
								<div class= "btn_with_icon_solo">b</div>
								&nbsp Borrar
							</button>
						</div>

						<div class = "span3 ">
							<button  class ="btn" type="reset"  style="width: 105px">
								<div class= "btn_with_icon_solo">Â</div>
								&nbsp Cancelar
							</button>
						</div>
					</div>
				</div>
			</div>
			
		</fieldset>
	</div>
</div>