
<fieldset>
	<legend>Carga masiva de alumnos</legend>
	<h3>Su archivo se ha cargado <?php echo $error;?></h3>

	<table class="table-striped table table-hover center">							
		<?php
		if (isset($filas)) {?>
		<thead>
			<tr>
				<th>Linea</th>
				<th>Rut</th>
				<th>Carrera</th>
				<th>Seccion</th>
				<th>Primer Nombre</th>
				<th>Segundo Nombre</th>
				<th>Apellido materno</th>
				<th>Apellido paterno</th>
				<th>Correo</th>
			</tr>
		</thead>
		<tbody>
			
			<?php	 foreach ($filas as $clave => $valor){?>
			
			<tr>	<td><?php echo $clave;?> </td>
				<?php foreach ($valor as $key => $value){?> 

				<td> <?php echo $value;?> </td>


				<?php	}?>
			</tr>
		<?php }}?>		


	</tbody>	

</table>
<div style="text-align:center!important;width: 100%">
	<button class="btn"><?php echo anchor('Alumnos/cargaMasivaAlumnos', 'Cargue un nuevo archivo!'); ?></button> 
</div>

</fieldset>