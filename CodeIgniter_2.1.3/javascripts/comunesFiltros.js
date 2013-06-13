

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
					nodoBtnFiltroAvanzado.setAttribute('title', "Buscar por "+tiposFiltro[i]);
					nodoBtnFiltroAvanzado.setAttribute('style', "cursor:pointer;");
						span = document.createElement('i');
						span.setAttribute('class', "icon-filter clickover");
						//span.setAttribute('style', "vertical-align:middle;");
					nodoBtnFiltroAvanzado.appendChild(span);
				th.appendChild(nodoTexto);
				th.appendChild(nodoBtnFiltroAvanzado);

				var divBtnCerrar = '<div class="btn btn-mini" data-dismiss="clickover" data-toggle="clickover" data-clickover-open="1" style="position:absolute; margin-top:-40px; margin-left:180px;"><i class="icon-remove"></i></div>';
				var divs = divBtnCerrar+'<div class="input-append"><input class="span9" id="'+ prefijo_tipoFiltro + i +'" type="text" autofocus onkeypress="getDataSource(this)" onChange="cambioTipoFiltro()" ><button class="btn" onClick="cambioTipoFiltro()" type="button"><i class="icon-search"></i></button></div>';
				
				$(nodoBtnFiltroAvanzado).clickover({html:true, content: divs, placement:'top', trigger:"click", title:"Búsqueda sólo por " + tiposFiltro[i], rel:"clickover"});

				
			tr.appendChild(th);
		}
		thead.appendChild(tr);
		
		tablaResultados.appendChild(thead);
	}
