<!-- Barra superior que contiene el nombre del usuario, el menu, cerrar sesión y botón de ayuda -->

<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" id="drop_user" role="button" class="dropdown-toggle" data-toggle="dropdown">
			<span class="glyphicon glyphicon-wrench"> </span>
			Bienvenido(a) <?php echo $nombre_usuario; ?>
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop_user">
			<li role="presentation">
				<a href="<?php echo site_url("User/datosUsuario") ?>" title="Perfil de usuario y cambio de contraseña">
					<span class="glyphicon glyphicon-user"> </span>
					Perfil de usuario
				</a>
			</li>
			<li role="presentation">
				<a href="<?php echo site_url("Login/logout") ?>" title="Desconectarse de ManteKA">
					<span class="glyphicon glyphicon-off"></span>
					Desconectarse de ManteKA
				</a>
			</li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" id="drop_help" role="button" class="dropdown-toggle" data-toggle="dropdown">
			<span class="glyphicon glyphicon-question-sign"> </span>
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop_help">
			<li role="presentation">
				<a href="<?php echo site_url("Ayuda/preguntasFrecuentes") ?>"> Preguntas Frecuentes</a>
			</li>
			<li role="presentation">
				<a href="/<?php echo config_item('dir_alias') ?>/index.php/About/acercaNosotros"> Acerca de Nosotros</a>
			</li>
			<li role="presentation">
				<a href="/<?php echo config_item('dir_alias') ?>/manual_usuario.pdf" target="blank">Manual de Usuario</a>
			</li>
		</ul>
	</li>
</ul> 


<!--
<ul class="dropdown-menu nav navbar-nav navbar-right">
	<li class="divider"></li>
	<li class="dropdown-header">Bienvenido(a) <?php echo $nombre_usuario; ?></li>
	<a class="btn btn-xs" href="<?php echo site_url("User/datosUsuario") ?>" title="Perfil de usuario y cambio de contraseña">
		<i class="glyphicon-user"> </i>
	</a>
	<a class="btn btn-xs" href="<?php echo site_url("Login/logout") ?>" title="Desconectarse de ManteKA">
		<i class="glyphicon-off"> </i>
	</a>
</ul>

<ul class="dropdown-menu nav navbar-nav navbar-right">
	<li>
		<a href="<?php echo site_url("Ayuda/preguntasFrecuentes") ?>"> Preguntas Frecuentes</a>
	</li>
	<li>
		<a href="/<?php echo config_item('dir_alias') ?>/index.php/About/acercaNosotros"> Acerca de Nosotros</a>
	</li>
	<li>
		<a href="/<?php echo config_item('dir_alias') ?>/manual_usuario.pdf" target="blank">Manual de Usuario</a>
	</li>
</ul>
-->