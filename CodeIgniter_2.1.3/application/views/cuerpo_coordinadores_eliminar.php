
<?php
/**
* Este Archivo corresponde al cuerpo central de la vista eliminar coordinadores en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Eliminar Coordinadores</legend>
	    <div class="row" style="margin-left:30px;"><!--fila-->
	        <div class="span4">
	            <h4>Seleccione los coordinadores a eliminar</h4>
	            <div class="input-append span9">
					<input class="span11" id="appendedDropdownButton" type="text" placeholder="Filtro">
					<div class="btn-group">
						<button class="btn dropdown-toggle" data-toggle="dropdown">
							<span id="show-filtro">Filtrar por</span>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" id="select-filtro">
							<li onclick="seleccionar_filtro(this)" class="active"><a href>Nombre</a></li>
							<!--<li onclick="seleccionar_filtro(this)"><a href >Modulos</a></li>
							<li onclick="seleccionar_filtro(this)"><a href >Secciones</a></li>
							<li onclick="seleccionar_filtro(this)"><a href >Correo </a></li> por implementar aun.-->
						</ul>
					</div>
				</div>
	            <select id="select-coordinadores" multiple class="span12" size=20 onchange="mostrarDatos(this)">
	            <?php
	                foreach ($listado_coordinadores as $coordinador) {
	                    echo "<option value='id".$coordinador["id"]."'>".$coordinador['nombre']."</option>";
	                }
	            ?>
	            </select>
	        </div>
	        <div class="span8">
	        	<div class="span12" style="height:70px"></div>
		        <h4>Seleccionados a eliminar</h4>
		        <div class="span11" style="overflow-y:scroll;height:300px">
		            <table class="table table-bordered">            
		                <tr>
		                    <th>Rut</th>
		                    <th>Paterno</th>
		                    <th>Materno</th>
		                    <th>Nombre</th>
		                </tr>
		                <?php 
		                	foreach ($listado_coordinadores as $coordinador) {
		                		echo "<tr class ='fila_tabla' style='display:none;' id='id".$coordinador['id']."'>";
			                	echo "<td>1".$coordinador['rut']."</td>";
			                	echo "<td>2".$coordinador['nombre']."</td>";
			                	echo "<td>2".$coordinador['nombre']."</td>";
			                	echo "<td>2".$coordinador['nombre']."</td>";
			                	echo "</tr>";
		                	}
		                ?>
		            </table>
		        
		        </div>
		        
		        <div class="offset9 span1">
		        	<br/>
		        	<form  action="borrarCoordinadores" method="POST" onsubmit="return confirmar();">
		        		<input type="hidden" name="lista_eliminar" id="input-eliminar">
	  					<button class="btn btn-danger" type="sumbit">Eliminar</button>
	  				</form>
				</div>
		        <div class="span1"></div>
		    </div>
	    </div>
	</br>
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
    	

    });
	function mostrarDatos(seleccion){
        var id_coordinador = seleccion.options[seleccion.selectedIndex].value;
        $('#select-coordinadores').val();
        $(".fila_tabla").hide();
        var seleccion = $('#select-coordinadores').val();
        for(var row in seleccion){
        	
			$("#"+seleccion[row]).show();
        }
    }
    function confirmar(){
    	var respuesta = confirm("Esta seguro de que decea eliminar estos Coordinadores?");
    	if(respuesta)
    		$('#input-eliminar').val($('#select-coordinadores').val());
    	return respuesta;
    }
    function seleccionar_filtro(option){
    	$(option).prevent
    	$('.active').removeClass("active");
    	$(option).addClass("active");
    	$("#show-filtro").empty().append($('.active a').text());
    }
    $("ul#select-filtro li a").click(function(event) {
	    event.preventDefault();
	});
       	

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

$(function() {
    $('#select-coordinadores').filterByText($('#appendedDropdownButton'), true);
});    	


</script>