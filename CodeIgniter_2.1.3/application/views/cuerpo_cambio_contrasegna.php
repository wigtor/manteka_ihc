
<fieldset>
	<legend>Perfil de usuario</legend>
	
	
	<?php echo form_open('Login/cambiarContrasegnaPost'); ?>
	<div class="error"> 
		<div style ="display:inline-block">
			<label>Nombres</label>
			<input type="text" value="<?php echo $datos->nombre1." ".$datos->nombre2 ?>" disabled>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Apellidos</label>
			<input type="text" value="<?php echo $datos->apellido1." ".$datos->apellido2 ?>" disabled>
		</div>	
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Rut</label>
			<input type="text" value="<?php echo $rut_usuario ?>" disabled>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Tipo de cuenta</label>
			<input type="text" value="<?php echo $datos->tipo_usuario ?>" disabled>
		</div>
		<br>
		<hr>

		<?php /* Con esto hago que cambie la class del control-group a 'error' en caso de que exista un error en la validación */
			$hay_error_contrasegna_actual = '';
			$hay_error_nva_contrasegna = '';
			$hay_error_nva_contrasegna_rep = '';
			$hay_error_telefono = '';
			$hay_error_correo1 = '';
			$hay_error_correo2 = '';
			if (form_error('telefono') != '') {
				$hay_error_telefono = 'error';
			}
			if (form_error('correo1') != '') {
				$hay_error_correo1 = 'error';
			}
			if (form_error('correo2') != '') {
				$hay_error_correo2 = 'error';
			}
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

		<div class="row-fluid">
			<font class="span6" color="red">* Campos Obligatorios</font>
		</div>
		
		<!--
		<div class="control-group <?php echo $hay_error_telefono ?>">  
			<label class="control-label" for="telefono">Teléfono</label>  
			<div class="controls">
				<input type="text" id="telefono" name="telefono" value="<?php echo $datos->telefono ?>">  
				<?php echo form_error('telefono', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group <?php echo $hay_error_correo1 ?>">  
			<label class="control-label" for="correo1"><font color="red">*</font> Correo</label>  
			<div class="controls">
				<input type="text" id="correo1" name="correo1" value="<?php echo $datos->email1 ?>" required>  
				<?php echo form_error('correo1', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group <?php echo $hay_error_correo2 ?>">  
			<label class="control-label" for="correo2">Correo alternativo</label>  
			<div class="controls">
				<input type="text" id="correo2" name="correo2" value="<?php echo $datos->email2 ?>">  
				<?php echo form_error('correo2', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		-->
		
		<div style ="display:inline-block">
			<label>Teléfono</label>
			<input type="text" name="telefono" maxlength="11" pattern="[0-9]+" placeholder="44556677" value="<?php echo $datos->telefono ?>" >
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label><font color="red">*</font> Correo</label>
			<input type="email" name="correo1" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" placeholder="nombre_usuario@miemail.com" value="<?php echo $datos->email1 ?>" required>
			<?php echo form_error('correo1', '<span class="help-inline">', '</span>'); ?>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<label>Correo alternativo</label>
			<input type="email" name="correo2" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)$" placeholder="nombre2_usuario@miemail.com" value="<?php echo $datos->email2 ?>" >
		</div>
		
		<hr>
		
		<div class="row-fluid">
			<font class="span12" color="red">* Campos Obligatorios, Si no desea cambiar su contraseña deje estos campos en blanco.</font>
		</div>
		<div class="control-group <?php echo $hay_error_contrasegna_actual ?>">  
			<label class="control-label" for="contrasegna_actual"><font color="red">*</font> Contraseña actual</label>  
			<div class="controls">
				<input type="password" id="contrasegna_actual" name="contrasegna_actual" value="<?php echo set_value('contrasegna_actual'); ?>">  
				<?php echo form_error('contrasegna_actual', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
			
		<div class="control-group <?php echo $hay_error_nva_contrasegna ?>">  
            <label class="control-label" for="contrasegna_actual"><font color="red">*</font> Nueva contraseña</label>  
            <div class="controls">
              	<input type="password" id="nva_contrasegna" name="nva_contrasegna" value="<?php echo set_value('nva_contrasegna'); ?>">  
              	<?php echo form_error('nva_contrasegna', '<span class="help-inline">', '</span>'); ?>
            </div>
      	</div>
		
		<div class="control-group <?php echo $hay_error_nva_contrasegna_rep ?>">  
            <label class="control-label" for="contrasegna_actual"><font color="red">*</font> Confirme su nueva contraseña</label>  
            <div class="controls">
              	<input type="password" id="nva_contrasegna_rep" name="nva_contrasegna_rep" value="<?php echo set_value('nva_contrasegna_rep'); ?>">  
              	<?php echo form_error('nva_contrasegna_rep', '<span class="help-inline">', '</span>'); ?>
            </div>
      	</div>
		
		<div style ="display:inline-block">
			<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
		</div>
		&nbsp; &nbsp;
		<div style ="display:inline-block">
			<button type="button" class="btn" onclick="window.location.href='<?php echo site_url("Login/index/") ?>'"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
		</div>
	</div>
	<?php echo form_close(""); ?>
	
</fieldset>
