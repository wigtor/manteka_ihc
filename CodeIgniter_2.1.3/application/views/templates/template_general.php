<!DOCTYPE html>
<html lang="en">
	<?php
		echo $head						//	Esta variable es pasada como parámetro a esta vista
	?>
<body>
	<!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">ManteKA</a>
        </div>



		<div class="navbar-collapse collapse">
			<?php
				echo $menu_superior;	//	Barra con los menú
			?>

			<?php
				echo $barra_usuario;	//	Barra con los datos del usuario logueado
			?>
		</div><!--/.nav-collapse -->



      </div>
    </div>

    <div class="container">
    	<?php
			//echo $banner_portada;	//	Banner del sitio Web
		?>

		<div class="row">
	    	<div class="col-md-12">
				<?php
					//	Se muestra un mensaje de alerta en caso de que se haya seteado. Se pasa desde el controlador.
					if (isset($mensaje_alert)) {
						echo $mensaje_alert; //	Mensaje de alerta
					}
				?>
			</div>
		</div>


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


		<?php
			echo $footer;
		?>
    </div> <!-- /container -->
</body>
</html>
