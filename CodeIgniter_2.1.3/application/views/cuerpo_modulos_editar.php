<?php
	if($mensaje_confirmacion != 2)	{
		if($mensaje_confirmacion==-1){
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
   			 <h4>Error</h4>
				 Error al actualizar módulo
    		</div>		

		<?php
		}
		else if($mensaje_confirmacion==1)
		{
		?>
		<div class="alert alert-error">
    			<button type="button" class="close" data-dismiss="alert">&times;</button>
    			 <h4>Listo</h4>	 
				 Módulo actualizado correctamente
    		</div>		

		<?php
 		}
 
}
?>

<script>
	function Cancelar(){
		document.getElementById("nombre_modulo").value = "";
		document.getElementById("descripcion").value = "";
		document.getElementById("cod_modulo").value = "";
		document.getElementById("nombre_modulo2").value = "";
		document.getElementById("cod_equipo2").value = "";
	
		var sesiones = document.getElementById("sesiones");
		$(sesiones).empty();
		var equipo = document.getElementById("equipo");
		$(equipo).empty();
		var profLider = document.getElementById("prof_lider");
		$(profLider).empty();
		var requisitos = document.getElementById("requisitos");
		$(requisitos).empty();
		
		return false;
	}

	function detalleModulo(cod_mod,descripcion,cod_equipo,name_mod) {
		document.getElementById("nombre_modulo").value = name_mod;
		document.getElementById("descripcion").value = descripcion;
		document.getElementById("cod_modulo").value = cod_mod;
		document.getElementById("nombre_modulo2").value = name_mod;
		document.getElementById("cod_equipo2").value = cod_equipo;
		
		$.ajax({//AJAX PARA SESIONES
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerSesionesEditar") ?>", /* Se setea la url del controlador que responderá */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("sesiones");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, input,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre sesiones");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					if(arrayRespuesta[i][1]==cod_mod || arrayRespuesta[i][1] == null){
						tr = document.createElement('tr');
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('value', arrayRespuesta[i][0]);
						input.setAttribute("name", "sesion[]");
						if(arrayRespuesta[i][1] == cod_mod){
							input.setAttribute('checked', 'true');
						}
						td.setAttribute('title', arrayRespuesta[i][2]);
						nodoTexto = document.createTextNode(arrayRespuesta[i][3]);
						td.appendChild(input);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
						}
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});
		$.ajax({//AJAX PARA EQUIPO y lider
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerProfes") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_equipo_post: cod_equipo},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
			//para equipo
			var tablaResultados = document.getElementById("equipo");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, input,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre profesores");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++){
					if(arrayRespuesta[i][0] == cod_equipo  || arrayRespuesta[i][0] == ""){
						tr = document.createElement('tr');
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('id',arrayRespuesta[i][1]);
						input.setAttribute('value', arrayRespuesta[i][1]);
						input.setAttribute("name", "profesores[]");
						input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','1')");
						if(arrayRespuesta[i][0] == cod_equipo && arrayRespuesta[i][6] != 1){
							input.setAttribute('checked', 'true');
						}
						nodoTexto = document.createTextNode(arrayRespuesta[i][2]+" "+arrayRespuesta[i][3]+" "+arrayRespuesta[i][4]+" "+arrayRespuesta[i][5]);
						td.appendChild(input);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
					}
				}
				//para lider
				tablaResultados = document.getElementById("prof_lider");
				$(tablaResultados).empty();
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre profesores");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++){
					if(arrayRespuesta[i][0] == cod_equipo  || arrayRespuesta[i][0] == ""){
						tr = document.createElement('tr');
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','radio');
						input.setAttribute('value', arrayRespuesta[i][1]);
						input.setAttribute('id',arrayRespuesta[i][1]);
						input.setAttribute("name", "cod_profesor_lider");
						input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','2')");
						if(arrayRespuesta[i][6] == 1){
							input.setAttribute('checked', 'true');
						}
						nodoTexto = document.createTextNode(arrayRespuesta[i][2]+" "+arrayRespuesta[i][3]+" "+arrayRespuesta[i][4]+" "+arrayRespuesta[i][5]);
						td.appendChild(input);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
					}
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});
		$.ajax({//AJAX PARA requisitos
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/obtenerRequisitos") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_mod_post: cod_mod},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("requisitos");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, input,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre Requisitos");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					
						tr = document.createElement('tr');
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('value', arrayRespuesta[i][0]);
						input.setAttribute("name", "requisitos[]");
						if(arrayRespuesta[i][3] == 1){
							input.setAttribute('checked', 'true');
						}
						td.setAttribute('title', arrayRespuesta[i][2]);
						nodoTexto = document.createTextNode(arrayRespuesta[i][1]);
						td.appendChild(input);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						tablaResultados.appendChild(tr);
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}

	function cargarModulos() {
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/verModulosEditar") ?>", /* Se setea la url del controlador que responderá */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultados");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre módulo");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				
				for (var i = 0; i < arrayRespuesta.length; i++){
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "modulo_"+arrayRespuesta[i].cod_mod);
					tr.setAttribute("onClick", "detalleModulo('"+arrayRespuesta[i].cod_mod+"','"+arrayRespuesta[i].descripcion+"','"+arrayRespuesta[i].cod_equipo+"','"+arrayRespuesta[i].nombre_mod+"')");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre_mod);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
	}
		
	$(document).ready(cargarModulos);
</script>

<script type="text/javascript">
	

function nombreEnUso(){
	nombre_tentativo = document.getElementById("nombre_modulo");
	nombre_tentativo2 = document.getElementById("nombre_modulo2");
	
	var arreglo = new Array();
	var cont = 0;
	<?php
	$contadorE = 0;
	while($contadorE<count($nombre_modulos)){
		echo 'arreglo['.$contadorE.'] = "'.$nombre_modulos[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	for(cont=0;cont < arreglo.length;cont++){
		if(arreglo[cont].toLowerCase () == nombre_tentativo.value.toLowerCase() && nombre_tentativo.value != nombre_tentativo2.value){
				alert("Nombre en uso. Use otro nombre");
				nombre_tentativo.value="";
				return;
		}

    }

}
function noPuedeEstar(rut,num_lista){
		var lider = document.getElementsByName("cod_profesor_lider");
		var equipo = document.getElementsByName("profesores[]");
		var cont;
		var numS = -1;
		
		if(num_lista==1){//marco uno de equipo
			for(cont=0;cont < lider.length;cont++){
				if(lider[cont].checked == true){
					numS = cont;
					cont = lider.lenght;
				}
			}
			if(lider[numS].value == rut){
				alert("No puede escoger al lider para el equipo");
				document.getElementById(rut).checked = false;
				return;
			}
		}
		else{
			for(cont=0;cont < equipo.length;cont++){
				if(equipo[cont].checked == true && equipo[cont].value ==rut){
					alert("Se sacará a esta persona del equipo para que pueda ser lider");
					document.getElementById(rut).checked = false;
					return;						
				}
			}
		}


}
function editarMod(){
		var sesion = document.getElementsByName("sesion[]");
		var equipo = document.getElementsByName("profesores[]");
		var cont;
		var numS = 0;
		var numE = 0;
		for(cont=0;cont < sesion.length;cont++){
			if(sesion[cont].checked == true){
				numS = numS + 1;
			}
		}
		if(numS == 0){
			alert("Debe escoger por lo menos una sesión");
			return false;
		}
		for(cont=0;cont < equipo.length;cont++){
			if(equipo[cont].checked == true){
				numE = numE + 1;
			}
		}
		if(numE == 0){
			alert("Debe escoger por lo menos un equipo");
			return false;
		}
		
		var editar = document.getElementById("formEditar");
		editar.action ="<?php echo site_url("Modulos/HacerEditarModulo/")?>";
		editar.submit();
}



</script>

<div class="row-floid">

	<div class="span10">
	<form id="formEditar" type="post" method="post" onsubmit="editarMod();return false">
		<fieldset>
			<legend>Editar Módulos</legend>
	  		<div class="row-fluid">
				<div class="span6">
					<div class="row-fluid">
						<div class="span6">
							1. Escoja un módulo de la lista
						</div>
					</div>


					<div class="row-fluid" style="margin-left: 0%;margin-top:2%">			
						<div style="border:#cccccc  1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" ><!--  para el scroll-->
							<table id="listadoResultados" class="table table-hover">
								<thead>
									<tr>
				
									</tr>
								</thead>
								<tbody>
								
									
															
								</tbody>
							</table>
						</div>
					</div>



					<div class="row-fluid" style="margin-top:2%">
							<div class="span6">
								2. Sesiones del Módulo Temático
							</div>
					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
										
										
						<table id="sesiones" class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>



					<div class="row-fluid" style="margin-top:2%">
							<div class="span7">
								3. Profesores del Módulo Temático
							</div>
					</div>

					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
											
											
							<table id="equipo" class="table table-hover">
								<thead>

								</thead>
								<tbody>									
											
													
								</tbody>
							</table>
						</div>
					</div>



			
		</div>
		
				<div class="span6" style="margin-left: 2%; padding: 0%; ">
					<div class="row-fluid">
						<div class="span6">
							4. Nombre del módulo
						</div>
					</div>

					<div class="row-fluid" style="margin-top:2%">
						<div class="span6">
								<input id="cod_equipo2" type="hidden" name="cod_equipo2">
								<input id="cod_modulo" type="hidden" name="cod_modulo">
								<input id="nombre_modulo2" type="hidden" name="nombre_modulo2">
								<input required id="nombre_modulo" type="text" name="nombre_modulo" style="width:90%" maxlength="49"  onblur="nombreEnUso()">
						</div>
					</div>

					<div class="row-fluid" style="margin-top:2%">
							<div class="span6">
								5. Profesor Lider 
							</div>

					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px; margin-top:2%" >
										
										
						<table id="prof_lider" class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>


					<div class="row-fluid" style="margin-top:3%">
							<div class="span8">
								6. Descripción del Módulo 
							</div>					
					</div>
					<div class="row-fluid" >
						<div class="span8">		
								<div class="controls">
										<textarea id="descripcion" required name="descripcion_modulo" maxlength="99" rows="5" cols="100" style="width:414px; height: 142px"></textarea>
								</div>
							</div>
						
					</div>

					<div class="row-fluid" >
							<div class="span6">
								7. Requisitos del Módulo
							</div>
					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:150px; -webkit-border-radius: 4px" >
										
										
						<table id="requisitos" class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>
					<div class="row-fluid" style="margin-top: 2%">
						<div class= "span4" style="margin-left:43%">
							<button class ="btn" type="submit" style="width: 111px">
								<div class="btn_with_icon_solo">Ã</div>
								&nbsp Modificar
							</button>
						</div>
						<div class= "span3" style="margin-left:0%">
							<button class ="btn" onclick="Cancelar();return false" style="width:105px">
								<div class="btn_with_icon_solo">Â</div>
								&nbsp Cancelar
							</button>
						</div>
					</div>
				</div>
			</div>	
		</fieldset>
		</form>
	</div>	
</div>