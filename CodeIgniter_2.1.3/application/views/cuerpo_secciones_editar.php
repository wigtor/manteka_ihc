<script type="text/javascript">
	var tiposFiltro = ["Nombre sección"]; //Debe ser escrito con PHP
	var valorFiltrosJson = [""];
	var prefijo_tipoDato = "seccion_";
	var prefijo_tipoFiltro = "tipo_filtro_";
	var url_post_busquedas = "<?php echo site_url("Secciones/postBusquedaSecciones") ?>";
	var url_post_historial = "<?php echo site_url("HistorialBusqueda/buscar/secciones") ?>";


	function verDetalle(elemTabla) {
		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		var cod_clickeado = idElem.substring(prefijo_tipoDato.length, idElem.length);
		//var rut_clickeado = elemTabla;

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/postDetallesSeccion") ?>", /* Se setea la url del controlador que responderá */
			data: { seccion: cod_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var letraDetalle = document.getElementById("rs_seccion");
				var numeroDetalle = document.getElementById("rs_seccion2");
				var cod_seccion = document.getElementById("cod_seccion");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				var letraSeccion = datos.nombre_seccion.substring(0, datos.nombre_seccion.indexOf('-'));
				var numeroSeccion = datos.nombre_seccion.substring(datos.nombre_seccion.indexOf('-')+1);
				$(letraDetalle).val($.trim(letraSeccion));
				$(numeroDetalle).val($.trim(numeroSeccion));
				$(cod_seccion).val($.trim(datos.nombre_seccion));

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
			}
		});
	}
    
	//Se cargan por ajax
	$(document).ready(function() {
		escribirHeadTable();
		cambioTipoFiltro(undefined);
	});

</script>

<script type="text/javascript">
	function EditarSeccion(){
		var cod=document.getElementById("cod_seccion").value;
		var cod1=document.getElementById("rs_seccion").value;
		var cod2=document.getElementById("rs_seccion2").value;
		if(cod!=""){
			$('#modalConfirmacion').modal();					
		}
		else{
			$('#modalSeleccioneAlgo').modal();
			return;
		}
		
	}
</script>


        <fieldset> 
		<legend>Editar Sección</legend>
			<div class="row-fluid">
				<div class="span5">
					<div class="controls controls-row">
						<div class="input-append span9">
							<input id="filtroLista" class="span8" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
							<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
						<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
					</div>
				</div>
				<div class="span7" >
					<font color="red">* Campos Obligatorios</font>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span5" >
					1.-Listado secciones
				</div>
				<div class="span7" >
					<p>2.-Complete los datos del formulario para modificar la sección:</p>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span5" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						
					</table>
				</div>
			
				<!-- Segunda columna -->
				<div class="span7">
					<?php
						$atributos= array('onsubmit' => 'return EditarSeccion()', 'id' => 'FormDetalle', 'class' => 'form-horizontal');
						echo form_open('Secciones/modificarSecciones/', $atributos);
					?>
						<input id="cod_seccion" type="text" name="cod_seccion" style="display:none">
						
						<div class="control-group">
							<label class="control-label" for="inputInfo">1-.<font color="red">*</font> Sección:<br>
								<i>(la sección debe estar compuesta por una letra y un número. Ej: B-12)</i>
							</label>
							
							<div class="controls">
								<input id="rs_seccion" name="rs_seccion"  maxlength="1" title=" Ingrese sólo una letra" pattern="^([A-Z]{1}|[a-z]{1})$" type="text" class="span2" required>
								-<input id="rs_seccion2" name="rs_seccion2"  maxlength="2"  title=" Ingrese sólo dos dígitos" pattern="[0-9]{2}" type="text" class="span2" required>
							</div>
						</div>

						<br>

						<div class="control-group">
							<div class="controls ">
								<button class="btn" type="button" onclick="EditarSeccion()">
									<div class="btn_with_icon_solo">Ã</div>
									&nbsp; Guardar
								</button>
								<button class="btn" type="reset" >
									<div class="btn_with_icon_solo">Â</div>
									&nbsp; Cancelar
								</button>&nbsp;
							</div>
						</div>


						<div id="modalConfirmacion" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Confirmación</h3>
							</div>
							<div class="modal-body">
								<p>Se va a editar la sección seleccionada ¿Está seguro?</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="submit"><div class="btn_with_icon_solo">Ã</div>&nbsp; Aceptar</button>
								<button class="btn" type="button" data-dismiss="modal"><div class="btn_with_icon_solo">Â</div>&nbsp; Cancelar</button>
							</div>
						</div>

						<!-- Modal de seleccionaAlgo -->
						<div id="modalSeleccioneAlgo" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>No ha seleccionado ninguna sección</h3>
							</div>
							<div class="modal-body">
								<p>Por favor seleccione una sección y vuelva a intentarlo</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					<?php echo form_close(''); ?>
                </div>
            </div>
        </fieldset>
