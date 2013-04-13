<!DOCTYPE html>
<html lang="es">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>
<body>
		
		<?php
			echo $banner_portada	//Esta variable es pasada como parámetro a esta vista
		?>
		<div class="span6">
			ManteKA es un sistema que le permite mantener una comunicación precisa y fluida con los participantes de la asignatura de Comunicación Efectiva perteneciente al módulo básico de ingeniería. <br>
			A través de ManteKA es posible envíar correos electrónicos masivos mediante los filtros que se proporcionan. <br>
			Basta de enviar correos uno por uno! :)
		</div>
		<div class="span6">
				<form class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="inputEmail">Rut</label>
						<div class="controls">
						  <input type="text" id="inputEmail" placeholder="Ingrese rut, ejemplo: 175657436">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPassword">Contraseña</label>
						<div class="controls">
							<input type="password" id="inputPassword" placeholder="Ingrese su contraseña">
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
				</form>
		</div>
		
		
</body>
</html>