<?php
 
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
					'APELLIDO_PATERNO' => $apellido_paterno ,
					'APELLIDO_MATERNO' => $apellido_materno ,
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
					'APELLIDO_PATERNO' => $apellido_paterno ,
					'APELLIDO_MATERNO' => $apellido_materno ,
					'CORREO_ESTUDIANTE' => $correo_estudiante,
					'COD_SECCION'=>$seccion
		);
		$this->db->where('RUT_ESTUDIANTE', $rut_estudiante);
        $datos = $this->db->update('estudiante',$data);
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
		$sql="DELETE FROM estudiante WHERE rut_estudiante = '$rut_estudiante' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
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
		$sql="SELECT * FROM estudiante ORDER BY APELLIDO_PATERNO"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_ESTUDIANTE'];
			$lista[$contador][1] = $row['NOMBRE1_ESTUDIANTE'];
			$lista[$contador][2] = $row['NOMBRE2_ESTUDIANTE'];
			$lista[$contador][3] = $row['APELLIDO_PATERNO'];
			$lista[$contador][4] = $row['APELLIDO_MATERNO'];
			$lista[$contador][5] = $row['CORREO_ESTUDIANTE'];
			$lista[$contador][6] = $row['COD_SECCION'];
			$lista[$contador][7] = $row['COD_CARRERA'];

			$contador = $contador + 1;
		}
		return $lista;
		
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
	public function VerSecciones()
	{
		$sql="SELECT COD_SECCION FROM seccion"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador] = $row['COD_SECCION'];
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
	
}
 
?>
