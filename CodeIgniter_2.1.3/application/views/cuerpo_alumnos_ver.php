<fieldset>
	<legend>Ver Alumnos</legend>
	<div class="row-fluid">
		<div class="span6">
			1.-Listado Alumnos
			<script type="text/javascript">
				function ordenarFiltro(largo){
					var filtroLista = document.getElementById("filtroLista").value;
					var arreglo = new Array();
					var alumno;
					var ocultar;
					var cont;
					
					<?php
					$contadorE = 0;
					while($contadorE<count($rs_estudiantes)){
						echo 'arreglo['.$contadorE.']=new Array();';
						echo 'arreglo['.$contadorE.'][1] = "'.$rs_estudiantes[$contadorE][1].'";';
						$contadorE = $contadorE + 1;
					}
					?>
					
					
					for(cont=0;cont < arreglo.length;cont++){
						alumno = document.getElementById(cont);
						ocultar=document.getElementById(cont);
						if(0 > arreglo[cont][1].indexOf(filtroLista)){
							ocultar.style.display='none';
						}
						else
						{
							ocultar.style.display='';
						}
				}
			}
			
			</script>
			<div class="span12"></div>
			
				<fieldset>
					<div class="span10">
					<input id="filtroLista"  onchange="ordenarFiltro(<?php echo count($rs_estudiantes)?>)" type="text" placeholder="Filtro búsqueda">
						<div class="btn-group" style="float: right;">
						  <a class="btn ">Filtrar por:</a>
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						  <ul class="dropdown-menu">
						    <li><a >Primer nombre</a></li>
						  </ul>
						</div>
					</div>
				</fieldset>
			
			<div class="row-fluid" style="margin-left: 3%;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th style="text-align:center;">Nombre Completo</th>
							
						</tr>
					</thead>
					<tbody>
					
						<?php
						$contador=0;
						
						echo '<form id="formDetalle" type="post">';
						while ($contador<count($rs_estudiantes)){
							
							echo '<tr>';
							echo	'<td  id="'.$contador.'"onclick="hacerSubmitDetalleAlumno('. $rs_estudiantes[$contador][0].')" style="text-align:center;">'. $rs_estudiantes[$contador][3].' '.$rs_estudiantes[$contador][4].' ' . $rs_estudiantes[$contador][1].' '.$rs_estudiantes[$contador][2].'</td>';
							echo '</tr>';
														
							$contador = $contador + 1;
						}
						echo '</form>';
						?>
						<script type="text/javascript">
							function hacerSubmitDetalleAlumno(rut_estudiante){
								var detalle = document.getElementById("formDetalle");
								detalle.action = "<?php echo site_url("Alumnos/VerPorBoton/") ?>/"+rut_estudiante;
								detalle.submit();
								
							}
						</script>
					</tbody>
				</table>
			</div>
		</div>
		<div class="span6" style="margin-left: 2%;">		
		2.-Detalle Alumnos:
	    <pre style="margin-top: 16%; margin-left: 3%;">
		<?php
		if(!empty($rs_estudiante)){
			echo "\nRut: ".$rs_estudiante[0]."\n";
			echo "Nombre: ".$rs_estudiante[1]."\n";
			echo "Apellido paterno: ".$rs_estudiante[3]."\n";
			echo "Apellido materno: ".$rs_estudiante[4]."\n";
			echo "Correo: ".$rs_estudiante[5]."\n";
			echo "Carrera: ".$rs_estudiante[7]."\n";
			echo "Sección: ".$rs_estudiante[6]."\n";
		}
		else {
			echo "\nRut:\n";
			echo "Nombre:\n";
			echo "Apellido paterno:\n";
			echo "Apellido materno:\n";
			echo "Correo:\n";
			echo "Carrera:\n";
			echo "Sección:\n";
		}
		?>
		
		</pre>

		</div>
	</div>
</fieldset>