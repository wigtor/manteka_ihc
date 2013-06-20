<script type="text/javascript">



function DetalleSeccion(cod_seccion){
			/*document.getElementById("seccion").value = cod_seccion;
			var editar = document.getElementById("formDetalle");
			editar.action = "<?php echo site_url("Secciones/verSecciones/") ?>/";
			editar.submit();*/

			/* Defino el ajax que hará la petición al servidor */
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: "<?php echo site_url("Secciones/postVerSeccion") ?>", /* Se setea la url del controlador que responderá */
				data: { seccion: cod_seccion }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */


				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					//console.log (respuesta);
					/* Obtengo los objetos HTML donde serán escritos los resultados */
					var seccion = document.getElementById("nombre_seccion");
					var modulo = document.getElementById("modulo");
					var dia = document.getElementById("dia");
					
					document.getElementById("codSeccion").value = cod_seccion;
					
					/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
					var datos = jQuery.parseJSON(respuesta);

					/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
					seccion.innerHTML = datos[0];
					modulo.innerHTML = datos[1];
					dia.innerHTML = datos[2];
					

					if (datos[1] == null){
						modulo.innerHTML= "sin asignación";
					}
					if(datos[2]==null){
						dia.innerHTML = "sin asignación";
						
					}

					/* Quito el div que indica que se está cargando */
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();

				}
		}
		);

		$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: "<?php echo site_url("Secciones/AlumnosSeccion") ?>", // Se setea la url del controlador que responderá */
		data: { seccion: cod_seccion}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
			var tablaResultados = document.getElementById("listadoResultados");
			$(tablaResultados).find('tbody').remove();
			var arrayRespuesta = jQuery.parseJSON(respuesta);

			
			//CARGO EL CUERPO DE LA TABLA
			tbody = document.createElement('tbody');
			if (arrayRespuesta.length == 0) {
				tr = document.createElement('tr');
				td = document.createElement('td');
				$(td).html("No se encontraron resultados");
				$(td).attr('colspan',tiposFiltro.length);
				tr.appendChild(td);
				tbody.appendChild(tr);
			}

			for (var i = 0; i < arrayRespuesta.length; i++) {
				tr = document.createElement('tr');
				tr.setAttribute('style', "cursor:pointer");
				for (var j = 0; j < 5; j++) {
					td = document.createElement('td');
					tr.setAttribute("onClick", "verDetalle(this)");
					if(j==4){
						nodoTexto = document.createTextNode(arrayRespuesta[i][j]+" "+arrayRespuesta[i][j+1]);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
						j=j+6;
					}
					else{

						nodoTexto = document.createTextNode(arrayRespuesta[i][j]);
						td.appendChild(nodoTexto);
						tr.appendChild(td);
					}
				}
		

				tbody.appendChild(tr);
			}
			tablaResultados.appendChild(tbody);

			/* Quito el div que indica que se está cargando */
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();

			
			$('tbody tr').on('click', function(event) {
				$(this).addClass('highlight').siblings().removeClass('highlight');
			});
		}
		});
		
		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

	}
			
	
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	//var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;
	var tipoDeFiltro=1;
	
	var arreglo = new Array();
	var sala;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($seccion)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.'][1] = "'.$seccion[$contadorE][1].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultar=document.getElementById("rs_seccionTd_"+cont);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
		}
		else
		{
			ocultar.style.display='';
		}
    }
}
</script>

<div class="row-fluid">
    <div class= "span11">
        <fieldset>
			<legend>Ver Sección</legend>
            	<form id="formDetalle" type="post" method="post">
            	
            
            
            <div class="row-fluid">
                <div class="span5">
                    <div class="row-fluid">
                        <div class="span7">
                            1.-Seleccionar sección
                        </div>
					</div>
			<div class="row-fluid">
				<div class="span11">
					
					<div class="controls controls-row">
			    		<div class="input-append span7">
							<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
							<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
			
					</div>	
						
				</div>
			</div>
			<div class="row-fluid" style="margin-left: 0%;">
				<!--<div class="span9">-->

					<div style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
							<tbody>
								<input id="seccion" type="text" name="cod_seccion" style="display:none">
								<?php
								$contador=0;
								$comilla= "'";
								
								while ($contador<count($seccion)){
									
									echo '<tr>';
									echo '<td  id="rs_seccionTd_'.$contador.'"  style="cursor:pointer"  onclick="DetalleSeccion('.$comilla.$seccion[$contador][0].$comilla.')"> '.$seccion[$contador][1].' </td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								
								?>
														
							</tbody>
						</table>
					</div>
				
			
				<!--</div>-->
			</div>

                </div>
                <div class="span7">
                    <div class="row-fluid">
                        <div class="span5">
                            2.-Información de la sección
                        </div>
                    </div>
                    <div class="row-fluid">
<pre style="margin-top: 0%; margin-left: 0%;">
Seccion: <b id="nombre_seccion"></b>
Día:     <b id="dia"></b>
Bloque:  <b id="modulo"></b>
</pre>
<input name="cod_seccion" type="hidden" id="codSeccion" value="">
                    </div>

                    <div class="row-fluid">
                        <div class="span5">
                            3.-Lista de Alumnos
                        </div>
                    </div>
                    
                    
                    <div class="row-fluid">
                        <div class="span13">
						<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
                            <table id="listadoResultados" class="table table-bordered">
                                <thead  bgcolor="#e6e6e6"  style="position:block">
                                    <tr>
                                        <th class="span2">Carrera</th>
                                        <th class="span2">RUT</th>
                                        <th class="span3">Apellido paterno</th>
                                        <th class="span3">Apellido materno</th>
                                        <th class="span9">Nombres</th>
                                    </tr>
                                </thead>
                                    
                                <tbody>
                                    	
                                </tbody>
                                
                            </table>
						</div>
                        </div>
                    </div>

                </div>
            </div>
         </form>
        </fieldset>
    </div>
</div>