
<fieldset>
	<legend>Planificación</legend>
	<table class="table-striped table table-hover center">
		<thead>
			<tr>
				<th>Sección</th>
				<th>Profesor</th>
				<th>Módulo Temático</th>
				<th>Sala</th>
				<th>Bloque</th>
				<th>Hora</th>
				<th>Día</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$columnas = 'seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sesion.DESCRIPCION_SESION, sala.NUM_SALA, horario.COD_DIA, horario.COD_MODULO';
			//foreach ($lista as $fila) {
			$contador=0;
			while($contador<count($lista)){
				echo '<tr>';
				echo '<td>'.$lista[$contador][0].'</td>';
				echo '<td>'.$lista[$contador][1].' '.$lista[$contador][2].' '.$lista[$contador][3].'</td>';
				echo '<td>'.$lista[$contador][4].'</td>';
				echo '<td>'.$lista[$contador][5].'</td>';
				echo '<td>'.$lista[$contador][6].'</td>';
				echo '<td>'.$lista[$contador][7].'</td>';
				echo '<td>'.$lista[$contador][8].'</td>';

				echo '</tr>';
				$contador=$contador+1;
			}

								
			?>			
		</tbody>
	</table>
</fieldset>