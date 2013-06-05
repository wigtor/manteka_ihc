<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<title>Agregar plantilla</title>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/borrarPlantillas.css" type="text/css" media="all"/>
		
		<script type="text/javascript">
		var editor;
		CKEDITOR.on('instanceReady', function( ev )
		{
			editor = ev.editor;
			editor.setReadOnly(true);
		});
		</script>
		
		<script type="text/javascript">
		function VistaPrevia(asunto, cuerpo, id)
		{
			document.getElementById('idPlantilla').value=id;
			document.getElementById('inputAsunto').value=asunto;
			CKEDITOR.instances.editor.setData (cuerpo);
		}
		</script>
		
		<script type="text/javascript">
		function eliminarPlantilla()
		{
			var id_plantilla=document.getElementById('idPlantilla').value;
			if(id_plantilla.trim() != '')
			{
				if (confirm('Está a punto de eliminar la plantilla seleccionada.\n¿Realmente desea continuar?'))
				{	 
					formBorrarPlantillas.submit();
				}
			}
			else
			{
				alert('Debe seleccionar la plantilla a eliminar.');
			}
		}
		</script>
		
		<script type="text/javascript">
		function filtrarPlantillas()
		{
			var busqueda = document.getElementById('busquedaPlantilla').value;
			var tipoBusqueda = document.getElementById('tipoBusqueda').value;	
			var resultados = new Array();
			var plantilla;
			var ocultar;
			var count;
			<?php
			$countPlantilla = 0;
			while( $countPlantilla < count($plantillas) )
			{
				echo 'resultados['.$countPlantilla.']=new Array();';
				echo 'resultados['.$countPlantilla.'][0] = "'.$plantillas[$countPlantilla]->ID_PLANTILLA.'";';
				echo 'resultados['.$countPlantilla.'][1] = "'.$plantillas[$countPlantilla]->NOMBRE_PLANTILLA.'";';
				echo 'resultados['.$countPlantilla.'][2] = "'.$plantillas[$countPlantilla]->ASUNTO_PLANTILLA.'";';
				echo 'resultados['.$countPlantilla.'][3] = "'.strip_tags($plantillas[$countPlantilla]->CUERPO_PLANTILLA).'";';
				$countPlantilla=$countPlantilla+1;
			}
			?>
			for( count=0; count < resultados.length; count++ )
			{
				plantilla = document.getElementById(resultados[count][0]);
				ocultar=document.getElementById(resultados[count][0]);
				if( 0 > resultados[count][Number(tipoBusqueda)].toLowerCase().indexOf(busqueda.toLowerCase()) )
				{
					ocultar.style.display='none';
				}
				else
				{
					ocultar.style.display='block';
				}
			}	
		}
		</script>
	</head>
	
	<body>
	<fieldset>
	<legend>&nbsp;Borrar plantillas&nbsp;</legend>
	
	<?php
	if(isset($msj))
	{
		if($msj=='1')
		{
			?>
			<div class="alert alert-success" id="msjOk">
    		<button type="button" class="close" id="btnMsjOk" data-dismiss="alert">&times;</button>
    		La plantilla ha sido borrada satisfactoriamente !!!
			</div>	
			<?php
		}
		else if($msj=='2')
		{
			?>
			<div class="alert alert-error" id="msjError">
			<button type="button" class="close" id="btnMsjError" data-dismiss="alert">&times;</button>
			A ocurrido un error interno. Inténtelo más tarde.
			</div>		
			<?php
		}
		unset($msj);
	}
	?>
	<div id="contenedorLista">
	
	<div class="txt">
	Plantillas
	</div>
	
	<div id="lista">
	<table class="table table-hover">
	<tbody>
	<?php
	$noVacio=true;
	$comilla="'";
	if( count($plantillas) === 0)
	{
		$noVacio=false;
		?>
		<div id="sinPlantillas">
		No existen plantillas guardadas.
		</div>
		<?php
	}
	else
	{
		foreach($plantillas as $plantilla)
		{
			echo '<tr>';
			echo '<td id="'.$plantilla->ID_PLANTILLA.'" onclick="javascript:VistaPrevia('.$comilla.$plantilla->ASUNTO_PLANTILLA.$comilla.', '.$comilla.htmlentities($plantilla->CUERPO_PLANTILLA).$comilla.', '.$comilla.$plantilla->ID_PLANTILLA.$comilla.');" style="text-align:left;">'.$plantilla->NOMBRE_PLANTILLA.'</td>';
			echo '</tr>';
		}
	}
	?>
	</tbody>
	</table>
	</div>
	
	</div>
	
	<?php
	if($noVacio===true)
	{
		?>
		<div id="contenedorBusquedaFiltro">
		
		<div class="txt">
		Búsqueda
		</div>
		
		<div id="busqueda">
		<input id="busquedaPlantilla" maxlength="40" onkeyup="filtrarPlantillas()" type="text" placeholder="Ingrese el texto a buscar">
		</div>
		
		<div class="txt">
		Filtrar resultados
		</div>
		
		<div id="filtroBusqueda">
		<select id="tipoBusqueda" size="1" onchange="filtrarPlantillas()" title="Filtrar resultados" >
		<option value="1" selected>Filtrar por nombre</option>
		<option value="2"><b>Filtrar por asunto</b></option>
		<option value="3">Filtrar por cuerpo</option>
		</select>
		</div>
		
		</div>
		
		<div class="separador">
		</div>
		<div id="contenedorEditor">
		<div class="txt2">
		Vista previa
		</div>
		
		<div id="contenedorAsunto">
		<input id="inputAsunto" readonly="true" type="text" placeHolder="Asunto">
		</div>
		
		<?php
		$atributos = array('class' => 'form', 'id' => 'formBorrarPlantillas', 'name'=>'formBorrarPlantillas');
		echo form_open('plantillas/borrarPlantillas', $atributos);
		$atributos = array('id'=>'editor', 'class'=>'ckeditor', 'name'=>'editor');
		echo form_textarea($atributos);
		?>
		<input name="idPlantilla" type="hidden" id="idPlantilla" maxlength="6">
		<?php
		echo form_close();
		?>
		</div>
		<div id="contenedorBotones">
		<button class="btn btn-primary" onclick="eliminarPlantilla();" type="button">
		Borrar plantilla
		</button>
		</div>
		<?php
	}
	else
	{
		?>
		<div class="espacio">
		</div>
		<?php
	}
	?>
	
	</fieldset>
	</body>
	
</html>