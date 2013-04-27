<!-- Barra superior que contiene el nombre del usuario, el menu, cerrar sesión y botón de ayuda -->
<!-- <div class="navbar barra_usuario"> -->
	<!-- <div class="navbar-inner hacerTransparente"> -->
		<ul class="nav nav-pills pull-right" style="position: absolute; width:100%; min-width:820px;">
			<li class="active  pull-right">
				<a style="font-size: 12px; padding-bottom: 5px; padding-top: 6px; padding-left: 10px; padding-right: 10px;" href="#">
					 <?php echo "Ayuda"?> </a>
			</li>
			<li>
				<!--button class="btn btn_sin_padding btn-primary dropdown-toggle" data-toggle="dropdown" href="#"> -->
					<?php  ?>
					<!-- <span class="caret"></span>
				</button> -->
				<li class="dropdown active btn_with_icon pull-right" style ="padding-left: 2px; padding-bottom: 0px;">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 12px; padding-bottom: 5px; padding-top: 6px; padding-left: 8px; padding-right: 5px;">
				        <?php echo $rut_usuario ?>
				        <b class="caret"></b>
				      </a>
				    <ul class="dropdown-menu">
				    	<li>
							<a href="#">Modificar Usuario</a>
				    	</li>
				    	<li>
							<a href="/<?php echo config_item('dir_alias') ?>/index.php/Login/cambiarContrasegna">Cambiar contraseña</a>
				    	</li>
				    	<li>
							<a href="/<?php echo config_item('dir_alias') ?>/index.php/php/logout">Cerrar Sesión</a>
				    	</li>
				    </ul>
					</li>
			</li>
			
		</ul>
	<!--</div> -->