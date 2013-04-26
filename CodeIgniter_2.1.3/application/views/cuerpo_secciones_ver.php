<?php
//crear un arreglo que tenga el nombre (listado_secciones) y ponerle datos random para mostrar en las tablitas.
    $arreglito1 = array("ingenieria",12558996-8,"araucano","maternox","gonzalo","miMail@usach.cl");//hago un arreglo con esos  valores
    $arreglito2 = array("Arquitectura",1111111-8,"muñoz","varas","lokohanks","miMail@usach.cl");//hago un arreglo con esos  valores
    $secciones = array("A-1","B-2","C-4","D-89","M888");
    //var_dump($arreglito[1]);muestro el valor con calve 1 , quedando 12.
   // echo "{$arreglito[1]}";tambien se puede hacer asi, //muestro el valor con calve 1 , quedando 12.
?>
<fieldset>
    <legend>Secciones</legend>
    <div class="row"><!--fila-->
        <div class="span3">
            <h4>Escoja una seccion de la lista</h4>
            <input type="text" placeholder="Filtro búsqueda"><br/>
            <select multiple="multiple" style="height:280px">
                <option><?php echo "{$secciones[0]}" ?></option>
                <option><?php echo "{$secciones[1]}" ?></option>
                <option><?php echo "{$secciones[2]}" ?></option>
                <option><?php echo "{$secciones[3]}" ?></option>
                <option><?php echo "{$secciones[4]}" ?></option>
            </select>
        </div>
            <h4>Vea la informacion de la seccion seleccionada</h4>
            <h6>Profesor: Juan Jota</h6>
            <h6>Modulo: M2</h6>
            <h6>Horario: M3</h6>
            <h6>Sala: 565</h6>
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
                <tr>
                    <td><?php echo "{$arreglito1[0]}" ?></td>
                    <td><?php echo "{$arreglito1[1]}" ?></td>
                    <td><?php echo "{$arreglito1[2]}" ?></td>
                    <td><?php echo "{$arreglito1[3]}" ?></td>
                    <td><?php echo "{$arreglito1[4]}" ?></td>
                    <td><?php echo "{$arreglito1[5]}" ?></td>
                </tr>
                <tr>
                    <td><?php echo "{$arreglito2[0]}" ?></td>
                    <td><?php echo "{$arreglito2[1]}" ?></td>
                    <td><?php echo "{$arreglito2[2]}" ?></td>
                    <td><?php echo "{$arreglito2[3]}" ?></td>
                    <td><?php echo "{$arreglito2[4]}" ?></td>
                    <td><?php echo "{$arreglito2[5]}" ?></td>
                </tr>
                 <tr>
                    <td><?php echo "{$arreglito1[0]}" ?></td>
                    <td><?php echo "{$arreglito1[1]}" ?></td>
                    <td><?php echo "{$arreglito1[2]}" ?></td>
                    <td><?php echo "{$arreglito1[3]}" ?></td>
                    <td><?php echo "{$arreglito1[4]}" ?></td>
                    <td><?php echo "{$arreglito1[5]}" ?></td>
                </tr>
                <tr>
                    <td><?php echo "{$arreglito2[0]}" ?></td>
                    <td><?php echo "{$arreglito2[1]}" ?></td>
                    <td><?php echo "{$arreglito2[2]}" ?></td>
                    <td><?php echo "{$arreglito2[3]}" ?></td>
                    <td><?php echo "{$arreglito2[4]}" ?></td>
                    <td><?php echo "{$arreglito2[5]}" ?></td>
                </tr>
                <tr>
                    <td><?php echo "{$arreglito1[0]}" ?></td>
                    <td><?php echo "{$arreglito1[1]}" ?></td>
                    <td><?php echo "{$arreglito1[2]}" ?></td>
                    <td><?php echo "{$arreglito1[3]}" ?></td>
                    <td><?php echo "{$arreglito1[4]}" ?></td>
                    <td><?php echo "{$arreglito1[5]}" ?></td>
                </tr>
                <tr>
                    <td><?php echo "{$arreglito2[0]}" ?></td>
                    <td><?php echo "{$arreglito2[1]}" ?></td>
                    <td><?php echo "{$arreglito2[2]}" ?></td>
                    <td><?php echo "{$arreglito2[3]}" ?></td>
                    <td><?php echo "{$arreglito2[4]}" ?></td>
                    <td><?php echo "{$arreglito2[5]}" ?></td>
                </tr>
            </table>
        </div>
    </div>
</br>
<fieldset>