<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" />

<script type="text/javascript">
/** 
* Esta función se llama al clickear un correo de la bandeja de correos enviados, En primera instancia muestra el detalle
* de dicho correo y a la vez ocultando la bandeja de correos mostrando sólo el detalle del correo seleccionado. 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver en el evento onclick() en donde están contenidos los correos (bandeja) .
*/
function DetalleCorreo(hora,fecha,asunto,id)
{		

	document.getElementById("fecha").innerHTML=fecha;
	document.getElementById("hora").innerHTML=hora;
	document.getElementById("asuntoDetalle").innerHTML=asunto;
	document.getElementById("cuerpoMail").innerHTML=document.getElementById("c"+id).value;
	$('#cuadroRecibidos').css({display:'none'});
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
	$('#cuadroDetalleCorreo').css({display:'none'});
	$('#cuadroRecibidos').css({display:'block'});
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
* Esta función se llama al hacer click en los botones para < y > para cambiar los correos mostrados
*/

function showCorreos()
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
			if(checked_ids[0]=="marcar")
				checked_ids.shift();
			document.getElementById('seleccion').value=checked_ids.join(";");			
			$('#cuadroRecibidos').css({display:'none'});
			$('#cuadroDestinoCorreo').css({display:'none'});

			formulario.action="<?php echo site_url("Correo/EliminarCorreoRecibido")?>";
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
		    <div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 Eliminación de correo(s) realizada satisfactoriamente !!!
    		</div>	
		<?php
	}
	else if($msj==0)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 La eliminación de correo(s) no se pudo realizar. Contacta al administrador del sistema.
    		</div>		

		<?php
	}else if($msj==2)
	{
		?>
		<div class="alert alert-success">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 El mensaje fue enviado satisfactoriamente.
    		</div>
		<?php
	}
	unset($msj);
}
?>



<fieldset id="cuadroRecibidos">
	<legend>&nbsp;Correos Recibidos&nbsp;</legend>
	<?php
	$contador=0;
	$comilla= "'";
	$estado=$listaRecibidos[0];
	array_shift($listaRecibidos);
	if($estado==1)
	{
		$correos=array();
		foreach($listaRecibidos as $lista)
		{
			array_push($correos, $lista[0]);
		}
		if(count($correos)!==0)
		{
			?>
			<button  class ="btn"  onclick="eliminarCorreo() " style=" margin-right:1%; float:right;" ><div class="btn_with_icon_solo">Ë</div> Eliminar seleccionados</button><br><br>
			<?php
		}

		if(count($correos)===0)
		{
			?>
			<div id="sinCorreos">
			Estimado usuario</br>
			La bandeja de correos recibidos se encuentra vacía.
			</div>
			<?php
		}
		else
		{
			while($contador<count($correos))
			{	
		?>
	    <ul class="pager" style="text-align:right;margin:0px">
    		<li><a href="#">Previous</a></li>
   	 		<li><a href="#">Next</a></li>
		</ul>
		<form name="formulario" id="formu" method="post">

		<table width="98%" align="center" height="30px" class="table table-hover " style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-top:1%; margin-bottom:0px">
			
		<tr class="info">
		<td width="5%"  style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" NAME="marcar" onClick="selectall(formulario)"/></td>
		<td width="23%" ><b>De</b></td>
		<td width="27%" ><b>Mensaje</b></td>
		<td width="8%" ><b>Fecha</b></td>
		<td width="8%" ><b>Hora</b></td>
		</tr>

		

		
		<tbody>
		<?php
				$total=0;

				echo '<tr >';
				echo '<td width="5%" id="'.$contador.'"
				style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" name="'.$correos[$contador]['cod_correo'].'" onClick="disableOthers(this)"/></td>';
		
				echo '<td width="23%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.')">ManteKA</td>';		

				echo '<textarea id="c'.$contador.'" style="display:none;">'.$correos[$contador]['cuerpo_email'].'</textarea>';
				
				echo '<td width="27%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.')">'.substr('<b>' .$correos[$contador]['asunto']. '</b> - '.strip_tags( $correos[$contador]['cuerpo_email']),0,50).'......</td>';
		
				echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.')">'. $correos[$contador]['fecha'].'</td>';
		
				echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.')">'. $correos[$contador]['hora'].'</td>';
				echo '</tr>';
				
				$contador = $contador + 1;
			}
		}
		?>
		</tbody>
		</table>

		<input type="hidden" id="seleccion" name="seleccion" value="">
		</form>
		<?php
	}
	else
	{
		?>
		<p id="errorBD">
		No se puede acceder a la lista de correos recibidos en estos momentos.
		</br>
		</br>
		Inténtalo más tarde o contacta al administrador del sitio.
		</p>
		<?php
	}
	?>
</fieldset>

<fieldset id="cuadroDetalleCorreo" style="display:none; " >
	<legend>&nbsp;Correos recibidos <font color="black">:::</font> detalles&nbsp;</legend>
	<div class="tituloPre2"><div class="tituloPreTxt">Detalles del correo seleccionado</div>
	<button class="btn"  onclick="volverCorreosRecibidos()" style="margin-bottom:20px; margin-right:1%; float:right;" ><div class="btn_with_icon_solo"><</div> Volver</button>
	</div>
	</br>
	<pre class="detallesEmail">
<div style="text-align:right;"><b  id="fecha"> </b>  <b style="text-align:right;" id="hora"></b></div>
  De:     <b >ManteKA</b>
  Asunto: <b id="asuntoDetalle"></b>
  <fieldset id="cuerpoMail" style=" min-height:250px;"></fieldset>
	</pre>
</fieldset>
