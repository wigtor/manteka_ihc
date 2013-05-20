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
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
						

							<div class="span6">
									
									<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Código Carrera</option>
									<option value="6">Filtrar por Seccion</option>
									</select>
							</div> 
						</div>
					</div>
				</div>
				
			
					<div class="row-fluid" style="margin-left: 0%;">
						
							<thead>
								<tr>
									<th style="text-align:left;"><br><b>Nombre Completo</b></th>
									
								</tr>
							</thead>
							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover">
									<tbody>
									
										<?php
										$contador=0;
										$comilla= "'";
										
										while ($contador<count($rs_estudiantes)){
											
											echo '<tr>';
											echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
														  style="text-align:left;">
														  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
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
					<div style="margin-bottom:0%">
							2.-Detalle del Alumno:
					</div>
					<form id="formBorrar" type="post">
					<div class="row-fluid">
						<div >
						<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombreunoDetalle"></b> <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>
<input type="hidden" id="rutEliminar" value="">
								
						</div>
					</div>
					<div class= "row-fluid" >
						<div class="row-fluid" style=" margin-top:10px; margin-left:54%">		
							<div class="span3 ">
								<button class="btn" onclick="eliminarAlumno()" >Eliminar</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" type="reset" onclick="DetalleAlumno('','','','','','','','')" >Cancelar</button>
							</div>
						</div>
					</div>
					</form>
				</div>	
			</div>

			
		</fieldset>
	</div>
</div>
