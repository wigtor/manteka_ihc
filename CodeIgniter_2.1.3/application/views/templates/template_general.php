<!DOCTYPE html>
<html lang="en">
	<?php
		echo $head						//	Esta variable es pasada como parámetro a esta vista
	?>
<body>
	<div id="wrap" style="min-width:1000px;">
		<?php
			echo $banner_portada;	//	Banner del sitio Web
		?>
		<div class="row-fluid">
			<div class="span2">
				<?php
					echo $barra_usuario		//	Barra de control de usuario
				?>
			</div>
			<div class="span9">
				<?php
					echo $menu_superior;	//	Barra con los menúes
				?>
			</div>

		</div>
		<!-- Ahora debe ir el código de la barra lateral y el contenido de la operación -->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					<!--Sidebar content-->
					<?php
						echo $barra_lateral;		//	Barra Lateral
					?>
				</div>
				<div class="span10">
					<div>
						<?php
							//	Se muestra un mensaje de alerta en caso de que se haya seteado. Se pasa desde el controlador.
							if (isset($mensaje_alert)) {
								echo $mensaje_alert;		//	Mensaje de alerta
							}
						?>
					
					</div>
					
					<!-- Barra de navegación con botones undo-redo -->
					<div style="min-height: 310px" class="undoable">
						<?php
							//	Se asume por defecto que la barra de undo-redo se carga
							//	Si la variable no ha sido seteada, se muestra la barra de navegación
							if (!isset($mostrarBarra_navegacion)) {
								echo $barra_navegacion;
							}
							//	Si la variable está seteada en TRUE, cargar la barra undo-redo
							else if ($mostrarBarra_navegacion == TRUE){
								echo $barra_navegacion;
							}
							//	Si no está entonces no se carga la barra
						?>
						
						<!--	Body content									-->
						<!--	Cuerpo central de la operación (de la vista)	-->
						<?php
							echo $cuerpo_central;		//	Cuerpo central pasado como parámetro desde el controlador
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
