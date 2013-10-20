<?php

/**
 * El presente archivo corresponde a la vista para eliminar plantillas del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Vistas
 * @author Diego García (DGM)
 **/
 
?>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<title>Agregar plantilla</title>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/borrarPlantillas.css" type="text/css" media="all"/>
		
		<script type="text/javascript">
	   /**
		* Hace que el cuerpo de la plantilla sea de sólo lectura.
		* 
		* Cuando se carga la instancia de ckeditor, permite que el contenido del 'textarea' no sea editable.
		* 
		* @author Diego García (DGM)
		**/
		var editor;
		CKEDITOR.on('instanceReady', function( ev )
		{
			editor = ev.editor;
			editor.setReadOnly(true);
		});
		</script>
		
		
		<script type="text/javascript">
	   /**
		* Muestra la vista previa de una plantilla.
		* 
		* Carga los datos de la plantilla seleccionada en los campos que conforman la vista previa de la plantilla.
		* Se invoca al seleccionar una plantilla de la lista de plantillas existentes en el sistema.
		* 
		* @author Diego García (DGM)
		* @param string $asunto Corresponde al asunto de la plantilla seleccionada.
		* @param string $cuerpo Corresponde al mensaje principal o cuerpo de la plantilla seleccionada.
		* @param int $id Corresponde al número identificador o clave primaria de la plantilla seleccionada.
		**/
		function VistaPrevia(asunto, cuerpo, id)
		{
			var t=document.getElementById('tbl'); 
			var f=t.getElementsByTagName('td'); 
			for(var q=0;q<f.length;++q) 
			{
				$('#'+f[q].id).css("background-color","white"); 
			}
			$('#'+id).css("background-color","#F0F0F0");
			document.getElementById('idPlantilla').value=id;
			document.getElementById('inputAsunto').value=asunto;
			cuerpo=cuerpo.replace('&#39;','\'');
			cuerpo=cuerpo.replace('&#34;','"');
			CKEDITOR.instances.editor.setData (cuerpo);
		}
		</script>
		
		
		<script type="text/javascript">
	   /**
		* Envia al controlador, la plantilla que se desea eliminar.
		* 
		* Antes de enviar la orden al controlador, se valida que haya sido seleccionada una plantilla.
		* Además se muestra un mensaje al usuario para confirmar la operación.
		* Esta función se invoca al presionar el botón 'Borrar plantilla' de la vista.
		* 
		* @author Diego García (DGM)
		**/
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
	   /**
	    * Filtra las plantillas existentes en el sistema según los criterios ingresados por el usuario. 
		*
		* Filtra las plantillas que cumplen los siguientes criterios: 
		* 1. Contienen un campo que coincide con el texto de búsqueda ingresado por el usuario.
		* 2. El campo que coincide con el texto de búsqueda, es del mismo tipo que el especificado en el 'select' para filtrar resultados.   
		* 
		* @author Diego García (DGM) (Función extraida y modificada a partir de la vista para editar alumnos creada por el grupo 4)
		**/
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
				echo 'resultados['.$countPlantilla.'][3] = "'.htmlentities($plantillas[$countPlantilla]->CUERPO_PLANTILLA).'";';
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
		
		<script type="text/javascript">
	   /**
	    * Reestablece el filtro de búsqueda.  
		* 
		* @author Diego García (DGM)
		**/
		function limpiar()
		{
			document.getElementById('busquedaPlantilla').value="";
			filtrarPlantillas();
		}
		</script>
	</head>
	
	<body>
	<fieldset>
	<legend>&nbsp;Borrar plantillas&nbsp;</legend>
	
	<?php
	/**
	* Muestra mensajes informativos al usuario. 
	* 
	* Dependiendo de las variables recibidas desde
	* el controlador, se muestran distintos mensajes
	* al usuario, según corresponda.
	* 
	* @author Diego García (DGM)
	**/
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
	
	$noVacio=true;
	$comilla="'";
	if( count($plantillas) === 0)
	{
		$noVacio=false;
	}
	else
	{
		/**
		* Muestra los elementos necesarios para realizar la búsqueda de una plantilla y filtrar los resultados. 
		* 
		* Para la búsqueda de la plantilla el usuario puede ingresar cualquier texto.
	    * La búsqueda puede ser filtrada por nombre, asunto o cuerpo de la plantilla.
		* 
		* @author Diego García (DGM) (Código extraido y modificado a partir de la vista para editar alumnos creada por el grupo 4)
		**/
		?>
		<div id="contenedorBusquedaFiltro">
		
		<div id="filtro1">
			<div class="txttt">
			Búsqueda
			</div>
			
			<div id="busqueda">
			<div class="input-append span9">
				<input id="busquedaPlantilla" size="40" maxlength="40" class="span9" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
				<button class="btn" onClick="filtrarPlantillas()" title="Iniciar una búsqueda" type="button"><i class="icon-search"></i></button>
			</div> 
				<button class="btn" onClick="limpiar()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
		
		<div id="filtro2">
			<div class="txttt">
			Filtrar resultados
			</div>
			
			<div id="filtroBusqueda">
			<select id="tipoBusqueda" style="height:30px;color:#999999;" size="1" onchange="limpiar()" title="Filtrar resultados" >
			<option value="1" selected>Filtrar por nombre</option>
			<option value="2"><b>Filtrar por asunto</b></option>
			<option value="3">Filtrar por cuerpo</option>
			</select>
			</div>
		</div>
		
		</div>
		
		<?php
	}
	
   /**
	* Muestra la lista de plantillas existentes en el sistema. 
	* 
	* En la lista se muestra sólo el nombre de las plantillas.	
	* 
	* @author Diego García (DGM)
	**/
	?>
	<div id="contenedorLista">
	
	<div class="txttt">
	Plantillas
	</div>
	
	<div id="lista">
	<table id="tbl" class="table table-hover">
	<tbody>
	<?php
	if( $noVacio === false)
	{
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
			echo '<td id="'.$plantilla->ID_PLANTILLA.'" onclick="javascript:VistaPrevia('.$comilla.$plantilla->ASUNTO_PLANTILLA.$comilla.', '.$comilla.str_replace('"','&#34;', str_replace('\'','&#39;', $plantilla->CUERPO_PLANTILLA)).$comilla.', '.$comilla.$plantilla->ID_PLANTILLA.$comilla.');" style="text-align:left;">'.$plantilla->NOMBRE_PLANTILLA.'</td>';
			echo '</tr>';
		}
	}
	?>
	</tbody>
	</table>
	</div>
	
	</div>
	
	<?php
	/* Este código sólo se ejecuta cuando existe al menos una plantilla almacenada en el sistema. */
	if($noVacio===true)
	{
	   /**
		* Muestra la vista previa de una plantilla seleccionada.
		* 
		* Esta vista previa no puede ser editada.
		* 
		* @author Diego García (DGM)
		**/
		?>
		<div id="contenedorEditor">
		<div class="txttt2">
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
		<input name="idPlantilla" type="hidden" id="idPlantilla">
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