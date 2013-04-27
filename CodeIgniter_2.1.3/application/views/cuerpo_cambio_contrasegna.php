
<fieldset>
	<legend>Cambiar contraseña</legend>
	
	<?php echo validation_errors(); ?>
	
	<?php echo form_open('Login/cambiarContrasegnaPost'); ?>
	<div> 
		<label>Nombre de usuario</label>
		<input type="text" placeholder="<?php echo $rut_usuario ?>" value="<?php echo $rut_usuario ?>" disabled>
		
		<label>Contraseña actual</label>
		<input type="text" name="contrasegna_actual" value="<?php echo set_value('contrasegna_actual'); ?>">
		
		<label>Nueva contraseña</label>
		<input type="text" name="nva_contrasegna" value="<?php echo set_value('nva_contrasegna'); ?>">
		
		<label>Repita su nueva contraseña</label>
		<input type="text" name="nva_contrasegna_rep" value="<?php echo set_value('nva_contrasegna_rep'); ?>">
		
		<div>
			<button type="submit" class="btn">Cambiar contraseña</button>
		</div>
	</div>
	
</fieldset>