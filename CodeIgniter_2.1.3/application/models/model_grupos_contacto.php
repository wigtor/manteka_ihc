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
   function eliminarGrupo($id_grupo){
      /**
      *  Elimina un grupo de contacto perteneciente
      *  a un determinado usuario por el identificador primario.
      *
      *
      *  @param string $id_grupo identificador del grupo a eliminar.
      *  @return valor que identifica exito o fracazo de la operación.
      */
      $query = $this->db->where('ID_FILTRO_CONTACTO',$id_grupo);
      $query = $this->db->delete('filtro_contacto');
      return $query;
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
      $data = array('QUERY_FILTRO_CONTACTO'=>$nuevo_filtro,);
      $this->db->update('filtro_contacto', $data);
   }

   public function getDatosGrupo($id_grupo){

      $this->db->select('QUERY_FILTRO_CONTACTO');
      $this->db->from('filtro_contacto');
      $this->db->where('ID_FILTRO_CONTACTO', $id_grupo);
      $query = $this->db->get();
      $aux = $query->result_array();
      $str_ruts = $aux[0]['QUERY_FILTRO_CONTACTO'];
      $ruts = explode(",", $str_ruts);
      
      $this->db->select('*');
      $this->db->from('estudiante');
      $this->db->where_in('RUT_ESTUDIANTE', $ruts);
      $query = $this->db->get();
      $estudiantes = $query->result_array();

      $this->db->select('*');
      $this->db->from('usuario');
      $this->db->where_in('RUT_USUARIO', $ruts);
      $query = $this->db->get();
      $usuario = $query->result_array();

      $this->db->select('*');
      $this->db->from('ayudante');
      $this->db->where_in('RUT_AYUDANTE', $ruts);
      $query = $this->db->get();
      $ayudantes = $query->result_array();

      $contador=0;
      $resultado = array();
      for($i=0 ; $i < count($estudiantes) ; $i++){
         $resultado[$contador] = [$estudiantes[$i]['RUT_ESTUDIANTE'] ,
                                  $estudiantes[$i]['NOMBRE1_ESTUDIANTE']." ".$estudiantes[$i]['NOMBRE2_ESTUDIANTE']." ".$estudiantes[$i]['APELLIDO1_ESTUDIANTE']." ".$estudiantes[$i]['APELLIDO2_ESTUDIANTE'],
                                  "Estudiante",
                                  $estudiantes[$i]['CORREO_ESTUDIANTE'] ];
         $contador++;
      }
      for($i=0;$i<count($usuario);$i++){
         $nombre = "nombre";
         if($usuario[$i]['ID_TIPO'] == 1){
              $tipo = "Profesor";
              $this->db->select('*');
              $this->db->from('profesor');
              $this->db->where('RUT_USUARIO2', $usuario[$i]['RUT_USUARIO']);
              $query = $this->db->get();
              $profe_completo = $query->result_array();
              $nombre = $profe_completo[0]['NOMBRE1_PROFESOR']." ".$profe_completo[0]['NOMBRE2_PROFESOR']." ".$profe_completo[0]['APELLIDO1_PROFESOR']." ".$profe_completo[0]['APELLIDO2_PROFESOR'];
         }else{
              $tipo = "Coordinador";
              $this->db->select('*');
              $this->db->from('coordinador');
              $this->db->where('RUT_USUARIO3', $usuario[$i]['RUT_USUARIO']);
              $query = $this->db->get();
              $profe_completo = $query->result_array();
              $nombre = $profe_completo[0]['NOMBRE1_COORDINADOR']." ".$profe_completo[0]['NOMBRE2_COORDINADOR']." ".$profe_completo[0]['APELLIDO1_COORDINADOR']." ".$profe_completo[0]['APELLIDO2_COORDINADOR'];
         }
         $resultado[$contador] = [$usuario[$i]['RUT_USUARIO'] ,
                                  $nombre,
                                  $tipo,
                                  $usuario[$i]['CORREO1_USER'] ];
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
    function getContactosGrupoFlacoPiterStyle($id_grupo){
        //
        $this->db->select('QUERY_FILTRO_CONTACTO');
        $this->db->from('filtro_contacto');
        $this->db->where('ID_FILTRO_CONTACTO', $id_grupo);
        $query = $this->db->get();
        $aux = $query->result_array();
        $str_ruts = $aux[0]['QUERY_FILTRO_CONTACTO'];
        $ruts = explode(",", $str_ruts);
        $resultado = array();

        //Get coordinadores
        $this->db->select('RUT_USUARIO3 AS rut');
        $this->db->select('NOMBRE1_COORDINADOR AS nombre1');
        $this->db->select('NOMBRE2_COORDINADOR AS nombre2');
        $this->db->select('APELLIDO1_COORDINADOR AS apellido1');
        $this->db->select('APELLIDO2_COORDINADOR AS apellido2');
        $this->db->select('CORREO1_USER AS correo');
        $this->db->from('coordinador');
        $this->db->join('usuario','coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
        $this->db->order_by("APELLIDO1_COORDINADOR", "asc");
        $this->db->where_in("coordinador.RUT_USUARIO3",$ruts);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            array_push($resultado, $row);
        }

        //get profesores
        $this->db->select('RUT_USUARIO2 AS rut');
        $this->db->select('NOMBRE1_PROFESOR AS nombre1');
        $this->db->select('NOMBRE2_PROFESOR AS nombre2');
        $this->db->select('APELLIDO1_PROFESOR AS apellido1');
        $this->db->select('APELLIDO2_PROFESOR AS apellido2');
        $this->db->select('CORREO1_USER AS correo');
        $this->db->from('profesor');
        $this->db->join('usuario','profesor.RUT_USUARIO2 = usuario.RUT_USUARIO');
        $this->db->where_in("profesor.RUT_USUARIO2",$ruts);
        $this->db->order_by("NOMBRE1_PROFESOR", "asc");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            array_push($resultado, $row);
        }
        

        //get alumnos
        $this->db->select('RUT_ESTUDIANTE AS rut');
        $this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
        $this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
        $this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
        $this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
        $this->db->select('CORREO_ESTUDIANTE as correo');
        $this->db->order_by("APELLIDO1_ESTUDIANTE", "asc");
        $this->db->where_in("RUT_ESTUDIANTE",$ruts);
        $query = $this->db->get('estudiante');
        foreach ($query->result_array() as $row) {
            array_push($resultado, $row);
        }
       

        //get ayudantes
        $this->db->select('RUT_AYUDANTE AS rut');
        $this->db->select('NOMBRE1_AYUDANTE AS nombre1');
        $this->db->select('NOMBRE2_AYUDANTE AS nombre2');
        $this->db->select('APELLIDO1_AYUDANTE AS apellido1');
        $this->db->select('APELLIDO2_AYUDANTE AS apellido2');
        $this->db->select('CORREO_AYUDANTE as correo');
        $this->db->where_in("RUT_AYUDANTE",$ruts);
        $this->db->order_by("NOMBRE1_AYUDANTE", "asc");
        $query = $this->db->get('ayudante');
        foreach ($query->result_array() as $row) {
            array_push($resultado, $row);
        }
        return $resultado;
   }
   
}
?>
