<?php

/**
* Clase utilizada para hacer consultas a la base de datos acerca de los estudiantes
* @author Grupo 4
*/
class Model_estudiante extends CI_Model {
	public $rut_estudiante = 0;
	var $nombre1_estudiante = '';
	var $nombre2_estudiante  = '';
	var $apellido_paterno='';
	var $apellido_materno='';
	var $correo_estudiante='';
	var $cod_seccion='';
	var $cod_carrera='';

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
	public function InsertarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$cod_seccion,$cod_carrera) 
	{
		$data = array(					
			'RUT_ESTUDIANTE' => $rut_estudiante ,
			'NOMBRE1_ESTUDIANTE' => $nombre1_estudiante ,
			'NOMBRE2_ESTUDIANTE' => $nombre2_estudiante ,
			'APELLIDO1_ESTUDIANTE' => $apellido_paterno ,
			'APELLIDO2_ESTUDIANTE' => $apellido_materno ,
			'CORREO_ESTUDIANTE' => $correo_estudiante ,
			'COD_SECCION' =>  $cod_seccion ,
			'COD_CARRERA' => $cod_carrera 
			);
		$datos = $this->db->insert('estudiante',$data);
		if($datos == true){
			return 1;
		}
		else{
			return -1;
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
	public function ActualizarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$seccion)
	{
		$data = array(					
			'NOMBRE1_ESTUDIANTE' => $nombre1_estudiante ,
			'NOMBRE2_ESTUDIANTE' => $nombre2_estudiante ,
			'APELLIDO1_ESTUDIANTE' => $apellido_paterno ,
			'APELLIDO2_ESTUDIANTE' => $apellido_materno ,
			'CORREO_ESTUDIANTE' => $correo_estudiante,
			'COD_SECCION'=>$seccion
			);
		$this->db->where('RUT_ESTUDIANTE', $rut_estudiante);
		$datos = $this->db->update('estudiante',$data);
        //echo $this->db->last_query();
		if($datos == true){
			return 1;
		}
		else{
			return -1;
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
	public function EliminarEstudiante($rut_estudiante)
	{
		$this->db->where('rut_estudiante', $rut_estudiante);
		$datos = $this->db->delete('estudiante'); 
		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
	}

	/**
	* Obtiene los datos de todos lo estudiantes de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada estudiante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los estudiantes del sistema
	*/
	public function VerTodosLosEstudiantes()
	{
		/*
		$this->db->order_by("APELLIDO_PATERNO", "asc"); 
		$query = $this->db->get('estudiante'); //Acá va el nombre de la tabla
		// Se obtiene la fila del resultado de la consulta a la base de datos
		$filaResultado = $query->row();
		return $filaResultado;
		*/
		$sql="SELECT * FROM estudiante ORDER BY APELLIDO1_ESTUDIANTE"; 
		$datos=mysql_query($sql); 
		echo mysql_error();
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_ESTUDIANTE'];
			$lista[$contador][1] = $row['NOMBRE1_ESTUDIANTE'];
			$lista[$contador][2] = $row['NOMBRE2_ESTUDIANTE'];
			$lista[$contador][3] = $row['APELLIDO1_ESTUDIANTE'];
			$lista[$contador][4] = $row['APELLIDO2_ESTUDIANTE'];
			$lista[$contador][5] = $row['CORREO_ESTUDIANTE'];
			$lista[$contador][6] = $row['COD_SECCION'];
			$lista[$contador][7] = $row['COD_CARRERA'];

			$contador = $contador + 1;
		}
		return $lista;
		
	}
	

	public function	getEstudiantesSeccion($cod_seccion){
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->where('COD_SECCION', $cod_seccion);
		$this->db->order_by("APELLIDO1_ESTUDIANTE", "asc");
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();

	}
	
	/**
	* Obtiene los nombre y rut de todos los estudiantes del sistema
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada estudiante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los estudiantes del sistema
	*/
	public function getAllAlumnos()
	{
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE as correo');
		$this->db->order_by("APELLIDO1_ESTUDIANTE", "asc");
		$query = $this->db->get('estudiante');
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
	public function getAlumnosByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('RUT_ESTUDIANTE AS id');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		//$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('NOMBRE_CARRERA AS carrera');
		$this->db->select('NOMBRE_SECCION AS seccion');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->join('seccion', 'seccion.COD_SECCION = estudiante.COD_SECCION');
		$this->db->order_by('APELLIDO1_ESTUDIANTE', 'asc');

		if ($texto != "") {
			$this->db->like('RUT_ESTUDIANTE',$texto);
			$this->db->or_like('NOMBRE1_ESTUDIANTE',$texto);
			$this->db->or_like('NOMBRE2_ESTUDIANTE',$texto);
			$this->db->or_like('APELLIDO1_ESTUDIANTE',$texto);
			$this->db->or_like('APELLIDO2_ESTUDIANTE',$texto);
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
				$this->db->like("RUT_ESTUDIANTE", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			}			
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
				$this->db->where("(NOMBRE1_ESTUDIANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2_ESTUDIANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");
				//$this->db->like("(NOMBRE1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
				//$this->db->or_like("NOMBRE2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
				$this->db->where("(APELLIDO1_ESTUDIANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2_ESTUDIANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
				//$this->db->like("(APELLIDO1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
				//$this->db->or_like("APELLIDO2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_CARRERA] != '') {
				$this->db->like("NOMBRE_CARRERA", $textoFiltrosAvanzados[BUSCAR_POR_CARRERA]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_SECCION] != '') {
				$this->db->like("NOMBRE_SECCION", $textoFiltrosAvanzados[BUSCAR_POR_SECCION]);
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
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE AS correo');
		$this->db->select('NOMBRE_CARRERA AS carrera');
		$this->db->select('estudiante.COD_SECCION AS seccion');
		$this->db->select('NOMBRE_SECCION AS nombre_seccion');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->join('seccion', 'seccion.COD_SECCION = estudiante.COD_SECCION', 'LEFT OUTER');
		$this->db->where('RUT_ESTUDIANTE', $rut);
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		//echo $this->db->last_query();
		return $query->row();
	}


	public function getSecciones() {
		$this->db->select('COD_SECCION AS cod');
		$this->db->select('NOMBRE_SECCION AS nombre');
		$query = $this->db->get('seccion');
		return $query->result();
	}

	
	/**
	* Obtiene los datos de todas las carreras de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada carrera y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todas las carreras del sistema
	*/
	public function VerCarreras()
	{
		/*
		$query = $this->db->get('carrera'); //Acá va el nombre de la tabla
		// Se obtiene la fila del resultado de la consulta a la base de datos
		$filaResultado = $query->row();
		return $filaResultado;
		*/

		$sql="SELECT * FROM carrera"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_CARRERA'];
			$lista[$contador][1] = $row['NOMBRE_CARRERA'];
			
			$contador = $contador + 1;
		}
		
		return $lista;
	}

	/**
	* Obtiene los datos de todas las secciones de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo el código de cada sección y se va guardando en un arreglo
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todas las secciones del sistema
	*/	
	public function VerSecciones(){
		$query = $this->db->get('seccion');	
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_SECCION;
			$lista[$contador][1] = $row->NOMBRE_SECCION;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	function CambioDeSecciones($seccionOUT,$listaRut){
		$contador = 0;
		$confirmacion = 1;
		while ($contador<count($listaRut)){
			$data = array(
				'COD_SECCION' => $seccionOUT
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
	
	public function getAllRut(){
		$lista = array();
		$contador = 0;
		
		//lista usuarios
		$this->db->select('RUT_USUARIO');
		$this->db->from('usuario');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_USUARIO;
			$contador++;
		}
		//lista ayudantes
		$this->db->select('RUT_AYUDANTE');
		$this->db->from('ayudante');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_AYUDANTE;
			$contador++;
		}
		//lista alumnos
		$this->db->select('RUT_ESTUDIANTE');
		$this->db->from('estudiante');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_ESTUDIANTE;
			$contador++;
		}
		return $lista;  	
	}
	
	public function rutExisteM($rut){
	//return $rut;
		$lista = array();
		$contador = 0;
		
		//lista usuarios
		$this->db->select('RUT_USUARIO');
		$this->db->from('usuario');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_USUARIO;
			$contador++;
		}
		//lista ayudantes
		$this->db->select('RUT_AYUDANTE');
		$this->db->from('ayudante');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_AYUDANTE;
			$contador++;
		}
		//lista alumnos
		$this->db->select('RUT_ESTUDIANTE');
		$this->db->from('estudiante');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->RUT_ESTUDIANTE;
			$contador++;
		}
		$contador = 0;
		while($contador < count($lista)){
			if(strtolower($lista[$contador]) == strtolower($rut)){
				return -1;
			}
			$contador = $contador + 1;
		}
		return 1;
	}

	function validaRut($rut){
		$suma = 0;
		if(strpos($rut,"-")==false){
			$RUT[0] = substr($rut, 0, -1);
			$RUT[1] = substr($rut, -1);
		}else{
			$RUT = explode("-", trim($rut));
		}
		$elRut = str_replace(".", "", trim($RUT[0]));
		$factor = 2;
		for($i = strlen($elRut)-1; $i >= 0; $i--):
			$factor = $factor > 7 ? 2 : $factor;
		$suma += $elRut{$i}*$factor++;
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
			$reg = array("options"=>array("regexp"=>"/^[a-zA-Z\-]+$/"));
			return filter_var($campo, FILTER_VALIDATE_REGEXP,$reg);
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

	function validarSeccion($seccion){
		
		$query = $this->db->select('seccion.COD_SECCION');
		$query = $this->db->from('seccion');
		$query = $this->db->where('NOMBRE_SECCION',$seccion);
		$query = $this->db->get();
		$sec = $query->row();
		if ($sec == FALSE) {
			return FALSE;
		}	

		return $sec->COD_SECCION;
	}


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

	public function cargaMasiva($archivo){

		if(!file_exists($archivo) || !is_readable($archivo))
			return FALSE;

		$f = fopen($archivo, "r");

		$header = NULL;
		$data = array();		
		$splitArray = array();

		$stack  = array();
		$c = 1;
		while(($linea = fgetcsv($f, 201, ',','"','\\')) !== FALSE)
		{			

			if(!$header){
				$header = $linea; 
				if(strcmp($header[0], 'RUT_ESTUDIANTE') != 0){
					fclose($f);
					unlink($archivo);
					return FALSE;
				} 
				$c++;
			}
			else{

				if(($data = array_combine($header, $linea)) == FALSE) {
					fclose($f);
					unlink($archivo);
					return FALSE;					
				}

				try{					
					if(($this->validaRut($data['RUT_ESTUDIANTE'])) == FALSE){
						$stack[$c] = $linea;
						$c++;
						continue;
					}
				}catch(Exception $e){
					$stack[$c] = $linea;
					$c++;
					continue;
				}

				$validador = $this->validarDatos($data['RUT_ESTUDIANTE'],"rut");				
				if(!$validador){
					$stack[$c] = $linea;
					$c++;
					continue;}
					$validador = $this->validarDatos($data['COD_CARRERA'],"carrera");
					if(!$validador){
						$stack[$c] = $linea;
						$c++;
						continue;}				
						$validador = $this->validarDatos($data['COD_SECCION'],"seccion");
						if(!$validador){
							$stack[$c] = $linea;
							$c++;
							continue;}
							$data['CORREO_ESTUDIANTE'] = trim($data['CORREO_ESTUDIANTE']);
							$validador = $this->validarDatos($data['CORREO_ESTUDIANTE'],"correo");
							if(!$validador){
								$stack[$c] = $linea;
								$c++;
								continue;}
								$validador = $this->validarDatos($data['NOMBRE1_ESTUDIANTE'].$data['NOMBRE2_ESTUDIANTE'].$data['APELLIDO1_ESTUDIANTE'].$data['APELLIDO2_ESTUDIANTE'],"nombre");
								if(!$validador){
									$stack[$c] = $linea;
									$c++;
									continue;}

									if(($data['COD_SECCION'] = $this->validarSeccion($data['COD_SECCION'])) == FALSE){
										$stack[$c] = $linea;
										$c++;
										continue;
									}
									if(($data['COD_CARRERA'] = $this->validarCarrera($data['COD_CARRERA'])) == FALSE){
										$stack[$c] = $linea;
										$c++;
										continue;
									}

									$data['RUT_ESTUDIANTE'] =  preg_replace('[\-]','',$data['RUT_ESTUDIANTE']);
									$data['RUT_ESTUDIANTE'] =  preg_replace('[\.]','',$data['RUT_ESTUDIANTE']);
									$data['RUT_ESTUDIANTE'] = substr($data['RUT_ESTUDIANTE'], 0, -1);



									if($this->rutExisteM($data['RUT_ESTUDIANTE']) != -1){                	
										$this->db->insert('estudiante',$data);
									} else{
										$stack[$c] = $linea;
										$c++;
										continue;
									}	

								}            
							}

							fclose($f);
							unlink($archivo);
							return $stack;
						}

					}

					?>
