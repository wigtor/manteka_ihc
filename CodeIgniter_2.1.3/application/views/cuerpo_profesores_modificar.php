
<fieldset>
	<legend>Editar profesores</legend>
	<div class="span4">
		<h4>Seleccione un profesor a modificar:<h4/><br/>
		<div class="input-append">
			<input class="span11" id="appendedDropdownButton" type="text" placeholder="Filtro">
			<div class="btn-group">
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					Filtrar por
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<li>Nombre</li>
				<li>Rut</li>
				<li>Mail</li>
				<li>Teléfono</li>
				<li>Módulo</li>
				<li>Sección</li>
				<li>Tipo</li>
				</ul>
			</div>
		</div>
	    <select size=18 style="width:342px">
		<option>Profesor 1 </option>
		<option>Profesor 2</option>
		<option>Profesor 3</option>
		<option>Profesor 4</option>
        </select>
	</div>
	<div class="span6 offset1">
		<div class="span12">
			<h4>Complete los siguientes datos para modificar un profesor:</h4><br/>
			<div class="span9">
				<br/>
				<table>
				<tr>
				<td><h6><span class="text-error">(*)</span>Nombre completo  :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:SOLAR FUENTES MAURICIO IGNACIO"></td>
				</tr>
				<tr>
				<td><h6><span class="text-error">(*)</span>Rut :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:5946896-3"></td>
				</tr>			
				<tr>
				<td><h6><span class="text-error">(*)</span>Mail :</h6></td>
				<td><input class ="input-xlarge"  type="text" placeholder="ej:usuario@contacto.cl"></td>
				</tr>
				<tr>
				<td><h6><span class="text-error">(*)</span>Teléfono:</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:02-123456"></td>
				</tr>
				<tr>
				<td><h6><span class="text-error">(*)</span>Módulo :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:Comunicación y compromiso"></td>
				</tr>
				<tr>
				<td><h6><span class="text-error">(*)</span>Sección :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:H-1"></td>
				</tr>
				<tr>
				<td><h6><span class="text-error">(*)</span>Tipo :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:De planta"></td>
				</tr>
				<tr>
				<td></td>
				<td>Los campos con <span class="text-error">(*)</span> son obligatorios</td>
				</tr>
				</table>
				
			</div>
		</div>	
	</div>
	<div class="span3 offset9">
		<button class="btn" type="button">Guardar</button>
		<button class="btn" type="button">Cancelar</button>
	</div>
	
</fieldset>