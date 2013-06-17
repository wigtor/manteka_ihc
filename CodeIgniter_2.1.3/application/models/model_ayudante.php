<?php

/**
* Clase que realiza las consultas a la base de datos relacionadas con los ayudantes
* @author Grupo 4
*/
class Model_ayudante extends CI_Model {
   public $rut_ayudante = 0;
    var $nombre1_ayudante = '';
    var $nombre2_ayudante = '';
    var $apellido1_ayudante='';
    var $apellido2_ayudante='';    
    var $correo_ayudante='';

	/**
	* Inserta un ayudante en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante a insertar
	* @param string $nombre1_ayudante Primer nombre del ayudante a insertar
	* @param string $nombre2_ayudante Segundo nombre del ayudante a insertar
	* @param string $apellido1_ayudante Primer apellido del ayudante a insertar
	* @param string $apellido2_ayudante Segundo apellido del ayudante a insertar
	* @param string $correo_ayudante Correo del ayudante a insertar
	* @param string $cod_profesor Código del profesor asociado al ayudante
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/	
	public function InsertarAyudante( $rut_ayudante, $nombre1_ayudante, $nombre2_ayudante, $apellido1_ayudante, $apellido2_ayudante, $correo_ayudante, $cod_profesor) {
		$data1 = array(					
					'RUT_AYUDANTE' => $rut_ayudante ,
					'NOMBRE1_AYUDANTE' => $nombre1_ayudante ,
					'NOMBRE2_AYUDANTE' => $nombre2_ayudante ,
					'APELLIDO1_AYUDANTE' => $apellido1_ayudante ,
					'APELLIDO2_AYUDANTE' => $apellido2_ayudante,
					'CORREO_AYUDANTE' => $correo_ayudante 
		);
        $datos1 = $this->db->insert('ayudante',$data1);
		
		$data2 = array(					
					'RUT_USUARIO2' => $cod_profesor,
					'RUT_AYUDANTE' => $rut_ayudante 
		);
        $datos2 = $this->db->insert('ayu_profe',$data2);
		
		
		if($datos1 && $datos2){
			return 1;
		}
		else{
			return -1;
		}
		
    }

	/**
	* Eliminar un ayudante de la base de datos
	*
	* Recibe el rut de un ayudante para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function EliminarAyudante($rut_ayudante)
    {
		$sql="DELETE FROM ayudante WHERE RUT_AYUDANTE = '$rut_ayudante' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }
    


	/**
	* Obtiene los datos de todos los ayudantes de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada ayudante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los ayudantes del sistema
	*/
	public function VerTodosLosAyudantes()
	{
		$sql="SELECT * FROM ayudante ORDER BY APELLIDO1_AYUDANTE"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		echo mysql_error();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_AYUDANTE'];
			$lista[$contador][1] = $row['NOMBRE1_AYUDANTE'];
			$lista[$contador][2] = $row['NOMBRE2_AYUDANTE'];
			$lista[$contador][3] = $row['APELLIDO1_AYUDANTE'];
			$lista[$contador][4] = $row['APELLIDO2_AYUDANTE'];
			$lista[$contador][5] = $row['CORREO_AYUDANTE'];
			$contador = $contador + 1;
		}
		
		return $lista;
		}

		public function getAllAyudantes()
	{
		$this->db->select('RUT_AYUDANTE AS rut');
		$this->db->select('NOMBRE1_AYUDANTE AS nombre1');
		$this->db->select('NOMBRE2_AYUDANTE AS nombre2');
		$this->db->select('APELLIDO1_AYUDANTE AS apellido1');
		$this->db->select('APELLIDO2_AYUDANTE AS apellido2');
		$this->db->select('CORREO_AYUDANTE as correo');
		$this->db->order_by("NOMBRE1_AYUDANTE", "asc");
		$query = $this->db->get('ayudante');
		if ($query == FALSE) {
			$query = array();
			return $query;
		}
		return $query->result();
	}
		
	/**
	* Obtiene los datos de todos los profesores de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada profesor y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los profesores del sistema
	*/
		public function VerTodosLosProfesores()
	{
		$sql="SELECT * FROM profesor ORDER BY NOMBRE1_PROFESOR"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_USUARIO2'];
			$lista[$contador][1] = $row['NOMBRE1_PROFESOR'];
			$lista[$contador][2] = $row['APELLIDO1_PROFESOR'];
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
	public function VerSecciones()
	{
		$sql="SELECT COD_SECCION FROM seccion"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador] = $row['COD_SECCION'];
			$contador = $contador + 1;
		}
		
	return $lista;
	}



	
	/**
	* Edita la información de un ayudante en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante al que se le actualizan los demás datos
	* @param string $nombre1_ayudante Primer nombre a editar del ayudante
	* @param string $nombre2_ayudante Segundo nombre a editar del ayudante
	* @param string $apellido_paterno Apellido paterno del ayudante
	* @param string $apellido_materno Apellido mateno del ayudante
	* @param string $correo_ayudante Correo a editar del ayudante
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function ActualizarAyudante($rut_ayudante,$nombre1_ayudante,$nombre2_ayudante,$apellido_paterno,$apellido_materno,$correo_ayudante)
	{
		$data = array(					
					'NOMBRE1_AYUDANTE' => $nombre1_ayudante ,
					'NOMBRE2_AYUDANTE' => $nombre2_ayudante ,
					'APELLIDO1_AYUDANTE' => $apellido_paterno ,
					'APELLIDO2_AYUDANTE' => $apellido_materno ,
					'CORREO_AYUDANTE' => $correo_ayudante
		);
		$this->db->where('RUT_AYUDANTE', $rut_ayudante);
        $datos = $this->db->update('ayudante',$data);
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}		
    }


	/**
	* Función que obtiene los ayudantes que coinciden con cierta búsqueda
	*
	* Esta función recibe un texto para realizar una búsqueda y un tipo de atributo por el cual filtrar.
	* Se realiza una consulta a la base de datos y se obtiene la lista de ayudantes que coinciden con la búsqueda
	* Esta búsqueda se realiza mediante la sentencia like de SQL.
	*
	* @param int $tipoFiltro Un valor entre 1 a 4 que indica el tipo de filtro a usar.
	* @param string $texto Es el texto que se desea hacer coincidir en la búsqueda
	* @return Se devuelve un array de objetos ayudante con sólo su nombre y rut
	* @author Alex Ahumada
	*/
    public function getAyudantesByFilter($texto, $textoFiltrosAvanzados)
   	{
		$this->db->select('RUT_AYUDANTE AS rut');
		$this->db->select('NOMBRE1_AYUDANTE AS nombre1');
		$this->db->select('APELLIDO1_AYUDANTE AS apellido1');
		$this->db->order_by('APELLIDO1_AYUDANTE', 'asc');

		if ($texto != "") {
			$this->db->like("RUT_AYUDANTE", $texto);
			$this->db->or_like("NOMBRE1_AYUDANTE", $texto);
			$this->db->or_like("NOMBRE2_AYUDANTE", $texto);
			$this->db->or_like("APELLIDO1_AYUDANTE", $texto);
			$this->db->or_like("APELLIDO2_AYUDANTE", $texto);
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_RUT", 0);
			define("BUSCAR_POR_NOMBRE", 1);
			define("BUSCAR_POR_APELLIDO", 2);
			$this->db->like("RUT_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
				$this->db->where("(NOMBRE1_AYUDANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2_AYUDANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");
				//$this->db->like("(NOMBRE1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
				//$this->db->or_like("NOMBRE2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
				$this->db->where("(APELLIDO1_AYUDANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2_AYUDANTE LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
				//$this->db->like("(APELLIDO1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
				//$this->db->or_like("APELLIDO2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
			}
		}
		$query = $this->db->get('ayudante');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
   }

   /**
   * Obtiene los detalles de un ayudante
   * 
   * Se recibe un rut y se hace la consulta para obtener todos los demás atributos del ayudante
   * con ese rut. Los atributos del objeto obtenido son:
   * rut, nombre1, nombre2, apellido1, apellido2, fono, correo, nombre1_profe, nombre2_profe, apellido1_profe, apellido2_profe
   * 
   * @author Alex Ahumada
   * @param int $rut El rut del ayudante que se busca
   * @return Se retorna un objeto cuyos atributos son los atributos del ayudante, FALSE si no se encontró
   */
   public function getDetallesAyudante($rut) {
      $this->db->select('ayudante.RUT_AYUDANTE AS rut');
      $this->db->select('NOMBRE1_AYUDANTE AS nombre1');
      $this->db->select('NOMBRE2_AYUDANTE AS nombre2');
      $this->db->select('APELLIDO1_AYUDANTE AS apellido1');
      $this->db->select('APELLIDO2_AYUDANTE AS apellido2');
      $this->db->select('CORREO_AYUDANTE AS correo');
      $this->db->select('NOMBRE1_PROFESOR AS nombre1_profe');
      $this->db->select('NOMBRE2_PROFESOR AS nombre2_profe');
      $this->db->select('APELLIDO1_PROFESOR AS apellido1_profe');
      $this->db->select('APELLIDO2_PROFESOR AS apellido2_profe');
      $this->db->join('ayu_profe', 'ayudante.RUT_AYUDANTE = ayu_profe.RUT_AYUDANTE', 'LEFT OUTER');
      $this->db->join('profesor', 'profesor.RUT_USUARIO2 = ayu_profe.RUT_USUARIO2', 'LEFT OUTER');
      $this->db->where('ayudante.RUT_AYUDANTE', $rut);
      $query = $this->db->get('ayudante');
      if ($query == FALSE) {
         return array();
      }
      return $query->row();
   }
}

?>
