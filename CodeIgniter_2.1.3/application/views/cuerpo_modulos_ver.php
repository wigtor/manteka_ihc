
<fieldset>
	<legend>M�dulos</legend>
	Instrucciones
	<br>
	<br>
	<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span4">
			1. Escoja un m�dulo de la lista
			<br>
			<br>
			<form class="navbar-search pull-left">
				<input type="text" class="search-query" placeholder="Filtro por nombre">
			</form>
			<br>
			<br>
			<br>
			<select multiple="multiple">
				<option>Comunicaci�n y Medios</option>
				<option>Estrategias de Comunicaci�n</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
			<br>
			<br>
		</div>
		
		<div class="span1">
			<?php
				/*$contador=0;
				while ($contador<count($rs_modulos)){
					
					echo '<tr>';
					echo	'<td  id="'.$contador.'" style="text-align:left;">'
					echo 	$rs_modulos[$contador][0].' '.$rs_modulos[$contador][1].' '.$rs_modulos[$contador][2].' '.$rs_modulos[$contador][3].' '.$rs_modulos[$contador][4];
					echo 	'</td>';
					echo '</tr>';
												
					$contador = $contador + 1;
				}*/
			?>
		</div>
		
		<div class="span7">
			2. Detalle m�dulo tem�tico
			<div class ="container-fluid">
				<div class ="row-fluid">
					<div class ="span5">
						<br>
						<b>Nombre del m�dulo: 
						<br>
						<br>
						<br>
						Profesor jefe: 
						<br>
						<br>
						<br>
						Lista de profesores: 
						<br>
						<br>
						<br>
						Secciones que lo cursan: </b>
						<br>
						<br>
					</div>
					
					<div class ="span7">
						<br>
						<b>Comunicaci�n y Medios</b>
						<br>
						<br>
						<br>
						<a href="//" target="Mauricio Mar�n">Mauricio Mar�n</a>
						<br>
						<br>
						<br>
						<select>
							<option>Edmundo Leiva</option>
							<option>Profe 2</option>
							<option>Profe 3</option>
							<option>Profe 4</option>
							<option>Profe 5</option>
						</select>
						<br>
						<br>
						<select>
							<option>A-01</option>
							<option>Cord 2</option>
							<option>Cord 3</option>
							<option>Cord 4</option>
							<option>Cord 5</option>
						</select>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
	
</fieldset>