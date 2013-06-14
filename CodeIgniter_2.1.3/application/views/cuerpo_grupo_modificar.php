<!--
<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/enviarCorreo.css" type="text/css" media="all" />
-->




<fieldset id="cuadroEnviar">
    <legend>&nbsp;Modificar Grupos de Contacto&nbsp;</legend>
	<div class="inicio" title="Paso 1: Selección de plantilla">
	<form action="<?php  ?>" method='post'>
	<?php
		$attributes = array();
		echo form_open('GruposContactos/editarGrupos',$attributes);
	?>
		<div class="texto1">
			Seleccione un Grupo de Contacto.
		</div>
		<div class="seleccion" >
		<select id="nombreGrupo" title="Grupos de Contacto" name="id_grupo">
		<?php for ($i = 0; $i < count($rs_nombres_contacto); $i++) { ?>
				  <option value ="<?php echo $rs_nombres_contacto[$i]['ID_FILTRO_CONTACTO']; ?>"><?php echo $rs_nombres_contacto[$i]['NOMBRE_FILTRO_CONTACTO']; ?></option>
		<?php } ?>
		
		</select>
		
		</div>
		
		
		<div class="row-fluid">
			<ul class="page pull-right">
			<button class ="btn" type="submit"  title="Avanzar a selección de contactos">Siguiente</button>
		</ul>
		</div>
	<?php echo form_close(""); ?>
	</div>
</fieldset>
<script type="text/javascript">

