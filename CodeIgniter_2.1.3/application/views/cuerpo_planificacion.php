
<fieldset>
	<legend>Planificación</legend>
	<table class="table-striped table table-hover center">
		<thead>
			<tr>
				<th>Coordinación</th>
				<th>Sección</th>
				<th>Profesor</th>
				<th>Módulo Tematico</th>
				<th>Sesión</th>
				<th>Sala</th>
				<th>Bloque</th>
				<th>Hora</th>
				<th>Día</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$h = 0;
				while ( $h<= 10) {
					echo "<tr>";
					for ($i=0; $i < 9; $i++) { 
						echo "<td> Prueba".$i." </td>";
					}
					echo "</tr>";
					$h++;
				}						
			?>			
		</tbody>
	</table>
</fieldset>