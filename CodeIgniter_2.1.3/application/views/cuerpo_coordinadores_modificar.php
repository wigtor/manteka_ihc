<fieldset>
	<legend>Modificar Coordinador</legend>
	<div class="span4">
		<h4>Seleccione un coordinador a modificar:<h4/><br/>
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
				<li>Contraseña</li>
				<li>Reingresar contraseña</li>
				<li>Correo </li>
				<li>Teléfono</li>
				</ul>
			</div>
		</div>
	    <select size=18 style="width:342px" onchange="mostrarDatos(this)">
			<?php 
				foreach ($listado_coordinadores as $coordinador){
					echo "<option value='id".$coordinador['id']."'>".$coordinador['nombre']."</option>";
				}
			?>
        </select>
	</div>
	<div class="span6 offset1">
		<div class="span12" id="visualizar-coordinador">
			<h4>Complete los siguientes datos para modificar un coordinador:</h4><br/>
			<?php 
				foreach ($listado_coordinadores as $coordinador){
					//echo form_open("http://localhost/manteka/index.php/Coordinadores/modificarCoordinador/");
					echo "<form class='span9' id='id".$coordinador['id']."'>";
					echo "<br/><table>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Nombre completo :</h6></td><td><input class ='input-xlarge' type='text' placeholder='ej:SOLAR FUENTES MAURICIO IGNACIO' default='".$coordinador['nombre']."' value='".$coordinador['nombre']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Rut :</h6></td><td><input class ='input-xlarge' type='text' placeholder='ej:5946896-3' default='".$coordinador['rut']."' value='".$coordinador['rut']."'></td></tr>	";		
					echo "<tr><td><h6><span class='text-error'>(*)</span>Contraseña :</h6></td><td><input class ='input-xlarge'  type='text' placeholder='*******' default='".$coordinador['contrasena']."' value='".$coordinador['contrasena']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Reingresar contraseña:</h6></td><td><input class ='input-xlarge' type='text' placeholder='*******' default='".$coordinador['contrasena']."' value='".$coordinador['contrasena']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Correo 1 :</h6></td><td><input class ='input-xlarge' type='text' placeholder='ej:edmundo.leiva@usach.cl' default='".$coordinador['correo1']."' value='".$coordinador['correo1']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Correo 2 :</h6></td><td><input class ='input-xlarge' type='text' placeholder='ej:edmundo@gmail.com' default='".$coordinador['correo2']."' value='".$coordinador['correo2']."'></td></tr>";
					echo "<tr><td><h6><span class='text-error'>(*)</span>Teléfono :</h6></td><td><input class ='input-xlarge' type='text' placeholder='ej:9-87654321' default='".$coordinador['fono']."' value='".$coordinador['fono']."'></td></tr>";
					echo "<tr><td></td><td>Los campos con <span class='text-error'>(*)</span> son obligatorios</td></tr>";
					echo "</table>";
					echo "<div class='span6 offset5' id='botones-guardar-cancelar'><button class='btn' type='button'>Guardar</button><button class='btn offset1' type='button'>Cancelar</button></div>";
					echo "</form><!-- span9-->";
				}
				
			?>

		</div>
	</div>
	
	
</fieldset>

<script type="text/javascript">
    $(document).ready(function(){
    	$("form.span9, #visualizar-coordinador").hide();

    });
	function mostrarDatos(seleccion){
        $("#visualizar-coordinador").show();
        var id_coordinador = seleccion.options[seleccion.selectedIndex].value;
        $("form.span9").hide();
        var visualizador = $("#"+id_coordinador);

        visualizador.show();

        
    }


</script>