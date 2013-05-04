
<fieldset>
	<legend>Correos Enviados</legend>


	<script type="text/javascript">
		function DetalleCorreo(rut,asunto,mail,fecha,hora){		
			document.getElementById("correoEliminar").value = rut;
			document.getElementById("rutDetalle").innerHTML = rut;					//Emisor
			document.getElementById("asuntoDetalle").innerHTML = asunto;			//Asunto
			document.getElementById("cuerpoMail").innerHTML = mail;					//Mail
			document.getElementById("fecha").innerHTML = fecha;						//Fecha
			document.getElementById("hora").innerHTML = hora;						//Hora
		}

		function selectall(form){  
 			var formulario = eval(form)  
 			for (var i=0, len=formulario.elements.length; i<len ; i++)  
  			{  
    			if ( formulario.elements[i].type == "checkbox" )  
      				formulario.elements[i].checked = formulario.elements[0].checked  
  			}  
		}  

		function eliminarCorreo(){
			var rut = document.getElementById("correoEliminar").value;
			if(rut!=""){
				var borrar = document.getElementById("formBorrar");
				borrar.action = "<?php echo site_url("Correo/EliminarCorreo/") ?>/"+rut;
				borrar.submit();
			}
			else{
				alert("Selecione un correo");
			}
		}
	</script>

	<div class = "span3 offset5">
		<button class ="btn"  onclick="eliminarCorreo()" >Eliminar</button>
	</div>

	<form name="formulario">
		<table width="100%" height="40" bordercolor="grey" border="1" cellpadding="10">
			<tr>
			
			<td width="10%" bgcolor="lightgrey" align="center"><INPUT TYPE="CHECKBOX" NAME="marcar" onClick="selectall(formulario)"/></td>
			<td width="23%" bgcolor="lightgrey"><b>Para:</b></td>
			<td width="23%" bgcolor="lightgrey"><b>Asunto</b></td>
			<td width="23%" bgcolor="lightgrey"><b>Correo</b></td>
			<td width="23%" bgcolor="lightgrey"><b>Fecha</b></td>
			</tr>
		</table>
		
		<div style="width:100%;height:200px;overflow:auto;">
		
		<table class="table table-hover">
			<tbody>
			<?php
				$contador=0;
				$comilla= "'";
				while ($contador<count($correos)){
					
					echo '<tr>';
					//CheckBox
					echo '<td  id="'.$contador.'" onclick="DetalleCorreo('.$comilla.$correos[$contador][0].$comilla.','.$comilla. $correos[$contador][1].$comilla.','.$comilla. $correos[$contador][2].$comilla.','.$comilla. $correos[$contador][3].$comilla.','.$comilla. $correos[$contador][4].$comilla.')" 
						style="text-align:center;">
						<INPUT TYPE="CHECKBOX" NAME="marca" onClick="disableOthers(this)" /></td>';
					//Destinatarios
					echo '<td  id="'.$contador.'" onclick="DetalleCorreo('.$comilla.$correos[$contador][0].$comilla.','.$comilla. $correos[$contador][1].$comilla.','.$comilla. $correos[$contador][2].$comilla.','.$comilla. $correos[$contador][3].$comilla.','.$comilla. $correos[$contador][4].$comilla.')" 
						style="text-align:left;">
						'. $correos[$contador][0].'</td>';
					//ASunto
					echo '<td  id="'.$contador.'" onclick="DetalleCorreo('.$comilla.$correos[$contador][0].$comilla.','.$comilla. $correos[$contador][1].$comilla.','.$comilla. $correos[$contador][2].$comilla.','.$comilla. $correos[$contador][3].$comilla.','.$comilla. $correos[$contador][4].$comilla.')" 
						style="text-align:left;">
						'.$correos[$contador][1].'</td>';
					//Correo
					echo '<td  id="'.$contador.'" onclick="DetalleCorreo('.$comilla.$correos[$contador][0].$comilla.','.$comilla. $correos[$contador][1].$comilla.','.$comilla. $correos[$contador][2].$comilla.','.$comilla. $correos[$contador][3].$comilla.','.$comilla. $correos[$contador][4].$comilla.')" 
						style="text-align:left;">
						'.$correos[$contador][2].'</td>';
					//Fecha
					echo '<td  id="'.$contador.'" onclick="DetalleCorreo('.$comilla.$correos[$contador][0].$comilla.','.$comilla. $correos[$contador][1].$comilla.','.$comilla. $correos[$contador][2].$comilla.','.$comilla. $correos[$contador][3].$comilla.','.$comilla. $correos[$contador][4].$comilla.')" 
						style="text-align:left;">
						'. $correos[$contador][3].' '.$correos[$contador][4].'</td>';	
					echo '</tr>';
															
					$contador = $contador + 1;
				}
			?>
			</tbody>
		</table>
		</div>
	</form>

	<form id="formBorrar" type="post">
		<pre><style="margin-top: 2%; padding: 2%;">
			<input type="hidden" id="correoEliminar" value="">
			Correo Enviado.
			De:             	<b id="rutDetalle"></b>
			Para:				
			Asunto:       		<b id="asuntoDetalle"></b>
			Fecha:				<b id="fecha" ></b>
			Hora:				<b id="hora" ></b>
			Mensaje:       		<b id="cuerpoMail" ></b>



		</pre>
	</form>
</fieldset>	

