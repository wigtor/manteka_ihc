<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" />

<script type="text/javascript">
/** 
* Esta función se llama al clickear un correo de la bandeja de correos enviados, En primera instancia muestra el detalle
* de dicho correo y a la vez ocultando la bandeja de correos mostrando sólo el detalle del correo seleccionado. 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver en el evento onclick() en donde están contenidos los correos (bandeja) .
*/
function DetalleCorreo(plantilla,hora,fecha,cuerpo,asunto)
{		
	if(plantilla=="")
		plantilla="No se utilizó plantilla para este correo.";
	if(cuerpo=="")
		plantilla="Este correo se envío sin cuerpo.";
	if(asunto=="")
		asunto="Este correo se envío sin asunto.";
	document.getElementById("fecha").innerHTML=fecha;
	document.getElementById("hora").innerHTML=hora;
	document.getElementById("plantilla").innerHTML=plantilla;
	document.getElementById("asuntoDetalle").innerHTML=asunto;
	document.getElementById("cuerpoMail").innerHTML=cuerpo;
	$('#cuadroEnviados').css({display:'none'});
	$('#cuadroDestinoCorreo').css({display:'none'});
	$('#cuadroDetalleCorreo').css({display:'block'});
}
</script>

<script type="text/javascript">
/** 
* Esta función se llama al clickear el botón que se encuentra en el Detalle del Correo, para poder mostrar nuevamente la 
* bandeja de correos enviados y ocultar el detalle del correo que se estaba mostrando.
* Para ver como se configura esto se debe ver en el evento onclick() del botón que se encuentra en el Detalle de Correo.
*/
function volverCorreosRecibidos()
{		
	$('#cuadroDestinoCorreo').css({display:'none'});
	$('#cuadroDetalleCorreo').css({display:'none'});
	$('#cuadroEnviados').css({display:'block'});
}
</script>

<script type="text/javascript">
/** 
* Esta función recibe como argumento un string que tiene concatenado todos los detalles del correo
* (destinaario, fecha, hora, mensaje, asunto, etc). Además indica con un número (el primer caracter) el tipo de destinatiario
* del correo (alumno, ayudante, profesor, coordinador) de esta forma se sabe que en lista se pdorá mostrar la información
* contenida en el string.
* La función en éste instante se encuentra incompleta ya que la su funcionalidad está orientada a sólo 1 destinatario
* pero se pretende mostrar todos los destinatarios de un mismo correo.
*/

function DestinoCorreo(destino)
{		
	var personaE="Este email no fue enviado a ningún estudiante";
	var personaA="Este email no fue enviado a ningún ayudante";
	var personaP="Este email no fue enviado a ningún profesor";
	var personaC="Este email no fue enviado a ningún coordinador";
	if(destino.substr(0,1)=="1")
		personaE=destino.substr(1);
	document.getElementById("destinoE").innerHTML=personaE;
	document.getElementById("destinoA").innerHTML=personaA;
	document.getElementById("destinoP").innerHTML=personaP;
	document.getElementById("destinoC").innerHTML=personaC;
	$('#cuadroEnviados').css({display:'none'});
	$('#cuadroDetalleCorreo').css({display:'none'});
	$('#cuadroDestinoCorreo').css({display:'block'});
}
</script>

<script type="text/javascript">
/** 
* Esta función se llama al hacer click en el checkbox principal, permitiendo marcar o desmarcar (según sea el caso) cada checkbox
* de los correos enviados del usuario. 
* Para marcar o desmarcar los checkbox, sólo se reconocen los elementos de tipo checkbox dentro del formulario, no se 
* hace una dsitinción o búsqueda por id del checkbox.
* Para ver como se configura esto se debe ver en el evento onclick() en donde se está creando el checkbox principal.
*/
function selectall(form)
{
	var formulario=eval(form);  
	for (var i=0,len=formulario.elements.length; i<len;i++)  
	{  
		if (formulario.elements[i].type=="checkbox")
			formulario.elements[i].checked=formulario.elements[0].checked; 
	}
}
</script>

<script type="text/javascript">
/** 
* Esta función permite eliminar el correo que se encuentre marcado con su checkbox, también es posible la eliminación en 
* grupo (varios checkbox marcados).
*/
function eliminarCorreo()
{
	var checked_ids = [];
	for(i=0;i<document.formulario.elements.length;i++)
	{
		if((document.formulario[i].type=='checkbox') && (document.formulario[i].checked==true))
			checked_ids.push(document.formulario[i].name);
	}
	if(checked_ids.length==0)
		alert('Debes seleccionar al menos un correo para eliminar.');
	else
	{
		if (confirm('Estás a punto de eliminar correos.\n¿Realmente deseas continuar?'))
		{
			$('#cuadroEnviados').css({display:'none'});
			$('#msjEliminacion1').css({display:'none'});
			$('#msjEliminacion2').css({display:'none'});
			$('#cuadroDestinoCorreo').css({display:'none'});
			$('#cuadroDetalleCorreo').css({display:'none'});
			$('#cRC').css({display:'block'});
			if(checked_ids[0]=="marcar")
				checked_ids.shift();
			document.getElementById('seleccion').value=checked_ids.join(";");
			formulario.action="<?php echo site_url("Correo/EliminarCorreo")?>";
			formulario.submit();
		}
	}
}
</script>

<?php
if(isset($msj))
{
	if($msj==1)
	{
		?>
		<p id="msjEliminacion1">
		Eliminación de correo(s) realizada satisfactoriamente !!!
		</p>
		<?php
	}
	else if($msj==0)
	{
		?>
		<p id="msjEliminacion2">
		Eliminación de correo(s) no se pudo realizar. Contacta al administrador del sistema.
		</p>
		<?php
	}
	unset($msj);
}
?>

<div id="cRC" style="display:none; position:relative; z-index:3; margin-top:10%; width:78%; text-align:center;">
<img src="/<?php echo config_item('dir_alias') ?>/img/procesando.gif" class="imgProcesando"/>
</div>

<fieldset id="cuadroEnviados">
	<legend>&nbsp;Correos enviados&nbsp;</legend>
	<?php
	$contador=0;
	$comilla= "'";
	$estado=$listaEnviados[0];
	array_shift($listaEnviados);
	if($estado==1)
	{
		$correos=array();
		$estudiantesEnviados=array();
		$ayudantesEnviados=array();
		$profesoresEnviados=array();
		$coordinadoresEnviados=array();
		foreach($listaEnviados as $lista)
		{
			array_push($correos, $lista[0]);
			array_push($estudiantesEnviados, $lista[1]);
			array_push($ayudantesEnviados, $lista[2]);
			array_push($profesoresEnviados, $lista[3]);
			array_push($coordinadoresEnviados, $lista[4]);
		}
		if(count($correos)!==0)
		{
			?>
			<button  class ="btn"  onclick="eliminarCorreo()" >Eliminar seleccionados</button>
			<?php
		}
		?>
		<form name="formulario" id="formu" method="post">
		<table width="98%" align="center" height="30px" style="font-size:12px; margin-top:5%;" border="1" cellpadding="5">
		<tr>
		<td width="5%" bgcolor="lightgrey" style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" NAME="marcar" onClick="selectall(formulario)"/></td>
		<td width="8%" bgcolor="lightgrey"><b>Fecha</b></td>
		<td width="8%" bgcolor="lightgrey"><b>Hora</b></td>
		<td width="27%" bgcolor="lightgrey"><b>Asunto</b></td>
		<td width="12%" bgcolor="lightgrey"><b>N° destinatarios</b></td>
		<td width="13%" bgcolor="lightgrey"><b>Lista destinatarios</b></td>
		<td width="7%" bgcolor="lightgrey"><b>Detalles</b></td>
		</tr>
		</table>
		
		<div style="width:100%;height:200px;overflow:auto;">
		<table class="table-hover" height="35px" width="98%" align="center" cellpadding="5" style="font-size:12px;border-bottom:solid 1px gray;border-left:solid 1px gray;border-right:solid 1px gray;color:#666666;font-weight:bold">
		<tbody>
		<?php
		if(count($correos)===0)
		{
			?>
			<div id="sinCorreos">
			Estimado usuario</br>
			La bandeja de correos enviados se encuentra vacía.
			</div>
			<?php
		}
		else
		{
			while($contador<count($correos))
			{	
				$destino='';
				$total=0;
				if(count($estudiantesEnviados[0])!=0)
				{
					$total+=count($estudiantesEnviados);
					$destino='11. <font color=blue><b>RUT: </b></font>'.$estudiantesEnviados[0][0]['rut_estudiante'].'  <font color=blue><b>NOMBRE: </b></font>'.$estudiantesEnviados[0][0]['nombre1_estudiante'].' '.$estudiantesEnviados[0][0]['nombre2_estudiante'].' '.$estudiantesEnviados[0][0]['apellido_paterno'].' '.$estudiantesEnviados[0][0]['apellido_materno'].'  <font color=blue><b>CORREO: </b></font>'.$estudiantesEnviados[0][0]['correo_estudiante'].'  <font color=blue><b>CARRERA: </b></font>'.$estudiantesEnviados[0][0]['cod_carrera'].'  <font color=blue><b>SECCIÓN: </b></font>'.$estudiantesEnviados[0][0]['cod_seccion'];
				}
				if(count($ayudantesEnviados[0])!=0)
				{
					$total+=count($ayudantesEnviados);
					$destino='21. <font color=blue><b>RUT: </b></font>'.$ayudantesEnviados[0][0]['rut_ayudante'].'  <font color=blue><b>NOMBRE: </b></font>'.$ayudantesEnviados[0][0]['nombre1_ayudante'].' '.$ayudantesEnviados[0][0]['nombre2_ayudante'].' '.$ayudantesEnviados[0][0]['apellido_paterno'].' '.$ayudantesEnviados[0][0]['apellido_materno'].'  <font color=blue><b>CORREO: </b></font>'.$ayudantesEnviados[0][0]['correo_ayudante'];
				}
				if(count($profesoresEnviados[0])!=0)
				{
					$total+=count($profesoresEnviados);
					$destino='31. <font color=blue><b>RUT: </b></font>'.$profesoresEnviados[0][0]['rut_usuario2'].'  <font color=blue><b>NOMBRE: </b></font>'.$profesoresEnviados[0][0]['nombre1_profesor'].' '.$profesoresEnviados[0][0]['nombre2_profesor'].' '.$profesoresEnviados[0][0]['apellido1_profesor'].' '.$profesoresEnviados[0][0]['apellido2_profesor'].'  <font color=blue><b>TIPO: </b></font>'.$profesoresEnviados[0][0]['tipo_profesor'];
				}
				if(count($coordinadoresEnviados[0])!=0)
				{
					$total+=count($coordinadoresEnviados);
					$destino='41. <font color=blue><b>RUT: </b></font>'.$coordinadoresEnviados[0][0]['rut_usuario3'].'  <font color=blue><b>NOMBRE: </b></font>'.$coordinadoresEnviados[0][0]['nombre1_coordinador'].' '.$coordinadoresEnviados[0][0]['nombre2_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido1_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido2_coordinador'];
				}
				if($destino!='')
				{
					echo '<tr>';
					echo '<td width="5%" id="'.$contador.'"
					style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" name="'.$correos[$contador]['cod_correo'].'" onClick="disableOthers(this)"/></td>';
			
					echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;">'. $correos[$contador]['fecha'].'</td>';
			
					echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;">'.$correos[$contador]['hora'].'</td>';
			
					echo '<td width="27%" id="'.$contador.'" style="text-align:left;padding-left:7px;">'. $correos[$contador]['asunto'].'</td>';

					echo '<td width="12%" id="'.$contador.'" style="text-align:left;padding-left:7px;">'.$total.'</td>';
			
					echo '<td width="13%" id="'.$contador.'" style="text-align:left;padding-left:7px;"><a id="opener2" href="javascript:DestinoCorreo('.$comilla.$destino.$comilla.')">Ver</a></td>';
			
					echo '<td width="7%" id="'.$contador.'" style="text-align:left;padding-left:7px;"><a id="opener1" href="javascript:DetalleCorreo('.$comilla.$correos[$contador]['id_plantilla'].$comilla.','.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['cuerpo_email'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.')">Ver</a></td>';
					echo '</tr>';
				}
				$contador = $contador + 1;
			}
		}
		?>
		</tbody>
		</table>
		</div>
		<input type="hidden" id="seleccion" name="seleccion" value="">
		</form>
		<?php
	}
	else
	{
		?>
		<p id="errorBD">
		No se puede acceder a la lista de correos enviados en estos momentos.
		</br>
		</br>
		Inténtalo más tarde o contacta al administrador del sitio.
		</p>
		<?php
	}
	?>
</fieldset>

<fieldset id="cuadroDetalleCorreo" style="display:none;">
	<legend>&nbsp;Correos enviados <font color="black">:::</font> detalles&nbsp;</legend>
	<div class="tituloPre2"><div class="tituloPreTxt">Detalles del correo seleccionado</div>
	<button class="btn" style="margin-right:1%;" onclick="volverCorreosRecibidos()">Volver a correos enviados</button>
	</div>
	</br>
	<pre class="detallesEmail">
	<div class="etiqueta">Fecha de envío:</div><div class="txt" type="text" id="fecha"></div>
	<div class="etiqueta">Hora de envío:</div><div class="txt" type="text" id="hora"></div>
	<div class="etiqueta">Plantilla:</div><div class="txt" type="text" id="plantilla"></div>
	<div class="etiqueta">Asunto:</div><div class="txt" type="text" id="asuntoDetalle"></div>
	<div class="etiqueta">Cuerpo:</div><div class="txt2" type="text" id="cuerpoMail"></div>
	</pre>
</fieldset>

<fieldset id="cuadroDestinoCorreo" style="display:none;">
	<legend>&nbsp;Correos enviados <font color="black">:::</font> destinatarios&nbsp;</legend>
	<div class="tituloPre2"><div class="tituloPreTxt">Destinatarios del correo seleccionado</div>
	<button class="btn" style="margin-right:1%;" onclick="volverCorreosRecibidos()">Volver a correos enviados</button>
	</div>
	</br>
	<pre class="listaDestinatarios">
	<div class="etiqueta">Estudiantes:</div><div class="txt" type="select" id="destinoE"></div>
	<div class="etiqueta">Ayudantes:</div><div class="txt" type="select" id="destinoA"></div>
	<div class="etiqueta">Profesores:</div><div class="txt" type="select" id="destinoP"></div>
	<div class="etiqueta">Coordinadores:</div><div class="txt2" type="select" id="destinoC"></div>
	</pre>
</fieldset>