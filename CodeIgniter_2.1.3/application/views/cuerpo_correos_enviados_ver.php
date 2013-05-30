<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" />

<script type="text/javascript">

var id;
var extended=false;
var destinoaux;


/** 
* Esta función se llama al clickear un correo de la bandeja de correos enviados, En primera instancia muestra el detalle
* de dicho correo y a la vez ocultando la bandeja de correos mostrando sólo el detalle del correo seleccionado. 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver en el evento onclick() en donde están contenidos los correos (bandeja) .
*/
function DetalleCorreo(hora,fecha,asunto,id,destino)
{		
	document.getElementById("fecha").innerHTML=fecha;
	document.getElementById("hora").innerHTML=hora;
	document.getElementById("asuntoDetalle").innerHTML=asunto;
	document.getElementById("cuerpoMail").innerHTML=document.getElementById("c"+id).value;
	
	this.id=id;

		destinoaux=destino;
		document.getElementById("destinos").innerHTML=destino.substring(0,5 );

	

	
	$('#cuadroEnviados').css({display:'none'});
	$('#cuadroDetalleCorreo').css({display:'block'});
}

/** 
* Esta función se llama al clickear el botón que se encuentra en el Detalle del Correo, para poder mostrar nuevamente la 
* bandeja de correos enviados y ocultar el detalle del correo que se estaba mostrando.
* Para ver como se configura esto se debe ver en el evento onclick() del botón que se encuentra en el Detalle de Correo.
*/
function volverCorreosEnviados()
{		
	$('#cuadroDetalleCorreo').css({display:'none'});
	$('#cuadroEnviados').css({display:'block'});
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
			<button  class ="btn"  onclick="eliminarCorreo()" style="margin-bottom:20px; margin-right:1%; float:right;" ><div class="btn_with_icon_solo">Ë</div> Eliminar seleccionados</button>
			<?php
		}

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
				?>
		<form name="formulario" id="formu" method="post">
		<table width="98%" align="center" height="30px" class="table table-hover" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-top:5%; margin-bottom:0px">
		<tr class="info">
		<td width="5%"  style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" NAME="marcar" onClick="selectall(formulario)"/></td>
		<td width="23%" ><b>Para</b></td>
		<td width="27%" ><b>Mensaje</b></td>
		<td width="8%" ><b>Fecha</b></td>
		<td width="8%" ><b>Hora</b></td>
		</tr>
		
		
		<tbody>
		<?php
				$destino='';
				$para='';
				$total=0;
				if(count($estudiantesEnviados[0])!=0)
				{
					$total+=count($estudiantesEnviados);
					$destino=$estudiantesEnviados[0][0]['nombre1_estudiante'].' '.$estudiantesEnviados[0][0]['apellido_paterno'].' '.$estudiantesEnviados[0][0]['apellido_materno'].' &lt'.$estudiantesEnviados[0][0]['correo_estudiante'].'&gt';
					$para=$estudiantesEnviados[0][0]['nombre1_estudiante'].' '.$estudiantesEnviados[0][0]['apellido_paterno'].' '.$estudiantesEnviados[0][0]['apellido_materno'];
				}	
				if(count($ayudantesEnviados[0])!=0)
				{
					$total+=count($ayudantesEnviados);
					$destino=$ayudantesEnviados[0][0]['nombre1_ayudante'].' '.$ayudantesEnviados[0][0]['apellido_paterno'].' '.$ayudantesEnviados[0][0]['apellido_materno'].' &lt'.$ayudantesEnviados[0][0]['correo_ayudante'].'&gt';
					$para=$ayudantesEnviados[0][0]['nombre1_ayudante'].' '.$ayudantesEnviados[0][0]['apellido_paterno'].' '.$ayudantesEnviados[0][0]['apellido_materno'];
				}
				if(count($profesoresEnviados[0])!=0)
				{
					$total+=count($profesoresEnviados);
					$destino=$profesoresEnviados[0][0]['nombre1_profesor'].' '.$profesoresEnviados[0][0]['apellido1_profesor'].' '.$profesoresEnviados[0][0]['apellido2_profesor'];
					$para=$profesoresEnviados[0][0]['nombre1_profesor'].' '.$profesoresEnviados[0][0]['apellido1_profesor'].' '.$profesoresEnviados[0][0]['apellido2_profesor'];
				}
				if(count($coordinadoresEnviados[0])!=0)
				{
					$total+=count($coordinadoresEnviados);
					$destino=$coordinadoresEnviados[0][0]['nombre1_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido1_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido2_coordinador'];
					$para=$coordinadoresEnviados[0][0]['nombre1_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido1_coordinador'].' '.$coordinadoresEnviados[0][0]['apellido2_coordinador'];
				}
				if($destino!='')
				{
					echo '<tr >';
				echo '<td width="5%" id="'.$contador.'"
				style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" name="'.$correos[$contador]['cod_correo'].'" onClick="disableOthers(this)"/></td>';
		
				echo '<td width="23%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.','.$comilla.$destino.$comilla.')">Para: '.$para.'</td>';		

				echo '<textarea id="c'.$contador.'" style="display:none;">'.$correos[$contador]['cuerpo_email'].'</textarea>';
				
				echo '<td width="27%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.','.$comilla.$destino.$comilla.')">'.substr('<b>' .$correos[$contador]['asunto']. '</b> - '.strip_tags( $correos[$contador]['cuerpo_email']),0,50).'......</td>';
		
				echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.','.$comilla.$destino.$comilla.')">'. $correos[$contador]['fecha'].'</td>';
		
				echo '<td width="8%" id="'.$contador.'" style="text-align:left;padding-left:7px;" onclick="DetalleCorreo('.$comilla.$correos[$contador]['hora'].$comilla.','.$comilla.$correos[$contador]['fecha'].$comilla.','.$comilla.$correos[$contador]['asunto'].$comilla.','.$contador.','.$comilla.$destino.$comilla.')">'. $correos[$contador]['hora'].'</td>';
				echo '</tr>';
				
				
				}
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
	<button class="btn" style="margin-bottom:20px; margin-right:1%; float:right;" onclick="volverCorreosEnviados()"><div class="btn_with_icon_solo"><</div> Volver</button>
	</div>
	</br>

	<pre class="detallesEmail">
<div style="text-align:right; margin-bottom:0%;"><b  id="fecha"> </b>  <b style="text-align:right;" id="hora"></b></div><table class="table table-hover" style="margin:0%; border-top:0px;">
<td style="text-align:left; margin:0%;  border-top:0px" > Para: <b  class="txt"  id="destinos"></b> <div href="#" rel="details"  class="btn btn_with_icon_solo" style="width: 15px; height: 15px; align:left;"><img src="/<?php echo config_item('dir_alias') ?>/img/icons/glyphicons_367_expand.png" alt=":" ></div></td>
</table>  Asunto:  <b  id="asuntoDetalle"></b>
  <fieldset id="cuerpoMail" style=" min-height:250px;"></fieldset>
	</pre>
</fieldset>
 <script type="text/javascript">
  $(document).ready(function() {
  	$("[rel=details]").tooltip({
  		placement : 'bottom', 
  		html: 'true', 
  		title : '<div style="text-color:white;"><strong>Muestra detalles</strong></div>',
  		trigger:'hover',
  	});
  	
  });

    $(window).load(function() {
  	  $("[rel=details]").popover({
	placement : 'bottom', 
    content: get_popover_content,
    html: true,
    trigger: 'click'
});
  	
  });

function get_popover_content() {
	fecha=document.getElementById("fecha").innerHTML;
	hora=document.getElementById("hora").innerHTML;
	asunto=document.getElementById("asuntoDetalle").innerHTML;
	content='<table class="pop" style=" background-color: #0040FF; color:white; width:100%;"><tr ><td >Para:</td><td><strong>'+destinoaux+'</strong></td></tr><tr><td>Asunto: </td><td><strong>'+asunto+'</strong></td></tr><tr><td>Fecha:  </td><td><strong>'+fecha  +'</strong></td><tr><td>Hora:   </td><td><strong>'+    hora+'</strong></td></tr></table>';
        return content;
}
  

  	</script>