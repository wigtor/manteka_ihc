
<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/correosEnviados.css" type="text/css" media="all" />

<script type="text/javascript">
/** 
* Esta función se llama al clickear un correo de la bandeja de correos enviados, En primera instancia muestra el detalle
* de dicho correo y a la vez ocultando la bandeja de correos mostrando sólo el detalle del correo seleccionado. 
* por convención las funciones que utilizan document.getElementById()
* deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
* Para ver como se configura esto se debe ver en el evento onclick() en donde están contenidos los correos (bandeja) .
*/
function irAEnviar(codigo)
{		
document.location = "enviarBorrador/"+codigo;
	
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

		
	}else if(direccion=="sig"){
		offset=offset+5;
		

	}
	$.ajax({
		type: "POST",
		url: "<?php echo site_url("Correo/postBorradores") ?>",
		data: { offset: offset},
		success: function(respuesta){
			var tablaResultados = document.getElementById('tabla');
			var nodoTexto;
			$(tablaResultados).empty();		
			listaBorradores = JSON.parse(respuesta);
			
			for (var i = 0; i < listaBorradores.length; i++) {
				tr = document.createElement('tr');
				td = document.createElement('td');
				td.setAttribute("width", "5%");
				td.setAttribute("id", i);
				td.setAttribute("style","padding-top:4px;padding-bottom:8px;");
				td.setAttribute("align","center");				
				check = document.createElement('input');
				check.type='checkbox';
				check.setAttribute("name",listaBorradores[i].codigo);
				check.checked=false;
				td.appendChild(check);
				//td.setAttribute(onclick,);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "23%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","irAEnviar('"+listaBorradores[i].codigo+"')");
				span=document.createElement('span');
				span.setAttribute('style','color:#DF0101');
				nodoTexto=document.createTextNode('Borrador');
				span.appendChild(nodoTexto);
				td.appendChild(span);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("id", "m"+i);
				td.setAttribute("width", "27%");
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","irAEnviar('"+listaBorradores[i].codigo+"')");
				bold =document.createElement('b');
				nodoTexto = document.createTextNode(listaBorradores[i].asunto);
				bold.appendChild(nodoTexto);
				td.appendChild(bold);

				nodoTexto = document.createTextNode(" "+listaBorradores[i].cuerpo_email);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","irAEnviar('"+listaBorradores[i].codigo+"')");
				nodoTexto=document.createTextNode(listaBorradores[i].fecha);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				td = document.createElement('td');
				td.setAttribute("width", "8%");
				td.setAttribute("id", i);
				td.setAttribute("style","text-align:left;padding-left:7px;");
				td.setAttribute("onclick","irAEnviar('"+listaBorradores[i].codigo+"')");
				
				nodoTexto=document.createTextNode(listaBorradores[i].hora);
				td.appendChild(nodoTexto);
				tr.appendChild(td);
				tablaResultados.appendChild(tr);
				textarea=document.createElement('textarea');
				textarea.setAttribute("id","c"+i);
				textarea.setAttribute("style","display:none");
				tablaResultados.appendChild(textarea);
				var cuerpo=listaBorradores[i].cuerpo_email;
				document.getElementById("m"+i).innerHTML="<b>"+listaBorradores[i].asunto+"</b> - "+strip(cuerpo).substr(0,40-listaBorradores[i].asunto.length)+"......";
				document.getElementById("c"+i).value=cuerpo;
				
				
			}
			var limite;
			if(<?php echo $cantidadBorradores;?><offset+5)
				limite=<?php echo $cantidadBorradores;?>;
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
				
				if(offset+5>=<?php echo $cantidadBorradores;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
				document.getElementById("ant").removeAttribute('class');

			}else 
			if(offset+5>=<?php echo $cantidadBorradores;?>){
					document.getElementById("sig").className="disabled";
					document.getElementById("sig").removeAttribute('onClick');
				}
			document.getElementById("mostrando").innerHTML="mostrando "+ (offset+1)+"-"+limite+ " de: "+<?php echo $cantidadBorradores;?>;

			
			
			var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
		}
	});
	/* Muestro el div que indica que se está cargando... */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).show();
	
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
* Esta función permite eliminar el correo que se encuentre marcado con su checkbox, también es posible la eliminación en 
* grupo (varios checkbox marcados).
*/
function eliminarBorrador()
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

			formulario.action="<?php echo site_url("Correo/EliminarBorradores")?>";
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
    			 Eliminación de borrador(es) realizada satisfactoriamente !!!
    		</div>	
		<?php
	}
	else if($msj==0)
	{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 La eliminación de borrador(es) no se pudo realizar. Contacta al administrador del sistema.
    		</div>		

		<?php
	}
	unset($msj);
}
?>



<fieldset id="cuadroBorradores">
	<legend>&nbsp;Borradores&nbsp;</legend>
	<?php
	$contador=0;
	$offset=0;

	if($cantidadBorradores<$offset+5)
		$limite=$cantidadBorradores;
	else
		$limite=$offset+5;

	$comilla= "'";
	$estado=1;
	if($estado==1)
	{

		if($cantidadBorradores!=0)
		{
			?>
			<button  class ="btn"  onclick="eliminarBorrador() " style=" margin-right:4px; float:right;" ><div class="btn_with_icon_solo">Ë</div> Eliminar seleccionados</button><br><br>
			<?php
		}

		if($cantidadBorradores==0)
		{
			?>
			<div id="sinCorreos">
			Estimado usuario</br>
			La bandeja de borradores se encuentra vacía.
			</div>
			<?php
		}
		else
		{
			?>
		    <ul id="pager" class="pager" style="text-align:right;margin:0px" >
		    	<span id="mostrando">  mostrando <?php echo ($offset+1)."-".$limite. " de: ".$cantidadBorradores; ?></span>
	    		<li id="ant" class="disabled" ><a href="#"><div class="btn_with_icon_solo"><</div></a></li>
	    		<?php 
	    		if($limite<$cantidadBorradores){
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

			<table width="98%" align="center" height="30px" class="table table-hover " style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-top:4px; margin-bottom:0px">
				
			<tr class="info">
			<td width="5%"  style="padding-top:4px;padding-bottom:8px;" align="center"><input type="checkbox" NAME="marcar" onClick="selectall(formulario)"/></td>
			<td width="23%" ><b></b></td>
			<td width="27%" ><b>Mensaje</b></td>
			<td width="8%" ><b>Fecha</b></td>
			<td width="8%" ><b>Hora</b></td>
			</tr>

			

			
			<tbody id="tabla">
				<script type="text/javascript">cambiarCorreos("inicio",0);</script>
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
		No se puede acceder a la lista de correos recibidos en estos momentos.
		</br>
		</br>
		Inténtalo más tarde o contacta al administrador del sitio.
		</p>
		<?php
	}
	?>
</fieldset>


