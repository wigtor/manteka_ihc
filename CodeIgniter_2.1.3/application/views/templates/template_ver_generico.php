<script src="/<?php echo config_item('dir_alias') ?>/javascripts/<?php echo $nombreJS ?>.js"></script>
<fieldset>
	<legend>Ver <?php echo $nombreView?></legend>
	<div class="row-fluid">
		<div class="span6">
			<div class="row-fluid">
				<div class="span6">
					1.- Lista de <?php echo $nombreView?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span11">
					<div class="row-fluid">
						<div class="span6">
							<input id="<?php echo $idInputFiltro?>" type="text" onChange="<?php echo $nombreFncCambiarTipoFiltro?>()" placeholder="Filtro búsqueda" style="width:90%">
						</div>
						<div class="span6">
							<select id="<?php echo $idSelectFiltro?>" onChange="<?php echo $nombreFncCambiarTipoFiltro?>()" title="Tipo de filtro" name="Filtro a usar">
								<?php
									foreach ($OpcionesFiltro as $opcion)
									{
										echo "<option value=".$opcion['id'].">".$opcion['nombre']."</option>"
									}
								?>
								<!--<option value="1">Filtrar por nombre</option>
								<option value="2">Filtrar por apellido paterno</option>
								<option value="3">Filtrar por apellido materno</option>
								<option value="4">Filtrar por carrera</option>
								<option value="5">Filtrar por seccion</option>
								<option value="6">Filtrar por bloque horario</option>-->
							</select> 
						</div>
					</div>
				</div>
			</div>

			
			<div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<b>Nombre Completo</b>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle <?php echo $nombreView ?>:
	    <pre style="margin-top: 2%; padding: 2%">
	    	<?php
	    		foreach ($ListaInformacion as $informacion)
	    		{
	    			echo $informacion['nombre'].":"."\t"."<b id=".$informacion['idCampo']."></b>";
	    		} 

	    	?>

    	<!--
			Rut:              <b id="rutDetalle"></b>
			Nombres:          <b id="nombre1Detalle"></b> <b id="nombre2Detalle" ></b>
			Apellido paterno: <b id="apellido1Detalle" ></b>
			Apellido materno: <b id="apellido2Detalle"></b>
			Carrera:          <b id="carreraDetalle" ></b>
			Sección:          <b id="seccionDetalle"></b>
			Correo:           <b id="correoDetalle"></b>
		-->
		</pre>
		</div>
	</div>
</fieldset>