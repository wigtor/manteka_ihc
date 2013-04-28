<fieldset>
	<legend>Ver alumnos</legend>
	<div class="span4">
		<h4>Listado alumnos<h4/><br/>
		<div class="input-append">
			<input class="span11" id="appendedDropdownButton" type="text" placeholder="Filtro">
			<div class="btn-group">
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					Filtrar por
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<li>Rut</li>
				<li>Nombre</li>
				<li>Apellido paterno</li>
				<li>Apellido materno</li>
				<li>Correo</li>
				<li>Carrera</li>
				<li>Sección</li>
				</ul>
			</div>
		</div>
	    <select size=10 style="width:342px" onchange="mostrarDatos(this)">
	    	<?php
                foreach ($listado_alumnos as $alumno) {
                    echo "<option value='".$alumno[0]."'>".$alumno[1]."</option>";
                }
            ?>
        </select>
	</div>
	<div class="span1">
	</div>
	<div class="span6">
		<h4>Detalle alumno</h4><br/>
		<h6>Rut:              <span id="mostrar-rut">     <!-- inyectar valor aqui --> </span></h6>
		<h6>Nombre:           <span id="mostrar-nombre">  <!-- inyectar valor aqui --> </span></h6>
        <h6>Apellido paterno: <span id="mostrar-paterno"> <!-- inyectar valor aqui --> </span></h6>
	    <h6>Apellido materno: <span id="mostrar-materno"> <!-- inyectar valor aqui --> </span></h6>
        <h6>Correo:           <span id="mostrar-correo">  <!-- inyectar valor aqui --> </span></h6>
		<h6>Carrera:          <span id="mostrar-carrera"> <!-- inyectar valor aqui --> </span></h6>
		<h6>Sección:          <span id="mostrar-seccion"> <!-- inyectar valor aqui --> </span></h6>
	</div>
</fieldset>
<script type="text/javascript">
	var arreglo_alumnos = [];
    <?php  
    	//pasar datos de php a javascript
        foreach ($listado_alumnos as $alumno) {
            echo "var temp = [];";
            echo "temp = [".$alumno[0].",'".$alumno[1]."','".$alumno[2]."','".$alumno[3]."','".$alumno[4]."','".$alumno[5]."','".$alumno[6]."','".$alumno[7]."'];";
            echo "arreglo_alumnos[temp[0]] = temp;";
        }
    ?>
    function mostrarDatos(seleccion){
        //borrar datos de los spans
        $("#mostrar-rut,#mostrar-nombre, #mostrar-paterno, #mostrar-materno, #mostrar-correo, #mostrar-carrera, #mostrar-seccion").empty();
        
        //setear nuevos datos de los spans
        var id_seccion = seleccion.options[seleccion.selectedIndex].value;
        $("#mostrar-rut").append(arreglo_alumnos[id_seccion][2]);
        $("#mostrar-nombre").append(arreglo_alumnos[id_seccion][1]);
        $("#mostrar-paterno").append(arreglo_alumnos[id_seccion][3]);
        $("#mostrar-materno").append(arreglo_alumnos[id_seccion][4]);
        $("#mostrar-correo").append(arreglo_alumnos[id_seccion][5]);
        $("#mostrar-carrera").append(arreglo_alumnos[id_seccion][6]);
        $("#mostrar-seccion").append(arreglo_alumnos[id_seccion][7]);
    }
	
	
</script>