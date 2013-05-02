
<fieldset>
	<legend>Correos Enviados</legend>
	<?php if(isset($correos)){ foreach($correos as $correo):?>
		<tr>
			<td><?php echo $correo->RUT_AYUDANTE ?></td>	
			<td><?php //echo anchor("marca/modificar/$marca->NOMBRE_MARCA", "Modificar");?></td>
		</tr>
	<?php endforeach;}?>
	
</fieldset>