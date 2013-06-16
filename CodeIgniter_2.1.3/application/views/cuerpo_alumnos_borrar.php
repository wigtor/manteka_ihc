<script type="text/javascript">
	
	if(Number("<?php echo $mensaje_confirmacion?>") != 2){
		if(Number("<?php echo $mensaje_confirmacion?>") != -1){
				alert("Alumno eliminado correctamente");
				}
				else{
					alert("Error al eliminar");
				}
	}
</script>

<script type="text/javascript">
	var tiposFiltro = ["Rut", "Nombre", "Apellido"]; //Debe ser escrito con PHP
	var valorFiltrosJson = ["", "", ""];
	var prefijo_tipoDato = "ayudante_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Alumnos/postBusquedaAlumnos") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/alumnos") ?>";

	function verDetalle(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("ayudante_".length, idElem.length);
		//var rut_clickeado = elemTabla;


		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Alumnos/postDetallesAlumnos") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */

				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutDetalle");
				var nombre1Detalle = document.getElementById("nombre1Detalle");
				var nombre2Detalle = document.getElementById("nombre2Detalle");
				var apellido1Detalle = document.getElementById("apellido1Detalle");
				var apellido2Detalle = document.getElementById("apellido2Detalle");
				var carreraDetalle = document.getElementById("carreraDetalle");
				var seccionDetalle = document.getElementById("seccionDetalle");
				var correoDetalle = document.getElementById("correoDetalle");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).html(datos.rut);
				$(nombre1Detalle).html($.trim(datos.nombre1));
				$(nombre2Detalle).html($.trim(datos.nombre2));
				$(apellido1Detalle).html($.trim(datos.apellido1));
				$(apellido2Detalle).html($.trim(datos.apellido2));
				$(carreraDetalle).html(datos.carrera);
				$(seccionDetalle).html(datos.nombre_seccion);
				$(correoDetalle).html(datos.correo);

				//ESTO ES DE QUIENES HICIERON EL BORRADO
				var rutInputHidden = document.getElementById("rutEliminar");
				$(rutInputHidden).val(datos.rut);

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
	function eliminarAlumno(){

		
		
		var rut = document.getElementById("rutEliminar").value;
		
		if(rut!=""){
					var answer = confirm("¿Está seguro de eliminar este estudiante?")
					if (!answer){
						var dijoNO = resetear();
						return false;
					}
					else{
						return true;
					}
		}
		else{
				alert("Selecione un estudiante");
				return false;
		}
	}

	function resetear() {
		//ESTO ES DE QUIENES HICIERON EL BORRADO
		var rutInputHidden = document.getElementById("rutEliminar");
		$(rutInputHidden).val("");
		/* Obtengo los objetos HTML donde serán escritos los resultados */
		var rutDetalle = document.getElementById("rutDetalle");
		var nombre1Detalle = document.getElementById("nombre1Detalle");
		var nombre2Detalle = document.getElementById("nombre2Detalle");
		var apellido1Detalle = document.getElementById("apellido1Detalle");
		var apellido2Detalle = document.getElementById("apellido2Detalle");
		var carreraDetalle = document.getElementById("carreraDetalle");
		var correoDetalle = document.getElementById("correoDetalle");
		var seccionDetalle = document.getElementById("seccionDetalle");
		
		/* Seteo los valores a string vacio */
		$(rutDetalle).html("");
		$(nombre1Detalle).html("");
		$(nombre2Detalle).html("");
		$(apellido1Detalle).html("");
		$(apellido2Detalle).html("");
		$(carreraDetalle).html("");
		$(correoDetalle).html("");
		$(seccionDetalle).html("");
	}
</script>

		<!--<form id="FormBorrar" type="post" onsubmit="eliminarAlumno();return false" method="post">-->
		<fieldset>
			<legend>Borrar Alumno</legend>
			<div class= "row-fluid">
				<div class="span6">
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
				<div class="span6" >
					1.-Listado alumnos:
				</div>
				<div class="span6" >
					2.-Detalle alumno:
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class="span6">
			
				<?php
					$atributos= array('onsubmit' => 'return eliminarAlumno()', 'id' => 'FormBorrar');
					echo form_open('Alumnos/eliminarAlumno/', $atributos);
				?>
				<pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombres:          <b id="nombre1Detalle"></b> <b id="nombre2Detalle" ></b>
Apellido paterno: <b id="apellido1Detalle" ></b>
Apellido materno: <b id="apellido2Detalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b>
				</pre>
				<input name="rut_estudiante" type="hidden" id="rutEliminar" value="">
					<div class="row-fluid">
							<div class="span3 offset5">
								<button class="btn" type="submit" style="width: 93px">
									<div class= "btn_with_icon_solo">b</div>
									&nbsp Borrar
								</button>
							</div>

							<div class = "span3 ">
								<button  class ="btn" type="reset" onclick="resetear()" style="width: 105px">
									<div class= "btn_with_icon_solo">Â</div>
									&nbsp Cancelar
								</button>
							</div>
					</div>
				</div>
				<?php echo form_close(''); ?>
			</div>
		</fieldset>
