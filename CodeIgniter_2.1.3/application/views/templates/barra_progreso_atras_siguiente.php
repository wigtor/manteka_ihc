<!-- Barra con los botones undo y redo -->
<?php
	if ($mostrarBarraProgreso) {
		
		echo '<div class="span7">
			<div class="progress progress-striped active">
				<div class="bar progress_bar" style="width: 20%;"><p class="letra_progress_bar">Paso 1</div>
				<div class="bar progress_bar " style="width: 20%;"><p class="letra_progress_bar">Paso 2</p></div>
				<div class="bar progress_bar" style="width: 20%;"><p class="letra_progress_bar">Paso 3</p></div>
			</div>
		</div>
		<div class="span5">
			<div class="row-fluid">
				<ul class="pager pull-right" style="margin:0">
					<li><a href="#"><div class="btn_with_icon_solo">&#60;</div> &nbsp; Atrás</a></li>
					<li><a href="#"><div class="btn_with_icon_solo">&#61;</div> &nbsp; Siguiente</a></li>
					<li><a href="#"><div class="btn_with_icon_solo">Â</div> &nbsp; Cancelar</a></li>
				</ul>
			</div>
		</div>';
	}
?>