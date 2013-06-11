<!DOCTYPE html>
<html lang="en">
	<?php
		echo $head						//	Esta variable es pasada como parámetro a esta vista
	?>
<body >
	<?php
			echo $banner_portada;	//	Banner del sitio Web
	?>
	<div id="body_google" style="
    	max-width: 50%;
    	margin-left: auto;
    	margin-right: auto;
	">
	<?php
		echo $body_google;
	?>	
	</div>
	<?php
		echo $footer;
	?>
</body>
</html>
