<!DOCTYPE html>
<html lang="en">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>
<body>
		
		<?php
			echo $banner_portada	//Esta variable es pasada como parámetro a esta vista
		?>
		<div class="row-fluid">
			<div class="span7 offset1">
				<h2>Bienvenido a ManteKA</h2>
				ManteKA es un sistema que le permite mantener una comunicación precisa y fluida con los participantes de la asignatura de Comunicación Efectiva perteneciente al módulo básico de ingeniería. <br>
				A través de ManteKA es posible envíar correos electrónicos masivos mediante los filtros que se proporcionan. <br>
				Basta de enviar correos uno por uno! :)
			</div>
			<div class="span4">
				<?php echo form_open('php/login/'); ?>
						<div class="control-group">
							<label class="control-label" for="inputRut">Rut</label>
							<div class="controls">
							  <input type="text" name="inputRut" id="inputRut" placeholder="Ingrese rut, ejemplo: 175657436" value="<?= set_value('inputPassword'); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputPassword">Contraseña</label>
							<div class="controls">
								<input type="password" name="inputPassword" id="inputPassword" placeholder="Ingrese su contraseña" value="<?= set_value('inputPassword'); ?>">
								<div class="LoginUsuariosError"><?= form_error('passwordlogin');?></div>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox"> Recordarme
								</label>
								<button type="submit" class="btn">Iniciar Sesión</button>
							</div>
						</div>
					
			</div>
		</div>
		
</body>
</html>