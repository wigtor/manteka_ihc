<script type="text/javascript">
function validacion(){
	var input = document.getElementById('arch').value.lastIndexOf(".csv");
	var cargar = document.getElementById("formCargar");
	var contenido =document.getElementById('arch').value;

	if(contenido==""){
		$('#modalSinArchivo').modal();
	}
	else if(input==-1){
 		$('#modalErrorFormato').modal();
		return false;
	}
	else {
		cargar.submit();
	}
}	
</script>

<fieldset>
	<legend>Carga masiva de alumnos</legend>
	<div style="text-align:center!important;width: 100%">
		<?php //echo $error;?>

		<?php $atributos = array('onsubmit' => 'return validacion()', 'id'=>'formCargar');
		echo form_open_multipart('Estudiantes/cargaMasivaEstudiantes',$atributos);?>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div id="archivo" class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Seleccionar Archivo</span><span class="fileupload-exists">Cambiar</span><input  id ="arch" type="file"  name = "userfile"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
			</div>
		</div>


		<button type="button"  onclick="validacion()" value="upload" class="btn"><i class="icon-upload"></i>&nbsp;Subir</button>

		<br /><br />

		<div><font style="font-weight:bold" color="red">Aviso: </font>Solo es posible subir archivos con formato csv (Revisar manual de usuario)</div>
	</div>
    
    <!-- Modal de formato incompatible -->
	<div id="modalErrorFormato" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Formato del archivo incorrecto.</h3>
		</div>
		<div class="modal-body">
			<p>Por favor ingrese un archivo con extension .csv</p>
		</div>
		<div class="modal-footer">
			<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
		</div>
	</div>

	<!-- Modal de SinArchivo -->
	<div id="modalSinArchivo" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>No hay archivo seleccionado</h3>
		</div>
		<div class="modal-body">
			<p>Por favor seleccione un archivo con extension .csv</p>
		</div>
		<div class="modal-footer">
			<button class="btn" type="button" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</form>
</fieldset>


