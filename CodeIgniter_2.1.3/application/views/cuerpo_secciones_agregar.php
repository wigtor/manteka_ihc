<div class="row-fluid">
	<div class= "span13">
		<fieldset>
			
			<legend>Agregar Sección</legend>
			
			<div class="row-fluid">
				<div class="span5">
					<div class="row-fluid">
						<div class="span5">
							1.-*Número de la Sección
						</div>
						<div class="span5">
							<input type="text" id="info" class="span2">
							<input type="text" id="info" class="span2">
						</div>

					</div>
					<div class="row-fluid">
						<div class="span5">
							2.-Agregar estudiantes
						</div>
					</div>
					<div class="row-fluid">
						<div class="span7">
							<input type="text" id="info" class="span13" placeholder="Filtro búsqueda">
						</div>
						<div class="span5">
							<select class="span13">
								  <option>1</option>
								  <option>2</option>
								  <option>3</option>
								  <option>4</option>
								  <option>5</option>
							</select>

						</div>

					</div>
					<div class="row-fluid" style="border: 1px solid #cccccc; -webkit-border-radius: 4px; overflow-y:scroll; height:150px; margin-top: 2%">


					</div>
					
					<div class="row-fluid" style="margin-left:82%; margin-top:2%">
						<div class="span2">
							<button class="btn" type="submit">Agregar</button>
						</div>
					</div>

				</div>
				<div class="span7">
					<div class="row-fluid">
						<div class="span5">
							3.-Lista de Alumnos
						</div>
					</div>
					<div class ="row-fluid">
						<div class="span10">
							<!--ESTE DIV ES PARA MOSTRAR LA SECCION CREADA-->
						</div>
					</div>
					<div class="row-fluid">
						<div class="span13" style="text-align:justify">
							A continuación se muestran los alumnos que se encuentran agregados a la sección. Si desea eliminar a un alumno de la sección, seleccione la o las casilla(s)
							correspondiente(s) y haga click en "Eliminar Seleccionados".
						</div>
					</div>
					<div class="row-fluid">
						<div class="span13">
							<table class="table table-bordered">
								<thead  bgcolor="#e6e6e6">
								    <tr>
								    	<th><input type="checkbox"></th>
								    	<th class="span2">Carrera</th>
								    	<th class="span2">RUT</th>
								    	<th class="span3">Paterno</th>
								    	<th class="span3">Materno</th>
								    	<th class="span9">Nombres</th>
								    </tr>
								</thead>
								    <!-- esta fila es solo de ejemplo-->
								<tbody>
								    <tr>
								    	<th><input type="checkbox"></th>
								    	<th>1853</th>
								    	<th>171233496</th>
								    	<th>Acevedo</th>
								    	<th>Baeza</th>
								    	<th>Marco Antonio</th>
								    </tr>
								</tbody>
								
							</table>
						</div>
					</div>
					<div class="row-fluid" style="margin-left:72%">
						<div class="span4">
							<button class="btn" type="submit">Eliminar seleccionados</button>
						</div>
					</div>
				</div>
			</div>
			
		</fieldset>
	</div>
</div>