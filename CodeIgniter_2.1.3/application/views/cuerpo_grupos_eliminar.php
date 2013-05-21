<?php
/**
* Este Archivo corresponde al cuerpo central de la vista eliminar grupos de contacto en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Secciones</legend>
	    <div class="row"><!--fila-->
	    	<div class="span2"></div>
	        <div class="span3">
	            <h4>1.- Listado de grupos</h4>
	            <input class="span6" type="text" placeholder="Filtro búsqueda">
	            <select id="select-secciones" size=16 onchange="mostrarDatos(this)">
	            <!--    <?php
	                    foreach ($listado_secciones as $seccion) {
	                        echo "<option value='".$seccion["id"]."'>".$seccion['nombre']."</option>";
	                    }
	                ?>
	                -->
	            </select>
	        </div>
	        <h4>2.- Miembros del grupo</h4>
	        <div class="span7" style="overflow:auto; height:450px">
				<select id="select-secciones" size=19 onchange="mostrarDatos(this)">
	            <!--    <?php
	                    foreach ($listado_secciones as $seccion) {
	                        echo "<option value='".$seccion["id"]."'>".$seccion['nombre']."</option>";
	                    }
	                ?>
	                -->
	            </select>
	        <p>
  				<button class="btn btn-danger" type="button">Eliminar</button>
  				<button class="btn" type="button" style="margin-left:50px">Cancelar</button>
			</p>
	        </div>
	        <div class="span1"></div>	
	    </div>
	</br>
</fieldset>

<script type="text/javascript">
	alert("En esta vista esta solo implementada la parte visual. Ninguna funcionalidad está disponible.")
</script>
