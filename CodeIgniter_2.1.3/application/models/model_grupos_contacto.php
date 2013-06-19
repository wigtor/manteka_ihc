<?php

/**
 * Modelo para operar sobre los datos referentes a los grupos
 * de contacto del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información.
 */
class model_grupos_contacto extends CI_Model{

   /**
   *  Retorna todos los grupos de contacto pertenecientes
   *  a un determinado usuario en forma de arreglo.
   *  Si no tiene grupos de contacto, se retorna un
   *  arreglo nulo.
   *
   *  @param string $rut RUT del usuario del cual se solicitan los grupos de contacto.
   *  @return array Conjunto de grupos de contacto pertenecientes al usuario.
   */
      function obtenerTodosGruposContacto($rut){
      // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas SQL.
      $query = $this->db->where('RUT_USUARIO',$rut);
      $query = $this->db->get('filtro_contacto'); //Acá va el nombre de la tabla

      // Se obtiene la fila del resultado de la consulta a la base de datos
      $ObjetoListaResultados = $query->result_array();
      
      $datos = array();
      $contador = 0;    
      foreach ($ObjetoListaResultados as $row) {
                        $datos[$contador] = array(
                        'id_filtro_contacto'=>$row['ID_FILTRO_CONTACTO'],
                        'rut'=>$row['RUT_USUARIO'],
                                'nombre_filtro_contacto'=> $row['NOMBRE_FILTRO_CONTACTO'],
                                'query'=>$row['QUERY_FILTRO_CONTACTO'],
                        );
                        $contador++;
      }
         return $datos;
   }

   function eliminarGrupoContactoPorNombre($rut,$nombre_grupo_contacto){
      /**
      *  Elimina un grupo de contacto perteneciente
      *  a un determinado usuario por el nombre asignado.
      *
      *
      *  @param string $rut RUT del usuario del cual se solicitan los grupos de contacto.
      *  @param string $nombre_grupo_contacto nombre del grupo de contacto a eliminar.
      *  @return none
      */
      $query = $this->db->where('RUT_USUARIO',$rut);
      $query = $this->db->where('NOMBRE_FILTRO_CONTACTO',$nombre_grupo_contacto);
      $query = $this->db->delete('filtro_contacto');
   }
   
   public function insertarGrupo($rut,$rut_contactos,$nombre_filtro){
      $grupo_de_contacto = array('RUT_USUARIO'=> $rut,
                                    'QUERY_FILTRO_CONTACTO'=> $rut_contactos ,                                   
                                    'NOMBRE_FILTRO_CONTACTO'=>$nombre_filtro );
      $this->db->insert('filtro_contacto',$grupo_de_contacto);  
   }
   
   public function VerGrupos($rut){
		$this->db->select('*');
		$this->db->from('filtro_contacto');
		$this->db->where('RUT_USUARIO',$rut);
		$query=$this->db->get();
		$ObjetoListaResultados = $query->result_array();
		return $ObjetoListaResultados;		
   }
   public function getGrupo($id){
		$this->db->select('*');
		$this->db->from('filtro_contacto');
		$this->db->where('ID_FILTRO_CONTACTO', $id);
		$query = $this->db->get();
		$ObjetoListaResultados = $query->result_array();	
		return $ObjetoListaResultados;	
	}
   public function modificarGrupo($id, $nuevo_filtro){
      $this->db->where('ID_FILTRO_CONTACTO',$id);
      //$data = array('PASSWORD_PRIMARIA'=>$pass,);
      $data = array('QUERY_FILTRO_CONTACTO'=>$nuevo_filtro,);
      $this->db->update('filtro_contacto', $data);
   }

   public function getDatosGrupo($id_grupo){

      $this->db->select('QUERY_FILTRO_CONTACTO');
      $this->db->from('filtro_contacto');
      $this->db->where('ID_FILTRO_CONTACTO', $id_grupo);
      $query = $this->db->get();
      $str_ruts = $query->result_array()[0]['QUERY_FILTRO_CONTACTO'];
      $ruts = explode(",", $str_ruts);
      
      $this->db->select('*');
      $this->db->from('estudiante');
      $this->db->where_in('RUT_ESTUDIANTE', $ruts);
      $estudiantes = $this->db->get()->result_array();

      $this->db->select('*');
      $this->db->from('profesor');
      $this->db->where_in('RUT_USUARIO2', $ruts);
      $profesores = $this->db->get()->result_array();

      $this->db->select('*');
      $this->db->from('ayudante');
      $this->db->where_in('RUT_AYUDANTE', $ruts);
      $ayudantes = $this->db->get()->result_array();

      $contador=0;
      $resultado = array();
      for($i=0 ; $i < count($estudiantes) ; $i++){
         $resultado[$contador] = [$estudiantes[$i]['RUT_ESTUDIANTE'] ,
                                  $estudiantes[$i]['NOMBRE1_ESTUDIANTE']." ".$estudiantes[$i]['NOMBRE2_ESTUDIANTE']." ".$estudiantes[$i]['APELLIDO1_ESTUDIANTE']." ".$estudiantes[$i]['APELLIDO2_ESTUDIANTE'],
                                  "Estudiante",
                                  $estudiantes[$i]['CORREO_ESTUDIANTE'] ];
         $contador++;
      }
      for($i=0;$i<count($profesores);$i++){
         $resultado[$contador] = [$profesores[$i]['RUT_USUARIO2'] ,
                                  $profesores[$i]['NOMBRE1_PROFESOR']." ".$profesores[$i]['NOMBRE2_PROFESOR']." ".$profesores[$i]['APELLIDO1_PROFESOR']." ".$profesores[$i]['APELLIDO2_PROFESOR'],
                                  "Profesor",
                                  "donde estará?" ];
         $contador++;
      }
      for($i=0;$i<count($ayudantes);$i++){
         $resultado[$contador] = [$ayudantes[$i]['RUT_AYUDANTE'] ,
                                  $ayudantes[$i]['NOMBRE1_AYUDANTE']." ".$ayudantes[$i]['NOMBRE2_AYUDANTE']." ".$ayudantes[$i]['APELLIDO1_AYUDANTE']." ".$ayudantes[$i]['APELLIDO2_AYUDANTE'],
                                  "Ayudante",
                                  $ayudantes[$i]['CORREO_AYUDANTE'] ];
         $contador++;
      }
      return $resultado;
   }
   
}
?>
