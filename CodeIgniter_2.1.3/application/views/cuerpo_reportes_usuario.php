<!--
<link rel="stylesheet" href="/<?php echo config_item('dir_alias') ?>/css/enviarCorreo.css" type="text/css" media="all" />
-->
<!--
	OJO ES MUY IMPORTANTE PONER LOS CÓDIGOS CORRECTOS DE CARRERA EN LA LISTA YA QUE LOS QUE SE UTILIZARON SON SÓLO DE PRUEBAS
-->
<script>
	
	function mostrarTitulo(){
		var titulo= $('input[id=TITULO]').val().length;
		if(titulo == 0){
			//alert("Debe ingresar título");
		}	
	}
	
	
	function bloquear_input(numero){
		if(numero == 0){
			 $('#COLUMNA1').attr("disabled",true);
			 $('#COLUMNA2').attr('disabled',true);
			 $('#RADIO_1').attr("checked",true);
			 $('#RADIO_2').attr("checked",false);
			 $('#RADIO_3').attr("checked",false);
		}
		if(numero == 1){
			 $('#COLUMNA1').attr('disabled',false);
			 $('#COLUMNA2').attr('disabled',true);
			 $('#RADIO_1').attr("checked",false);
			 $('#RADIO_2').attr("checked",true);
			 $('#RADIO_3').attr("checked",false);
		}
		if(numero == 2){
			 $('#COLUMNA1').attr('disabled',false);
			 $('#COLUMNA2').attr('disabled',false);
			 $('#RADIO_1').attr("checked",false);
			 $('#RADIO_2').attr("checked",false);
			 $('#RADIO_3').attr("checked",true);
		}
	}
	function cantidad_columnas(){
		if( $('#RADIO_1').attr("checked")){
			return 0;
		}
		if( $('#RADIO_2').attr("checked")){
			return 1;
		}
		if( $('#RADIO_3').attr("checked")){
			return 2;
		}
	}
	function MostrarReporte(NombredelReporte) {
			var titulo = $('input[id=TITULO]').val();	
			var descripcion = $('#DESCRIPCION').val();
			var carrera = $('select[id=CARRERA]').val();			
			var seccion = $('select[id=SECCION]').val();	
			var lugar=$('#LUGAR').val();
			var horario=$('#HORARIO').val();
			var columnas=cantidad_columnas();
			if(columnas == 1){
				var columna_1 = $('#COLUMNA1').val(); 				
			}
			if(columnas == 2){
				var columna_1 = $('#COLUMNA1').val(); 
				var columna_2 = $('#COLUMNA2').val(); 
			}
			
			var myModal2 = document.getElementById("myModal2");
			var parametros = "&titulo="+titulo+"&carrera="+carrera+"&seccion="+seccion+"&descripcion="+descripcion+"&horario="+horario+"&lugar="+lugar+"&columnas="+columnas+"&columna_1="+columna_1+"&columna_2="+columna_2;
			//alert(parametros);
			$(myModal2).attr('src','/<?php echo config_item("dir_alias") ?>/report_view_usuario.php?nombreReporte='+NombredelReporte+"&mode=I"+parametros);
			$('#buttonDescarga').attr('name',NombredelReporte);
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();	
	}

	function DescargarArchivo() {
			var titulo = $('input[id=TITULO]').val();	
			var descripcion = $('#DESCRIPCION').val();
			var carrera = $('select[id=CARRERA]').val();			
			var seccion = $('select[id=SECCION]').val();	
			var lugar=$('#LUGAR').val();
			var horario=$('#HORARIO').val();
			var columnas=cantidad_columnas();
			if(columnas == 1){
				var columna_1 = $('#COLUMNA1').val(); 				
			}
			if(columnas == 2){
				var columna_1 = $('#COLUMNA1').val(); 
				var columna_2 = $('#COLUMNA2').val(); 
			}
			var parametros = "&titulo="+titulo+"&carrera="+carrera+"&seccion="+seccion+"&descripcion="+descripcion+"&horario="+horario+"&lugar="+lugar+"&columnas="+columnas+"&columna_1="+columna_1+"&columna_2="+columna_2;
			var nombreReporte = $('#buttonDescarga').attr('name');
			var myModal2 = document.getElementById("myModal2");		
			window.location = '/<?php echo config_item("dir_alias") ?>/report_view_usuario.php?nombreReporte='+nombreReporte+"&mode=D"+parametros;
	}

	$(document).ready(function(){
		$('tbody tr').on('click', function(event) {
				$(this).addClass('highlight').siblings().removeClass('highlight');
			});
		});
</script>
<fieldset id="cuadroEnviar">
    <legend>&nbsp;Reportes de Usuario&nbsp;</legend>
	
	<div class="inicio" title="">
	<form action="<?php  ?>" method='post'>
	<?php
		$attributes = array();
		echo form_open('ReportesUsuario/detalleReportes',$attributes);		
	?>
		<div class="span4">
		<div class="texto1" >Título del Reporte</div>
		<div><input id="TITULO"type="text" name="TITULO" maxlength="16" placeholder="Ingrese título para el reporte" title="Ingrese título para el reporte"></div>
		<div class="texto1" >Descripción</div>
		<div><input id="DESCRIPCION" type="text" maxlength="34" name="DESCRIPCION" placeholder="Ingrese descripción del reporte"title="Ingrese descripción para el reporte" cols="20" rows="3" style="resize:none"></div>
		<div class="texto1" >Horario</div>
		<div><input id="HORARIO"type="text" name="HORARIO" maxlength="5" placeholder="Ingrese el horario, Ej: 14:00 hrs" title="Ingrese el horario para el reporte"></div>
		<div class="texto1" >Lugar</div>
		<div><input id="LUGAR"type="text" name="LUGAR" maxlength="15" placeholder="Ingrese el lugar, Ej: SALA 565" title="Ingrese el lugar para el reporte"></div>
		
		
		</div>
		<div class="span4">
		<div class="texto1">
			Seleccione Seccion de Alumnos		
		</div>
		<div class="seleccion" >
			<input type="checkbox" name="CHECK_SECCIONES" onclick = "SECCION.disabled = !this.checked" title="Seleccione si desea filtrar por seccion"style="margin-top:-10px">
				<select id="SECCION" title="Secciones" name="SECCION" disabled>
				<option value ="0"></option>
				<?php for ($i = 0; $i < count($seccion); $i++) { ?>
					<option value ="<?php echo $seccion[$i][0]; ?>"><?php echo $seccion[$i][1]; ?></option>
				<?php } ?>		
			</select>
		
		</div>
		<div class="texto1">
			Seleccione una Carrera		
		</div>
		<div class="seleccion" >
		<input type="checkbox" name="CHECK_CARRERA" onclick = "CARRERA.disabled = !this.checked" title="Seleccione si desea filtrar por carrera" style="margin-top:-10px">
			<select id="CARRERA" title="Seleccione una Carrera" name="CARRERA" disabled>
				<option value ="0"></option>
				<?php for ($i = 0; $i < count($carreras); $i++) { ?>
					<option value ="<?php echo $carreras[$i][0]; ?>"><?php echo $carreras[$i][1]; ?></option>
				<?php } ?>	
				<!--<option value ="">Ingeniería en Biotecnología</option>-->
			</select>		
		</div>
		</div>
		<div class="span4">
		<div class="texto1" >Ingrese la cantidad de columnas que desea agregar al reporte:</div>
		<div class "seleccion">
		<div><input type="radio" id="RADIO_1" name="COLUMNAS" value="0" onchange = "bloquear_input(0)" checked>  No agregar Columnas</div>
		<div><input type="radio" id="RADIO_2" name="COLUMNAS" value="1" onchange = "bloquear_input(1)" >  Agregar 1 Columna </div>
		<div><input type="radio" id="RADIO_3" name="COLUMNAS" value="2"  onchange = "bloquear_input(2)" >  Agregar 2 Columnas</div><br>
		<div><input id="COLUMNA1"type="text" name="COLUMNA1" maxlength="12" placeholder="Ingrese el título de la columna 1" title="Ingrese el título de la columna 1" disabled></div>
		<div><input id="COLUMNA2"type="text" name="COLUMNA2"  maxlength="12" placeholder="Ingrese el título de la columna 2" title="Ingrese el título de la columna 2" disabled	><BR></div>
		
		</div>
		<div class="row-fluid">
			<ul class="page pull-right">
			<br><br>
			<button class ="btn" type="submit" href="#myModal" title="Generar Reporte"  onClick="MostrarReporte('Estudiantes por Usuario')" data-toggle="modal">Generar Reporte</button>
			</ul>
		</div>
		</div>
		
	<?php echo form_close(""); ?>
	</div>
	<div id="myModal" class="modal hide fade" style="width:70%;border-color: #e5e5e5; bottom:5%; left:35%; top:5%; background-color: rgb(248, 248, 248); box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px inset, rgba(82, 168, 236, 0.6) 0px 0px 8px; border: 1px solid #e5e5e5; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div  class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	    	<button onClick="DescargarArchivo()" id="buttonDescarga" type="button" class="close" style="height: 45px; width: 119px; margin: -11px 30px 0px 0px;" aria-hidden="true"><div class="btn_with_icon_solo" style="height: 13px;"></div>&nbsp;Descargar</button>
	    	<h3 id="myModalLabel" style="color: #0088cc;">Reporte de Usuarios</h3>
	  	</div>
	  	<iframe class="modal-body" id="myModal2" style="width:100%; height:90%; max-height:90%; border:0px; padding: 1px 0px 0px 0px;"></iframe>
	  	
	</div>
	</fieldset>
<script type="text/javascript">
