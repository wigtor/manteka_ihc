<fieldset>
	<legend>Ver Alumnos</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado Alumnos
			<div class="span12"></div>
			<form style="margin-left: 3%;">
				<fieldset>
					<div class="span10">
					<input type="text" placeholder="Flitro búsqueda">
						<div class="btn-group" style="float: right;">
						  <a class="btn ">Filtrar por:</a>
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						  <ul class="dropdown-menu">
						    <li><a>Acuerdate de preguntar por los filtros</a></li>
						  </ul>
						</div>
					</div>
				</fieldset>
			</form>
			<div class="row-fluid" style="margin-left: 3%;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Nombre Completo</th>
							
						</tr>
					</thead>
					<tbody>
					
						<?php
						$contador=0;
						while ($contador<count($rs_estudiantes)){
							
							echo '<form  type="post" action="VerPorBoton/'. $rs_estudiantes[$contador][0].'">';
							echo '<tr>';
							echo	'<td  style="text-align:center;">'. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'<p></p><input type="submit" value="detalle" align="right"></input></td>';
							//echo '<input type="hidden" name="seleccion1" id="tipo" value="'. $rs_articulos[$contador][0].'">';
							//echo '<input type="submit" name="cualquierNombre"">Agregar alumno</input>';
							echo '</tr>';
							echo '</form>';
							
							$contador = $contador + 1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%;">		
		2.-Detalle Alumnos:
	    <pre style="margin-top: 16%; margin-left: 3%;">
		<?php
		if(!empty($rs_estudiante)){
			echo "\nRut: ".$rs_estudiante[0]."\n";
			echo "Nombre: ".$rs_estudiante[1]."\n";
			echo "Apellido paterno: ".$rs_estudiante[3]."\n";
			echo "Apellido materno: ".$rs_estudiante[4]."\n";
			echo "Correo: ".$rs_estudiante[5]."\n";
			echo "Carrera: ".$rs_estudiante[7]."\n";
			echo "Sección: ".$rs_estudiante[6]."\n";
		}
		else {
			echo "\nRut:\n";
			echo "Nombre:\n";
			echo "Apellido paterno:\n";
			echo "Apellido materno:\n";
			echo "Correo:\n";
			echo "Carrera:\n";
			echo "Sección:\n";
		}
		?>
		
		</pre>

		</div>
	</div>
</fieldset>