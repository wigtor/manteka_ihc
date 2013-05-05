
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
	            <select id="select-secciones" size=16 onchange="mostrarDatos(this)">
	            <!--    <?php
	                    foreach ($listado_secciones as $seccion) {
	                        echo "<option value='".$seccion["id"]."'>".$seccion['nombre']."</option>";
	                    }
	                ?>
	                -->
	            </select>
	        </div>
	        <h4>Seleccionados a eliminar</h4>
	        <div class="span7" style="overflow:auto">
	            <table class="table table-bordered" style="height:300px" >            
	                <tr>
	                    <th>Rut</th>
	                    <th>Paterno</th>
	                    <th>Materno</th>
	                    <th>Nombre</th>
	                </tr>
	                <span id="mostrar-tabla_alumnos">
	                    <!-- aqui se inyectará con javascript la lista de alumnos de la seccion elegida -->
	                </span>
	            </table>
	        <p>
  				<button class="btn btn-danger" type="button">Eliminar</button>
			</p>
	        </div>
	        <div class="span1"></div>
	    </div>
	</br>
</fieldset>