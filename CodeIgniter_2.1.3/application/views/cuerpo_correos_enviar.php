


	<!-- css ant sig -->
<head>
	<style>
    .contenedor_ant_sig{
      display:block;
      width:98%;
      position:relative;
      margin: 10px auto 20px auto;
     }
     .contenedor_ant_sig div.bloque, .contenedor_ant_sig div.final, .contenedor_ant_sig div.inicio{
        overflow:hidden;
        float: left;
        min-height:100px;
        
        margin-bottom:10px;
        width:0%;
        position:relative;
        padding: 10px 0 10px 0;
      }
      .contenedor_ant_sig div.bloque.activo, .contenedor_ant_sig div.inicio.activo, .contenedor_ant_sig div.final.activo{
        width:98%;
        padding: 10px 1% 10px 1%;
      }
      .contenedor_ant_sig div.bloque button, .contenedor_ant_sig div.final button, .contenedor_ant_sig div.inicio button, .contenedor_ant_sig input.submit{
        float:right;
        margin-right:12px;
        height:inherit;
        width:80px;
        text-align:center;
      }
      .box_anterior_siguiente{
        position:absolute;
        height:30px;
        bottom:15px;
        width:100%;
        margin-top:15px;
        padding-top:15px;
        border-top:1px solid #999;
      }
      .box_anterior_siguiente div.barra_navegacion{
        
        width:76%;
        float:left;
        height:inherit ;
        line-height:30px;
      }
      .box_anterior_siguiente div.barra_navegacion div.elemento_navegacion{
        float:left;
        text-align:center;
        height:inherit ;
        line-height:30px;
      }
      .box_anterior_siguiente div.barra_navegacion div.elemento_navegacion.activo{
        background-color:grey;
      }
	</style>
</head>




<!-- codigo   -->
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
                        <input id="filtroLista"  onkeyup="ordenarFiltro()" type="text" placeholder="Filtro búsqueda">
                        <select id="tipoDeDestinatario" title="Tipo de destinatario" >
                            <option value="1">Estudiantes</option>
                            <option value="2">Profesores</option>
                            <option value="3">Ayudantes</option>

						</select> 

					</div>
                    <div class="row-fluid" style="margin-left: 3%;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre Completo</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        $contador=0;
                        $comilla= "'";
                        echo '<form id="formDetalle" type="post">';
                        $rs_receptor=$rs_estudiantes;
                        while ($contador<count($rs_receptor)){
                            
                            echo '<tr>';
                            echo    '<td  id="'.$contador.'" onclick="DetalleAlumno('.$comilla.$rs_receptor[$contador][0].$comilla.','.$comilla. $rs_receptor[$contador][1].$comilla.','.$comilla. $rs_receptor[$contador][2].$comilla.','.$comilla. $rs_receptor[$contador][3].$comilla.','.$comilla. $rs_receptor[$contador][4].$comilla.','.$comilla. $rs_receptor[$contador][5].$comilla.','. $comilla.$rs_receptor[$contador][6].$comilla.','.$comilla. $rs_receptor[$contador][7].$comilla.')" 
                                          style="text-align:left;">
                                          '. $rs_receptor[$contador][3].' '.$rs_receptor[$contador][4].' ' . $rs_receptor[$contador][1].' '.$rs_receptor[$contador][2].'</td>';
                            echo '</tr>';
                                                        
                            $contador = $contador + 1;
                        }
                        echo '</form>';
                        ?>
                                                
                    </tbody>
                </table>
            </div>
        </div>
			</fieldset>
		<div class="span6" style="margin-left: 2%; padding: 0%; ">
        2.-Receptor:
        <pre style="margin-top: 2%; padding: 2%">
Rut:              <b id="rutDetalle"></b>
Nombre uno:       <b id="nombreunoDetalle"></b>
Nombre dos:       <b id="nombredosDetalle" ></b>
Apellido paterno: <b id="apellidopaternoDetalle" ></b>
Apellido materno: <b id="apellidomaternoDetalle"></b>
Carrera:          <b id="carreraDetalle" ></b>
Sección:          <b id="seccionDetalle"></b>
Correo:           <b id="correoDetalle"></b></pre>

        </div>		
			</div>
			

        </div><!-- .bloque -->


        <div class="final" titulo="Seccion final">
            <h1>bloque final</h1>
            <input />
        </div><!-- .final -->
    </div><!-- .contenedor -->

</fieldset>


<!--javascript envio -->

<script type="text/javascript">
function ordenarFiltro(){
    var filtroLista = document.getElementById("filtroLista").value;
    var tipoDeDestinatario = document.getElementById("tipoDeDestinatario").value;

    
    var arreglo = new Array();
    var alumno;
    var ocultar;
    var cont;
    

    <?php
    $contadorE = 0;
    $rs_receptor=$rs_estudiantes;
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
        alumno = document.getElementById(cont);
        ocultar=document.getElementById(cont);
        if(0 > arreglo[cont][3].toLowerCase ().indexOf(filtroLista.toLowerCase ())){
            ocultar.style.display='none';
        }
        else
        {
            ocultar.style.display='';
        }
    }
}
</script>


	<!-- javascript ant sig -->

	<!-- javascript -->
<script type="text/javascript">
	//codigo necesario para el funcionamiento de la barra de "anterior - siguiente"
    $(document).ready(function () {        
        $('.inicio').each(function () {
            string = "<div class='elemento_navegacion activo'>"+ $(this).attr("titulo") +"</div>";
        });
        $('.bloque , .final').each(function () {
            string = string + "<div class='elemento_navegacion'>"+ $(this).attr("titulo") +"</div>";
        });
        
        $(".contenedor_ant_sig div.inicio").each(function (index) {
            $(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+ string +"</div><button class='siguiente'>siguiente</button></div>");
            $(this).addClass("activo");
        });
        $(".contenedor_ant_sig .bloque").each(function (index) {
            $(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+string+"</div><button class='siguiente'>siguiente</button><button class='anterior'>anterior</button></div>");
        });
        $(".contenedor_ant_sig .final").each(function (index) {
		    var submit_name = "Enviar";
		    if( $(".contenedor_ant_sig").attr('boton_enviar') ){
				submit_name = $(".contenedor_ant_sig").attr('boton_enviar');
			}
			//el submit puede o no tener mas atributos los cuales deben ser especificados caso a caso.
            $(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+string+"</div><input class='submit' type='submit' value='"+ submit_name +"'  /><button class='anterior'>anterior</button></div>");
        });
        $('.contenedor_ant_sig div button.siguiente').click(function(event){
            event.preventDefault();
            event.stopPropagation();
            $(".activo").removeClass("activo").next().addClass("activo");
        });
        $('.contenedor_ant_sig div button.anterior').click(function(event){
            event.preventDefault();
            event.stopPropagation();
            $(".activo").removeClass("activo").prev().addClass("activo");
        });
        
        $('.contenedor_ant_sig').height(altura_maxima_bloques);
        var cantidad_cartas = $(".inicio .elemento_navegacion").length;
        var ancho_total = $(".barra_navegacion").width();
        var ancho_elemento_navegacion = Math.floor(ancho_total/cantidad_cartas - 5);
        $(".elemento_navegacion").css({width:ancho_elemento_navegacion});
        
        var altura_maxima_bloques=$(".contenedor_ant_sig div.inicio").height();
        $('.contenedor_ant_sig div.inicio, .contenedor_ant_sig div.bloque,.contenedor_ant_sig div.final').each(function () {
            if( altura_maxima_bloques < $(this).height() ){
                altura_maxima_bloques = $(this).height();
            }
        });
        $('.contenedor_ant_sig div.inicio, .contenedor_ant_sig div.bloque,.contenedor_ant_sig div.final').each(function () {
            $(this).height(altura_maxima_bloques+40);
        });
    });
</script>
<!-- /javascript -->


</html>
