<fieldset>
    <legend>Secciones</legend>
    <div><!--fila-->
        <div class="span3">
            <h4>Escoja una seccion de la lista</h4>
            <input type="text" placeholder="Filtro búsqueda"><br/>
            <select id="select-secciones" size=16 onchange="mostrarDatos(this)">
                <?php
                    foreach ($listado_secciones as $seccion) {
                        echo "<option value='".$seccion[0]."'>".$seccion[1]."</option>";
                    }
                ?>
                
            </select>
        </div>
        <h4>Vea la informacion de la seccion seleccionada</h4>
        <h6>Profesor: <span id="mostrar-profesor"> <!-- inyectar valor aqui --> </span></h6>
        <h6>Modulo:   <span id="mostrar-modulo">   <!-- inyectar valor aqui --> </span></h6>
        <h6>Horario:  <span id="mostrar-horario">  <!-- inyectar valor aqui --> </span></h6>
        <h6>Sala:     <span id="mostrar-sala">     <!-- inyectar valor aqui --> </span></h6>
        <div class="span9" style="overflow:auto; height:200px">
            <table id="mostrar-tabla_alumnos" class="table table-bordered" >            
                <tr>
                    <th>Carrera</th>
                    <th>Rut</th>
                    <th>Paterno</th>
                    <th>Materno</th>
                    <th>Nombres</th>
                    <th>Mail</th>
                </tr>
                <!-- aqui se inyectará con javascript la lista de alumnos de la seccion elegida -->
            </table>
        </div>
    </div>
</br>
<fieldset>
<script type="text/javascript">
    var arreglo_secciones = [];
    <?php  
        foreach ($listado_secciones as $seccion) {
            echo "var temp = [];";
            echo "temp = [".$seccion[0].",'".$seccion[1]."','".$seccion[2]."','".$seccion[3]."','".$seccion[4]."','".$seccion[5]."','".$seccion[6]."'];";
            echo "arreglo_secciones[temp[0]] = temp;";
        }
    ?>
    function mostrarDatos(seleccion){
        //borrar datos de los spans
        $("#mostrar-profesor,#mostrar-modulo, #mostrar-horario, #mostrar-sala, #mostrar-tabla_alumnos").empty();
        
        //setear nuevos datos de los spans
        var id_seccion = seleccion.options[seleccion.selectedIndex].value;
        $("#mostrar-profesor").append(arreglo_secciones[id_seccion][2]);
        $("#mostrar-modulo").append(  arreglo_secciones[id_seccion][3]);
        $("#mostrar-horario").append( arreglo_secciones[id_seccion][4]);
        $("#mostrar-sala").append(    arreglo_secciones[id_seccion][5]);
        var string_linea ="<tr><th>Carrera</th><th>Rut</th><th>Paterno</th><th>Materno</th><th>Nombres</th><th>Mail</th></tr>"+arreglo_secciones[id_seccion][6];
        $("#mostrar-tabla_alumnos").append(string_linea);

    }
</script>
<script type="text/javascript">
    
    
    
    
</script>