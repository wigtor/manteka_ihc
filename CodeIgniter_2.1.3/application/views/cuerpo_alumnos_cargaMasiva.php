
<fieldset>
	<legend>Carga masiva de alumnos</legend>
	<?php echo $error;?>

	<?php echo form_open_multipart('Alumnos/cargaMasivaAlumnos');?>
	<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="input-append">
			<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name = "userfile"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		</div>
	</div>
	<br /><br />

	<button type="submit" value="upload" class="btn">Subir</button>

</form>

</fieldset>


