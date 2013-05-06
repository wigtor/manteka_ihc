
<fieldset>
	<legend>Coordinadores</legend>
	    <div class="row"><!--fila-->
	        <div class="span3">
	            <h4>1.- Lista Coordinadores</h4>
	            <input class="span8" type="text" placeholder="Filtro búsqueda">
	            <select class="span4">
				    <option>Filtrar Por...</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				</select>
	            <select id="select-coordinadores" class="span12" size=16 onchange="mostrarDatos(this)">
	            <?php
	                foreach ($listado_coordinadores as $coordinador) {
	                    echo "<option value='id".$coordinador["id"]."'>".$coordinador['nombre']."</option>";
	                }
	            ?>
	            </select>
	        </div>
	        <?php 
	        	foreach ($listado_coordinadores as $coordinador) {
		        	echo "<div class='span7 offset1 visualizar-coordinador' id='id".$coordinador['id']."'>
			            <h4>Detalle Coordinador</h4><br />
			        
			            <h4>Coordinador: ".$coordinador['nombre']."</h4>
			            <h4>Rut: ".$coordinador['rut']."</h4>
			            <h4>Mail: ".$coordinador['correo1']."</h4>
			            <h4>Fono: ".$coordinador['fono']."</h4>
			            <h4>Modulo: ".$coordinador['modulos']."</h4>
			            <h4>Seccion: ".$coordinador['secciones']."</h4>
			        </div>
			        ";
			    }
	        ?>
	    </div>
	</br>
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
    	$(".visualizar-coordinador").hide();

    });
	function mostrarDatos(seleccion){

        
        var id_coordinador = seleccion.options[seleccion.selectedIndex].value;
        $(".visualizar-coordinador").hide();

        $("#"+id_coordinador).show();
    }
       	
    	


</script>