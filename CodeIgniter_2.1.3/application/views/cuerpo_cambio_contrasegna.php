
<fieldset>
	<legend>Perfil de usuario</legend>
	
	
	<?php echo form_open('Login/cambiarContrasegnaPost'); ?>
	<div class="error"> 
		<div style ="display:inline-block">
			<label>Nombres</label>
			<input type="text" placeholder="<?php echo $datos->nombre1." ".$datos->nombre2 ?>" value="<?php echo $datos->nombre1." ".$datos->nombre2 ?>" disabled>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Apellidos</label>
			<input type="text" placeholder="<?php echo $datos->apellido1." ".$datos->apellido2 ?>" value="<?php echo $datos->apellido1." ".$datos->apellido2 ?>" disabled>
		</div>	
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Rut</label>
			<input type="text" placeholder="<?php echo $rut_usuario ?>" value="<?php echo $rut_usuario ?>" disabled>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Tipo de cuenta</label>
			<input type="text" placeholder="<?php echo $datos->tipo_usuario ?>" value="<?php echo $datos->tipo_usuario ?>" disabled>
		</div>
		<br>
		<hr>
		<div style ="display:inline-block">
			<label>Teléfono</label>
			<input type="text" name="telefono" placeholder="<?php echo $datos->telefono ?>" value="<?php echo $datos->telefono ?>" >
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>* Correo</label>
			<input type="text" name="correo1" placeholder="<?php echo $datos->email1 ?>"  value="<?php echo $datos->email1 ?>" >
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Correo alternativo</label>
			<input type="text" name="correo2" placeholder="<?php echo $datos->email2 ?>" value="<?php echo $datos->email2 ?>" >
		</div>
		<hr>
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
		
		<div style ="display:inline-block">
			<input type="submit" class="btn" value="Guardar">
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<input type="button" class="btn" onclick= "window.location.href='/<?php echo config_item('dir_alias') ?>/index.php/Login/index'" value="Cancelar">
		</div>
	</div>
	<?php echo form_close(""); ?>
	
</fieldset>
