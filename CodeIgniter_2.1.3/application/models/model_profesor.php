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
	//OPERACIÓN PARA INGRESAR PROFESOR    
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


   
	//OPERACIÓN PARA VER A UN PROFESOR
    public function VerProfesor($rut_profesor)
    {
		$sql="SELECT * FROM PROFESOR WHERE rut_profesor = '$rut_profesor' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$row=mysql_fetch_array($datos);
		$profesor[0] = $row['RUT_USUARIO2'];
		$profesor[1] = $row['NOMBRE1_PROFESOR'];
        $profesor[2] = $row['NOMBRE2_PROFESOR'];
		$profesor[3] = $row['APELLIDO_PROFESOR'];
        $profesor[4] = $row['APELLIDO2_PROFESOR'];
		$profesor [5] = $row['TELEFONO_PROFESOR'];
		$profesor [6] = $row['TIPO_PROFESOR'];
		
		return $profesor;
    }

	//OPERACIÓN VER A TODOS LOS PROFESORES
	public function VerTodosLosProfesores()
	{
		$sql="SELECT * FROM PROFESOR ORDER BY APELLIDO1_PROFESOR"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		echo mysql_error();
		$contador = 0;
		$lista;
		while ($row = mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			/*$lista[$contador][0] = $row['RUT_PROFESOR'];
			$lista[$contador][1] = $row['NOMBRE_PROFESOR'];
			$lista[$contador][2] = $row['APELLIDO_PATERNO'];
			$lista[$contador][3] = $row['CORREO_PROF1'];
			$lista[$contador][4] = $row['CORREO_PROF2'];
			$lista[$contador][5] = $row['TELEFONO'];
			$lista[$contador][6] = $row['TIPO'];*/
		
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

	//OPERACIÓN EDITAR PROFESOR
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
		
		/*$data1=array(
			'CORREO1_USER'=> $$modu ,
		
		);
		$this->db->where('RUT_USUARIO', $run_profe);
        $datos1 = $this->db->update('usuario',$data1);
		

		$this->db->where('RUT_USUARIO2', $run_profe);
        $datos1 = $this->db->update('modulo_tematico',$modu);
		
		*/
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}	
    }
    //Función get que obtiene profesores, si se le da un argumento obtiene cantidad de profesores
	/*$this->db->select('*');
	$this->db->from('blogs');
	$this->db->join('comments', 'comments.id = blogs.id');
	$query = $this->db->get();
	$data = $this->db->query("SELECT *	FROM profesor"); // the entries for the relevant month and year
	    return $data->result_array();
	*/
	
	function ObtenerProfesor(){	
		$this->db->select('*');
		$this->db->from('profesor');
		$data = $this->db->get();
	    return $data->result_array();
	}
   
   function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD',md5($password));
      $query = $this->db->get('usuario'); //Ac? va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la b?squeda. (FALSE en caso que no existir coincidencias)
   }

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
