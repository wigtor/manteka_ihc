<?php
class Model_secciones extends CI_Model{
	public $cod_seccion = 0;


	
		/**
	* Obtiene los datos de todos lo estudiantes de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada estudiante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los estudiantes del sistema
	*/
	public function VerTodosLosEstudiantes($cod_seccion)
	{
		
		$sql="SELECT * FROM ESTUDIANTE WHERE COD_SECCION= '$cod_seccion' ORDER BY APELLIDO_PATERNO"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
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
	* Obtiene los datos de todos las secciones de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada seccion y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todas las secciones del sistema
	*/
	public function VerTodasSecciones()
	{
		
		$sql="SELECT * FROM SECCION ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_SECCION'];
			$contador = $contador + 1;
		}
		return $lista;
	}
	
				/**
	* Obtiene los datos de una seccion de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de la seccion y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de una seccion del sistema
	*/
	public function VerSeccion($cod_seccion)
	{
	//sala horario, horario, dia
		$sql="SELECT * FROM SALA_HORARIO WHERE COD_SECCION='$cod_seccion' ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
		
		$lista[$contador][0] = $cod_seccion;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			
			$hora=$row['COD_HORARIO'];
			$sql1="SELECT * FROM HORARIO WHERE COD_HORARIO='$hora' ORDER BY COD_HORARIO"; 
			$datos1=mysql_query($sql1); 
			while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
				
				$dia=$row1['COD_DIA'];
				$sql2="SELECT * FROM DIA WHERE COD_DIA='$dia' ORDER BY COD_DIA"; 
				$datos2=mysql_query($sql2); 
				while ($row2=mysql_fetch_array($datos2)) { 
					$lista[$contador][1] = $row1['NOMBRE_HORARIO'];
					$lista[$contador][2] = $row2['NOMBRE_DIA'];
				}
			}
			$contador = $contador + 1;
		}
		if($contador==0){
			$lista[$contador][1] = '';
			$lista[$contador][2] = '';
			
		}
		
		return $lista;
	}

		/**
	* Eliminar seccion de la base de datos
	*
	* Recibe el codigo de la seccion para que se elimine ésta y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la eliminacion correctamente o no.
	*
	* @param string $cod_sala codigo de la seccion que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function EliminarSeccion($cod_seccion)
    {
		if($cod_seccion==""){ return 2;}
		else{
		$sql1="SELECT * FROM ESTUDIANTE WHERE COD_SECCION= '$cod_seccion' ORDER BY APELLIDO_PATERNO"; 
		$datos1=mysql_query($sql1); 
		$contador = 0;
		while ($row=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
			$contador = $contador + 1;
		}
		if($contador==0){
			$sql="DELETE FROM seccion WHERE COD_SECCION = '$cod_seccion' "; //código MySQL
			$datos=mysql_query($sql); //enviar código MySQL
		}
		else{return 3;}
		


		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
		}
    }

 
}
?>