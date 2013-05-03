<fieldset>
	<legend>Ver Profesor</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado Profesores
			<div class="span9"></div>
			
				<fieldset>
					<div class="span10">
					<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">
						<!--div class="btn-group" style="float: right;">
						  <a class="btn ">Filtrar por:</a>
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						  <ul id="tipoDeFiltro" class="dropdown-menu">
						    <li><a value="Primer nombre val">Primer nombre</a></li>
						  </ul>
						</div-->
						<select id="tipoDeFiltro" title="Tipo de filtro" name="Filtro a usar">
						<option value="1">Filtrar por Nombre</option>
						<option value="3">Filtrar por Apellido paterno</option>
						<option value="4">Filtrar por Apellido materno</option>
						<option value="5">Filtrar por Seccion</option>
						</select> 
					</div>
				</fieldset>
			
			<div class="row-fluid" style="margin-left: 0%;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="text-align:left;">Nombre Completo</th>
						</tr>

					</thead>
<!--					<tbody>
					
						<?php
						$contador=0;
						$comilla= "'";
						echo '<form id="formDetalle" type="post">';
						while ($contador<count($rs_estudiantes)){
							
							echo '<tr>';
							echo	'<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_estudiantes[$contador][0].$comilla.','.$comilla. $rs_estudiantes[$contador][1].$comilla.','.$comilla. $rs_estudiantes[$contador][2].$comilla.','.$comilla. $rs_estudiantes[$contador][3].$comilla.','.$comilla. $rs_estudiantes[$contador][4].$comilla.','.$comilla. $rs_estudiantes[$contador][5].$comilla.','. $comilla.$rs_estudiantes[$contador][6].$comilla.','.$comilla. $rs_estudiantes[$contador][7].$comilla.')" 
										  style="text-align:center;">
										  '. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
							echo '</tr>';
														
							$contador = $contador + 1;
						}
						echo '</form>';
						?>
												
					</tbody> -->
				</table>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle Profesor:
	    <pre style="margin-top: 2%; padding: 2%">
 Rut:              <!--<b id="rutDetalle"></b>-->
 Nombre uno:       <!--<b id="nombreunoDetalle"></b>-->
 Apellido paterno: <!--<b id="apellidopaternoDetalle" ></b>-->
 Correo:           <!--<b id="mailDetalle" ></b>-->
 Fono:			  <!--<b id="fonoDetalle" ></b> -->
 Modulo:			  <!--<b id="moduloDetalle" ></b> -->
 Seccion:          <!--<b id="seccionDetalle"></b>-->
 Tipo:             <!--<b id="tipoDetalle">usach</b>--></pre>

		</div>
	</div>
</fieldset>