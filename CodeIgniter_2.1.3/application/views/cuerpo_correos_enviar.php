<!--javascript envio -->
<script type='text/javascript'>
  /* Esta función se llama al hacer click en el botón enviar, 
   * por convención las funciones que utilizan document.getElementById()
   * deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
   * Esta función retorna true o false, en caso de ser true el formulario se envía al servidor
   * Para ver como se configura esto se debe ver como es seteado el evento onsubmit() en el formulario.
   *Esta función se encarga de evitar el envio de mails sin destinatario o sin asunto ni cuerpo de correo
   *en caso de no contar con solo asunto o cuerpo decuerpo de correo pide confirmacion
  */

    function validacionSeleccion() {
        var rutRecept = document.getElementById("rutRecept").value;
        var texto = document.getElementById("editor").value;


        if (rutRecept!="") {
            texto = document.getElementById("editor").value;
            var asunto = document.getElementById("asunto").value;
            if (asunto==""&&texto==""){
                alert("No se puede mandar un mail sin asunto ni mensaje");
                return false;
            }else if (asunto=="") {
                if (confirm("Desea mandar este mensaje sin asunto?"))
                    return true;
                else 
                    return false;
            }else if (texto=="") {
                if (confirm("Desea mandar este mensaje sin cuerpo?"))
                    return true;
                else 
                    return false;
            }
            return true;
        }
        else {
            alert("Debe seleccionar un destinatario en el paso anterior");
            return false;
        }
            return false;
    }


  /* Esta función se llama al escribir en el filtro de busqueda, 
   * por convención las funciones que utilizan document.getElementById()
   * deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
   * Esta función elimina los resultados que no coincidan von el filtro de busqueda
  */
    function ordenarFiltro(filtroLista){
        var tipoDeDestinatario = document.getElementById("tipoDeDestinatario").value;
        
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


  /* Esta función se llama al hacer click en el botón enviar, 
   * por convención las funciones que utilizan document.getElementById()
   * deben ser definidas en la misma vista en que son utilizados para evitar conflictos de nombres.
   * Esta función muestra los detalles de la persona seleccinada y guarda su rut y correo para el envio
   */

    function DetalleAlumno(rut,nombre1,nombre2,apePaterno,apeMaterno,correo,seccion,carrera,numero){

        document.getElementById("rutDetalle").innerHTML = rut;
        document.getElementById("to").value=correo;
        document.getElementById("rutRecept").value=rut;
        document.getElementById("nombreunoDetalle").innerHTML = nombre1;
        document.getElementById("nombredosDetalle").innerHTML = nombre2;
        document.getElementById("apellidopaternoDetalle").innerHTML = apePaterno;
        document.getElementById("apellidomaternoDetalle").innerHTML = apeMaterno;
        document.getElementById("carreraDetalle").innerHTML = carrera;
        document.getElementById("seccionDetalle").innerHTML = seccion;
        document.getElementById("correoDetalle").innerHTML = correo;
        document.getElementById("numero").style.backgroundColor='#f00';
        
    }
</script>

    <style type="text/css">

    
    /* These classes are used by the script as rollover effect for table 1 and 2 */
    
    .tableRollOverEffect1{
        background-color:#848484;
        color:#81DAF5;
    }


    .tableRowClickEffect1{
        background-color:#0174DF;
        color:#FFFFFF;
    }

    
    </style>
    <script type="text/javascript">
    /************************************************************************************************************
    (C) www.dhtmlgoodies.com, November 2005
    
    This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.   
    
    Terms of use:
    You are free to use this script as long as the copyright message is kept intact. However, you may not
    redistribute, sell or repost it without our permission.
    
    Thank you!
    
    www.dhtmlgoodies.com
    Alf Magne Kalleland
    
    ************************************************************************************************************/   
    var arrayOfRolloverClasses = new Array();
    var arrayOfClickClasses = new Array();
    var activeRow = false;
    var activeRowClickArray = new Array();
    
    function highlightTableRow()
    {
        var tableObj = this.parentNode;
        if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

        if(this!=activeRow){
            this.setAttribute('origCl',this.className);
            this.origCl = this.className;
        }
        this.className = arrayOfRolloverClasses[tableObj.id];
        
        activeRow = this;
        
    }
    
    function clickOnTableRow()
    {
        var tableObj = this.parentNode;
        if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;        
        
        if(activeRowClickArray[tableObj.id] && this!=activeRowClickArray[tableObj.id]){
            activeRowClickArray[tableObj.id].className='';
        }
        this.className = arrayOfClickClasses[tableObj.id];
        
        activeRowClickArray[tableObj.id] = this;
                
    }
    
    function resetRowStyle()
    {
        var tableObj = this.parentNode;
        if(tableObj.tagName!='TABLE')tableObj = tableObj.parentNode;

        if(activeRowClickArray[tableObj.id] && this==activeRowClickArray[tableObj.id]){
            this.className = arrayOfClickClasses[tableObj.id];
            return; 
        }
        
        var origCl = this.getAttribute('origCl');
        if(!origCl)origCl = this.origCl;
        this.className=origCl;
        
    }
        
    function addTableRolloverEffect(tableId,whichClass,whichClassOnClick)
    {
        arrayOfRolloverClasses[tableId] = whichClass;
        arrayOfClickClasses[tableId] = whichClassOnClick;
        
        var tableObj = document.getElementById(tableId);
        var tBody = tableObj.getElementsByTagName('TBODY');
        if(tBody){
            var rows = tBody[0].getElementsByTagName('TR');
        }else{
            var rows = tableObj.getElementsByTagName('TR');
        }
        for(var no=0;no<rows.length;no++){
            rows[no].onmouseover = highlightTableRow;
            rows[no].onmouseout = resetRowStyle;
            
            if(whichClassOnClick){
                rows[no].onclick = clickOnTableRow; 
            }
        }
        
    }
    </script>

<!-- codigo -->
<fieldset>

    <legend>Enviar correo</legend>
    <div class="row-fluid">
        <div class="contenedor_ant_sig" boton_enviar="Enviar">


            <!--primer paso seleccionar plantilla -->

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
    
            <!--segundo paso seleccion de destinatario -->

        <div class="bloque" titulo="segunda Seccion">
            <div class="span6">
                2.-seleccione destinatarios
                <div class="span12">
                    <fieldset>
                        <input id="filtroLista" name="filtroLista" onkeyup="ordenarFiltro(this.value)" type="text" placeholder="Filtro búsqueda">
                        <select  id="tipoDeDestinatario" title="Tipo de destinatario" >
                            <option  value="1">Estudiantes</option>
                            <option  value="2">Profesores</option>
                            <option value="3">Ayudantes</option>
                        </select>
                    </fieldset> 
                </div>
                <fieldset >
                    <div class="span12"  >
                        <table id="tabla" class="table table-hover" style=" display: block; height: 350px; overflow-y: scroll;"  >
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Nombre Completo</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                    $rs_receptor=$rs_estudiantes;
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
                                                ','.$comilla.$contador.$comilla.')"style="text-align:left;">'. $rs_receptor[$contador][3].
                                                ' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].
                                            '</td>';
                                        echo '</tr>';
                                                                    
                                        $contador = $contador + 1;
                                    }
                                    echo '</form>';
                                ?>
                            </tbody>
                        </table>
                        <script type="text/javascript">
                            addTableRolloverEffect('tabla','tableRollOverEffect1','tableRowClickEffect1');
                            
                        </script> 
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

        <!--ultimo paso  enviar correo-->

        <div class="final" titulo="Seccion final">
        3. Escriba el correo deseado<br>

        <?php 
        $attributes = array('onSubmit' => 'return validacionSeleccion()', 'id' => 'formEnviar');
        echo form_open('Correo/enviarPost',$attributes);?>
        
            <div class="span4" style="margin-left: 1%; margin-top=2%">
                
                <fieldset>
                    
                    Para: &nbsp;&nbsp;&nbsp;&nbsp;<input id="to" name="to" type="text" value="<?php set_value('to'); ?>" readonly><br>
                    Asunto: &nbsp;<input id="asunto" name="asunto" type="text" value="<?php  set_value('asunto'); ?>">
                   
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
                ?><input type="hidden" name="rutRecept" id="rutRecept" value="<?php  set_value('rutRecept'); ?>" />
                 
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 1%; margin-top: 2%">enviar</button>
           <?php echo form_close(""); ?>

            
            
        </div><!-- .final -->
    </div><!-- .contenedor -->

</fieldset>

</html>