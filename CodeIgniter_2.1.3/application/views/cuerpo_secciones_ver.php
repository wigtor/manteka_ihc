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
            <select size=16>
                <?php
                    foreach ($listado_secciones as $seccion) {
                        echo "<option value='".$seccion["id"]."'>".$seccion['nombre']."</option>";
                    }
                ?>
                
            </select>
        </div>
        <h4>Vea la informacion de la seccion seleccionada</h4>
        <h6>Profesor: <span id="profesor"> <!-- inyectar valor aqui --> </span></h6>
        <h6>Modulo:   <span id="modulo">   <!-- inyectar valor aqui --> </span></h6>
        <h6>Horario:  <span id ="horario"> <!-- inyectar valor aqui --> </span></h6>
        <h6>Sala:     <span id="sala">     <!-- inyectar valor aqui --> </span></h6>
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
                <span id="tabla_alumnos">
                    <!-- aqui se inyectará con javascript la lista de alumnos de la seccion elegida -->
                </span>
                
                
            </table>
        </div>
    </div>
</br>
<fieldset>