<!-- codigo -->
<fieldset>

    <legend>Enviar correo</legend>
    <div class="row-fluid">
        <div class="contenedor_ant_sig" boton_enviar="Enviar">
        <div class="inicio" titulo="Seccion inicial">
            <div class="span4">
                1.-seleccione plantilla

                    <div class="span10">
                        <select id="tipoDePantilla" title="Tipo de plantilla" name="Plantilla a usar">
                            <option value="1">Sin plantilla</option>
                        
                        </select>
                    </div>


            </div>

            <div class="span10" >

            <pre style="margin-top: 5%;margin-bottom: 5%;">





            </pre>
            </div>
        </div><!-- .inicio -->
    
        <div class="bloque" titulo="segunda Seccion">
            <div class="span6">
                2.-seleccione destinatarios
                <div class="span12">
                    <fieldset>
                        <input id="filtroLista" onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">
                        <select onchange="seleccionarTipo()" id="tipoDeDestinatario" title="Tipo de destinatario" >
                            <option  value="1">Estudiantes</option>
                            <option  value="2">Profesores</option>
                            <option value="3">Ayudantes</option>
                        </select>
                    </fieldset> 
                </div>
                <fieldset >
                <div class="span12"  >
                    <table class="table table-hover" style=" display: block; height: 350px; overflow-y: scroll;"  >
                        <thead>
                            <tr>
                                <th style="text-align:left;">Nombre Completo</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                            <?php
                                $rs_receptor=$rs_estudiantes;//cambiar ver tablas dinamicas
                                $contador=0;
                                $comilla= "'";
                                echo '<form id="formDetalle" type="post">';
                                
                                
                                while ($contador<count($rs_receptor)){
                                    echo '<tr>';
                                    echo '<td id="'.$contador.'
                                            " onclick="DetalleAlumno('.$comilla.$rs_receptor[$contador][0].
                                            $comilla.','.$comilla. $rs_receptor[$contador][1].$comilla.
                                            ','.$comilla. $rs_receptor[$contador][2].$comilla.','.$comilla. 
                                            $rs_receptor[$contador][3].$comilla.','.$comilla. 
                                            $rs_receptor[$contador][4].$comilla.','.$comilla. $rs_receptor[$contador][5].$comilla.
                                            ','. $comilla.$rs_receptor[$contador][6].$comilla.','.$comilla. $rs_receptor[$contador][7].$comilla.
                                            ')"style="text-align:left;">'. $rs_receptor[$contador][3].
                                            ' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].
                                        '</td>';
                                    echo '</tr>';
                                                                
                                    $contador = $contador + 1;
                                }
                                echo '</form>';
                            ?>
                        </tbody>
                    </table>
                </div>  
                
            </fieldset>
            </div>
                   
            <div class="span5" style="margin-left: 2%; padding: 0%; ">
                Receptor:
                <pre style="margin-top: 2%; padding: 2%">
                    Rut: <b id="rutDetalle"></b>
                    Nombre uno: <b id="nombreunoDetalle"></b>
                    Nombre dos: <b id="nombredosDetalle" ></b>
                    Apellido paterno: <b id="apellidopaternoDetalle" ></b>
                    Apellido materno: <b id="apellidomaternoDetalle"></b>
                    Carrera: <b id="carreraDetalle" ></b>
                    Sección: <b id="seccionDetalle"></b>
                    Correo: <b id="correoDetalle"></b>
                </pre>
            </div>
        </div><!-- .bloque -->


        <div class="final" titulo="Seccion final">
        3. Escriba el correo deseado<br>

        <?php echo form_open('Correo/enviarPost');?>
        
            <div class="span4" style="margin-left: 1%; margin-top=2%">
                <fieldset>
                    <!--cambiar correo ver pasar datos entre las vistas -->
                    Para: &nbsp;&nbsp;&nbsp;&nbsp;<input id="to" name="to" type="text" value="<?php echo 'byronlanasl@hotmail.com';?>" readonly><br>
                    Asunto: &nbsp;<input id="asunto" name="asunto" type="text" value="<?= set_value('asunto'); ?>">
                   
                </fieldset>
            </div>
            <div class="span14"style="margin-left: 1%; margin-top: 2%">
                <?php 
                $data = array(
              'name'        => 'editor',
              'id'          => 'editor',
              'value'       => set_value('editor'),
              'class'       => 'ckeditor',
            );
                echo form_textarea($data);
                echo form_hidden('tipo', 'CARTA_ESTUDIANTE'); //cambiar ver tablas dinamicas
                echo form_hidden('rutRecept', '18464353'); //cambiar ver pasar datos 
                 ?>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 1%; margin-top: 2%">enviar</button>
           <?php echo form_close(""); ?>

            
            
        </div><!-- .final -->
    </div><!-- .contenedor -->

</fieldset>


<!--javascript envio -->

<script type="text/javascript">
    function seleccionarTipo(){
        
        
        //cambiar ver tablas dinamicas
        if(Number(tipoDeDestinatario)==1){
            <?php
                $rs_receptor=$rs_receptor;
            ?>
        }else if(Number(tipoDeDestinatario)!=1){
            <?php
                $rs_receptor=null;
            ?>
        }
    }
</script>

<script type="text/javascript">
    function ordenarFiltro(){
        var filtroLista = document.getElementById("filtroLista").value;
        
        var arreglo = new Array();
        var receptor;
        var ocultar;
        var cont;

        <?php
            $contadorE = 0;
            $rs_receptor=$rs_estudiantes;//cambiar ver tablas dinamicas
            while($contadorE<count($rs_receptor)){
                echo 'arreglo['.$contadorE.']=new Array();';
                echo 'arreglo['.$contadorE.'][1] = "'.$rs_receptor[$contadorE][1].'";';
                echo 'arreglo['.$contadorE.'][3] = "'.$rs_receptor[$contadorE][3].'";';
                echo 'arreglo['.$contadorE.'][4] = "'.$rs_receptor[$contadorE][4].'";';
                echo 'arreglo['.$contadorE.'][7] = "'.$rs_receptor[$contadorE][7].'";';
                echo 'arreglo['.$contadorE.'][6] = "'.$rs_receptor[$contadorE][6].'";';
                $contadorE = $contadorE + 1;
            }
        ?>
        for(cont=0;cont < arreglo.length;cont++){
            receptor = document.getElementById(cont);
            ocultar=document.getElementById(cont);
            if(0 > arreglo[cont][3].toLowerCase ().indexOf(filtroLista.toLowerCase ())&
               0 > arreglo[cont][4].toLowerCase ().indexOf(filtroLista.toLowerCase ())&
               0 > arreglo[cont][1].toLowerCase ().indexOf(filtroLista.toLowerCase ()))
            {
                ocultar.style.display='none';
            }
            else{
                ocultar.style.display='';
            }
        }
    }
</script>

<script type="text/javascript">
    function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera){
        
        document.getElementById("rutDetalle").innerHTML = rut;
        
        document.getElementById("nombreunoDetalle").innerHTML = nombre1;
        document.getElementById("nombredosDetalle").innerHTML = nombre2;
        document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
        document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
        document.getElementById("carreraDetalle").innerHTML = carrera;
        document.getElementById("seccionDetalle").innerHTML = seccion;
        document.getElementById("correoDetalle").innerHTML = correo;
        
    }
</script>




</html>