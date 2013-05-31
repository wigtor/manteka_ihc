<?php
class Model_secciones extends CI_Model{
	public $cod_seccion = 0;
	var $nombre_seccion= '';

	
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
		$lista=array();
		if($cod_seccion!=''){
		$sql="SELECT * FROM estudiante WHERE COD_SECCION= '$cod_seccion' ORDER BY APELLIDO2_ESTUDIANTE"; 
		$datos=mysql_query($sql); 
		$contador = 0;	
		if (false != $datos) {
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
		}}
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
		
		$sql="SELECT * FROM seccion ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_SECCION'];
			$lista[$contador][1] = $row['NOMBRE_SECCION'];
			$contador = $contador + 1;
		}}
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
	
		$lista=array();	
		$sql3="SELECT * FROM seccion WHERE COD_SECCION='$cod_seccion' ORDER BY COD_SECCION"; 
		$datos3=mysql_query($sql3); 
		$contador3 = 0;
		while ($row3=mysql_fetch_array($datos3)) { 
			$lista[0][0] = $row3['NOMBRE_SECCION'];
			$contador3 = $contador3 + 1;
		}
		$sql="SELECT * FROM sala_horario WHERE COD_SECCION='$cod_seccion' ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;	
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			
			$hora=$row['COD_HORARIO'];
			$sql1="SELECT * FROM horario WHERE COD_HORARIO='$hora' ORDER BY COD_HORARIO"; 
			$datos1=mysql_query($sql1); 
			while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
				
				$dia=$row1['COD_DIA'];
				$sql2="SELECT * FROM dia WHERE COD_DIA='$dia' ORDER BY COD_DIA"; 
				$datos2=mysql_query($sql2); 
				while ($row2=mysql_fetch_array($datos2)) { 
					$lista[$contador][1] = $row1['NOMBRE_HORARIO'];
					$lista[$contador][2] = $row2['NOMBRE_DIA'];
				}
			}
			$contador = $contador + 1;
		}
		}
		if($contador==0 && $cod_seccion!=''){
			$lista[$contador][1] = '';
			$lista[$contador][2] = '';
		}
		if($cod_seccion==''){
			$lista[$contador][0] = '';
			$lista[$contador][1] = '';
			$lista[$contador][2] = '';
			
		}
		$lista[$contador][3] = $cod_seccion;
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
		$sql1="SELECT * FROM estudiante WHERE COD_SECCION= '$cod_seccion' ORDER BY APELLIDO_PATERNO"; 
		$datos1=mysql_query($sql1); 
		$contador = 0;
		if (false != $datos1) {
		while ($row=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
			$contador = $contador + 1;
		}}
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
	
	
	/**
	* Edita la información de una seccion en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'data'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $cod_seccion codigo de la seccion a la que se le actualizan los demás datos
	* @param string $nombre_seccion1 letra del nombre de la seccion a editar
	* @param string $nombre_seccion2 número del nombre de la seccion a editar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function AgregarSeccion($nombre_seccion1,$nombre_seccion2)
	{
		if($nombre_seccion1=="" || $nombre_seccion2=="") return 2;
		
		$nombre=$nombre_seccion1."-".$nombre_seccion2;
		$sql="SELECT * FROM seccion ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
		$var=0;
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			if( $row['NOMBRE_SECCION']==$nombre){
			$var=1;
			}
			$contador = $contador + 1;
		}}
		
		if($var!=1){
		$data = array(	
					'NOMBRE_SECCION' => $nombre	
		);
		$this->db->insert('seccion',$data); 
		
         
		if($data == true){
			return 1;
		}
		else{
			return -1;
		}}
		else return 3;
    }

	/**
	* Agregar la información de una seccion en la base de datos
	*
	* Guarda las variables a agregar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'data'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $nombre_seccion1 letra del nombre de la seccion a agregar
	* @param string $nombre_seccion2 número del nombre de la seccion a agregar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function ActualizarSeccion($cod_seccion,$nombre_seccion1,$nombre_seccion2)
	{
		if($cod_seccion=="" || $nombre_seccion1=="" || $nombre_seccion2=="") return 2;
		$nombre=$nombre_seccion1."-".$nombre_seccion2;
		$sql="SELECT * FROM seccion ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$var=0;
		$lista=array();
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			if($row['COD_SECCION']!=$cod_seccion){
				if( $row['NOMBRE_SECCION']==$nombre){
				$var=1;
				}
			}
			$contador = $contador + 1;
		}}
		
		if($var!=1){
		$data = array(	
					'COD_SECCION' => $cod_seccion,
					'NOMBRE_SECCION' => $nombre	
		);
		$this->db->where('COD_SECCION', $cod_seccion);
		$this->db->update('seccion',$data); 
		
         
		if($data == true){
			return 1;
		}
		else{
			return -1;
		}}
		else{return 3;}
    }
 
}
?>