<!--	Vista que le indica al usuario que ingrese un correo para que se genere una nueva contraseña temporal	-->

<!DOCTYPE html>
<html lang="en">
<?php
	echo $head						//	Header de la página. Esta variable es pasada como parámetro a esta vista.
?>
<body>
	<div id="wrap">

		<?php
			echo $banner_portada	//	Banner de la página. Esta variable es pasada como parámetro a esta vista.
		?>
		<div class="wrapp row-fluid">
			<fieldset class="span4 offset4">
				<legend>
		        ¿Olvidó su contraseña?
		      	</legend>

		      	<p id="feedback">
		        	Escriba su dirección de correo electrónico y se le enviará una contraseña temporal para que pueda entrar.
		      	</p><br>

		      	<?php echo form_open('Login/recuperaPassPost/'); ?>
			      	<?php
				      	$hay_error_email = '';
						if (form_error('email') != '') {
							$hay_error_email = 'error';
						}
					?>
		      		<div class="control-group <?php echo $hay_error_email ?>">
			        	<label class="control-label" for="email-input">
			          		Email:
			        	</label>
			        	<div class="controls">
			        		<input type="email" name="email" id="email-input" placeholder="Ejemplo: alguien@usach.cl" value="<?php echo set_value('email'); ?>" autofocus/>
			        		<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
			        	</div>

		        	</div>
		      		<div>
	        			<input type="submit" class="btn btn-primary" value="Enviar"></input>
	        			<a class="pull-right" href="<?php echo site_url("Login/index")?>">Volver al inicio de sesión</a>
	        		</div>
        		<?php echo form_close(""); ?>
	      	</fieldset>
    	</div>
    </div>
		<?php
			echo $footer;
		?>

</body>
</html>