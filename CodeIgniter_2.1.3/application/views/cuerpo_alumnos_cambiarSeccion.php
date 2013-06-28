


<script type="text/javascript">
	function cambioSeccion(){
		var seccion1 = document.getElementsByName("cod_seccion1");
		var seccion2 = document.getElementsByName("cod_seccion2");
		var cont;
		var numS1;
		var numS2;
		for(cont=0;cont < seccion1.length;cont++){
			if(seccion1[cont].checked == true){
				numS1 = cont;
				cont = seccion1.lenght;
			}
		}
		for(cont=0;cont < seccion2.length;cont++){
			if(seccion2[cont].checked == true){
				numS2 = cont;
				cont = seccion2.lenght;
			}
		}
	
		if(seccion1[numS1].value == seccion2[numS2].value){		
			$('#modalSeccionIgual').modal();
			return false;
		}
				
		$('#modalConfirmacion').modal();
	
	}
</script>

<script type="text/javascript">
	function mostrarS(cod_seccion,tipo_lista){
	//
	$.ajax({//
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/obtenerAlumnosSeccion") ?>", /* Se setea la url del controlador que responderá */
			data: { cod_seccion_post: cod_seccion},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				var tablaResultados = document.getElementById(tipo_lista+"tabla");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, input,nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre alumnos de sesión");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					input = document.createElement('input');
					input.setAttribute('type','checkbox');
					if(tipo_lista == "lista1_"){
						input.setAttribute('name','seleccionadosS1[]');
					}
					else{
						input.setAttribute('name','seleccionadosS2[]');
					}
					input.setAttribute('value', arrayRespuesta[i].rut);
					nodoTexto = document.createTextNode(" "+arrayRespuesta[i].apellido1+" "+arrayRespuesta[i].apellido2+" "+arrayRespuesta[i].nombre1+" "+arrayRespuesta[i].nombre2);
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
	//
	}
</script>

<script type="text/javascript">
function ordenarFiltroSeccion(tipo_seccion){
	var filtroLista = document.getElementById(tipo_seccion).value;
	var arreglo = new Array();
	var ocultarInput;
	var ocultarTd;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($secciones)){
		echo 'arreglo['.$contadorE.'] = "'.$secciones[$contadorE].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultarInput=document.getElementById(tipo_seccion+arreglo[cont]);
		ocultarTd=document.getElementById(tipo_seccion+cont);
		if(0 > arreglo[cont].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultarTd.style.display='none';
			//ocultarInput.checked = false;
		}
		else
		{
			ocultarTd.style.display='';
		}
    }
}
</script>





<div class= "row-fluid">
	<div class= "span10">
		<fieldset>
			<legend>Cambio de sección</legend>
			<div class= "row-fluid">
				<form id="FormS1" type="post"   method="post" action="<?php echo site_url("Alumnos/HacerCambiarSeccionAlumnos/")?>"><!--FORM PRIMERA SECCION-->
				<div class="span6">
					<div class="row-fluid">
						<div class="span6"> 
							1.- Seleccione una sección:
								<br>
								<br>
								<br>
								<br>
								<br>
								<br>
								Mover de sección:
								<button class="btn"  type="button" onclick="cambioSeccion()" name="botonCambio" value="1">   >   </button>
				
						</div>
						<div class="span6" style="align:right">
							
							<div class="controls">
								<input type="text" onkeyup="ordenarFiltroSeccion('filtro1_')" id="filtro1_" placeholder="Filtro de Sección" style="width: 93%">
							</div>
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px;-webkit-border-radius: 4px" >
								<table class="table table-hover">
									<thead>
									</thead>
										<tbody>									
											<?php
												$contador=0;
												$comilla= "'";
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro1_'.$contador.'" ><input required onclick="mostrarS('.$comilla.$secciones[$contador][0].$comilla.','.$comilla.'lista1_'.$comilla.')" required id="filtro1_'.$secciones[$contador][0].'" value="'.$secciones[$contador][0].'" name="cod_seccion1" type="radio" ></input> '.$secciones[$contador][1].'</td>';
												echo '</tr>';
												$contador = $contador + 1;
												}
											?>

										</tbody>
								</table>		
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<br>
						Estudiantes de la sección:
						 
						<br>
						<br>
						<div class="span11">
						
							<div class="row-fluid">
								<div class="span6">
									
									
									<input id="lista1_filtro"  onkeyup="ordenarFiltro('lista1_')" type="text" placeholder="Filtro búsqueda" style="width:90%">
								</div>
							

								<div class="span6">
										
										
										<select id="lista1_tipoDeFiltro" title="Tipo de filtro">
										<option value="1">Filtrar por Nombre</option>
										<option value="3">Filtrar por Apellido paterno</option>
										<option value="4">Filtrar por Apellido materno</option>
										<option value="7">Filtrar por Código carrera</option>
										</select>
								</div> 
							</div>
						</div>
					</div>
				
			
					<div class="row-fluid" style="margin-left: 0%;">
						

							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover" id="lista1_tabla">

								</table>
							</div>

					</div>
				</div>
				<div class="span6">
					<div class="row-fluid">
						<div class="span6"> 
							2.- Seleccione una segunda sección:
							
								<br>
								<br>
								<br>
								<br>
								<br>
								Mover de sección:
									<button class="btn" type="button" onclick="cambioSeccion()" name="botonCambio" value="2">   <   </button>
				
						</div>
						<div class="span6">
							
							<div class="controls">
								<input type="text" onkeyup="ordenarFiltroSeccion('filtro2_')" id="filtro2_" placeholder="Filtro de Sección" style:"width:93%">
							</div>
							<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px;-webkit-border-radius: 4px" >
								<table class="table table-hover">
									<thead>
									</thead>
										<tbody>									
											<?php
												$contador=0;
												$comilla= "'";
												while ($contador<count($secciones)){
												echo '<tr>';
												echo '<td id="filtro2_'.$contador.'" ><input required onclick="mostrarS('.$comilla.$secciones[$contador][0].$comilla.','.$comilla.'lista2_'.$comilla.')" required id="filtro2_'.$secciones[$contador][0].'" value="'.$secciones[$contador][0].'" name="cod_seccion2" type="radio" >'.$secciones[$contador][1].'</td>';
												echo '</tr>';
												$contador = $contador + 1;
												}
											?>
										</tbody>
								</table>
							</div>
						</div>
					</div>
				<div class="row-fluid">
					<br>
					Estudiantes de la sección:
					<br>
					<br>
					<div class="span11">
					
						<div class="row-fluid">
							<div class="span6">
								<input id="lista2_filtro"  onkeyup="ordenarFiltro('lista2_')" type="text" placeholder="Filtro búsqueda" style="width:90%">
							</div>
							<div class="span6">
									<select id="lista2_tipoDeFiltro" title="Tipo de filtro" >
									<option value="1">Filtrar por Nombre</option>
									<option value="3">Filtrar por Apellido paterno</option>
									<option value="4">Filtrar por Apellido materno</option>
									<option value="7">Filtrar por Código carrera</option>
									</select>
							</div> 
						</div>
					</div>
				</div>
					<div class="row-fluid" style="margin-left: 0%;">

							<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px">
								<table class="table table-hover" id="lista2_tabla">

								</table>
							</div>

					</div>
				</div>
				
				<!-- Modal de confirmación -->
				<div id="modalConfirmacion" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Confirmación</h3>
					</div>
					<div class="modal-body">
						<p>Se realizará el cambio de sección ¿Está seguro?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
						<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
					</div>
				</div>

				<!-- Modal de aviso que no ha seleccionado algo -->
				<div id="modalSeccionIgual" class="modal hide fade">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Se han seleccionado dos secciones iguales</h3>
					</div>
					<div class="modal-body">
						<p>Por favor seleccione dos secciones distintas para hacer el cambio</p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
				</form><!--FORM SEGUNDA SECCION-->
			</div>

			
		</fieldset>
				
	</div>
</div>


















