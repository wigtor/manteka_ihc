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
			url: "<?php echo site_url("Secciones/postDetalleUnaSeccion") ?>", /* Se setea la url del controlador que responderá */
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
				$(cod_seccion).val($.trim(datos.cod_seccion));

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
		var letra = document.getElementById("rs_seccion").value;
		var num = document.getElementById("rs_seccion2").value;
		var resultadoAjax =false;
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Secciones/secExiste") ?>", /* Se setea la url del controlador que responderá */
			data: { letra_post:letra,num_post: num, cod_post:cod},
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				//var tablaResultados = document.getElementById("modulos");
				//$(tablaResultados).empty();
				var existe = jQuery.parseJSON(respuesta);
				if(cod!=""){
				if(existe == 1){		
					$('#modalSeccionExiste').modal();
					document.getElementById("rs_seccion").value = "";
					document.getElementById("rs_seccion2").value = "";
					
				}
				else{
					if(letra!="" && num!=""){
					//alert(document.getElementById("cod_seccion").value+" y "+document.getElementById("rs_seccion").value+"y "+document.getElementById("rs_seccion2").value);
					$('#modalConfirmacion').modal();
					// en caso de que se presione cancelar se quita el icono de cargando
					var iconoCargado = document.getElementById("icono_cargando");
					$(icono_cargando).hide();
					return;				
				}
					else{$('#modalFaltanCampos').modal();}
				}
				}
				else {$('#modalSeleccioneAlgo').modal();}
				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}
		});

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();
		
		
			
		
		
	}
</script>


        <fieldset> 
		<legend>Editar Sección</legend>
			<div class="row-fluid">
				<div class="span5">
				<font color="red">* Campos Obligatorios</font>
					<div class="controls controls-row">
						<div class="input-append span9">
							<input id="filtroLista" class="span8" type="text" onkeypress="getDataSource(this)" onChange="ordenarFiltro()" placeholder="Filtro búsqueda">
							<button class="btn" onClick="ordenarFiltro()" title="Iniciar una búsqueda considerando todos los atributos" type="button"><i class="icon-search"></i></button>
						</div>
						<button class="btn" onClick="limpiarFiltros()" title="Limpiar todos los filtros de búsqueda" type="button"><i class="caca-clear-filters"></i></button>
					</div>
				</div>
				<div class="span7" >
				</div>
			</div>
			<div class="row-fluid">
				<div class="span5" >
					1.- Seleccione la sección a editar:
				</div>
				<div class="span7" >
					<p>2.- Complete los datos del formulario para modificar la sección:</p>
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
							<label class="control-label" for="inputInfo">1.- <font color="red">*</font> Sección:<br>
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
								<p>Por favor seleccione una sección y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
						<div id="modalFaltanCampos" class="modal hide fade">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3>Campos Obligatorios no completados</h3>
							</div>
							<div class="modal-body">
								<p>Por favor complete el campo vacío y vuelva a intentarlo.</p>
							</div>
							<div class="modal-footer">
								<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
							</div>
						</div>	
						<!-- Modal de modalRutUsado -->
					<div id="modalSeccionExiste" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>La sección ingresada ya existe</h3>
						</div>
						<div class="modal-body">
							<p>Por favor ingrese otro nombre de sección y vuelva a intentarlo.</p>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
						</div>
					</div>

					<?php echo form_close(''); ?>
                </div>
            </div>
        </fieldset>
