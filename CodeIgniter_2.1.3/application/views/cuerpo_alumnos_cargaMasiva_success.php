
<fieldset>
	<legend>Carga masiva de alumnos</legend>
		<h3>Su archivo se ha cargado con éxito</h3>

		<ul>
			<?php foreach ($upload_data as $item => $value):?>
			
			<li><?php echo $item;?>: <?php echo $value;?></li>
			<?php endforeach; ?>
		</ul>

		<p><?php echo anchor('Alumnos/cargaMasivaAlumnos', 'Cargue un nuevo archivo!'); ?></p>

</fieldset>