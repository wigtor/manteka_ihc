

function escribirHeadTable() {

	var tablaResultados = document.getElementById("listadoResultados");
	$(tablaResultados).find('tbody').remove();
	var tr, td, th, thead, nodoTexto, nodoBtnFiltroAvanzado;
	thead = document.createElement('thead');
	thead.setAttribute('style', "cursor:default;");
	tr = document.createElement('tr');

	// Se comprueba si existe el Array inputAllowedFiltro. Éste indica el tipo de texto aceptado para cada filtro.
	if( (typeof(inputAllowedFiltro) == 'undefined') || inputAllowedFiltro == null){
		inputAllowedFiltro = new Array(tiposFiltro.length);
		for(var i =0; i < tiposFiltro.length; i++)
			inputAllowedFiltro[i] = "";
	}

	//SE CREA LA CABECERA DE LA TABLA

	// Si existe un sólo filtro, la tabla no necesita filtros avanzados, puesto que el filtro general ya cumple dicha función
	for (var i = 0; i < tiposFiltro.length; i++) {
			th = document.createElement('th');
			if (tiposFiltro[i] != '') {
				
				// Texto
				nodoTexto = document.createTextNode(tiposFiltro[i]+" ");
				th.appendChild(nodoTexto);
				
				if(tiposFiltro.length > 1){

					// Botón de filtros avanzado
					nodoBtnFiltroAvanzado = document.createElement('a');
					nodoBtnFiltroAvanzado.setAttribute('class', "btn btn-mini clickover");
					nodoBtnFiltroAvanzado.setAttribute('id', 'cabeceraTabla_'+tiposFiltro[i]);
					//$(nodoBtnFiltroAvanzado).attr('title', "Buscar por "+tiposFiltro[i]);
					nodoBtnFiltroAvanzado.setAttribute('style', "cursor:pointer;");
					span = document.createElement('i');
					span.setAttribute('class', "icon-filter clickover");
						//span.setAttribute('style', "vertical-align:middle;");
					nodoBtnFiltroAvanzado.appendChild(span);
					th.appendChild(nodoBtnFiltroAvanzado);

					// Se comprueba que existe un elemento para dicha posición del Array inputAllowedFiltro. En caso de que no, se setea en string vacío
					inputAllowedFiltro[i] = typeof(inputAllowedFiltro[i]) == 'undefined' ? "" : inputAllowedFiltro[i];
					/// Se asigna el valor del atributo pattern que tendrá el input.
					var inputPattern = inputAllowedFiltro[i] != "" ? 'pattern="'+inputAllowedFiltro[i]+'"' : "";

					var divBtnCerrar = '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
					
					var divs = divBtnCerrar+'<div class="input-append"><input class="span9 popovers" '+inputPattern+' id="'+ prefijo_tipoFiltro + i +'" type="text" onkeypress="getDataSource(this)" onChange="cambioTipoFiltro(this)" ><button class="btn" onClick="cambioTipoFiltro(this.parentNode.firstChild)" type="button"><i class="icon-search"></i></button></div>';
					

					$(nodoBtnFiltroAvanzado).clickover({html:true, content: divs, placement:'top', onShown: despuesDeMostrarPopOver, title:"Búsqueda sólo por " + tiposFiltro[i], rel:"clickover", indice: i});
				}

			}
			else { //Esto es para el caso de los checkbox que marcan toda la tabla
				nodoCheckeable = document.createElement('input');
				nodoCheckeable.setAttribute('data-previous', "false,true,false");
				nodoCheckeable.setAttribute('type', "checkbox");
				nodoCheckeable.setAttribute('id', "selectorTodos");
				nodoCheckeable.setAttribute('title', "Seleccionar todos");
				th.appendChild(nodoCheckeable);
			}
			
		tr.appendChild(th);
	}
	thead.appendChild(tr);
	
	tablaResultados.appendChild(thead);
}

function cambioTipoFiltro(inputUsado) {
	var inputTextoFiltro = document.getElementById('filtroLista');
	var texto = inputTextoFiltro.value;
	if (inputUsado != undefined) {
		if(!inputUsado.validity.valid){			// Se verifica si el texto ingresado en el input respeta la expresión regular
			inputUsado.focus();
			return;
		}
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
					return (value == null ? "": value);
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
				tr.setAttribute("id", prefijo_tipoDato+arrayObjectRespuesta[i].id); //Da lo mismo en este caso los id repetidos en los div
				tr.setAttribute("onClick", "verDetalle(this)");
				for (var j = 0; j < tiposFiltro.length; j++) {
					td = document.createElement('td');
					if(arrayRespuesta[i][j] == null){
						arrayRespuesta[i][j] = " ";

					}
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
