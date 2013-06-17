

function escribirHeadTable() {

	var tablaResultados = document.getElementById("listadoResultados");
	$(tablaResultados).find('tbody').remove();
	var tr, td, th, thead, nodoTexto, nodoBtnFiltroAvanzado;
	thead = document.createElement('thead');
	thead.setAttribute('style', "cursor:default;");
	tr = document.createElement('tr');

	//SE CREA LA CABECERA DE LA TABLA
	for (var i = 0; i < tiposFiltro.length; i++) {
			th = document.createElement('th');
				nodoTexto = document.createTextNode(tiposFiltro[i]+" ");
				

				nodoBtnFiltroAvanzado = document.createElement('a');
				nodoBtnFiltroAvanzado.setAttribute('class', "btn btn-mini clickover");
				nodoBtnFiltroAvanzado.setAttribute('id', 'cabeceraTabla_'+tiposFiltro[i]);
				//$(nodoBtnFiltroAvanzado).attr('title', "Buscar por "+tiposFiltro[i]);
				nodoBtnFiltroAvanzado.setAttribute('style', "cursor:pointer;");
					span = document.createElement('i');
					span.setAttribute('class', "icon-filter clickover");
					//span.setAttribute('style', "vertical-align:middle;");
				nodoBtnFiltroAvanzado.appendChild(span);
			th.appendChild(nodoTexto);
			th.appendChild(nodoBtnFiltroAvanzado);

			var divBtnCerrar = '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
			
			var divs = divBtnCerrar+'<div class="input-append"><input class="span9 popovers" id="'+ prefijo_tipoFiltro + i +'" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(this)" ><button class="btn" onClick="cambioTipoFiltro(this)" type="button"><i class="icon-search"></i></button></div>';
			

			$(nodoBtnFiltroAvanzado).clickover({html:true, content: divs, placement:'top', onShown: despuesDeMostrarPopOver, title:"Búsqueda sólo por " + tiposFiltro[i], rel:"clickover", indice: i});

			
		tr.appendChild(th);
	}
	thead.appendChild(tr);
	
	tablaResultados.appendChild(thead);
}

function cambioTipoFiltro(inputUsado) {
	var inputTextoFiltro = document.getElementById('filtroLista');
	var texto = inputTextoFiltro.value;
	if (inputUsado != undefined) {
		var idElem = inputUsado.id;
		var index = idElem.substring(prefijo_tipoFiltro.length, idElem.length);
		valorFiltrosJson[index] = inputUsado.value; //Copio el valor del input al array de filtros
	}

	$.ajax({
		type: "POST", /* Indico que es una petición POST al servidor */
		url: url_post_busquedas, /* Se setea la url del controlador que responderá */
		data: { textoFiltroBasico: texto, textoFiltrosAvanzados: valorFiltrosJson}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
		success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
			var tablaResultados = document.getElementById("listadoResultados");
			$(tablaResultados).find('tbody').remove();
			var arrayObjectRespuesta = jQuery.parseJSON(respuesta);
			var arrayRespuesta = new Array();
			for (var i = 0; i < arrayObjectRespuesta.length; i++) {
				arrayRespuesta[i] = $.map( arrayObjectRespuesta[i], function( value, key ) {
					return value;
				});
			}

			
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

				for (var j = 0; j < tiposFiltro.length; j++) {
					td = document.createElement('td');
					tr.setAttribute("id", prefijo_tipoDato+arrayObjectRespuesta[i].rut); //Da lo mismo en este caso los id repetidos en los div
					tr.setAttribute("onClick", "verDetalle(this)");
					nodoTexto = document.createTextNode(arrayRespuesta[i][j]);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
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


function limpiarFiltros() {
	var tam = valorFiltrosJson.length;
	for (var i = 0; i < tam; i++) {
		valorFiltrosJson[i] = "";
	}
	var inputTextoFiltro = document.getElementById('filtroLista');
	$(inputTextoFiltro).val("");

	//Luego de limpiar los filtros, se debe iniciar una nueva búsqueda
	cambioTipoFiltro(undefined);

}

function despuesDeMostrarPopOver() {
	var input_popover = document.getElementById(prefijo_tipoFiltro+this.options.indice);

	
	if (input_popover != undefined) {
		//var idElem = $(input_popover).attr('id')
		//var index = idElem.substring(prefijo_tipoFiltro.length, idElem.length);
		$(input_popover).focus();
		$(input_popover).val(valorFiltrosJson[this.options.indice]);

	}
	
}


function getDataSource(inputUsado) {
	$(inputUsado).typeahead({
		minLength: 1,
		source: function(query, process) {
			$.ajax({
				type: "POST", /* Indico que es una petición POST al servidor */
				url: url_post_historial, /* Se setea la url del controlador que responderá */
				data: { letras : query }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
				success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
					//alert(respuesta)
					var arrayRespuesta = jQuery.parseJSON(respuesta);
					arrayRespuesta[arrayRespuesta.length] = query;
					process(arrayRespuesta);
				}
			});
		}
	});
}
