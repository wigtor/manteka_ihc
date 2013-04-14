<!DOCTYPE html>
<html lang="es">
<?php
	echo $head						//Esta variable es pasada como parámetro a esta vista
?>
<body>

		
		<?php //NO SE DONDE PONER ESTA WEA PARA QUE SE VEA BIEN
			echo $barra_usuario		//Esta variable es pasada como parámetro a esta vista
		?>
		
		<?php
			echo $banner_portada;	//Esta variable es pasada como parámetro a esta vista
		?>
		
		
		<div>
		<?php
			echo $menu_superior;		//Esta variable es pasada como parámetro a esta vista
		?>
		</div>
		<div class="barra_superior_gradiente">
			
		</div>
		
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
					<!-- Barra de navegación con botones undo-redo -->
					
						<?php
							echo $barra_navegacion;
						?>
						<!--Body content-->
						<?php
							echo $cuerpo_central;		//Esta variable es pasada como parámetro a esta vista
						?>
					
				</div>
			</div>
		</div>
</body>
</html>

