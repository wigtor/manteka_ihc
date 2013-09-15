<?php

/**
* Clase utilizada para hacer consultas a la base de datos acerca de los estudiantes
* @author Grupo 4
*/
class Model_estudiante extends CI_Model {

	/**
	* Inserta un estudiante en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_estudiante Rut del estudiante a insertar
	* @param string $nombre1_estudiante Primer nombre del estudiante a insertar
	* @param string $nombre2_estudiante Segundo nombre del estudiante a insertar
	* @param string $apellido_paterno Apellido paterno del estudiante a insertar
	* @param string $apellido_materno Apellido mateno del estudiante a insertar
	* @param string $correo_estudiante Correo del estudiante a insertar
	* @param string $cod_seccion Código de la sección del estudiante a insertar
	* @param string $cod_carrera Código de carrera del estudiante a insertar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function agregarEstudiante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono, $id_seccion, $cod_carrera) {
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_ESTUDIANTE,
			'PASSWORD_PRIMARIA' => md5($rut),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1,
			'NOMBRE2' => $nombre2,
			'APELLIDO1' => $apellido1,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $fono,
			'LOGUEABLE' => FALSE
		);
		$data2 = array('RUT_USUARIO' => $rut, 'COD_CARRERA' => $cod_carrera, 'ID_SECCION' => $id_seccion);

		$this->db->trans_start();
		$datos2 = $this->db->insert('usuario',$data1);

		$datos = $this->db->insert('estudiante',$data2);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	
	/**
	* Edita la información de un estudiante en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $rut_estudiante Rut del estudiante al que se le actualizan los demás datos
	* @param string $nombre1_estudiante Primer nombre a editar del estudiante
	* @param string $nombre2_estudiante Segundo nombre a editar del estudiante
	* @param string $apellido_paterno Apellido paterno del estudiante
	* @param string $apellido_materno Apellido mateno del estudiante
	* @param string $correo_estudiante Correo a editar del estudiante
	* @param string $cod_seccion Código de la sección a editar del estudiante
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function actualizarEstudiante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $carrera, $seccion) {
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_AYUDANTE,
			'PASSWORD_PRIMARIA' => md5($rut),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1,
			'NOMBRE2' => $nombre2,
			'APELLIDO1' => $apellido1,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $telefono
		);
		$data2 = array(
			'ID_SECCION' => $seccion,
			'COD_CARRERA' => $carrera
		);

		$this->db->trans_start();
		$this->db->where('ID_TIPO', TIPO_USR_ESTUDIANTE);
		$this->db->where('RUT_USUARIO', $rut);
		$datos2 = $this->db->update('usuario', $data1);

		$this->db->where('RUT_USUARIO', $rut);
		$datos2 = $this->db->update('estudiante', $data2);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	/**
	* Eliminar un estudiante de la base de datos
	*
	* Recibe el rut de un estudiante para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_estudiante Rut del estudiante que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function eliminarEstudiante($rut_estudiante) {
		$this->db->trans_start();
		$this->db->where('RUT_USUARIO', $rut_estudiante);
		$this->db->where('ID_TIPO', TIPO_USR_ESTUDIANTE);
		$datos = $this->db->delete('usuario'); 
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	/**
	* Obtiene los nombre y rut de todos los estudiantes del sistema
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada estudiante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los estudiantes del sistema
	*/
	public function getAllEstudiantes() {
		$this->db->select('estudiante.RUT_USUARIO AS id');
		$this->db->select('estudiante.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE1 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS telefono');
		$this->db->select('CORREO1_USER AS correo1');
		$this->db->select('CORREO2_USER AS correo2');
		$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->order_by('APELLIDO1', 'asc');
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function	getEstudiantesBySeccion($id_seccion){
		$this->db->select('estudiante.RUT_USUARIO AS id');
		$this->db->select('estudiante.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE1 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS telefono');
		$this->db->select('CORREO1_USER AS correo1');
		$this->db->select('CORREO2_USER AS correo2');
		$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->where('estudiante.ID_SECCION', $id_seccion);
		$this->db->order_by('APELLIDO1', 'asc');
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	* Función que obtiene los alumnos que coinciden con cierta búsqueda
	*
	* Esta función recibe un texto para realizar una búsqueda y un tipo de atributo por el cual filtrar.
	* Se realiza una consulta a la base de datos y se obtiene la lista de alumnos que coinciden con la búsqueda
	* Esta búsqueda se realiza mediante la sentencia like de SQL.
	*
	* @param int $tipoFiltro Un valor entre 1 a 6 que indica el tipo de filtro a usar.
	* @param string $texto Es el texto que se desea hacer coincidir en la búsqueda
	* @return Se devuelve un array de objetos alumnos con sólo su nombre y rut
	* @author Víctor Flores
	*/
	public function getEstudiantesByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('usuario.RUT_USUARIO AS id');
		$this->db->select('NOMBRE1 AS nombre1');
		//$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('NOMBRE_CARRERA AS carrera');
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS seccion');
		$this->db->join('usuario', 'usuario.RUT_USUARIO = estudiante.RUT_USUARIO');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->join('seccion', 'seccion.ID_SECCION = estudiante.ID_SECCION', 'LEFT OUTER');
		$this->db->order_by('APELLIDO1', 'asc');

		if ($texto != "") {
			$this->db->like('usuario.RUT_USUARIO',$texto);
			$this->db->or_like('NOMBRE1',$texto);
			$this->db->or_like('NOMBRE2',$texto);
			$this->db->or_like('APELLIDO1',$texto);
			$this->db->or_like('APELLIDO2',$texto);
			$this->db->or_like('NOMBRE_CARRERA',$texto);
			$this->db->or_like('NOMBRE_SECCION',$texto);
		} 
		else {
			
			//Sólo para acordarse
			define("BUSCAR_POR_RUT", 0);
			define("BUSCAR_POR_NOMBRE", 1);
			define("BUSCAR_POR_APELLIDO", 2);
			define("BUSCAR_POR_CARRERA", 3);
			define("BUSCAR_POR_SECCION", 4);
			
			if($textoFiltrosAvanzados[BUSCAR_POR_RUT] != ''){
				$this->db->like("usuario.RUT_USUARIO", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			}			
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
				$this->db->where("(NOMBRE1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");
				//$this->db->like("(NOMBRE1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
				//$this->db->or_like("NOMBRE2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
				$this->db->where("(APELLIDO1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
				//$this->db->like("(APELLIDO1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
				//$this->db->or_like("APELLIDO2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_CARRERA] != '') {
				$this->db->like("NOMBRE_CARRERA", $textoFiltrosAvanzados[BUSCAR_POR_CARRERA]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_SECCION] != '') {
				$this->db->where("(LETRA_SECCION LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR NUMERO_SECCION LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
			}
		}
		$query = $this->db->get('estudiante');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
   * Obtiene los detalles de un estudiante
   * 
   * Se recibe un rut y se hace la consulta para obtener todos los demás atributos del estudiante
   * con ese rut. Los atributos del objeto obtenido son:
   * rut, nombre1, nombre2, apellido1, apellido2, correo, carrera, seccion
   * 
   * @author Víctor Flores
   * @param int $rut El rut del estudiante que se busca
   * @return Se retorna un objeto cuyos atributos son los atributos del estudiante, FALSE si no se encontró
   */
	public function getDetallesEstudiante($rut) {
		$this->db->select('estudiante.RUT_USUARIO AS id');
		$this->db->select('estudiante.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS telefono');
		$this->db->select('CORREO1_USER AS correo1');
		$this->db->select('CORREO2_USER AS correo2');
		$this->db->select('estudiante.COD_CARRERA AS cod_carrera');
		$this->db->select('NOMBRE_CARRERA AS carrera');
		$this->db->select('estudiante.ID_SECCION AS id_seccion');
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS seccion');
		$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->join('seccion', 'seccion.ID_SECCION = estudiante.ID_SECCION', 'LEFT OUTER');
		$this->db->where('usuario.RUT_USUARIO', $rut);
		$query = $this->db->get('estudiante');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}







/* FUNCIONES NO LIMPIADAS AÚN*/




	/**
	* Camobia todos los estudiantes con rut en $listaRut a la seección $seccionOUT 
	*
	* @param $seccionOUT Corresponde la sección a la que se cambiara la lista de rut
	* @param $listaRut Lista de rutd correspondedientes a los estudiantes que se cambiaran de sección
	* @return $conformacion resultado de la función que es uno en el caso exitoso y -1 en el caso fallido
	*/	
	function CambioDeSecciones($seccionOUT,$listaRut){
		$contador = 0;
		$confirmacion = 1;
		while ($contador<count($listaRut)){
			$data = array(
				'ID_SECCION' => $seccionOUT
				);
			$this->db->where('RUT_ESTUDIANTE', $listaRut[$contador]);
			$datos = $this->db->update('estudiante',$data);
			if($datos != true){
				$confirmacion = -1;
			}

			$contador = $contador + 1;
		}
		return $confirmacion;
	}


	/**
	* Valida el rut para chile
	*
	* Se evalua si la cadena $rut contiene guión, de existir se elimina, luego se considera el ultimo elemento como
	* el digito vericador, se procede a a plicar el algoritmo de comprobación de rut y finalmente retorna TRUE si
	* es un rut valido y FALSE si es invalido.
	*
	* @param $rut rut de cual se quiere comprobar su validez.
	* @return bool TRUE o FALSE segun corresponda si el rut es valido o no.
	*/	

	function validaRut($rut){
		$suma = 0;
		if(strpos($rut,"-")==false){
			$RUT[0] = substr($rut, 0, -1);
			$RUT[1] = substr($rut, -1);
		}else{
			$RUT = explode("-", trim($rut));
		}
		$elRut = str_replace(".", "", trim($RUT[0]));
		$ffactor = 2;
		for($i = strlen($elRut)-1; $i >= 0; $i--):
			$ffactor = $ffactor > 7 ? 2 : $ffactor;
		$suma += $elRut{$i}*$ffactor++;
		endfor;
		$dv = 11 - ($suma % 11); 
		if($dv == 11){
			$dv=0;
		}else if($dv == 10){
			$dv="k";
		}
		if($dv == trim(strtolower($RUT[1]))){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	/**
	* Función que valida que los campos ingresados posean solo caracteres validos 
	*
	* Se evalua cual es campo a validar por medio de $tipo y se filtra el campo con la función filter_var y un 
	* filtro segun el tipo de campo-
	* 
	* @param $campo corresponde al campo que se quiere filtrar.
	* @param $tipo es el tipo de campo que se filtrara nombre, mail, carrera, rut.
	* @return retorna el valor que devuleva filter_var o en su defecto retorna FALSE
	*/	
	function validarDatos($campo,$tipo){
		switch ($tipo) {
			case "carrera":				
			return filter_var($campo, FILTER_VALIDATE_INT);     
			break;
			case "seccion":
			$reg = array("options"=>array("regexp"=>"/^[a-zA-Z0-9\-]+$/"));
			return filter_var($campo, FILTER_VALIDATE_REGEXP,$reg);
			break;
			case "nombre":
			$reg = array("options"=>array("regexp"=>"/^[a-zA-ZäáàëéèíìöóòúùñçÄÁÀËÉÈÍÌÖÓÒÚÙÑÇ \-]+$/"));			
			return filter_var(trim($campo), FILTER_VALIDATE_REGEXP,$reg);
			break;
			case "rut":
			$reg = array("options"=>array("regexp"=>"/^[k0-9\-\.]+$/"));
			return filter_var($campo, FILTER_VALIDATE_REGEXP,$reg);
			break;
			case "correo":
			return filter_var($campo, FILTER_VALIDATE_EMAIL);
			break;
		} 
		return FALSE;
	} 

	/**
	* Valida que la sección a la que pertenece el estudiante a ingresar ya exista en el sistema
	*
	* Se obtiene el el codigo de sección que corresponde al nombre entregado como parametro
	*
	* @param $seccion es el nombre de la sección que se evaluará
	* @return $sec->ID_SECCION es el codigo de la sección que corresponde al nombre ingresado en $seccion
	*/	
	function validarSeccion($seccion){
		
		$query = $this->db->select('seccion.ID_SECCION');
		$query = $this->db->from('seccion');
		$query = $this->db->where('NOMBRE_SECCION',$seccion);
		$query = $this->db->get();
		$sec = $query->row();
		if ($sec == FALSE) {
			return FALSE;
		}	

		return $sec->ID_SECCION;
	}

	/**
	* Valida que la carrera a la que pertenece el estudiante a ingresar ya exista en el sistema
	*
	* Se retorna el valor de $carrera o FALSE en caso de que la carrera consulta no esista en el sistema
	*
	* @param $carrera es el codigo de la carrera que se evaluará
	* @return $carrerra es el codigo de la carrera, se retorna FALSE en caso de que la carrera no exista
	*/	

	function validarCarrera($carrera){

		$query = $this->db->select('COD_CARRERA');
		$query = $this->db->from('carrera');
		$query = $this->db->where('COD_CARRERA',$carrera);
		$query = $this->db->get();
		$car = $query->row();
		if ($car == FALSE) {
			return FALSE;
		} 
		return $carrera;
	}


	/**
	* Carga de forma masiva los datos de estudiantes en el sistema
	*
	* Se evalua si existe el archivo en la ruta indicada en $archvivo y se procede a la lectura de este 
	* se evalua campo a campo la información obtenoda del archivo csv y se recopila información de la filas erroneas
	* si los datos no contienen un error se inserta en la base de datos y se procede con la linea siguiente
	* se cierra el descriptor de lectura y se elimina el archivo del servidor
	* de encontrarse algun error critico se termina el ciclo de lectura y se retorna FALSE
	* si la función termina exitosamente se entregan las filas con errores en $stack
	*
	* @param $archivo ruta del archivo con la información de los estudiantes que se desea ingresarf a manteka
	* @return $stack lineas del archivo csv que contienen errores retorna FALSE en caso de error critico
	*/
	public function cargaMasiva($archivo){

		if(!file_exists($archivo) || !is_readable($archivo))
			return FALSE;

		$ff = fopen($archivo, "r");

		$header = array();
		$data = array();		
		$splitArray = array();
		$stack  = array();
		$c = 1;
		$flag = FALSE;
		while(($linea = fgets($ff)) !== FALSE)
		{

			if(!$header){
				$header = explode(';',trim($linea));
				if((strcmp($header[0], 'RUT_ESTUDIANTE') != 0)||(count($header)!=8)){
					fclose($ff);
					unlink($archivo);
					return FALSE;
				}				
			}
			else
			{
				$linea =  explode(';',$linea);
				if(($data = array_combine($header, $linea)) == FALSE) {
					$linea[] = "</br>El numero de argumentos en la linea es incorrecto</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$validador = $this->validarDatos($data['RUT_ESTUDIANTE'],"rut");
				if(!$validador){
					$linea[] = "</br>El rut del estudiante tiene caracteres no válidos</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				try{
					if(($this->validaRut($data['RUT_ESTUDIANTE'])) == FALSE){
						$linea[] = "</br>El rut del estudiante no es valido</br>";
					$stack[$c] = $linea;
						fclose($ff);
						unlink($archivo);
						return $stack;
					}
				}catch(Exception $e){
					$linea[] = "</br>El rut del estudiante no es valido</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$data['RUT_ESTUDIANTE'] =  preg_replace('[\-]','',$data['RUT_ESTUDIANTE']);
				$data['RUT_ESTUDIANTE'] =  preg_replace('[\.]','',$data['RUT_ESTUDIANTE']);
				$data['RUT_ESTUDIANTE'] = substr($data['RUT_ESTUDIANTE'], 0, -1);				
				$validador = $this->rutExisteM($data['RUT_ESTUDIANTE']);
				if($validador == -1){
					$linea[] = "</br>El rut de estudiante ya existe en manteka</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;		
				}				
				$validador = $this->validarDatos($data['COD_CARRERA'],"carrera");
				if(!$validador){
					$linea[] = "</br>La carrera del estudiante es erronea, solo se admiten numeros.</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$validador = $this->validarDatos($data['ID_SECCION'],"seccion");
				if(!$validador){
					$linea[] = "</br>EL nombre de la seccion no existe en manteka</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$data['CORREO_ESTUDIANTE'] = trim($data['CORREO_ESTUDIANTE']);				
				$validador = $this->validarDatos($data['CORREO_ESTUDIANTE'],"correo");
				if(!$validador){
					$linea[] = "</br>El correo del estudiante no tiene un formato válido</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$validador = $this->validarDatos($data['NOMBRE1_ESTUDIANTE'].$data['NOMBRE2_ESTUDIANTE'].$data['APELLIDO1_ESTUDIANTE'].$data['APELLIDO2_ESTUDIANTE'],"nombre");
				if(!$validador){
					$linea[] = "</br>El nombre del estudiante tiene caracteres no válidos</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				if(($data['ID_SECCION'] = $this->validarSeccion($data['ID_SECCION'])) == FALSE){
					$linea[] = "</br>La sección no se encuentra en la base de datos</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				if(($data['COD_CARRERA'] = $this->validarCarrera($data['COD_CARRERA'])) == FALSE){
					$linea[] = "</br>La carrera no se encuentra en la base de datos</br>";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}				
				$flag = TRUE;

			}
			$c++;						
		}	
		fclose($ff);
		$ffa = fopen($archivo, "r");	
		if ($flag) {			
			while(($linea = fgets($ffa)) !== FALSE)
			{
				if(!$header){
					$header = explode(';',trim($linea));
				}
				else
				{
					$linea =  explode(';',$linea);
					$data = array_combine($header, $linea);				
					$data['ID_SECCION'] = $this->validarSeccion($data['ID_SECCION']);
					$data['RUT_ESTUDIANTE'] =  preg_replace('[\-]','',$data['RUT_ESTUDIANTE']);
					$data['RUT_ESTUDIANTE'] =  preg_replace('[\.]','',$data['RUT_ESTUDIANTE']);
					$data['RUT_ESTUDIANTE'] = substr($data['RUT_ESTUDIANTE'], 0, -1);	

					$this->db->insert('estudiante',$data);

				}

			}
		}else{
			fclose($ffa);
			unlink($archivo);
			return FALSE;
		}
		fclose($ffa);
		unlink($archivo);
		return $stack;		
	}

}

?>
