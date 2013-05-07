<!DOCTYPE html>
<html lang="en">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>

<body>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>

	<script type='text/javascript'>
		/* Esta función se llama al hacer click en el botón entrar, 
		* por convención las funciones que utilizan document.getElementById()
		* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
		* Esta función retorna true o false, en caso de ser true el formulario se envía al servidor
		* Para ver como se configura esto se debe ver como es seteado el evento onsubmit() en el formulario.
		*/
		function validacionRut() {
			var inputRut = document.getElementById("inputRut");
			var rut = inputRut.value;
			var inputGuionRut = document.getElementById("inputGuionRut");
			var guionCaracter = inputGuionRut.value;
			var resultadoValidacionRut = calculaDigitoVerificador(rut, guionCaracter);

			if (resultadoValidacionRut == DV_CORRECTO) {
				//Hago el submit
				return true;
			}
			else if (resultadoValidacionRut == DV_NO_VALIDO) {
				var controlGroupRut = document.getElementById("groupRut");
				$(controlGroupRut).addClass("error");
				var spanError = document.getElementById("spanInputRutError");
				$(spanError).html("El rut introducido no es válido.");
				return false;
			}
			else if (resultadoValidacionRut == DV_INCORRECTO) {
				var controlGroupRut = document.getElementById("groupRut");
				$(controlGroupRut).addClass("error");
				var spanError = document.getElementById("spanInputRutError");
				$(spanError).html("El dígito verificador o el rut no son válidos.");
				return false;
			}
			return false;
		}
	</script>

	<div id="wrap">
		<?php
			echo $banner_portada	//Esta variable es pasada como parámetro a esta vista
		?>
		<div class="row-fluid">
			<div class="span7 offset1">
				<h2>Bienvenido a ManteKA</h2>
						<p align="justify">
							ManteKA es un sistema que le permite mantener una comunicación precisa y fluida con los participantes de la asignatura de Comunicación Efectiva perteneciente al módulo básico de ingeniería. 							A través de ManteKA es posible enviar correos electrónicos masivos a las personas que usted requiere 
							Basta de enviar correos uno por uno!.
						</p>
			</div>
			<fieldset class="span3">
				<legend>Inicio de sesión</legend>
					<?php
						$attributes = array('onSubmit' => 'return validacionRut()', 'id' => 'formLogin');
						echo form_open('Login/LoginPost', $attributes);
					?>
						<?php /* Con esto hago que cambie la class del control-group a 'error' en caso de que exista un error en la validación */
							$inputRut = '';
							$inputPassword = '';
							if (form_error('inputPassword') != '') {
								$inputPassword = 'error';
							}
							if (form_error('inputRut') != '') {
								$inputRut = 'error';
							}
						?>
						<div class="control-group <?php echo $inputRut ?>" id="groupRut">
							<label class="control-label" for="inputRut">Rut</label>
							<div class="controls">
							  	<input style="width:200px" type="text" name="inputRut" id="inputRut" maxlength="9" placeholder=" Ingrese rut, ejemplo: 17565743" value="<?= set_value('inputRut'); ?>">
							 	<STRONG>-</STRONG>
							  	<input style="width:15px" type="text" name="inputGuionRut" maxlength="1" id="inputGuionRut"  placeholder="k" value="<?= set_value('inputGuionRut'); ?>">
								<?= form_error('inputRut', '<span class="help-inline">', '</span>');?>
								<span id="spanInputRutError" class="help-inline"></span>
							</div>
						</div>
						<div class="control-group <?php echo $inputPassword ?>" id="groupPassword">
							<label class="control-label" for="inputPassword">Contraseña</label>
							<div class="controls">
								<input style="width:242px" type="password" name="inputPassword" id="inputPassword" placeholder="  Ingrese su contraseña" value="<?= set_value('inputPassword'); ?>">
								<?= form_error('inputPassword', '<span class="help-inline">', '</span>');?>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox"> Recordarme&nbsp;
									<a href="<?php echo site_url("Login/olvidoPass")?>">¿Olvidó su contraseña?</a>
								</label>
								<button type="submit" class="btn btn-primary">
									Entrar
								</button>					
							</div>
						</div>
						<hr>
				<?php echo form_close(""); ?>
				<?php echo form_open('Login/signInGoogle/google'); ?>
						<div class="control-group text-center">
							<button type="submit" class="btn">
								<div class="pull-right">
									<img src="/<?php echo config_item('dir_alias') ?>/img/logo_google.png" alt="logo google" style="width: 55px; height: 20px;">
								</div>
								Entrar con cuenta de&nbsp; 
							</button>
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