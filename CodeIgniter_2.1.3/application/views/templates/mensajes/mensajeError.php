<!--	Vista que entrega un mensaje determinado para el usuario.							-->
<!--	La clase del mensaje, es decir, su estilo depende del tipo de mensaje.				-->
<!--	El tipo de mensaje es determinado por la variable entregada desde el controlador	-->
<div class="alert alert-block 
	<?php
		// Tipo del mensaje
		echo $tipo_msj 
	?> fade in">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<h4>
		<?php
			// Título del mensaje
			echo $titulo_msj
		?>
	</h4>
	<?php
		// Cuerpo del mensaje
		echo $cuerpo_msj
	?>
</div>
