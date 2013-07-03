<?php

/**
 * El presente archivo corresponde a la vista para editar plantillas en el sistema Manteka.
 *
 * @package Manteka
 * @subpackage Vistas
 * @author Diego García (DGM)
 **/
 
?>
<html>

	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<title>Editar plantilla</title>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/editarPlantillas.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/agregarPlantillas.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/ventanaModal.css" type="text/css" media="all"/>
		
		<script type="text/javascript">
	   /**
		* Hace que el cuerpo de la plantilla no sea de sólo lectura.
		* 
		* Cuando se carga la instancia de ckeditor, permite que el contenido del 'textarea' sea editable.
		* 
		* @author Diego García (DGM)
		**/
		var editor;
		CKEDITOR.on('instanceReady', function( ev )
		{
			editor = ev.editor;
			editor.setReadOnly(false);
		});
		</script>
		
		<script type='text/javascript'>
	   /**
		* Permite mostrar y ocultar la ventana modal que informa sobre el uso
		* de variables para la creación de plantillas.
		* 
		* Al hacer clic en el vínculo cuyo clase es "verVariables" se muestra
		* la ventana modal. Y al hacer click en el botón cuyo identificador es
		* "botonCerrar" se oculta dicha ventana.
		* 
		* @author Diego García (DGM)
		**/
		$(document).ready(function() {
			$('.verVariables').click(function() {
				type=$(this).attr('data-type');
				$('.contenedor-principal').fadeIn(function() {
				window.setTimeout(function(){
					$('.contenedor-secundario.'+type).addClass('contenedor-secundario-visible');
				}, 100);
				});
			});
			$('#botonCerrar').click(function() {
				document.documentElement.style.overflowY='auto';
				$('.contenedor-principal').fadeOut().end().find('.contenedor-secundario').removeClass('contenedor-secundario-visible');
			});
		});
		</script>
		
		<script type='text/javascript'>
	   /**
		* Oculta la barra de scroll vertical del navegador.
		* 
		* Se utiliza para ocultar el scroll vertical del navegador
		* al momento de mostrar la ventana modal que informa sobre el uso
		* de variables en la creación de plantillas.
		* 
		* @author Diego García (DGM)
		**/
		function ocultarScroll()
		{
			document.documentElement.style.overflowY='hidden';
		}
		</script>
		
		
		<script type="text/javascript">
	   /**
		* Muestra la vista previa de una plantilla.
		* 
		* Carga los datos de la plantilla seleccionada en los campos que conforman la vista previa de la plantilla.
		* Se invoca al seleccionar una plantilla de la lista de plantillas existentes en el sistema.
		* 
		* @author Diego García (DGM)
		* @param string $nombre Corresponde al nombre de la plantilla seleccionada.
		* @param string $asunto Corresponde al asunto de la plantilla seleccionada.
		* @param string $cuerpo Corresponde al mensaje principal o cuerpo de la plantilla seleccionada.
		* @param int $id Corresponde al número identificador o clave primaria de la plantilla seleccionada.
		**/
		function VistaPrevia(nombre, asunto, cuerpo, id)
		{
			var t=document.getElementById('tbl'); 
			var f=t.getElementsByTagName('td'); 
			for(var q=0;q<f.length;++q) 
			{
				$('#'+f[q].id).css("background-color","white"); 
			}
			$('#'+id).css("background-color","#F0F0F0");
			document.getElementById('nombrePlantilla').value=nombre;
			document.getElementById('idPlantilla').value=id;
			document.getElementById('asunto').value=asunto;
			cuerpo=cuerpo.replace('&#39;','\'');
			cuerpo=cuerpo.replace('&#34;','"');
			CKEDITOR.instances.editor.setData(cuerpo);
			$('#'+id).css("background-color","#F0F0F0");
		}
		</script>
		
		
		<script type="text/javascript">
	   /**
		* Envia al controlador, el formulario con los cambios realizados a la plantilla seleccionada.
		* 
		* Antes de enviar el formulario con los cambios, se valida que haya sido seleccionada una plantilla.
		* Además se muestra un mensaje al usuario para confirmar la operación.
		* Esta función se invoca al presionar el botón 'Guardar cambios' del formulario.
		* 
		* @author Diego García (DGM)
		**/
		function editarPlantilla()
		{
			var id_plantilla=document.getElementById('idPlantilla').value;
			if(id_plantilla.trim() != '')
			{
				if (confirm('Está a punto de modificar la plantilla seleccionada.\n¿Realmente desea continuar?'))
				{	 
					formEditarPlantillas.submit();
				}
			}
			else
			{
				alert('Debe seleccionar la plantilla a editar.');
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
	<legend>&nbsp;Editar plantillas&nbsp;</legend>
	
	<?php
	/**
	* Ventana modal sobre el uso de variables en la creación de plantillas.
	* 
	* Muestra información relevante al usuario, sobre como incluir
	* variables en las plantillas.
	*
	* @author Diego García (DGM)
	**/
	?>
		
	<div class="contenedor-principal">	
	<div class="contenedor-secundario zoomout">
	<div class="tituloModal">
	Estimado usuario
	</div>
	<div class="txtModal">
	Las variables predefinidas permiten definir segmentos de texto dentro de una plantilla, que tomarán distintos valores según las características del mensaje o la lista de destinatarios a utilizar.
	El valor de estas variables será asignado automáticamente al momento de realizar el envío de un correo electrónico.
	</div>
	<div class="txtModal">
	Para definir una variable anteponga los caracteres  <font color="blue">%%</font>  antes del nombre de dicha variable.
	</div>
	<div class="txtModal">
	<div id="salto">Las variables predefinidas que puede utilizar son:</div>
	<div class="txtLabel">%%nombre</div><div class="txtDescripcion">Asigna el nombre y apellido del receptor del correo electrónico.</div>
	<div class="txtLabel">%%rut</div><div class="txtDescripcion">Asigna el rut del receptor del correo electrónico.</div>
	<div class="txtLabel">%%carrera_estudiante</div><div class="txtDescripcion">Asigna la carrera a la que pertenece el estudiante receptor del correo electrónico.</div>
	<div class="txtLabel">%%seccion_estudiante</div><div class="txtDescripcion">Asigna la sección a la que pertenece el estudiante receptor del correo electrónico.</div>
	<div class="txtLabel">%%modulo_estudiante</div><div class="txtDescripcion">Asigna el módulo temático al que pertenece el estudiante receptor del correo electrónico.</div>
	<div class="txtLabel">%%hoy</div><div class="txtDescripcion">Asigna la fecha actual al momento de realizar el envío.</div>
	<div class="txtLabel">%%remitente</div><div class="txtDescripcion">Asigna el nombre del usuario que realiza el envío del correo electrónico.</div>
	</div>
	<span id="botonCerrar" class="btn btn-primary">Cerrar</span>
	</div>
	</div>
		
	<div id="txtInformativo" class="txt" style="margin-left:1%;margin-bottom:30px;">
	<div id="txt1" style="text-align:justify;margin-right:2%;">
	La utilización de plantillas permite definir variables cuyos valores serán asignados automáticamente por el sistema, al momento de enviar un correo.
	</div>
	<div id="txt2">
	Para obtener más información sobre el uso de variables haga clic <a href="#" onclick="ocultarScroll()" class="verVariables" data-type="zoomout">acá</a>
	<div id="boxes">
	<div id="dialog" class="window"> 
	</div>
	<div id="mask">
	</div>
	</div>
	</div>
	</div>
	
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
		if($msj[0]=='1')
		{
			?>
			<div class="alert alert-success" id="msjOk">
    		<button type="button" class="close" id="btnMsjOk" data-dismiss="alert">&times;</button>
    		La plantilla ha sido modificada satisfactoriamente !!!
			</div>	
			<?php
		}
		else if($msj[0]=='0')
		{
			?>
			<div class="alert alert-error" id="msjError">
			<button type="button" class="close" id="btnMsjError" data-dismiss="alert">&times;</button>
			Por favor corrija los siguientes errores:
			</br>
			</br>
			<?php
			echo validation_errors();
			if(isset($msj[5]))
			{
				?>
				Ya existe una plantilla con el nombre especificado. Utilice otro nombre.
				<?php
			}
			?>
			</div>		
			<?php
		}
		else if($msj[0]=='2')
		{
			?>
			<div class="alert alert-error" id="msjError">
			<button type="button" class="close" id="btnMsjError2" data-dismiss="alert">&times;</button>
			A ocurrido un error interno. Inténtelo más tarde.
			</div>		
			<?php
		}
		$idPrevio=$msj[1];
		$nombrePrevio=$msj[2];
		$asuntoPrevio=$msj[3];
		$cuerpoPrevio=utf8_encode($msj[4]);
		unset($msj);
	}
	else
	{
		$idPrevio='';
		$nombrePrevio='';
		$asuntoPrevio='';
		$cuerpoPrevio='';
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
			/* Al seleccionar una plantilla de la lista se muestra una vista previa de esta. */
			echo '<tr>';
			echo '<td id="'.$plantilla->ID_PLANTILLA.'" onclick="javascript:VistaPrevia('.$comilla.$plantilla->NOMBRE_PLANTILLA.$comilla.', '.$comilla.$plantilla->ASUNTO_PLANTILLA.$comilla.', '.$comilla.str_replace('"','&#34;', str_replace('\'','&#39;', $plantilla->CUERPO_PLANTILLA)).$comilla.', '.$comilla.$plantilla->ID_PLANTILLA.$comilla.');" style="text-align:left;">'.$plantilla->NOMBRE_PLANTILLA.'</td>';
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
		* Esta vista previa puede ser editada y posteriormente guardar los cambios
		* realizados a la plantilla.
		* Se puede editar el nombre, el asunto y el cuerpo de la plantilla.
		* 
		* @author Diego García (DGM)
		**/
		?>
		<div id="contenedorEditor">
		<div class="txttt2">
		Vista previa
		</div>
		
		<?php
		$atributos = array('class' => 'form', 'id' => 'formEditarPlantillas', 'name'=>'formEditarPlantillas');
		echo form_open('plantillas/editarPlantillas', $atributos);
		
		echo "<div class='etiqueta'>";
		echo form_label("Nombre de la plantilla");
		$atributos = array('id' => 'nombrePlantilla', 'size' => '30', 'name' => 'nombrePlantilla', 'onkeyup'=>"if( event.keyCode==226 || this.value.indexOf('\'') != -1 || this.value.indexOf('&') != -1 || this.value.indexOf('/') != -1 || this.value.indexOf('\&quot;') != -1) this.value='';
		", 'maxlength' => '40', 'placeHolder'=>'Máximo 40 caracteres', 'value'=>$nombrePrevio);
		echo form_input($atributos);
		echo "</div>";
		
		echo "<div class='etiqueta'>";
		echo form_label("Asunto");
		$atributos = array('id' => 'asunto', 'size' => '30', 'name' => 'asunto', 'onkeyup'=>"if( event.keyCode==226 || this.value.indexOf('\'') != -1 || this.value.indexOf('&') != -1 || this.value.indexOf('/') != -1 || this.value.indexOf('\&quot;') != -1) this.value='';
		", 'maxlength' => '40', 'placeHolder'=>'Máximo 40 caracteres', 'value'=>$asuntoPrevio);
		echo form_input($atributos);
		echo "</div>";
		
		echo "<div class='etiqueta2'>";
		echo form_label("Cuerpo del mensaje");
		$atributos = array('id'=>'editor', 'class'=>'ckeditor', 'name'=>'editor', 'value'=>$cuerpoPrevio);
		echo form_textarea($atributos);
		echo "</div>";
		
		$atributos = array('id' => 'idPlantilla', 'name' => 'idPlantilla', 'value'=>$idPrevio, 'type'=>'hidden');
		echo form_input($atributos);
		
		echo "<div id='contenedorBotones'>";
		$atributos = array('id' => 'btnCrear', 'name' => 'btnCrear', 'class' =>'btn btn-primary', 'onclick'=>'editarPlantilla();');
		echo form_button($atributos, 'Guardar cambios');
		echo "</div>";
		
		echo form_close();
		?>
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