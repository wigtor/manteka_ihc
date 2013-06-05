<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<title>Agregar plantilla</title>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/agregarPlantillas.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/ventanaModal.css" type="text/css" media="all"/>
		
		<script type='text/javascript'>
		$(document).ready(function(){
			$("formAgregarPlantillas").submit(function(e){
			e.preventDefault();
				$.post(
					"plantillas/agregarPlantillas",
					$(this).serialize(),
					function(data){
						alert(data);
					}
				);
			});
		});
        </script>
		
		
		<script type='text/javascript'>
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
		function ocultarScroll()
		{
			document.documentElement.style.overflowY='hidden';
		}
		</script>
		
		<script type='text/javascript'>
		function borrarCKEditor()
		{
			 CKEDITOR.instances.editor.setData ("");
		}
		</script>
		
		<script type='text/javascript'>
		var inicio=true;
		CKEDITOR.on('currentInstance', function(e)
		{
			if(inicio==true && <?php echo !isset($msj[3]) ?>)
			{
				CKEDITOR.instances.editor.setData ("");
				inicio=false;
			}
		});
		</script>
		
    </head>
	
	<body>
	
		<div class="contenedor-principal">	
		<div class="contenedor-secundario zoomout">
		<div class="tituloModal">
		Estimado usuario
		</div>
		<div class="txtModal">
		Las variables permiten definir segmentos de texto dentro de una plantilla, que tomarán distintos valores según las características del mensaje o la lista de destinatarios a utilizar.
		El valor de estas variables será solicitado al usuario al momento de realizar el envío del correo electrónico.
		</div>
		<div class="txtModal">
		Para definir una variable anteponga los caracteres  <font color="blue">%%</font>  antes del nombre de dicha variable.
		</div>
		<div class="txtModal">
		El sistema manteka cuenta con variables predefinidas cuyo valor será asignado automáticamente al momento de realizar un envío.
		</div>
		<div class="txtModal">
		<div id="salto">Las variables predefinidas son:</div>
		<div class="txtLabel">%%nombre:&nbsp;&nbsp;</div><div class="txtDescripcion">Asigna el nombre del receptor del correo electrónico, para cada receptor dentro de la lista de destinatarios.</div>
		<div class="txtLabel">%%fecha:&nbsp;&nbsp;</div><div class="txtDescripcion">Asigna la fecha actual al momento de realizar el envío.</div>
		<div class="txtLabel">%%remitente:&nbsp;&nbsp;</div><div class="txtDescripcion">Asigna el nombre del usuario que realiza el envío del correo electrónico.</div>
		</div>
		<span id="botonCerrar" class="btn btn-primary">Cerrar</span>
		</div>
		</div>
		
		<fieldset>
		<legend>&nbsp;Agregar plantillas&nbsp;</legend>
		<div id="txtInformativo" class="txt">
		<div id="txt1">
		La creación de plantillas permite definir variables cuyo valor será solicitado al usuario, al momento de realizar el envío del correo electrónico.
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
		<div id="formAgregarPlantillas">	
        <?php
		if(isset($msj))
		{
			if($msj[0]=='1')
			{
				?>
				<div class="alert alert-success" id="msjOk">
    			<button type="button" class="close" id="btnMsjOk" data-dismiss="alert">&times;</button>
    			La plantilla ha sido creada satisfactoriamente !!!
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
				<?php echo validation_errors();?>
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
			$nombrePrevio=$msj[1];
			$asuntoPrevio=$msj[2];
			if(isset($msj[3]))
			{
				$ejemplo=(string)$msj[3];
			}
			else
			{
				$ejemplo='<p><span style="color:#FF0000"><strong><u>Ejemplo de plantilla:</u></strong></span><br /><br />Estimado %%nombre<br /><br />Te informamos que hoy %%fecha se han suspendido las clases del profesor %%profesor, <span style="color:#666666;font-size:12pt"><strong>debido a motivos de fuerza mayor.</strong></span><br /><br /><span style="color:lightblue">Cordialmente<br />Coordinador %%remitente </span></p>';
			}
			unset($msj);
		}
		else
		{
			$nombrePrevio='';
			$asuntoPrevio='';
			$ejemplo='<p><span style="color:#FF0000"><strong><u>Ejemplo de plantilla:</u></strong></span><br /><br />Estimado %%nombre<br /><br />Te informamos que hoy %%fecha se han suspendido las clases del profesor %%profesor, <span style="color:#666666;font-size:12pt"><strong>debido a motivos de fuerza mayor.</strong></span><br /><br /><span style="color:lightblue">Cordialmente<br />Coordinador %%remitente </span></p>';
		}
		$inicio=true;
		$atributos = array('class' => 'form', 'id' => 'formAgregarPlantillas', 'name'=>'formAgregarPlantillas');
		
		echo form_open('plantillas/agregarPlantillas', $atributos);
		
		echo "<div class='etiqueta'>";
		echo form_label("Nombre de la plantilla");
		$atributos = array('id' => 'txtNombrePlantilla', 'size' => '30', 'name' => 'txtNombrePlantilla', 'maxlength' => '40', 'placeHolder'=>'Máximo 40 caracteres', 'value'=>$nombrePrevio);
		echo form_input($atributos);
		echo "</div>";
		
		echo "<div  class='etiqueta'>";
		echo form_label("Asunto");
		$atributos = array('id' => 'txtAsunto', 'size' => '30', 'name' => 'txtAsunto', 'maxlength' => '40', 'placeHolder'=>'Máximo 40 caracteres', 'value'=>$asuntoPrevio);
		echo form_input($atributos);
		echo "</div>";
            
		echo "<div class='etiqueta'>";
		echo form_label("Cuerpo del mensaje");
		$atributos = array('id'=>'editor', 'class'=>'ckeditor', 'name'=>'editor', 'value'=>$ejemplo);
		echo form_textarea($atributos);
		echo "</div>";
		
		echo "<div id='btns'>";
		$atributos = array('id' => 'btnLimpiar', 'name' => 'btnLimpiar', 'class' =>'btn', 'onclick'=>'borrarCKEditor();');
		echo form_reset($atributos, 'Limpiar plantilla');
		$atributos = array('id' => 'btnCrear', 'name' => 'btnCrear', 'class' =>'btn btn-primary');
		echo form_submit($atributos, 'Crear plantilla');
		echo "</div>";
		
		echo form_close();
		?>
		</div>
		</fieldset>
    </body>
</html>