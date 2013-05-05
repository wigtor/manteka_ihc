<?php
class model_coordinadores extends CI_Model{
  /* function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD',md5($password));
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
   }*/

   	function ObtenerTodosCoordinadores(){
   		/* SUMARIO DE LA FUNCIÓN:
   			La función simplemente obtiene desde la base de datos
   			todos las coordinaciones disponibles en el
   			sistema.

   			El resultado es entregado al controlador en forma de
   			array de objetos, por tanto éste debe recorrer el
            array y transformar los objetos en filas para
            obtener la información correspondiente.
   		*/
   		$query = $this->db->get('coordinador');
   		$ObjetoListaResultados = $query->result();
   		return $ObjetoListaResultados;
   	}

   	function BuscarCoordinadores($entrada,$criterio){
         /* SUMARIO DE LA FUNCIÓN:
            La función obtiene desde la base de datos
            todos las coordinaciones disponibles en el
            sistema que cumplan

            El resultado es entregado al controlador en forma de
            array de objetos, por tanto éste debe recorrer el
            array y transformar los objetos en filas para
            obtener la información correspondiente.
         */

         /*Según el criterio del filtro, se configura la entrada de la consulta a la
            base de datos. Como se trata de una búsqueda, las sentencias de consulta
            utilizan LIKE en vez de WHERE, que exigiría una entrada exacta para producir
            resultados, algo poco probable. */

         switch ($criterio) {
            /*
               NOTA: escape_like_str debería impedir inyecciones SQL.
               Ya que no se ocupan comodines en la búsqueda, quizás
               escape() pueda hacer el mismo trabajo.
            */
            case 'e-mail':
               $this->db->like('CORREO1_USER',$this->db->escape_like_str($entrada));
               $this->db->or_like('CORREO2_USER',$this->db->escape_like_str($entrada));
               break;
            case 'rut':
               $this->db->like('RUT_USUARIO',$this->db->escape_like_str($entrada));
               break;
            case 'nombre':
               $this->db->like('COORD_NOMBRE',$this->db->escape_like_str($entrada));
               break;
            case 'telefono':
               $this->db->like('COORD_TELEFONO',$this->db->escape_like_str($entrada));
               break;
            case 'tipo': //será un criterio válido?
               $this->db->like('ID_TIPO',$this->db->escape_like_str($entrada));
               break;
            case 'id':
               $this->db->like('ID_COORD',$this->db->escape_like_str($entrada));
               break;
            default:
               //nada
               break;
         }
         //Ejecución consulta
         $ObjetoListaResultados=array();
         $this->db->get('coordinador');//equivale a this->db->from()
         $this->db->order_by('COORD_NOMBRE','asc');
         $ObjetoListaResultados = $this->db->result();
   	}

      function agregarCoordinador($nombre,$rut,$correo1,$correo2,$telefono,$id,$tipo){
         $informacion = array('RUT_USUARIO' => $rut, 
                        'COORD_NOMBRE' => $nombre,
                        'ID_TIPO' => $tipo,
                        'ID_COORD' => $id,
                        'CORREO1_USER' => $correo1,
                        'CORREO2_USER' => $correo2,
                        'COORD_TELEFONO' => $telefono,);
         $this->db->insert('coordinador',$informacion);
      }

      function borrarCoordinador($nombre,$rut){
         $this->db->where('COORD_NOMBRE',$nombre);
         $this->db->or_where('RUT_USUARIO',$rut);
         $this->db->delete('coordinador');
      }

      function modificarCoordinador($nombreActual,$rutActual,$nombreNuevo,$rutNuevo,$correo1Nuevo,$correo2Nuevo,$telefonoNuevo,$idNuevo,$tipoNuevo){
         $this->db->where('COORD_NOMBRE',$nombreActual);
         $this->db->or_where('RUT_USUARIO',$rutActual)
         $informacion = array('RUT_USUARIO' => $rut, 
                        'COORD_NOMBRE' => $nombre,
                        'ID_TIPO' => $tipo,
                        'ID_COORD' => $id,
                        'CORREO1_USER' => $correo1,
                        'CORREO2_USER' => $correo2,
                        'COORD_TELEFONO' => $telefono,);
         $this->db->update('coordinador',$informacion);
         
      }


}
?>