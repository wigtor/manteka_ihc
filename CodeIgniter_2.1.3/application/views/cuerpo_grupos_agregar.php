<?php
/**
* Este Archivo corresponde al cuerpo central de la vista agregar grupos de contacto en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Views
* @author     Grupo 2 IHC 1-2013 Usach
*/
?>
<fieldset>
	<legend>Agregar grupo de contacto</legend></br>
	<div class="span6">
		<h4>Datos del grupo:<h4/></br>
			<div class="span12">
				<table>
				<tr>
				<td><h6><span class="text-error">(*)</span>Nombre del grupo  :</h6></td>
				<td><input class ="input-xlarge" type="text" placeholder="ej:manteka"></td>
				</tr>
				</table>
			</div>	
	</div>
	<div class="span4">
		<h4>Seleccionar miembros:<h4/><br/>
		<div class="input-append">
			<input class="span11" id="appendedDropdownButton" type="text" placeholder="Filtro">
			<div class="btn-group">
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					Filtrar por
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<li>Rut</li>
				<li>Nombre</li>
				<li>Apellido paterno</li>
				<li>Apellido materno</li>
				<li>Correo</li>
				<li>Carrera</li>
				<li>Secci�n</li>
				</ul>
			</div>
		</div>
	    <select size=9 style="width:342px">
		<option>Alumno 1</option>
		<option>Alumno 2</option>
		<option>Alumno 3</option>
		<option>Alumno 4</option>
        </select>
	</div>
	<div class="span3 offset9">
		<button class="btn" type="button">Agregar</button>
		<button class="btn" type="button">Cancelar</button>
	</div>
	
</fieldset>

<script type="text/javascript">
	alert("En esta vista esta solo implementada la parte visual. Ninguna funcionalidad est� disponible.")
</script>
