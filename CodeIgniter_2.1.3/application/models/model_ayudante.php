<?php
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
	* Recibe un texto para filtrar y un número que indica el tipo de filtro,
	* Devuelve un arreglo con los ayudantes que cumplen con el filtro de búsqueda
	* @param int $tipoFiltro valor entre 1 y 4 que indica el tipo de filtro usado.
	* @param string $texto palabras introducidas por el usuario para buscar
	*/
    public function getAyudantesByFilter($tipoFiltro, $texto)
   	{

      //Sólo para acordarse
      define("BUSCAR_POR_NOMBRE", 1);
      define("BUSCAR_POR_APELLIDO1", 2);
      define("BUSCAR_POR_APELLIDO2", 3);
      define("BUSCAR_POR_CORREO", 4);

      $attr_filtro = "";
      if ($tipoFiltro == BUSCAR_POR_NOMBRE) {
         $attr_filtro = "NOMBRE1_AYUDANTE";
      }
      else if ($tipoFiltro == BUSCAR_POR_APELLIDO1) {
         $attr_filtro = "APELLIDO1_AYUDANTE";
      }
      else if ($tipoFiltro == BUSCAR_POR_APELLIDO2) {
         $attr_filtro = "APELLIDO2_AYUDANTE";
      }
      else if ($tipoFiltro == BUSCAR_POR_CORREO) {
         $attr_filtro = "CORREO_AYUDANTE";
      }
      else {
         return array(); //No es válido, devuelvo vacio
      }

      $this->db->select('RUT_AYUDANTE AS rut');
      $this->db->select('NOMBRE1_AYUDANTE AS nombre1');
      $this->db->select('NOMBRE2_AYUDANTE AS nombre2');
      $this->db->select('APELLIDO1_AYUDANTE AS apellido1');
      $this->db->select('APELLIDO2_AYUDANTE AS apellido2');
      $this->db->order_by('APELLIDO1_AYUDANTE', 'asc');
      $this->db->like($attr_filtro, $texto);
      if ($tipoFiltro == BUSCAR_POR_NOMBRE) {
         $this->db->or_like("NOMBRE2_AYUDANTE", $texto);
      }
      $query = $this->db->get('ayudante');
      if ($query == FALSE) {
         return array();
      }
      return $query->result();
   }

   /**
   * Recibe el rut del ayudante y devuelve toda su información.
   * @param int $rut El rut del ayudante que se está buscando
   * @return Un objeto con los datos del ayudante, FALSE si no se encontró
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
