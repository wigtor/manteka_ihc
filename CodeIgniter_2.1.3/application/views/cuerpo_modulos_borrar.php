<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Borrar Módulo</legend>
			<div class= "row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							1.-Listado Módulos
						</div>
					</div>
				<div class="row-fluid">
					<div class="span13">
					
						<div class="row-fluid">
							<div class="span9">
								<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
						

							<div class="span3">	
									<button class="btn"  >Buscar</button>
							</div> 
						</div>
					</div>
				</div>
				
			
					<div class="row-fluid" style="margin-left: 0%;">
						
							<thead>
								<tr>
									<th style="text-align:left;"><br><b>Nombre Módulos</b></th>
									
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px">
								<table class="table table-hover">
									<tbody>
									
										<?php
										/*$contador=0;
										$comilla= "'";
										
										while ($contador<count($rs_estudiantes)){
											
											echo '<tr>';
											echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
														  style="text-align:left;">
														  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
											echo '</tr>';
																		
											$contador = $contador + 1;
										}*/
										
										?>
																
									</tbody>
								</table>
							</div>

					</div>
				</div>
			

				<div class="span6" style="margin-left: 2%; padding: 0%; ">
			2. Detalle Módulo Temático
			<div class ="row-fluid">
				<pre style="margin-top: 2%; padding: 2%; height:6%">
Nombre del Módulo:	Módulo 1
Profesor Lider: 	Mauricio Marín

			</pre>
				
			</div>
			<div class="row-fluid">
				<div class="row-fluid">
						<div class="span6">
							3. Sesiones del Módulo Temático
						</div>
				</div>
			</div>
			<div class="row-fluid">
				<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" >
									
									
					<table class="table table-hover">
						<thead>

						</thead>
						<tbody>									
									
											
						</tbody>
					</table>
				</div>
			</div>
			<div class="row-fluid">
				<div class="row-fluid" style="margin-top:2%">
						<div class="span7">
							4. Profesores del Módulo Temático
						</div>
				</div>
			</div>
			<div class="row-fluid">
				<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" >
									
									
					<table class="table table-hover">
						<thead>

						</thead>
						<tbody>									
									
											
						</tbody>
					</table>
				</div>
			</div>
			<div class="row-fluid" style="margin-top: 2%; margin-left:54%">
				<div class="span3">
					<button class="btn"  >Eliminar</button>
				</div>
				<div class="span3">
					<button class="btn"  >Cancelar</button>
				</div>
			</div>


		</div>
			</div>

			
		</fieldset>
	</div>
</div>
