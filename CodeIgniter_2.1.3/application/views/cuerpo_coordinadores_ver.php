
<fieldset>
	<legend>Coordinadores</legend>
	    <div class="row"><!--fila-->
	        <div class="span3">
	            <h4>1.- Lista Coordinadores</h4>
	            <input class="span6" type="text" placeholder="Filtro búsqueda">
	            <select class="span4">
				    <option>Filtrar Por...</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				    <option>#</option>
				</select>
	            <select id="select-coordinadores" size=16 onchange="mostrarDatos(this)">
	            <?php
	                foreach ($listado_coordinadores as $coordinador) {
	                    echo "<option value='".$coordinador["id"]."'>".$coordinador['nombre']."</option>";
	                }
	            ?>
	            </select>
	        </div>
	        <div class="span7">
	        <h4>Detalle Coordinador</h4><br />
	        
	            <h4>Coordinador: Solar Fuentes Mauricio Gonzalo</h4>
	            <h4>Rut: 17555888-4</h4>
	            <h4>Mail: asd@fasd.com</h4>
	            <h4>Fono: 027378899</h4>
	            <h4>Modulo: Comunicacion y compromiso</h4>
	            <h4>Seccion: H1,H2</h4>

	                <span id="mostrar-tabla_alumnos">
	                    <!-- aqui se inyectará con javascript la lista de alumnos de la seccion elegida -->
	                </span>

	        </div>
	        <div class="span1"></div>
	    </div>
	</br>
</fieldset>