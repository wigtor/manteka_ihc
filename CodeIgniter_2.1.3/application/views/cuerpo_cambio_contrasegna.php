
<fieldset>
	<legend>Cambiar contraseña</legend>
	
	
	<?php echo form_open('Login/cambiarContrasegnaPost'); ?>
	<div class="error"> 
		<label>Nombre de usuario</label>
		<input type="text" placeholder="<?php echo $rut_usuario ?>" value="<?php echo $rut_usuario ?>" disabled>
		
		<?php /* Con esto hago que cambie la class del control-group a 'error' en caso de que exista un error en la validación */
			$hay_error_contrasegna_actual = '';
			$hay_error_nva_contrasegna = '';
			$hay_error_nva_contrasegna_rep = '';
			if (form_error('contrasegna_actual') != '') {
				$hay_error_contrasegna_actual = 'error';
			}
			if (form_error('nva_contrasegna') != '') {
				$hay_error_nva_contrasegna = 'error';
			}
			if (form_error('nva_contrasegna_rep') != '') {
				$hay_error_nva_contrasegna_rep = 'error';
			}
		?>

		<div class="control-group <?php echo $hay_error_contrasegna_actual ?>">  
            <label class="control-label" for="contrasegna_actual">* Contraseña actual</label>  
            <div class="controls">
              	<input type="password" id="contrasegna_actual" name="contrasegna_actual" value="<?php echo set_value('contrasegna_actual'); ?>">  
              	<?php echo form_error('contrasegna_actual', '<span class="help-inline">', '</span>'); ?>
            </div>
      	</div>
			
		<div class="control-group <?php echo $hay_error_nva_contrasegna ?>">  
            <label class="control-label" for="contrasegna_actual">* Nueva contraseña</label>  
            <div class="controls">
              	<input type="password" id="nva_contrasegna" name="nva_contrasegna" value="<?php echo set_value('nva_contrasegna'); ?>">  
              	<?php echo form_error('nva_contrasegna', '<span class="help-inline">', '</span>'); ?>
            </div>
      	</div>
		
		<div class="control-group <?php echo $hay_error_nva_contrasegna_rep ?>">  
            <label class="control-label" for="contrasegna_actual">* Confirme su nueva contraseña</label>  
            <div class="controls">
              	<input type="password" id="nva_contrasegna_rep" name="nva_contrasegna_rep" value="<?php echo set_value('nva_contrasegna_rep'); ?>">  
              	<?php echo form_error('nva_contrasegna_rep', '<span class="help-inline">', '</span>'); ?>
            </div>
      	</div>
		
		<div>
			<input type="submit" class="btn btn-primary" value="Cambiar contraseña"></input>
		</div>
		
		
		
	</div>
	
</fieldset>