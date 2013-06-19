<?php
/**
* Este Archivo corresponde al cuerpo central de la vista ver grupos de contacto en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<!--<fieldset>
	<legend>&nbsp;Ver Grupos de Contacto&nbsp;</legend>
	<div class="inicio" title="Paso 1: Selección de plantilla">
	<form action="<?php  ?>" method='post'>
	<?php
		$attributes = array();
		echo form_open('GruposContactos/editarGrupos',$attributes);
	?>
		<div class="texto1">
			Seleccione un Grupo de Contacto.
		</div>
		<div class="seleccion" >
			<select id="nombreGrupo" title="Grupos de Contacto" name="id_grupo">
			<?php for ($i = 0; $i < count($rs_nombres_contacto); $i++) { ?>
					  <option value ="<?php echo $rs_nombres_contacto[$i]['ID_FILTRO_CONTACTO']; ?>"><?php echo $rs_nombres_contacto[$i]['NOMBRE_FILTRO_CONTACTO']; ?></option>
			<?php } ?>
			
			</select>
			<button class ="btn" style="margin-top:-10px;" type="submit"  title="Avanzar a selección de contactos">Ver Grupo</button>
		
		</div>
		
		
	<?php echo form_close(""); ?>
	</div>
	<br />

		<div id="listaDestinatarios" class="span5">
			<table id="tabla2" class="table table-hover table-bordered" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-bottom:0px">
				<thead>
					<tr>
						<th>
						</th>
						<th >
							Grupo 

						</th>
					</tr>
				</thead>				
				
				<tbody id="tbody2">
					<?php if(isset($rs_estudiantes)){ ?>
					<?php for ($i = 0; $i <count($rs_estudiantes); $i++) {  ?>
						<?php if(existe_palabra($rutes['QUERY_FILTRO_CONTACTO'],$rs_estudiantes[$i][0])){ ?>
						<tr rut="<?php echo $rs_estudiantes[$i]['0'] ?>" >
							<td>
							
							</td>
							<td>
								<?php echo $rs_estudiantes[$i][1]." ".$rs_estudiantes[$i][2]." ".$rs_estudiantes[$i][3]." ".$rs_estudiantes[$i][4]; ?>
							</td>
						</tr>
					
					<?php } } ?>
					<?php for ($i = 0; $i <count($rs_profesores); $i++) {  ?>
						<?php if(existe_palabra($rutes['QUERY_FILTRO_CONTACTO'],$rs_profesores[$i][0])){ ?>
						<tr rut="<?php echo $rs_profesores[$i]['0'] ?>" >
							<td>
							
							</td>
							<td>
								<?php echo $rs_profesores[$i][1]." ".$rs_profesores[$i][2]." ".$rs_profesores[$i][3]." ".$rs_profesores[$i][4]; ?>
							</td>
						</tr>
					
					<?php } } ?>
					<?php for ($i = 0; $i <count($rs_ayudantes); $i++) { ?>
						<?php if(existe_palabra($rutes['QUERY_FILTRO_CONTACTO'],$rs_ayudantes[$i][0])){ ?>
						<tr rut="<?php echo $rs_ayudantes[$i]['0'] ?>" >
							<td>
							
							</td>
							<td>
								<?php echo $rs_ayudantes[$i][1]." ".$rs_ayudantes[$i][2]." ".$rs_ayudantes[$i][3]." ".$rs_ayudantes[$i][4]; ?>
							</td>
						</tr>
					<?php } } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	    
</fieldset>

-->
<!--  -->

<script type="text/javascript">
	function DetalleGrupo(id_grupo){
		
			document.getElementById("num_sala").innerHTML = num_sala;
			document.getElementById("capacidad").innerHTML = capacidad;
			document.getElementById("ubicacion").innerHTML = ubicacion;
			var imp= new Array();	
			<?php
				$contadorE = 0;
				while($contadorE<count($salaImplemento)){
					echo 'imp['.$contadorE.']=new Array();';
					echo 'imp['.$contadorE.'][0]= "'.$salaImplemento[$contadorE][0].'";';//sala
					echo 'imp['.$contadorE.'][1]= "'.$salaImplemento[$contadorE][2].'";';//nombre
					echo 'imp['.$contadorE.'][2]= "'.$salaImplemento[$contadorE][3].'";';//descripcion	
					$contadorE = $contadorE + 1;
				}
			?>
			var cont;
			var algo='';
			for(cont=0;cont < imp.length;cont++){
				if(imp[cont][0]==cod_sala){
					if(algo!=''){
						algo= algo+"\n"+"		"+imp[cont][1];
					}
					else {
						algo=imp[cont][1];
					}
				}
			}
			
			document.getElementById("impDetalle").innerHTML=algo; 	
			
	}
</script>

						
<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;

	
	var arreglo = new Array();
	var sala;
	var ocultar;
	var cont;
	
	<?php
	$contadorE = 0;
	while($contadorE<count($rs_nombres_contacto)){
		echo 'arreglo['.$contadorE.']=new Array();';
		echo 'arreglo['.$contadorE.']["NOMBRE_FILTRO_CONTACTO"] = "'.$rs_nombres_contacto[$contadorE]['NOMBRE_FILTRO_CONTACTO'].'";';
		$contadorE = $contadorE + 1;
	}
	?>
	
	
	for(cont=0;cont < arreglo.length;cont++){
		ocultar=document.getElementById(cont);
		if(0 > arreglo[cont]['NOMBRE_FILTRO_CONTACTO'].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
		}
		else{
			ocultar.style.display='';
		}
    }
}
</script>

<div class="row-fluid">
<div class="span10">
<fieldset>
	<legend>Ver Sala</legend>
	<div class="row-fluid">
		<div class="span4">
			<div class="row-fluid">
				<div class="span6">
					1.-Listado sala
				</div>
			</div>
			<div class="row-fluid">
				<div>
					<div class="row-fluid">	
						<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtrar por nombre" style="width:90%">
					</div>	
				</div>
			</div>
			<div class="row-fluid" style="margin-left: 0%;">
					<div style="border:#cccccc  1px solid;overflow-y:scroll;height:330px; -webkit-border-radius: 4px" ><!--  para el scroll-->
						<table class="table table-hover">
							<thead>
								<tr>
									<th >
										Nombre de Grupo
									</th>
								</tr>
							</thead>
							<tbody>
							
								<?php
								$contador=0;
								$comilla= "'";
								echo '<form id="formDetalle" type="post">';
								while ($contador<count($rs_nombres_contacto)){
									echo '<tr>';
									echo	'<td  id="'.$contador.'" onclick="DetalleGrupo('.$comilla.$rs_nombres_contacto[$contador]['ID_FILTRO_CONTACTO'].$comilla.')" style="text-align:left;">'. $rs_nombres_contacto[$contador]['NOMBRE_FILTRO_CONTACTO'].'</td>';
									echo '</tr>';
																
									$contador = $contador + 1;
								}
								echo '</form>';
								?>
														
							</tbody>
						</table>
					</div>
				
			
				<!--</div>-->
			</div>
		</div>
		<div class="span8" style="margin-left: 2%; padding: 0%; ">
		2.-Detalle del Grupo:
		  	<div id="listaDestinatarios" style="margin-top:50px;">
				<table id="tabla2" class="table table-hover table-bordered" style=" width:100%; display:block; height:331px; cursor:pointer;overflow-y:scroll;margin-bottom:0px">
					<thead>
						<tr>
							<th >
								Nombre 
							</th>
							<th>
								Tipo
							</th>
							<th>
								Email
							</th>
						</tr>
					</thead>
					
					<?php
						function existe_palabra($texto,$palabra){  
							if(substr_count($texto, $palabra) !== 0 ){  
								return true;  
							}else{  
								return false;  
							}  
						} 

					?>
					
					
					<tbody id="tbody2">
						
					</tbody>
				</table>
			</div>

		</div>
	</div>
</fieldset>
</div>
</div>