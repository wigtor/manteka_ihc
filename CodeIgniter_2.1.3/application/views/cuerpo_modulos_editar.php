<script>
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
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "modulo_"+arrayRespuesta[i].cod_mod);
					tr.setAttribute("onClick", "detalleModulo('"+arrayRespuesta[i].cod_mod"','"+arrayRespuesta[i].descripcion"','"+arrayRespuesta[i].cod_equipo"')");
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
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el modulo");
				
				}
				else{
					alert("Error al agregar");
			
				}
	}


function ordenarFiltro(numeroLista){
	var filtroLista = document.getElementById(numeroLista+"filtroLista").value;
	var tipoDeFiltro = document.getElementById(numeroLista+"tipoDeFiltro").value;

	
	var arreglo = new Array();
	var alumno;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($profesores)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][0] = "'.$profesores[$contadorE][0].'";';//rut
		echo 'arreglo['.$contadorE.'][1] = "'.$profesores[$contadorE][1].'";';//nombre
		echo 'arreglo['.$contadorE.'][2] = "'.$profesores[$contadorE][2].'";';//apellido
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarTd=document.getElementById(numeroLista+"profesores_"+cont);
		//ocultar =document.getElementById(arreglo[cont][0]);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			//ocultar.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			//ocultar.style.display='';
			ocultarTd.style.display='';
		}
    }
}

function sacarDelEquipo(contadorProfe){
	
	var numero_profesores =	<?php echo count($profesores);?>;
	var cont = 0;
	
	for(cont=0;cont < numero_profesores;cont++){	
		document.getElementById("2profesores_"+cont).style.display='';
	}
	document.getElementById("2profesores_"+contadorProfe).style.display='none';
	document.getElementById("cb_2profesores_"+contadorProfe).checked=false;
}

function nombreEnUso(){
	nombre_tentativo = document.getElementById("nombre_modulo");
	
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
		if(arreglo[cont].toLowerCase () == nombre_tentativo.value.toLowerCase ()){
				alert("Nombre en uso. Use otro nombre");
				nombre_tentativo.value="";
				return;
		}

    }

}
function validarMod(){
		var sesion = document.getElementsByName("cod_sesion[]");
		var equipo = document.getElementsByName("cod_profesor_equipo[]");
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

					<div class="row-fluid">
						<div class="span11">
							<div class="row-fluid">
								<div class="span8">
									<input id="filtroLista"   type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
								<div class="span3">
									<button class ="btn" type="submit" >Buscar</button>
								</div>
							</div>
						</div>
					</div>
					2. Seleccione módulo a editar
					<div class="row-fluid" style="margin-left: 0%;margin-top:2%">			
						<div style="border:#cccccc  1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" ><!--  para el scroll-->
							<table id="listadoResultados"class="table table-hover">
								<thead>
									<tr>
										<th style="text-align:left;"><br><b>Nombre módulo</b></th>
										
									</tr>
								</thead>
								<tbody>
								
									
															
								</tbody>
							</table>
						</div>
					</div>



					<div class="row-fluid" style="margin-top:8%">
							<div class="span6">
								3. Sesiones del Módulo Temático
							</div>
					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" >
										
										
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>



					<div class="row-fluid" style="margin-top:2%">
							<div class="span7">
								4. Profesores del Módulo Temático
							</div>
					</div>

					<div class="row-fluid">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" >
											
											
							<table class="table table-hover">
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
							5. Nombre del módulo
						</div>
					</div>

					<div class="row-fluid">
						<div class="span6">
								<input required id="nombre_modulo" type="text" name="nombre_modulo" style="width:90%">
						</div>
					</div>

					<div class="row-fluid" style="margin-top:2%">
							<div class="span6">
								6. Profesor Lider 
							</div>

					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px; margin-top:2%" >
										
										
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>


					<div class="row-fluid" style="margin-top:19%">
							<div class="span8">
								7. Descripción del Módulo 
							</div>					
					</div>
					<div class="row-fluid" style="margin-top:1%">
						<pre style="margin-top: 2%; padding: 2%; height:6%">


						</pre>
					</div>

					<div class="row-fluid" >
							<div class="span6">
								8. Requisitos del Módulo
							</div>
					</div>

					<div style="border:#cccccc 1px solid;overflow-y:scroll;height:30%; -webkit-border-radius: 4px" >
										
										
						<table class="table table-hover">
							<thead>

							</thead>
							<tbody>									
										
												
							</tbody>
						</table>
					</div>
					<div class="row-fluid" style="margin-top: 2%">
						<div class= "span4" style="margin-left:4%">
							<button class ="btn" type="submit" >Actualizar Módulo</button>
						</div>
						<div class= "span3" style="margin-left:0%">
							<button class ="btn" type="reset" >Cancelar</button>
						</div>
					</div>
				</div>
			</div>	
		</fieldset>
	</form>
	</div>
</div>