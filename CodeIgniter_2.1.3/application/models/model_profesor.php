<?php

class Model_profesor extends CI_Model {
   public $rut_profesor = 0;
    var $nombre_profesor = '';
    var $nombre2_profesor ='';
    var $apellido_paterno ='';
    var $apellido_materno='';
    var $correo_prof1='';
    var $correo_prof2='';
    var $telefono='';
    var $tipo=''; // se refiere a si es profesor normal o coordinador

	
	/**
	* Inserta un profesor en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos', esto corresponde a la inserción en la tabla usuarios. Siguiente se debe insertar en la tabla profesores, donde se repite el procedimiento. 
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_profesor Rut del profesor a insertar
	* @param string $nombre1_profesor Primer nombre del profesor a insertar
	* @param string $nombre2_profesor Segundo nombre del profesor a insertar
	* @param string $apellido1_profesor Primer apellido del profesor a insertar
	* @param string $apellido2_profesor Segundo apellido del profesor a insertar
	* @param string $correo_profesor Correo del ayudante a insertar
	* @param string $telefono_profesor Telefono del profesor a insertar
	* @param string $tipo_profesor Tipo del profesor a insertar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function InsertarProfesor($rut_profesor,$nombre1_profesor,$nombre2_profesor,$apellido1_profesor,$apellido2_profesor,$correo_profesor,$telefono_profesor, $tipo_profesor) 
  {
  	$id_tipo = 1;
    $pass = "123";
    $data2 = array(         
          'RUT_USUARIO' => $rut_profesor,
          'ID_TIPO' => $id_tipo,
          'PASSWORD_PRIMARIA' => md5($pass),
          'CORREO1_USER' => $correo_profesor,
    );
    
    $datos2 = $this->db->insert('usuario',$data2);
    
    $data = array(          
          'RUT_USUARIO2' => $rut_profesor ,
          'NOMBRE1_PROFESOR' => $nombre1_profesor ,
          'NOMBRE2_PROFESOR' => $nombre2_profesor ,
          'APELLIDO1_PROFESOR' => $apellido1_profesor ,
          'APELLIDO2_PROFESOR' => $apellido2_profesor,
          'TELEFONO_PROFESOR' =>  $telefono_profesor,
          'TIPO_PROFESOR' => $tipo_profesor, 
    );

    $datos = $this->db->insert('profesor',$data);

    if($datos && $datos2){
      return 1;
    }
    else{
      return -1;
    }
    
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
		$sql="SELECT * FROM PROFESOR ORDER BY APELLIDO1_PROFESOR"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		echo mysql_error();
		$contador = 0;
		$lista;
		while ($row = mysql_fetch_array($datos)) { //Bucle para ver todos los registros
		
           $lista[$contador][0] = $row['RUT_USUARIO2'];
           $lista[$contador][1] = $row['NOMBRE1_PROFESOR'];
           $lista[$contador][2] = $row['NOMBRE2_PROFESOR'];
           $lista[$contador][3] = $row['APELLIDO1_PROFESOR'];
           $lista[$contador][4] = $row['APELLIDO2_PROFESOR'];
           $lista[$contador][5] = $row['TELEFONO_PROFESOR'];
            $lista[$contador][6]= $row['TIPO_PROFESOR'];
			$contador = $contador + 1;
		}
		return $lista;
		}

	/**
	* Edita la información de un profesor en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $run_profe Rut del profesor al que se le actualizan los demás datos
	* @param string $telefono_profe Correo a editar del profesor
	* @param string $tipo_profe Correo a editar del profesor
	* @param string $nom1 Primer nombre a editar del profesor
	* @param string $nom2 Segundo nombre a editar del profesor
	* @param string $ape1 Apellido paterno del profesor
	* @param string $ape2 Apellido mateno del profesor
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function EditarProfesor($run_profe,$telefono_profe,$tipo_profe,$nom1, $nom2, $ape1,$ape2)
    {
		$data = array(					
					'RUT_USUARIO2' => $run_profe ,
					'NOMBRE1_PROFESOR' => $nom1 ,
					'NOMBRE2_PROFESOR' => $nom2,
					'APELLIDO1_PROFESOR' => $ape1 ,
					'APELLIDO2_PROFESOR' => $ape2,
					'TELEFONO_PROFESOR'=>$telefono_profe,
					'TIPO_PROFESOR' => $tipo_profe,

		);
		$this->db->where('RUT_USUARIO2', $run_profe);
        $datos = $this->db->update('profesor',$data);
		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}	
    }


	/**
	* Obtiene los datos de todos los modulos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada modulo y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los modulos del sistema
	*/
   public function verModulo()
  {
    $sql="SELECT * FROM MODULO_TEMATICO"; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
    $contador = 0;
    $lista;
    while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
      $lista[$contador][0] = $row['COD_MODULO_TEM'];
      $lista[$contador][3] = $row['NOMBRE_MODULO'];
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
	public function verSeccion(){
		$sql="SELECT COD_SECCION FROM SECCION"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador] = $row['COD_SECCION'];
			$contador = $contador + 1;
		}
		
		return $lista;
	}

	
	/**
	* Eliminar un profesor de la base de datos
	*
	* Recibe el rut de un profesor para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_profesor Rut del profesor que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function EliminarProfesor($rut_profesor)
    {
    $sql="DELETE FROM PROFESOR WHERE rut_usuario2 = '$rut_profesor' "; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
    if($datos == true){
      return 1;
    }
    else{
      return -1;
    }
    }


}

?>
