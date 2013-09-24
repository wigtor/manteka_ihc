<head>
	<!-- Acá poner el título, las importaciones de los css y javascript -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="/<?php echo config_item('dir_alias') ?>/img/icons/icon_manteka.png">
	<?php
		$mensajesNoLeidos = "";
		if (isset($numNoLeidos)) {
			if ($numNoLeidos > 0) {
				$mensajesNoLeidos = " (".$numNoLeidos.")";
			}
		}
	?>
	<title><?php echo $title.$mensajesNoLeidos ?></title>
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/bootstrap.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/bootstrap-fileupload.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/datepicker.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/personalizados.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/ant-sig.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/faq.css" type="text/css" media="all" />
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/jquery.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/faq.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-transition.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-alert.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-datepicker.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-datepicker.es.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-modal.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-dropdown.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-scrollspy.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-tab.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-tooltip.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-popover.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-button.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-collapse.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-carousel.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-typeahead.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrap-fileupload.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/bootstrapx-clickover.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/ant-sig.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/undo-redo.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/ckeditor/ckeditor.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/ckeditor/config.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/ckeditor/build-config.js"></script>
	<script src="/<?php echo config_item('dir_alias') ?>/ckeditor/styles.js"></script>

	<script src="/<?php echo config_item('dir_alias') ?>/javascripts/comunesFiltros.js"></script>
	<script>
	//Configura la apariencia de colores de los botones de la barra lateral
	$(document).ready(function() {
		$('.accordion-group').css("box-shadow", "0px 1px 1px rgba(0, 0, 0, 0) inset, 0px 0px 8px rgba(0, 0, 0, 0)")
		$(".in").parents('.accordion-group').css("box-shadow", "0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(82, 168, 236, 0.6)")

		$(".in").parents('.accordion-group').css("border-radius", "4px")
		$(".in").parents('.accordion-group').css("-moz-border-radius", "4px")
		$(".in").parents('.accordion-group').css("-webkit-border-radius", "4px")
		$('.accordion-heading').css("border-radius", "5px")
		$('.accordion-heading').css("background-color", "rgb(255, 255, 255)")
		$(".in").parents('.accordion-group').find('.accordion-heading').css("background-color", "rgb(248, 248, 248)")
		$(function() { 
			$('[rel="clickover"]').clickover(); 
		});
	});
	</script>

	<script>
		function actualizatNumCorreosNoLeidos() {
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Correo/postCantidadCorreosNoLeidos") ?>", /* Se setea la url del controlador que responderá */
				data: { },
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					var cantCorreos = parseInt(respuesta);
					var mensajesNoLeidos = "";
					if (cantCorreos > 0) {
						mensajesNoLeidos = " ("+cantCorreos+")";
					}
					var divBotonLateralCorreosRecibidos = document.getElementById('botonLateralCorreosRecibidos');
					var divBotonCorreosSuperior = document.getElementById('botonCorreosSuperior');
					var titleDelHtml = document.title;
					document.title = "<?php echo $title; ?>" + mensajesNoLeidos;
					if (divBotonCorreosSuperior != undefined) {
						//$(divBotonCorreosSuperior).html(mensajesNoLeidos);
						divBotonCorreosSuperior.innerHTML = mensajesNoLeidos;
					}
					if (divBotonLateralCorreosRecibidos != undefined) {
						//$(divBotonLateralCorreosRecibidos).html(mensajesNoLeidos);
						divBotonLateralCorreosRecibidos.innerHTML = mensajesNoLeidos;
					}
					setTimeout("actualizatNumCorreosNoLeidos()", 20*1000); //Cada 20 segundos
				}
			});
		}
		setTimeout("actualizatNumCorreosNoLeidos()", 20*1000); //Cada 20 segundos
	</script>
</head>
