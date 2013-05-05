<!-- Barra superior que contiene el nombre del usuario, el menu, cerrar sesión y botón de ayuda -->
		<ul class="nav nav-pills pull-right" style="position: absolute; width:100%; min-width:820px;">
			<li class="active  pull-right">
				<a style="font-size: 12px; padding-bottom: 5px; padding-top: 6px; padding-left: 10px; padding-right: 10px;" href="#">
					 <?php echo "Ayuda"?> </a>
			</li>
				<li class="dropdown active pull-right" style ="padding-left: 2px; padding-bottom: 0px;">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-size: 12px; padding-bottom: 5px; padding-top: 6px; padding-left: 8px; padding-right: 5px;">
				        <?php echo $nombre_usuario; ?>
				        <b class="caret"></b>
					</a>
				    <ul class="dropdown-menu">
				    	<li>
							<a href="/<?php echo config_item('dir_alias') ?>/index.php/User">Configurar Perfil</a>
				    	</li>
				    	<li>
							<a href="/<?php echo config_item('dir_alias') ?>/index.php/Login/logout">Cerrar Sesión</a>
				    	</li>
				    </ul>
				</li>
			
		</ul>
