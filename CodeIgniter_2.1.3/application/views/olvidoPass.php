<!DOCTYPE html>
<html lang="en">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>
<body>
		
		<?php
			echo $banner_portada	//Esta variable es pasada como parámetro a esta vista
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
		      		<div class="control-group">
			        	<label class="control-label" for="email-input">
			          		Dirección de correo electrónico:
			        	</label>
			        	<div class="controls">
			        		<input type="email" name="email" id="email-input" placeholder="Ejemplo: alguien@usach.cl" autofocus/>
			        		<div>
			        			<input type="submit" class="btn btn-primary" value="Enviar"></input>
			        		</div>
			        	</div>
		        	</div>
		      	
	      	</fieldset>
    	</div>
		
</body>
</html>