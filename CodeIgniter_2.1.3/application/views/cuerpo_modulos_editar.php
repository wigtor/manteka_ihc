<script>
	var tiposFiltro = ["Nombre", "Descripción"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", ""];
	var prefijo_tipoDato = "modulo_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Modulos/getModulosTematicosAjax") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/modulos") ?>";

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

	function verDetalle(elemTabla) {
		/* Obtengo el código del módulo clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var cod_mod = idElem.substring(prefijo_tipoDato.length, idElem.length);

		var descripcion, cod_equipo, name_mod; //Se setean en el primer ajax

		$.ajax({//AJAX PARA OBTENER LOS DETALLES DEL MÓDULO
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Modulos/postDetallesModulo") ?>", /* Se setea la url del controlador que responderá */
			async: false, //con esto se hace que el ajax sea sincrono con la función javascript
			data: { cod_modulo: cod_mod},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var moduloRespuesta = jQuery.parseJSON(respuesta);
				cod_equipo = $.trim(moduloRespuesta.cod_equipo);
				descripcion = $.trim(moduloRespuesta.descripcion);
				name_mod = $.trim(moduloRespuesta.nombre_mod);
				if($.trim(moduloRespuesta.descripcion) ==""){
					moduloRespuesta.descripcion = "No tiene descripcion";
				}
			}
		});

		$('#nombre_modulo').val(name_mod);
		$('#cod_modulo').val(cod_mod);
		$('#nombre_modulo2').val(name_mod);
		$('#cod_equipo2').val(cod_equipo);
		if(descripcion == "null"){
			descripcion = "No hay descripción";
		}
		$('#descripcion').val(descripcion);
		
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
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('value', arrayRespuesta[i][0]);
						input.setAttribute("name", "sesion[]");
						if(arrayRespuesta[i][1] == cod_mod){
							input.setAttribute('checked', 'true');
						}
						td.setAttribute('title', arrayRespuesta[i][2]);
						nodoTexto = document.createTextNode(" "+arrayRespuesta[i][3]);
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
					if( arrayRespuesta[i][0] == cod_equipo  || arrayRespuesta[i][0] == "" || arrayRespuesta[i][7] == cod_equipo
						|| (arrayRespuesta[i][0] != cod_equipo && arrayRespuesta[i][6]==1)
						|| (arrayRespuesta[i][7] != cod_equipo && arrayRespuesta[i][8]==1)
					){
						tr = document.createElement('tr');
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('id',arrayRespuesta[i][1]);
						input.setAttribute('value', arrayRespuesta[i][1]);
						input.setAttribute("name", "profesores[]");
						if(	(arrayRespuesta[i][0] == cod_equipo && arrayRespuesta[i][6]==1 && arrayRespuesta[i][7] != cod_equipo && arrayRespuesta[i][8]==0)
						|| (arrayRespuesta[i][0] != cod_equipo && arrayRespuesta[i][6]==0 && arrayRespuesta[i][7] == cod_equipo && arrayRespuesta[i][8]==1)){
							input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','1','9')");
							}
						else{
							input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','1','0')");
						}
						if( (arrayRespuesta[i][0] == cod_equipo && arrayRespuesta[i][6] != 1) || (arrayRespuesta[i][7] == cod_equipo && arrayRespuesta[i][8] != 1)){
							input.setAttribute('checked', 'true');
						}
						nodoTexto = document.createTextNode(" "+arrayRespuesta[i][2]+" "+arrayRespuesta[i][3]+" "+arrayRespuesta[i][4]+" "+arrayRespuesta[i][5]);
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
					if( arrayRespuesta[i][0] == cod_equipo  || arrayRespuesta[i][0] == "" || arrayRespuesta[i][7] == cod_equipo
						|| (arrayRespuesta[i][0] != cod_equipo && arrayRespuesta[i][6]==0)
						|| (arrayRespuesta[i][7] != cod_equipo && arrayRespuesta[i][8]==0)
					)			
					{
						tr = document.createElement('tr');
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','radio');
						input.setAttribute('value', arrayRespuesta[i][1]);
						input.setAttribute('id',arrayRespuesta[i][1]);
						input.setAttribute("name", "cod_profesor_lider");
						if(	(arrayRespuesta[i][0] == cod_equipo && arrayRespuesta[i][6]==0 && arrayRespuesta[i][7] != cod_equipo && arrayRespuesta[i][8]==1)
						|| (arrayRespuesta[i][0] != cod_equipo && arrayRespuesta[i][6]==1 && arrayRespuesta[i][7] == cod_equipo && arrayRespuesta[i][8]==0)){
							input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','2','9')");
						}
						else{
							input.setAttribute("onClick", "noPuedeEstar('"+arrayRespuesta[i][1]+"','2','0')");
							}
						if( (arrayRespuesta[i][6] == 1 && arrayRespuesta[i][0] == cod_equipo)
							||	(arrayRespuesta[i][7] == cod_equipo && arrayRespuesta[i][8]==1)
						){
							input.setAttribute('checked', 'true');
						}
						nodoTexto = document.createTextNode(" "+arrayRespuesta[i][2]+" "+arrayRespuesta[i][3]+" "+arrayRespuesta[i][4]+" "+arrayRespuesta[i][5]);
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
						tr.setAttribute("style", "cursor:default");
						td = document.createElement('td');
						input = document.createElement('input');
						input.setAttribute('type','checkbox');
						input.setAttribute('value', arrayRespuesta[i][0]);
						input.setAttribute("name", "requisitos[]");
						if(arrayRespuesta[i][3] == 1){
							input.setAttribute('checked', 'true');
						}						
						if(arrayRespuesta[i][2]  == null){
							td.setAttribute('title', "Sin descripción");
						}else{
							td.setAttribute('title', arrayRespuesta[i][2]);
						}
						nodoTexto = document.createTextNode(" "+arrayRespuesta[i][1]);
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
		
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});
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
				$('#NombreEnUso').modal();
				nombre_tentativo.value="";
				return;
		}

    }

}
function noPuedeEstar(rut,num_lista,nopuede){
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
				$('#LiderDelEquipo').modal();
				document.getElementById(rut).checked = false;
				return;
			}
		}
		else{
			for(cont=0;cont < equipo.length;cont++){
				if(equipo[cont].checked == true && equipo[cont].value ==rut){
					$('#LiderDelEquipo').modal();
					document.getElementById(rut).checked = false;
					return;						
				}
			}
		}
		if(nopuede == 9){
			if(num_lista == 1){
				for(cont=0;cont < equipo.length;cont++){
					if(equipo[cont].checked == true && equipo[cont].value ==rut){
						$('#noDosequipos').modal();
						equipo[cont].checked = false;
						return;						
					}
				}			
			}
			else{
				for(cont=0;cont < lider.length;cont++){
					if(lider[cont].checked == true && lider[cont].value ==rut){
						$('#noDosequipos').modal();
						lider[cont].checked = false;
						return;						
					}
				}
			}
		}
}
function editarMod(){
		var sesion = document.getElementsByName("sesion[]");
		var equipo = document.getElementsByName("profesores[]");
		var cod=document.getElementById("cod_modulo").value;
		var nombre=document.getElementById("nombre_modulo").value;
		var des=document.getElementById("descripcion").value;

		var cont;
		var numS = 0;
		var numE = 0;
		for(cont=0;cont < sesion.length;cont++){
			if(sesion[cont].checked == true){
				numS = numS + 1;
			}
		}
		
		for(cont=0;cont < equipo.length;cont++){
			if(equipo[cont].checked == true){
				numE = numE + 1;
			}
		}if(numS == 0 &&cod!=""){
			$('#EscojaSesion').modal();
			return false;
		}
		if(numE == 0 && cod!=""){
			$('#EscojaEquipo').modal();
			return false;
		}
		
		if(cod==""){
			$('#EscojaModulo').modal();
			return false;
		}
		if(nombre!="" && des!=""){
			$('#modalConfirmacion').modal();
		}
		else{
			$('#modalFaltanCampos').modal();
			return false;
		}

}

</script>

<fieldset style="min-width: 1000px;">
	<legend>Editar Módulo</legend>
	<div class="row-fluid">
		<div class="span6">
			<font color="red">* Campos Obligatorios</font>
			<div class="controls controls-row">
				<div class="input-append span7">
					<input id="filtroLista" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(undefined)" placeholder="Filtro búsqueda">
					<button class="btn" onClick="cambioTipoFiltro(undefined)" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
				</div>
				<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<p>1.- Seleccione el módulo temático a editar:</p>
		</div>
		<div class="span6">
			<p>2.- Complete los datos del formulario para modificar el módulo temático:</p>
		</div>
	</div>
	<div class="row-fluid" >
		<div class="span6" style="border:#cccccc  1px solid;overflow-y:scroll;height:400px; -webkit-border-radius: 4px" ><!--  para el scroll-->
			<table id="listadoResultados" class="table table-hover">

			</table>
		</div>


		<div class="span6">
			<?php
				$attributes = array('id' => 'formEditar', 'class' => 'form-horizontal');
				echo form_open('Modulos/postEditarModulo', $attributes);
			?>
				<!-- nombre modulo -->
				<div class="control-group">
					<label class="control-label" for="nombre">1.- <font color="red">*</font> Nombre módulo:</label>
					<div class="controls">
						<input class="span12" id="nombre" required type="text" name="nombre" maxlength="49"  placeholder="Ej: Comunicación no verbal" onblur="nombreEnUso()">
					</div>
				</div>
				<br>

				<!-- descripción módulo temático -->
				<div class="control-group">
					<label class="control-label" for="descripcion">2.- <font color="red">*</font> Ingrese una descripción del módulo:</label>
					<div class="controls">
						<textarea required id="descripcion" name="descripcion" placeholder="Ingrese una descripción para el módulo temático" maxlength="99" rows="5" style="resize: none;" class="span12"></textarea>
					</div>
				</div>
				
				<!-- Requisitos módulo temático -->
				<div class="control-group">
					<label class="control-label" for="id_requisitos">3.- Agregar requisitos existentes:</label>
					<div class="controls">
						<select id="id_requisitos" name="id_requisitos[]" class="span12" title="asigne profesor" multiple="multiple">
						<?php
						if (isset($requisitosModulo)) {
							foreach ($requisitosModulo as $req) {
								?>
									<option value="<?php echo $req->id; ?>"><?php echo $req->nombre; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				<!--profesor lider-->
				<div class="control-group">
					<label class="control-label" for="id_profesorLider" >4.- <font color="red">*</font> Asignar profesor lider:</label>
					<div class="controls">
						<select required id="id_profesorLider" name="id_profesorLider" class="span12" title="asigne profesor lider">
						<?php
						if (isset($posiblesProfesoresLider)) {
							foreach ($posiblesProfesoresLider as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>
				<br>
				
				<!--equipo profesores-->
				<div class="control-group">
					<label class="control-label" for="id_profesoresEquipo" >5.- <font color="red">*</font> Profesores del equipo:</label>
					<div class="controls">
						<select required id="id_profesoresEquipo" name="id_profesoresEquipo[]" class="span12" title="Escoja los profesores del equipo" multiple="multiple">
						<?php
						if (isset($posiblesProfesoresEquipo)) {
							foreach ($posiblesProfesoresEquipo as $profe) {
								?>
									<option value="<?php echo $profe->id; ?>"><?php echo $profe->id.' - '.$profe->nombre1.' '.$profe->apellido1; ?></option>
								<?php 
							}
						}
						?>
						</select> 
					</div>
				</div>

				</br>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="agregarModulo()">
							<div class="btn_with_icon_solo">Ã</div>
							&nbsp; Agregar
						</button>
						<button class="btn" type="button" onclick="resetearModulo()" >
							<div class="btn_with_icon_solo">Â</div>
							&nbsp; Cancelar
						</button>
					</div>
					<?php
						if (isset($dialogos)) {
							echo $dialogos;
						}
					?>
				</div>
			<?php echo form_close(""); ?>
		</div>
	</div>
</fieldset>
