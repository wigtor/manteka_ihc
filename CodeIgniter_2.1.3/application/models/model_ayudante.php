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
					'APELLIDO_PATERNO' => $apellido1_ayudante ,
					'APELLIDO_MATERNO' => $apellido2_ayudante,
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
		$sql="DELETE FROM AYUDANTE WHERE RUT_AYUDANTE = '$rut_ayudante' "; //código MySQL
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
		$sql="SELECT * FROM AYUDANTE ORDER BY APELLIDO_PATERNO"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_AYUDANTE'];
			$lista[$contador][1] = $row['NOMBRE1_AYUDANTE'];
			$lista[$contador][2] = $row['NOMBRE2_AYUDANTE'];
			$lista[$contador][3] = $row['APELLIDO_PATERNO'];
			$lista[$contador][4] = $row['APELLIDO_MATERNO'];
			$lista[$contador][5] = $row['CORREO_AYUDANTE'];
			$contador = $contador + 1;
		}
		
		return $lista;
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
		$sql="SELECT * FROM PROFESOR ORDER BY NOMBRE1_PROFESOR"; //código MySQL
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
		$sql="SELECT COD_SECCION FROM SECCION"; //código MySQL
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
					'APELLIDO_PATERNO' => $apellido_paterno ,
					'APELLIDO_MATERNO' => $apellido_materno ,
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
}

?>
