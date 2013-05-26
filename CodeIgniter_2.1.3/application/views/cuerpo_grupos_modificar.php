<?php
/**
* Este Archivo corresponde al cuerpo central de la vista modificar grupos de contacto en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Agregar grupo de contacto</legend></br>
	<div class="span4">
		<h4>Seleccionar grupo:<h4/></br>
			<div class="span12">
				<input class ="input-xlarge" type="text" placeholder="Filtro de b�squeda">
				<select size=13 style="width:285px">
				<option>IHC</option>
				<option>Manteka</option>
				<option>Grupo A</option>
				<option>Agrupaci�n marilyn</option>
				</select>
			</div>	
	</div>
	<div class="span7">
		<h4>Edite los datos del grupo:<h4/><br/>
		<table>
		<tr>
		<td><h6><span class="text-error">(*)</span>Nombre del grupo  :</h6></td>
		<td><input class ="input-xlarge" type="text" placeholder="ej:Manteka"></td>
		</tr>
		</table>
		<div class="span5">
			</br>
			<h6>Miembros del grupo:</h6>
			<select size=9 style="width:200px">
			<option>Alumno 1</option>
			<option>Alumno 2</option>
			<option>Alumno 3</option>
			<option>Alumno 4</option>
			</select>
		</div>
		<div class="span1">
		
		</div>
		<div class="span5">
			</br>
			<div class="input-append">
			<input class="span7" id="appendedDropdownButton" type="text" placeholder="Filtro">
			<div class="btn-group">
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					Filtrar por
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<li>Nombre</li>
				<li>Rut</li>
				<li>Contrase�a</li>
				<li>Reingresar contrase�a</li>
				<li>Correo </li>
				<li>Tel�fono</li>
				</ul>
			</div>
		</div>
	    <select size=9 style="width:250px">
		<option>Alumno 6</option>
		<option>Alumno 7</option>
		<option>Alumno 8</option>
		<option>Alumno 9</option>
        </select>
		</div>
	</div>
	<div class="span3 offset9">
		<button class="btn" type="button">Agregar</button>
		<button class="btn" type="button">Cancelar</button>
	</div>
	
</fieldset>

<script type="text/javascript">
	alert("En esta vista esta solo implementada la parte visual. Ninguna funcionalidad est� disponible.")
</script>
