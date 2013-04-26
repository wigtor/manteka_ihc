<?php
    $arreglito1 = array("ingenieria",12558996-8,"araucano","maternox","gonzalo","miMail@usach.cl");
    $arreglito2 = array("Arquitectura",1111111-8,"muñoz","varas","lokohanks","miMail@usach.cl");
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