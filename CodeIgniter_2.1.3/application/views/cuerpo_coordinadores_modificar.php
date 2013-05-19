<fieldset>
	<legend>Modificar Coordinador</legend>
	<div class="span4">
		<h4>Seleccione un coordinador a modificar:<h4/><br/>
		
		<div class="input-append span9">
		<input class="span11" id="appendedDropdownButton" type="text" placeholder="Filtro">
		<div class="btn-group">
			<button class="btn dropdown-toggle" data-toggle="dropdown">
				<span id="show-filtro">Filtrar por</span>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="select-filtro">
				<li onclick="seleccionar_filtro(this)" class="active"><a href>Nombre</a></li>
				<!--<li onclick="seleccionar_filtro(this)"><a href >Rut</a></li>
				<li onclick="seleccionar_filtro(this)"><a href >Correo </a></li>  //no implementado aun-->
			</ul>
		</div>
	</div>
	    <select id="select-coordinadores" size=18 style="width:342px" onchange="mostrarDatos(this)">
			<?php 
				foreach ($listado_coordinadores as $coordinador){
					echo "<option value='id".$coordinador['id']."'>".$coordinador['nombre']."</option>";
				}
			?>
        </select>
	</div>
	<div class="span6 offset1">
		<div class="span12" id="visualizar-coordinador">
			<h4>Complete los siguientes datos para modificar un coordinador:</h4><br/>
			<?php 
				foreach ($listado_coordinadores as $coordinador){
					$attributes = array('onSubmit' => 'return validar(this)', 'class' => 'span9', 'id' =>"id".$coordinador['id']);
					echo form_open('Coordinadores/editarCoordinadores', $attributes);
					//echo "<form class='span9' id='id".$coordinador['id']."' method='POST' action='/manteka/index.php/Coordinadores/editarCoordinadores/' onsubmit='return validar(this)'>";
					echo "<input name='id' type='hidden' value='".$coordinador['id']."'>";
					echo "<br/><table>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Nombre completo:</h6></td><td><input required name='nombre' class ='input-xlarge' type='text' placeholder='ej:SOLAR FUENTES MAURICIO IGNACIO' default='".$coordinador['nombre']."' value='".$coordinador['nombre']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Contrase?a:</h6></td><td><input name='contrasena' class ='input-xlarge'  type='text' placeholder='*******'  ></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Reingresar contrase?a:</h6></td><td><input name='contrasena2' class ='input-xlarge' type='text' placeholder='*******'  ></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Correo 1:</h6></td><td><input name='correo1' required class ='input-xlarge' type='email' placeholder='ej:edmundo.leiva@usach.cl' default='".$coordinador['correo1']."' value='".$coordinador['correo1']."'></td></tr>";
					echo "<tr><td><h6>Correo 2 :</h6></td><td><input name='correo2' class ='input-xlarge' type='email' placeholder='ej:edmundo@gmail.com' default='".$coordinador['correo2']."' value='".$coordinador['correo2']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Tel?fono:</h6></td><td><input name='fono' required class ='input-xlarge' type='text' placeholder='ej:9-87654321' default='".$coordinador['fono']."' value='".$coordinador['fono']."'></td></tr>";
					echo "<tr><td></td><td>Los campos con <span class='text-error'>(*)</span> son obligatorios</td></tr>";
					echo "</table>";
					echo "<br/><div class='span7 offset5' id='botones-guardar-cancelar'><button type='submit' class='btn' type='button'>Guardar</button><a class='btn offset1' href='/manteka/index.php/Coordinadores/modificarCoordinador/'>Cancelar</a></div>";
					echo form_close(""); echo "<!-- span9-->";
				}
				
			?>

		</div>
	</div>
	
	
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
    	$("form.span9, #visualizar-coordinador").hide();

    });
	function mostrarDatos(seleccion){
        $("#visualizar-coordinador").show();
        var id_coordinador = seleccion.options[seleccion.selectedIndex].value;
        $("form.span9").hide();

        $("#"+id_coordinador).show();

        /*var inputs = $("#"+id_coordinador+" input");
        for (var i in inputs) {
        	i.value= i.attr("default");
        }*/
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

$(function() {
    $('#select-coordinadores').filterByText($('#appendedDropdownButton'), true);
});

       	
    	


</script>