
<fieldset>
	<legend>Planificación</legend>
	<table class="table-striped table table-hover center">
		<thead>
			<tr>
				<th>Sección</th>
				<th>Profesor</th>
				<th>Módulo Tematico</th>
				<th>Sala</th>
				<th>Bloque</th>
				<th>Hora</th>
				<th>Día</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$columnas = 'seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sesion.DESCRIPCION_SESION, sala.NUM_SALA, horario.COD_DIA, horario.COD_MODULO';
			foreach ($lista as $fila) {
				echo '<tr>';
				echo '<td>'.$fila['COD_SECCION'].'</td>';
				echo '<td>'.$fila['NOMBRE1_PROFESOR'].' '.$fila['NOMBRE2_PROFESOR'].' '.$fila['APELLIDO1_PROFESOR'].' '.$fila['APELLIDO2_PROFESOR'].'</td>';
				echo '<td>'.$fila['NOMBRE_MODULO'].'</td>';
				echo '<td>'.$fila['NUM_SALA'].'</td>';
				echo '<td>'.$fila['NOMBRE_HORARIO'].'</td>';
				echo '<td>'.$fila['NUMERO_MODULO'].'</td>';
				echo '<td>'.$fila['NOMBRE_DIA'].'</td>';

				echo '</tr>';
			}

								
			?>			
		</tbody>
	</table>
</fieldset>