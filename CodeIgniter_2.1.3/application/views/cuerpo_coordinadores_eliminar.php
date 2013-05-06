<?php
$listado_coordinadores= [['id'=>1 , 'nombre'=>"asd", 'rut'=>"1213451-1", 'contrasena'=>"asd", 'correo1'=>"correo1",'correo2'=>"correo2",'fono'=>"81234567",],['id'=>2 , 'nombre'=>"segundonombre", 'rut'=>"1213451-1", 'contrasena'=>"asd", 'correo1'=>"correo1",'correo2'=>"correo2",'fono'=>"81234567",],['id'=>3 , 'nombre'=>"asd", 'rut'=>"1213451-1", 'contrasena'=>"asd", 'correo1'=>"correo1",'correo2'=>"correo2",'fono'=>"81234567",],['id'=>4 , 'nombre'=>"segundonombre", 'rut'=>"1213451-1", 'contrasena'=>"asd", 'correo1'=>"correo1",'correo2'=>"correo2",'fono'=>"81234567",]];
?>
<fieldset>
	<legend>Secciones</legend>
	    <div class="row"><!--fila-->
	        <div class="span3">
	            <h4>Seleccione los coordinadores a eliminar</h4>
	            <input class="span6" type="text" placeholder="Filtro búsqueda">
	            <select class="span4">
				    <option>Filtrar Por...</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				</select>
	            <select id="select-coordinadores" multiple class="span12" size=16 onchange="mostrarDatos(this)">
	            <?php
	                foreach ($listado_coordinadores as $coordinador) {
	                    echo "<option value='id".$coordinador["id"]."'>".$coordinador['nombre']."</option>";
	                }
	            ?>
	            </select>
	        </div>
	        <h4>Seleccionados a eliminar</h4>
	        <div class="span7" style="overflow-y:scroll;max-height:300px">
	            <table class="table table-bordered">            
	                <tr>
	                    <th>Rut</th>
	                    <th>Paterno</th>
	                    <th>Materno</th>
	                    <th>Nombre</th>
	                </tr>
	                <?php 
	                	foreach ($listado_coordinadores as $coordinador) {
	                		echo "<tr class ='fila_tabla' id='id".$coordinador['id']."'>";
		                	echo "<td>1".$coordinador['rut']."</td>";
		                	echo "<td>2".$coordinador['nombre']."</td>";
		                	echo "<td>2".$coordinador['nombre']."</td>";
		                	echo "<td>2".$coordinador['nombre']."</td>";
		                	echo "</tr>";
	                	}
	                	
	                ?>
	                
	            </table>
	        
	        </div>
	        <br/>
	        <p>
  				<button class="btn btn-danger" type="button">Eliminar</button>
			</p>
	        <div class="span1"></div>
	    </div>
	</br>
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
    	$(".fila_tabla").hide();

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
       	
    	


</script>