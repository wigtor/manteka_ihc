<?php
/**
* Este Archivo corresponde al cuerpo central de la vista modificar coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Modificar Coordinador</legend>
	<div class="row-fluid">
		<div class="span4">
			<h4>Seleccione un coordinador a modificar:</h4><br/>
			
			<div class="input-append span9">
			<input class="span11" id="filtroLista" type="text" placeholder="Filtro">
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<span id="show-filtro">Filtrar por</span>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="select-filtro">
						<li onclick="seleccionar_filtro(this)" id="filtro1" class="active" value="1">
							<a href>Nombre</a>
						</li>
						<li onclick="seleccionar_filtro(this)" id="filtro2" class="passive" value="2" >
							<a href>Apellido Paterno</a>
						</li>
						<li onclick="seleccionar_filtro(this)" id="filtro3" class="passive" value="3">
							<a href>Apellido Materno</a>
						</li>
						<li onclick="seleccionar_filtro(this)" id="filtro4" class="passive" value="4">
							<a href>Correo Electrónico</a>
						</li>
					</ul>
				</div>
			</div>
		    <div class="row-fluid" style="margin-left: 0%;">
				<div class="span12" style="border:#cccccc 1px solid; overflow-y:scroll; height:400px; -webkit-border-radius: 4px;">
					<table id="listadoResultados" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre Completo</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="span6 offset1">
			<div class="span12" id="visualizar-coordinador">
				<h4>Complete los siguientes datos para modificar un coordinador:</h4><br/>
				<?php 
					$attributes = array('onSubmit' => 'return validar(this)', 'class' => 'span9', 'id' =>"formEditar");
					echo form_open('Coordinadores/editarCoordinadores', $attributes);
					//echo "<form class='span9' id='id".$coordinador['id']."' method='POST' action='/manteka/index.php/Coordinadores/editarCoordinadores/' onsubmit='return validar(this)'>";
					echo "<input name='id' id='rutCoordinador' type='hidden'>";
					echo "<br/><table>";
					echo "<tr><td><h6><span class='text-error'></span>Nombre completo:</h6></td><td><input required id='nombre' name='nombre' class ='input-xlarge' type='text' placeholder='ej:SOLAR FUENTES MAURICIO IGNACIO' ></td></tr>";
					echo "<tr><td><h6><span class='text-error'></span>Contraseña:</h6></td><td><input id='contrasena' name='contrasena' class ='input-xlarge'  type='text' placeholder='*******'  ></td></tr>";
					echo "<tr><td><h6><span class='text-error'></span>Reingresar contraseña:</h6></td><td><input id='contrasena2' name='contrasena2' class ='input-xlarge' type='text' placeholder='*******'  ></td></tr>";
					echo "<tr><td><h6><span class='text-error'></span>Correo 1:</h6></td><td><input id='correo1' name='correo1' required class ='input-xlarge' type='email' placeholder='ej:edmundo.leiva@usach.cl'></td></tr>";
					echo "<tr><td><h6>Correo 2 :</h6></td><td><input id='correo2' name='correo2' class ='input-xlarge' type='email' placeholder='ej:edmundo@gmail.com' ></td></tr>";
					echo "<tr><td><h6><span class='text-error'></span>Tel?fono:</h6></td><td><input id='fono' name='fono' required class ='input-xlarge' type='text' placeholder='ej:9-87654321' ></td></tr>";
					echo "<tr><td></td><td>Los campos con <span class='text-error'></span> son obligatorios</td></tr>";
					echo "</table>";
					echo "<br/><div class='span7 offset5' id='botones-guardar-cancelar'><button type='submit' class='btn' type='button'>Guardar</button><a class='btn offset1' href='/manteka/index.php/Coordinadores/modificarCoordinador/'>Cancelar</a></div>";
					echo form_close(""); echo "<!-- span9-->";
					
				?>

			</div>
		</div>
	</div>
</div>
</fieldset>

<script type="text/javascript">
    
    $(document).ready(function(){
    	//$("form.span9, #visualizar-coordinador").hide();
    	$("#select-filtro li.active").click();

    });
	
	function detalleCoordinador(elemTabla) {

		/* Obtengo el rut del usuario clickeado a partir del id de lo que se clickeó */
		var idElem = elemTabla.id;
		rut_clickeado = idElem.substring("coordinador_".length, idElem.length);
		//var rut_clickeado = elemTabla;

		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		/* Defino el ajax que hará la petición al servidor */
		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/postDetallesCoordinador") ?>", /* Se setea la url del controlador que responderá */
			data: { rut: rut_clickeado }, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				/* Obtengo los objetos HTML donde serán escritos los resultados */
				var rutDetalle = document.getElementById("rutCoordinador");
				var nombre = document.getElementById("nombre");
				var fonoDetalle = document.getElementById("fono");
				var correoDetalle = document.getElementById("correo1");
				var correoDetalle2 = document.getElementById("correo2");
				
				/* Decodifico los datos provenientes del servidor en formato JSON para construir un objeto */
				var datos = jQuery.parseJSON(respuesta);

				/* Seteo los valores desde el objeto proveniente del servidor en los objetos HTML */
				$(rutDetalle).val(datos.rut);
				$(nombre).val(datos.nombre1 + " " + (datos.nombre2 == "" ? '' : datos.nombre2) + " " + datos.apellido1 + " " + (datos.apellido2 == "" ? '' : datos.apellido2) );
				$(fonoDetalle).val(datos.fono);
				$(correoDetalle).val(datos.correo);
				$(correoDetalle2).val(datos.correo2 == "null" ? '' : datos.correo2);

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();

			}
		});
	}
    
    function seleccionar_filtro(option){
    	var selectorFiltro = option;
		var inputTextoFiltro = document.getElementById('filtroLista');
		var valorSelector = selectorFiltro.value;
		var texto = inputTextoFiltro.value;


		/* Muestro el div que indica que se está cargando... */
		var iconoCargado = document.getElementById("icono_cargando");
		$(icono_cargando).show();

		$.ajax({
			type: "POST", /* Indico que es una petición POST al servidor */
			url: "<?php echo site_url("Coordinadores/postBusquedaCoordinadores") ?>", /* Se setea la url del controlador que responderá */
			data: { textoFiltro: texto, tipoFiltro: valorSelector}, /* Se codifican los datos que se enviarán al servidor usando el formato JSON */
			success: function(respuesta) { /* Esta es la función que se ejecuta cuando el resultado de la respuesta del servidor es satisfactorio */
				var tablaResultados = document.getElementById("listadoResultados");
				$(tablaResultados).empty();
				var arrayRespuesta = jQuery.parseJSON(respuesta);
				var tr, td, th, thead, nodoTexto;
				thead = document.createElement('thead');
				tr = document.createElement('tr');
				th = document.createElement('th');
				nodoTexto = document.createTextNode("Nombre Completo");
				th.appendChild(nodoTexto);
				tr.appendChild(th);
				thead.appendChild(tr);
				tablaResultados.appendChild(thead);
				for (var i = 0; i < arrayRespuesta.length; i++) {
					tr = document.createElement('tr');
					td = document.createElement('td');
					tr.setAttribute("id", "coordinador_"+arrayRespuesta[i].rut);
					tr.setAttribute("onClick", "detalleCoordinador(this)");
					nodoTexto = document.createTextNode(arrayRespuesta[i].nombre1 +" "+ arrayRespuesta[i].nombre2 +" "+ arrayRespuesta[i].apellido1 +" "+arrayRespuesta[i].apellido2);
					td.appendChild(nodoTexto);
					tr.appendChild(td);
					tablaResultados.appendChild(tr);
				}

				$(option).prevent;
				$('#select-filtro li').removeClass("active");
				$(option).addClass("active");
				$("#show-filtro").empty().append($('#select-filtro li.active').text());

				/* Quito el div que indica que se está cargando */
				var iconoCargado = document.getElementById("icono_cargando");
				$(icono_cargando).hide();
				}

		});

		
    }
    
    $("ul#select-filtro li a").click(function(event) {
	    event.preventDefault();
	});

	function validar(form){
		if($('input[name="contrasena"]').val() != "" || $('input[name="contrasena2"]').val()!= ""){
			if ($('input[name="contrasena"]').val() != $('input[name="contrasena2"]').val()) {
				alert("Las contrase?as no coinciden.");
				return false;
			}else{
				return true;
			};
		}
		return true;
}

jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
    return this.each(function() {
        var select = this;
        var options = [];
        $(select).find('option').each(function() {
            options.push({value: $(this).val(), text: $(this).text()});
        });
        $(select).data('options', options);
        $(textbox).bind('change keyup', function() {
        	$('option').attr("selected",false);
            var options = $(select).empty().data('options');
            var search = $(this).val().trim();
            var regex = new RegExp(search,"gi");
          
            $.each(options, function(i) {
                var option = options[i];
                if(option.text.match(regex) !== null) {
                    $(select).append(
                       $('<option>').text(option.text).val(option.value)
                    );
                }
            });
            if (selectSingleMatch === true && $(select).children().length === 1) {
                $(select).children().get(0).selected = true;
            }
        });            
    });
};

/*$(function() {
    $('#select-coordinadores').filterByText($('#appendedDropdownButton'), false);
});*/

</script>