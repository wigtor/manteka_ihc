<!DOCTYPE html>
<html lang="es">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>
<body>
		
		<?php
			echo $banner_portada	//Esta variable es pasada como parámetro a esta vista
		?>
		<div>
			ManteKA es un sistema que le permite mantener una comunicación precisa y fluida con los participantes de la asignatura de Comunicación Efectiva perteneciente al módulo básico de ingeniería.
		</div>
		<div class="login">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail">Nombre de usuario</label>
					<div class="controls">
					  <input type="text" id="inputEmail" placeholder="Ingrese usuario, por ejemplo: 175657436">
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