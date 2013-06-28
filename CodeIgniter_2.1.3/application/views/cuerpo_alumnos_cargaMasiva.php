
<fieldset>
	<legend>Carga masiva de alumnos</legend>
	<div style="text-align:center!important;width: 100%">
		<?php echo $error;?>

		<?php echo form_open_multipart('Alumnos/cargaMasivaAlumnos');?>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Seleccionar Archivo</span><span class="fileupload-exists">Cambiar</span><input type="file" name = "userfile"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
			</div>
		</div>


		<button type="submit" value="upload" class="btn">Subir</button>

		<br /><br />

		<div><font style="font-weight:bold" color="red">Aviso: </font>Solo es posible subir archivos con formato csv (Revisar manual de usuario)</div>
	</div>
</form>
</fieldset>


