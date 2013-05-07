
<fieldset>
	<legend>Secciones</legend>
	    <div class="row" style="margin-left:30px;"><!--fila-->
	        <div class="span4">
	            <h4>Seleccione los coordinadores a eliminar</h4>
	            <input class="span7" type="text" placeholder="Filtro b&#250;squeda">
	            <select class="span5">
				    <option>Filtrar Por...</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				</select>
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
       	
    	


</script>