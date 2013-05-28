<!DOCTYPE html>
<html lang="en">
<?php
	echo $head						//	Header de la página. Esta variable es pasada como parámetro a esta vista
?>

<body>
	 <link href="/<?php echo config_item('dir_alias') ?>/css/especial.css" rel="stylesheet" type="text/css">
	 <script src="/<?php echo config_item('dir_alias') ?>/javascripts/verificadorRut.js"></script>
	 <script src="/<?php echo config_item('dir_alias') ?>/javascripts/jQuery.js"></script>
     <script src="/<?php echo config_item('dir_alias') ?>/javascripts/jquery.bpopup.min.js"></script>
     <script src="/<?php echo config_item('dir_alias') ?>/javascripts/funcionAyuda.js"></script>
     

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
			RecepcionRut = rut;
			var inputGuionRut = document.getElementById("inputGuionRut");
			var guionCaracter = inputGuionRut.value;
			var resultadoValidacionRut = calculaDigitoVerificador(rut, guionCaracter);
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();

			// Si el resultado de la validación es satisfactorio
			if (resultadoValidacionRut == DV_CORRECTO) {
				// Realizar un submit
				$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Login/postLoguearse") ?>", /* Se setea la url del controlador que responderá */
				data: { rutEnvio: RecepcionRut}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var datos = jQuery.parseJSON(respuesta);
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					}
				});
				return true;
			}
			// Caso en que la validación entregue un error de validación
			else if (resultadoValidacionRut == DV_NO_VALIDO) {
				// Se especifican las clases para los elementos, de tal manera de que se le indique al usuario el error
				var controlGroupRut = document.getElementById("groupRut");
				$(controlGroupRut).addClass("error");
				var spanError = document.getElementById("spanInputRutError");
				$(spanError).html("El rut introducido no es válido.");
				$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Login/postLoguearse") ?>", /* Se setea la url del controlador que responderá */
				data: { rutEnvio: RecepcionRut}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var datos = jQuery.parseJSON(respuesta);
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					}
				});
				return false;
			}
			// Caso que el RUT ingresado sea incorrecto
			else if (resultadoValidacionRut == DV_INCORRECTO) {
				// Se especifican las clases para los elementos, de tal manera de que se le indique al usuario el error
				var controlGroupRut = document.getElementById("groupRut");
				$(controlGroupRut).addClass("error");
				var spanError = document.getElementById("spanInputRutError");
				$(spanError).html("El dígito verificador o el rut no son válidos.");
				$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Login/postLoguearse") ?>", /* Se setea la url del controlador que responderá */
				data: { rutEnvio: RecepcionRut}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var datos = jQuery.parseJSON(respuesta);
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					}
				});
				return false;
			}
			return false;
		}
	</script>

	<div id="wrap">
		<?php
			echo $banner_portada	//	Banner de la página. Esta variable es pasada como parámetro a esta vista
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
					<div  id="my-button" class="pull-right pull-top" ><a class="btn_with_icon_solo" style="position: absolute; font-size: 45px !important; margin-top: -15px; margin-left: -25px;" href="<?php echo site_url("Ayuda/index") ?>">R</a></div>
					<div id="element_to_pop_up"><img src="/<?php echo config_item('dir_alias') ?>/img/ayudaInicio.png"></div>
					<?php
						$attributes = array('onSubmit' => 'return validacionRut()', 'id' => 'formLogin');
						echo form_open('Login/LoginPost', $attributes);
					?>
						<?php
							/* Cambiar la clase al objeto, para que se muestre un error en la validación. */
							$inputRut = '';
							$inputPassword = '';
							if (form_error('inputPassword') != '') {
								$inputPassword = 'error';
							}
							if (form_error('inputRut') != '') {
								$inputRut = 'error';
								$rut_almacenado = set_value('inputRut'); //Está es una excepción de como usar el control de errores
								//La idea es que si no hay errores, se muestra el rut almacenado en las cookies.
							}
							
							else if (set_value('inputRut') != '') {
								$rut_almacenado = set_value('inputRut');
							}
							else if (!isset($rut_almacenado)) {
								$rut_almacenado = "";
								$dv_almacenado = "";
							}


							if (set_value('inputGuionRut') != '') {
								$dv_almacenado = set_value('inputGuionRut');
							}
							else if (!isset($dv_almacenado)) {
								$dv_almacenado = "";
							}


							if (!isset($recordarme)) {
								$recordarme = "";
							}
							else if ($recordarme){
								$recordarme = "checked";
							}
							else {
								$recordarme = "";
							}
						?>
						<div class="control-group <?php echo $inputRut ?>" id="groupRut">
							<label class="control-label" for="inputRut">Rut</label>
							<div class="controls">
							  	<input style="width:200px" type="text" name="inputRut" id="inputRut" maxlength="9" placeholder=" Ingrese rut, ejemplo: 17565743" value="<?php echo $rut_almacenado; ?>">
							 	<STRONG>-</STRONG>
							  	<input style="width:15px" type="text" name="inputGuionRut" maxlength="1" id="inputGuionRut"  placeholder="k" value="<?php echo $dv_almacenado; ?>">
								<?php echo form_error('inputRut', '<span class="help-inline">', '</span>');?>
								<span id="spanInputRutError" class="help-inline"></span>
							</div>
						</div>
						<div class="control-group <?php echo $inputPassword ?>" id="groupPassword">
							<label class="control-label" for="inputPassword">Contraseña</label>
							<div class="controls">
								<input style="width:242px" type="password" name="inputPassword" id="inputPassword" placeholder="  Ingrese su contraseña" value="<?php echo set_value('inputPassword'); ?>">
								<?php echo form_error('inputPassword', '<span class="help-inline">', '</span>');?>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" name="recordarme_check" <?php echo $recordarme;?> >Recordarme&nbsp;
									<a href="<?php echo site_url("Login/olvidoPass")?>">¿Olvidó su contraseña?</a>
								</label>
								<div class="row">
									<div class="span4 offset1">
										<button type="submit" class="btn btn-primary">
											Entrar
										</button>	
									</div>
									<div class="span2">
										<img id="icono_cargando" src="/<?php echo config_item('dir_alias') ?>/img/procesando.gif" style="display:none; width:25px; height:25px;">
									</div>
								</div>				
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