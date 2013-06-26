<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Se ha agregado el ayudante");
				}
				else{
					alert("Error al agregar");
				}
	}
</script>

<script type="text/javascript">
function ordenarFiltro(){
	var filtroLista = document.getElementById("filtroLista").value;
	var tipoDeFiltro = document.getElementById("tipoDeFiltro").value;

	
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
		ocultarTd=document.getElementById("profesoresTd_"+cont);
		ocultar =document.getElementById(arreglo[cont][0]);
		if(0 > arreglo[cont][Number(tipoDeFiltro)].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
			ocultar.style.display='none';
			ocultarTd.style.display='none';
		}
		else
		{
			ocultar.style.display='';
			ocultarTd.style.display='';
		}
    }
}

	function resetearAyudante() {

		var rutDetalle = document.getElementById("rutEditar");
		var nombre1Detalle = document.getElementById("nombreunoEditar");
		var nombre2Detalle = document.getElementById("nombredosEditar");
		var apellido1Detalle = document.getElementById("apellidopaternoEditar");
		var apellido2Detalle = document.getElementById("apellidomaternoEditar");
		var correoDetalle = document.getElementById("correoEditar");
		var fonoDetalle = document.getElementById("fono");
		var correoDetalle2 = document.getElementById("correoEditar2");
		$(rutDetalle).val("");
		$(nombre1Detalle).val("");
		$(nombre2Detalle).val("");
		$(apellido1Detalle).val("");
		$(apellido2Detalle).val("");
		$(correoDetalle).val("");
		$(correoDetalle2).val("");
		$(fonoDetalle).val("");
	}

	function agregarAyudante(){
		rut = $("#rut_ayudante").val();
		nombre1Detalle = $("#nombre1_ayudante").val();
		nombre2Detalle = $("#nombre2_ayudante").val();
		apellido1Detalle = $("#apellido1_ayudante").val();
		apellido2Detalle = $("#apellido2_ayudante").val();
		correoDetalle = $("#correo_ayudante").val();
		if ((rut == "") || (nombre1Detalle == "") || (apellido1Detalle == "") || (apellido2Detalle == "") || (correoDetalle == "")) {
			return; //Faltan campos!!!
		}
		$('#modalConfirmacion').modal();
	}
</script>


<fieldset>
	<legend>Agregar Ayudante</legend>
	<?php
		$attributes = array('id' => 'formAgregar', 'class' => 'form-horizontal');
		echo form_open('Ayudantes/insertarAyudante', $attributes);
	?>
		<div class="row-fluid">
			<div class="span6">
				<font color="red">* Campos Obligatorios</font>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class= "span6" >
				<p>Complete los datos del formulario para ingresar un ayudante</p>
			</div>
		</div>



		<div class="row-fluid">
			<div class= "span6" >
				<div class="control-group">
					<label class="control-label" for="rut_ayudante" style="cursor: default">1-.<font color="red">*</font> RUT</label>
					<div class="controls">
						<input id="rut_ayudante" name="rut_ayudante" maxlength="9" min="1" type="text" pattern="\d{8,9}" class="span12" placeholder="Ej:177858741" title="Ingrese su rut sin puntos ni guion" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre1_ayudante" style="cursor: default">2-.<font color="red">*</font> Primer nombre</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="nombre1_ayudante" name="nombre1_ayudante" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nombre2_ayudante" style="cursor: default">3-. Segundo nombre</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="nombre2_ayudante" name="nombre2_ayudante" maxlength="20" >
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido1_ayudante" style="cursor: default">4-.<font color="red">*</font> Apellido Paterno</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellido1_ayudante" name="apellido1_ayudante" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="apellido2_ayudante" style="cursor: default">5-.<font color="red">*</font> Apellido Materno</label>
					<div class="controls">
						<input type="text" pattern="[a-zA-ZñÑáéíóúüÁÉÍÓÚÑ\-_çÇ& ]+" class="span12" title="Use solo letras para este campo" id="apellido2_ayudante" name="apellido2_ayudante" maxlength="20" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="correo_ayudante" style="cursor: default">6-.<font color="red">*</font> Correo</label>
					<div class="controls">
						<input type="email" id="correo_ayudante" name="correo_ayudante" class="span12" maxlength="199" placeholder="nombre_usuario@miemail.com" required>
					</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputInfo" style="cursor: default">7-.<font color="red">*</font>Asignar profesor</label>
					<div class="controls">
						<input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" class="span12" placeholder="Filtro búsqueda">
						<div class="row-fluid" style="margin-top:2%">
							<div class="span12">
								<div style="border:#cccccc 1px solid;overflow-y:scroll;height:200px; -webkit-border-radius: 4px" >
								
								
									<table class="table table-hover">
										<thead>

										</thead>
										<tbody>									
								
										<?php
										$contador=0;
										while ($contador<count($profesores)){
											echo '<tr>';
											echo '<td id="profesoresTd_'.$contador.'" ><input required value="'.$profesores[$contador][0].'" name="cod_profesores" type="radio" >'.$profesores[$contador][1].'  '.$profesores[$contador][2].'</td>';
											echo '</tr>';
											$contador = $contador + 1;
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
				<div class="controls pull-right">
						<button type="button" class="btn" onclick="agregarAyudante()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearProfesor()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>&nbsp;

						<!-- Modal de confirmación -->
						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se van a guardar los cambios del ayudante ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	<?php echo form_close(""); ?>			
</fieldset>
