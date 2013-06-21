
<script>

	function MostrarReporte(NombredelReporte) {
			var myModal2 = document.getElementById("myModal2");
			$(myModal2).attr('src','/<?php echo config_item("dir_alias") ?>/report_view.php?nombreReporte='+NombredelReporte);
			$('#buttonDescarga').attr('name',NombredelReporte);
			var iconoCargado = document.getElementById("icono_cargando");
			$(icono_cargando).hide();	
	}

	function DescargarArchivo() {
			var nombreReporte = $('#buttonDescarga').attr('name');
			var myModal2 = document.getElementById("myModal2");
			window.location = '/<?php echo config_item("dir_alias") ?>/report_descarga.php?nombreReporte='+nombreReporte;
	}

	$(document).ready(function(){
		$('tbody tr').on('click', function(event) {
				$(this).addClass('highlight').siblings().removeClass('highlight');
			});
		});
</script>

<fieldset>
	<div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Nombre del reporte</th>
					<th>Descripcion</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><a href="#myModal" onClick="MostrarReporte('Estudiantes')" data-toggle="modal">Reporte Estudiantes</a></td>
					<td>Este reporte entrega los datos personales de los estudiantes</td>
				</tr>
				<tr>
					<td><a>Reporte Profesores</a></td>
					<td>Este reporte entrega los datos personales de los profesores</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- Pantalla externa que muestra el pdf <href="#myModal" data-toggle="modal"s-->
	<div id="myModal" class="modal hide fade" style="width:70%;border-color: #e5e5e5; bottom:5%; left:35%; top:5%; background-color: rgb(248, 248, 248); box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px inset, rgba(82, 168, 236, 0.6) 0px 0px 8px; border: 1px solid #e5e5e5; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div  class="modal-header">
	    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	    	<button onClick="DescargarArchivo()" id="buttonDescarga"type="button" class="close" style="margin-right:100px" aria-hidden="true">Descargar</button>
	    	<h3 id="myModalLabel" style="color: #0088cc;">Reporte Estudiantes</h3>
	  	</div>
	  	<iframe class="modal-body" id="myModal2" style="width:100%; height:90%; max-height:90%; border:0px; padding: 1px 0px 0px 0px;"></iframe>
	  	
	</div>
</fields>