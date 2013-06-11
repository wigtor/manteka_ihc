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
		document.getElementById("destinos").innerHTML=destino.split(",",1 );

	

	
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


/** 
* Esta función elimina los tags HTML
*/
function strip(html)
{
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent||tmp.innerText;
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
* Esta función se llama al hacer click en los botones < y > para cambiar los correos mostrados
*/

function cambiarCorreos(direccion,offset)
{
	
	if (direccion=="ant") {
		offset=offset-5;

		
	}else if (direccion=="sig"){
		offset=offset+5;
		

	}
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postEnviados") ?>",
		data: { offset: offset},
		success: function(respuesta){
			var tablaResultados = document.getElementById('tabla');
			var nodoTexto;
			$(tablaResultados).empty();		
			listaEnviados = JSON.parse(respuesta);
			listaEnviados.shift();


			for (var i = 0; i < listaEnviados.length; i++) {
				destino="";
				para="";
				if(typeof listaEnviados[i][1][0] != 'undefined')
				{  j=0;
					while(typeof listaEnviados[i][1][j] != 'undefined'){
						if(destino==""){
							destino=listaEnviados[i][1][j].nombre1_estudiante+' '+listaEnviados[i][1][j].apellido_paterno+' '+listaEnviados[i][1][j].apellido_materno+' &#60'+listaEnviados[i][1][j].correo_estudiante+'&#62';					
							para=listaEnviados[i][1][j].nombre1_estudiante+' '+listaEnviados[i][1][j].apellido_paterno+' '+listaEnviados[i][1][j].apellido_materno;
						}else{
							destino=destino+',<br>'+listaEnviados[i][1][j].nombre1_estudiante+' '+listaEnviados[i][1][j].apellido_paterno+' '+listaEnviados[i][1][j].apellido_materno+' &#60'+listaEnviados[i][1][j].correo_estudiante+'&#62';
							para=para+".....";
						}
						j++;	
					}
					
					
				}
				if(typeof listaEnviados[i][2][0] != 'undefined')
				{j=0;
					while(typeof listaEnviados[i][2][j] != 'undefined'){
						if(destino==""){
							destino=listaEnviados[i][2][j].nombre1_ayudante+' '+listaEnviados[i][2][j].apellido_paterno+' '+listaEnviados[i][2][j].apellido_materno+' &#60'+listaEnviados[i][2][j].correo_ayudante+'&#62';					
							para=listaEnviados[i][2][j].nombre1_ayudante+' '+listaEnviados[i][2][j].apellido_paterno+' '+listaEnviados[i][2][j].apellido_materno;
						}else{
							destino=destino+',<br>'+listaEnviados[i][2][j].nombre1_ayudante+' '+listaEnviados[i][2][j].apellido_paterno+' '+listaEnviados[i][2][j].apellido_materno+' &#60'+listaEnviados[i][2][j].correo_ayudante+'&#62';					
							para=para+".....";
						}
						j++;	
					}
					
				}
				if(typeof listaEnviados[i][3][0] != 'undefined')
				{j=0;
					while(typeof listaEnviados[i][3][j] != 'undefined'){
						if(destino==""){
							destino=listaEnviados[i][3][j].nombre1_profesor+' '+listaEnviados[i][3][j].apellido1_profesor+' '+listaEnviados[i][3][j].apellido2_profesor;					
							para=listaEnviados[i][3][j].nombre1_profesor+' '+listaEnviados[i][3][j].apellido1_profesor+' '+listaEnviados[i][3][j].apellido2_profesor;
						}else{
							destino=destino+',<br>'+listaEnviados[i][3][j].nombre1_profesor+' '+listaEnviados[i][3][j].apellido1_profesor+' '+listaEnviados[i][3][j].apellido2_profesor;					
							para=para+".....";
						}
						j++;	
					}
					
				}
				if(typeof listaEnviados[i][4][0] != 'undefined')
				{j=0;
					while(typeof listaEnviados[i][4][j] != 'undefined'){
						if(destino==""){
							destino=listaEnviados[i][4][j].nombre1_coordinador+' '+listaEnviados[i][4][j].apellido1_coordinador+' '+listaEnviados[i][4][j].apellido2_coordinador;					
							para=listaEnviados[i][4][j].nombre1_coordinador+' '+listaEnviados[i][4][j].apellido1_coordinador+' '+listaEnviados[i][4][j].apellido2_coordinador;
						}else{
							destino=destino+',<br>'+listaEnviados[i][4][j].nombre1_coordinador+' '+listaEnviados[i][4][j].apellido1_coordinador+' '+listaEnviados[i][4][j].apellido2_coordinador;					
							para=para+".....";
						}
						j++;	
					}
					
				}
				tr = document.createElement('tr');
				td = document.createElement('td');
				td.setAttribute("width", "5%");
				td.setAttribute("id", i);
				td.setAttribute("style","padding-top:4px;padding-bottom:8px;");
				td.setAttribute("align","center");				
				check = document.createElement('input');
				check.type='checkbox';
				check.setAttribute("name",listaEnviados[i][0].cod_correo);
				check.checked=false;
				td.appendChild(check);
				//td.setAttribute(onclick,);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "23%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaEnviados[i][0].hora+"','"+listaEnviados[i][0].fecha+"','"+listaEnviados[i][0].asunto+"',"+i+",'"+destino+"')");
				nodoTexto=document.createTextNode(para);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("id", "m"+i);
				td.setAttribute("width", "27%");
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaEnviados[i][0].hora+"','"+listaEnviados[i][0].fecha+"','"+listaEnviados[i][0].asunto+"',"+i+",'"+destino+"')");
				bold =document.createElement('b');
				nodoTexto = document.createTextNode(listaEnviados[i][0].asunto);
				bold.appendChild(nodoTexto);
				td.appendChild(bold);

				nodoTexto = document.createTextNode(" "+listaEnviados[i][0].cuerpo_email);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaEnviados[i][0].hora+"','"+listaEnviados[i][0].fecha+"','"+listaEnviados[i][0].asunto+"',"+i+",'"+destino+"')");
				nodoTexto=document.createTextNode(listaEnviados[i][0].fecha);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","DetalleCorreo('"+listaEnviados[i][0].hora+"','"+listaEnviados[i][0].fecha+"','"+listaEnviados[i][0].asunto+"',"+i+",'"+destino+"')");
				
				nodoTexto=document.createTextNode(listaEnviados[i][0].hora);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				tablaResultados.appendChild(tr);
				textarea=document.createElement('textarea');
				textarea.setAttribute("id","c"+i);
				textarea.setAttribute("style","display:none");
				tablaResultados.appendChild(textarea);
				var cuerpo=listaEnviados[i][0].cuerpo_email;
				document.getElementById("m"+i).innerHTML="<b>"+listaEnviados[i][0].asunto+"</b> - "+strip(cuerpo+".").substr(0,40-listaEnviados[i][0].asunto.length)+"......";
				document.getElementById("c"+i).value=cuerpo;
				
				
			}
			var limite;
			if(<?php echo $cantidadCorreos;?><offset+5)
				limite=<?php echo $cantidadCorreos;?>;
			else
				limite=offset+5;

			
			
			document.getElementById("sig").setAttribute("onClick", "cambiarCorreos('sig',"+offset+")");
			document.getElementById("ant").setAttribute("onClick", "cambiarCorreos('ant',"+offset+")");
			if (direccion=="ant") {
					
					if(offset==0){
						document.getElementById("ant").className="disabled";
						document.getElementById("ant").removeAttribute('onClick');
					}
					document.getElementById("sig").removeAttribute('class');
			}else if(direccion=="sig"){
				
				if(offset+5>=<?php echo $cantidadCorreos;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
				document.getElementById("ant").removeAttribute('class');

			}else if(offset+5>=<?php echo $cantidadCorreos;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
			document.getElementById("mostrando").innerHTML="mostrando "+ (offset+1)+"-"+limite+ " de: "+<?php echo $cantidadCorreos;?>;

			
			
			var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
		}
	});
	/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
	
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



<fieldset id="cuadroEnviados">
	<legend>&nbsp;Correos enviados&nbsp;</legend>
	<?php
	$contador=0;
	$offset=0;

	if($cantidadCorreos<$offset+5)
		$limite=$cantidadCorreos;
	else
		$limite=$offset+5;

	$comilla= "'";
	$estado=1;
	
	if($estado==1)
	{

		if($cantidadCorreos!==0)
		{
	
	
			?>
			<button  class ="btn"  onclick="eliminarCorreo()" style=" margin-right:4px; float:right;" ><div class="btn_with_icon_solo">Ë</div> Eliminar seleccionados</button><br><br>
			<?php
		}

		if($cantidadCorreos==0)
		{
			?>
			<div id="sinCorreos">
			Estimado usuario</br>
			La bandeja de correos enviados se encuentra vacía.
			</div>
			<?php
		}
		else
		{?>
		    <ul id="pager" class="pager" style="text-align:right;margin:0px" >
		    	<span id="mostrando">  mostrando <?php echo ($offset+1)."-".$limite. " de: ".$cantidadCorreos; ?></span>
	    		<li id="ant" class="disabled" ><a href="#"><div class="btn_with_icon_solo"><</div></a></li>
	    		<?php 
	    		if($limite<$cantidadCorreos){
	    			?>
	    			<li id ="sig" onClick="cambiarCorreos('sig',<?php echo $offset; ?>)"><a href="#"><div class="btn_with_icon_solo">=</div></a></li>
	    			<?php
	    		}else{
	    			?>
	    			<li id ="sig" onClick="cambiarCorreos('sig',<?php echo $offset; ?>)" class="disabled"><a href="#"><div class="btn_with_icon_solo">=</div></a></li>
	    			<?php
	    		}
	    		?>

	   	 		
			</ul>
			<form name="formulario" id="formu" method="post">
			<table width="98%" align="center" height="30px" class="table table-hover" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-top:20px; margin-bottom:0px">
			<tr class="info">
			<td width="5%"  style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" NAME="marcar" onClick="selectall(formulario)"/></td>
			<td width="23%" ><b>Para</b></td>
			<td width="27%" ><b>Mensaje</b></td>
			<td width="8%" ><b>Fecha</b></td>
			<td width="8%" ><b>Hora</b></td>
			</tr>
			
			
			<tbody id="tabla">
				<script type="text/javascript">cambiarCorreos("inicio",0)</script>
			<?php		
			
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
	<button class="btn" style="margin-bottom:20px; margin-right:14px; float:right;" onclick="volverCorreosEnviados()"><div class="btn_with_icon_solo"><</div> Volver</button>
	</div>
	</br>

	<pre class="detallesEmail">
<div style="text-align:right; margin-bottom:0px;">Fecha: <b  id="fecha"> </b>  <b style="text-align:right;" id="hora"></b></div><table class="table table-hover" style="margin:0px; border-top:0px;">
<td style="text-align:left; margin:px;  border-top:0px" > Para: <b  class="txt"  id="destinos"></b> <div href="#" rel="details"  class="btn btn_with_icon_solo" style="width: 15px; height: 15px; align:left;"><img src="/<?php echo config_item('dir_alias') ?>/img/icons/glyphicons_367_expand.png" alt=":" ></div></td>
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
	content='<table class="pop" style="  width:100%;"><tr ><td >Para:</td><td><strong>'+destinoaux+'</strong></td></tr><tr><td>Asunto: </td><td><strong>'+asunto+'</strong></td></tr><tr><td>Fecha:  </td><td><strong>'+fecha  +'</strong></td><tr><td>Hora:   </td><td><strong>'+    hora+'</strong></td></tr></table>';
        return content;
}
  

  	</script>