<fieldset>
	<legend>Agregar Coordinador</legend>
		<div class="span7">
		<div class="span12">
			<h4>Complete los siguientes datos para agregar un coordinador:</h4><br/>
			<form  method="POST" class="span9" action="/manteka/index.php/Coordinadores/crearCoordinador/">
				<br/>
				<table>
					<tr>
					<td><h6><span class="text-error">(*)</span>Nombre completo  :</h6></td>
					<td><input class ="input-xlarge" name='nombre' type="text" placeholder="ej:SOLAR FUENTES MAURICIO IGNACIO"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Rut :</h6></td>
					<td><input class ="input-xlarge" name='rut' type="text" placeholder="ej:5946896-3"></td>
					</tr>			
					<tr>
					<td><h6><span class="text-error">(*)</span>Contrase�a :</h6></td>
					<td><input class ="input-xlarge" name='contrasena1'  type="text" placeholder="*******"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Confirmar contrase�a:</h6></td>
					<td><input class ="input-xlarge" name='contrasena2' type="text" placeholder="*******"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Correo 1 :</h6></td>
					<td><input class ="input-xlarge" name='correo1' type="text" placeholder="ej:edmundo.leiva@usach.cl"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Correo 2 :</h6></td>
					<td><input class ="input-xlarge" name='correo2' type="text" placeholder="ej:edmundo.leiva@gmail.com"></td>
					</tr>
					<tr>
					<td><h6><span class="text-error">(*)</span>Tel�fono :</h6></td>
					<td><input class ="input-xlarge" name='fono' type="text" placeholder="ej:9-87654321"></td>
					</tr>
					<tr>
					<td></td>
					<td>Los campos con <span class="text-error">(*)</span> son obligatorios</td>
					</tr>
				</table>
				<br />
				<div class="span6 offset6">
					<button class="btn" type="submit">Agregar</button>
					<a class="btn" href="/manteka/index.php/Coordinadores/verCoordinadores/" type="button">Cancelar</a>
				</div>
			</form>
		</div>
	</div>	
</fieldset>