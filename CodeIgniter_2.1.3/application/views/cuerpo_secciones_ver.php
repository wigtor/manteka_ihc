<?php

    $alumnos=[["ingenieria",12558996-8,"araucano","maternox","gonzalo","miMail@usach.cl"],["Arquitectura",1111111-8,"muñoz","varas","lokohanks","miMail@usach.cl"]];
    
    $seccion1 = ['id'=>1, 'nombre'=>"nombreseccion", "modulo"=>"M3", "Horario"=>"9:30","sala"=>"565","alumnos"=>$alumnos];
    $seccion2 = ['id'=>2, 'nombre'=>"nombreseccio2", "modulo"=>"X3", "Horario"=>"9:3__0","sala"=>"5653","alumnos"=>$alumnos];
    $seccion3 = ['id'=>3, 'nombre'=>"nombreseccio3", "modulo"=>"v3", "Horario"=>"9:_30","sala"=>"56567","alumnos"=>$alumnos];
    $listado_secciones[$seccion1['id']] = $seccion1;
    $listado_secciones[$seccion2['id']] = $seccion2;
    $listado_secciones[$seccion3['id']] = $seccion3;
    //var_dump( $listado_secciones);

                    


?>

<fieldset>
    <legend>Secciones</legend>
    <div class="row"><!--fila-->
        <div class="span3">
            <h4>Escoja una seccion de la lista</h4>
            <input type="text" placeholder="Filtro búsqueda"><br/>
            <select id="select-secciones" size=16 onchange="mostrarDatos(this)">
                <?php
                    foreach ($listado_secciones as $seccion) {
                        echo "<option value='".$seccion["id"]."'>".$seccion['nombre']."</option>";
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
            <table class="table table-bordered" >            
                <tr>
                    <th>Carrera</th>
                    <th>Rut</th>
                    <th>Paterno</th>
                    <th>Materno</th>
                    <th>Nombres</th>
                    <th>Mail</th>
                </tr>
                <span id="mostrar-tabla_alumnos">
                    <!-- aqui se inyectará con javascript la lista de alumnos de la seccion elegida -->
                </span>
                
                
            </table>
        </div>
    </div>
</br>
<fieldset>

<script type="text/javascript">
    
    var array = <?php json_encode($listado_secciones); ?>;
    //alert(array[0]);
    function mostrarDatos(seleccion){
        //borrar datos de los spans
        $("#mostrar-profesor,#mostrar-modulo, #mostrar-horario, #mostrar-sala, #mostrar-tabla_alumnos").empty();
        //setear nuevos datos de los spans
        //$("#mostrar-profesor,#mostrar-modulo, #mostrar-horario, #mostrar-sala, #mostrar-tabla_alumnos").append("asddfsg");
        //var id_seccion = $("#select-secciones").value();
        var id_seccion = seleccion.options[seleccion.selectedIndex].value;

        //alert(<?php echo "'"; var_dump($listado_secciones);echo "'"; ?>)
        //alert(<?php echo "'".$listado_secciones."'"; ?>);
        
    }
</script>