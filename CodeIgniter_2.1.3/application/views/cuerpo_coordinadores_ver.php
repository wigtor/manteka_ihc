
<fieldset>
	<legend>Ver Coordinadores</legend>
	    <div class="row" style="margin-left:30px;"><!--fila-->
	        <div class="span4">
	            <h4>1.- Lista Coordinadores</h4>
	            <!--olitruco-->
	            <div class="input-append span9">
					<input class="span11" id="filtro-texto" type="text" placeholder="Filtro">
					<div class="btn-group">
						<button class="btn dropdown-toggle" data-toggle="dropdown">
							<span id="show-filtro">Filtrar por</span>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" id="select-filtro">
							<li onclick="seleccionar_filtro(this)" class="active"><a href>Nombre</a></li>
							<!--<li onclick="seleccionar_filtro(this)"><a href >Modulos</a></li>
							<li onclick="seleccionar_filtro(this)"><a href >Secciones</a></li>
							<li onclick="seleccionar_filtro(this)"><a href >Correo </a></li>--> <!--no implementado aun-->
						</ul>
					</div>
				</div>
				<!--olitruco-->
	            <select id="select-coordinadores" class="span12" size=16 onchange="mostrarDatos(this)">
	            <?php
	                foreach ($listado_coordinadores as $coordinador) {
	                    echo "<option modulo='".$coordinador["modulos"]."' secciones='".$coordinador["secciones"]."' mail='".$coordinador["correo1"]."' value='id".$coordinador["id"]."'>".$coordinador['nombre']."</option>";
	                }
	            ?>
	            </select>
	        </div>
	        <!--<div class="span5 offset1" style="margin-top: 7%; padding: 2%">
	 			<h6>Rut: <span id="rutDetalle"></span></h6>
	 			<h6>Nombre: <span id="nombreunoDetalle"></span></h6>
	 			<h6>Apellido Paterno: <span id="apellidopaternoDetalle" ></span></h6>
	 			<h6>Apellido Materno: <span id="apellidomaternoDetalle" ></span></h6>
	 			<h6>Correo:           <span id="mailDetalle" ></span></h6>
	 			<h6>Telefono: <span id="telefonoDetalle" ></span></h6>
	 			<h6>Tipo: <span id="tipoDetalle"></span></h6>
	 		</div>-->
	        <?php 
	        	foreach ($listado_coordinadores as $coordinador) {
		        	echo "<div class='span7 offset1 visualizar-coordinador' id='id".$coordinador['id']."'>
			            <h5>Detalle Coordinador</h5><br />
			        
			            <h6>Coordinador: ".$coordinador['nombre']."</h6>
			            <h6>Rut: ".$coordinador['rut']."</h6>
			            <h6>Mail: ".$coordinador['correo1']."</h6>
			            <h6>Fono: ".$coordinador['fono']."</h6>
			            <h6>Modulo: ".$coordinador['modulos']."</h6>
			            <h6>Seccion: ".$coordinador['secciones']."</h6>
			        </div>";
			    }
	        ?>
	    </div>
	</br>
</fieldset>

<script type="text/javascript">
	var tipo_filtro = "Nombre";

    $(document).ready(function(){
    	$(".visualizar-coordinador").hide();

    });
	function mostrarDatos(seleccion){

        
        var id_coordinador = seleccion.options[seleccion.selectedIndex].value;
        $(".visualizar-coordinador").hide();

        $("#"+id_coordinador).show();
    }
    function seleccionar_filtro(option){
    	$(option).prevent
    	$('.active').removeClass("active");
    	$(option).addClass("active");
    	$("#show-filtro").empty().append($('.active a').text());
    	tipo_filtro = $('.active a').text();
    }
    $("ul#select-filtro li a").click(function(event) {
	    event.preventDefault();
	});


	
</script>

<script type="text/javascript">


jQuery.fn.filterByText = function(textbox, selectSingleMatch) {
        return this.each(function() {
            var select = this;
            var options = [];
            $(select).find('option').each(function() {
                options.push({value: $(this).val(), text: $(this).text(), modulos: $(this).attr("modulos"), secciones: $(this).attr("secciones"), mail: $(this).attr("mail") });
            });
            $(select).data('options', options);
            $(textbox).bind('change keyup', function() {
            	$('option').attr("selected",false);
                var options = $(select).empty().data('options');
                var search = $(this).val().trim();
                var regex = new RegExp(search,"gi");
              
                $.each(options, function(i) {
                    var option = options[i];
                    var strToComp = option.text;
                    if(tipo_filtro == "Modulos")
                    	strToComp = option.modulos;
                    if(tipo_filtro == "Secciones")
                    	strToComp = option.secciones;
                    if(tipo_filtro == "Correo")
                    	strToComp = option.mail;
                    //alert("alerta -"+ tipo_filtro+" ---> "+ strToComp);

                    
                    if(strToComp.match(regex) !== null) {
                        $(select).append(
                           $('<option>').text(option.text).val(option.value).attr('modulos', option.modulos).attr('secciones', option.secciones).attr('mail',option.mail).attr('modulos', option.modulos)
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
        $('#select-coordinadores').filterByText($('#filtro-texto'), true);
    });
</script>

