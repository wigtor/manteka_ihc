<!DOCTYPE html>
<html lang="en">
	<?php
		echo $head						//Esta variable es pasada como parámetro a esta vista
	?>
<body >
	<div id="wrap">
		<?php //NO SE DONDE PONER ESTO PARA QUE SE VEA BIEN
			echo $barra_usuario		//Esta variable es pasada como parámetro a esta vista
		?>
		<?php
			echo $banner_portada;	//Esta variable es pasada como parámetro a esta vista
		?>
		<?php
			echo $menu_superior;		//Esta variable es pasada como parámetro a esta vista
		?>
		<!-- Ahora debe ir el código de la barra lateral y la carga de la vista más interna -->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					<!--Sidebar content-->
					<?php
						echo $barra_lateral;		//Esta variable es pasada como parámetro a esta vista
					?>
				</div>
				<div class="span10">
					<div>
						<?php
							//Se muestra un mensaje de alerta en caso de que se haya seteado
							if (isset($mensaje_alert)) {
								echo $mensaje_alert;		//Esta variable es pasada como parámetro a esta vista
							}
						?>
					
					</div>
					
					<!-- Barra de navegación con botones undo-redo -->
					<div style="min-height: 310px">
						<?php
							if (!isset($mostrarBarra_navegacion)) {
								echo $barra_navegacion;
							}
							else if ($mostrarBarra_navegacion == TRUE){
								echo $barra_navegacion;
							}
							//Si no está entonces no se hace ningún echo
						?>
						<!--Body content-->
						<?php
							echo $cuerpo_central;		//Esta variable es pasada como parámetro a esta vista
						?>
					</div>
					<div class="row-fluid">
						<?php
							echo $barra_progreso_atras_siguiente;		//Esta variable es pasada como parámetro a esta vista
						?>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php
		echo $footer;
	?>
	</body>
</html>
