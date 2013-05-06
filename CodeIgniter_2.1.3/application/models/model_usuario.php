<?php
class model_usuario extends CI_Model{
   function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD_PRIMARIA',md5($password));

      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      $filaResultado = $query->row();
      if ($filaResultado == FALSE) { //Si no validó usando la password primaria, uso la password secundaria
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->where('PASSWORD_TEMPORAL',md5($password));
         $query = $this->db->where('VALIDEZ >', date('Y-m-d H:i:s')); //compruebo que esté dentro del periodo de validez
         $query = $this->db->get('usuario');
         //echo $this->db->last_query(); //Para hacer debug de la query
         $filaResultado = $query->row();
      }
      if ($filaResultado == FALSE) {
         return FALSE;
      }
      return $this->datos_usuario($filaResultado->RUT_USUARIO);
   }

   function ValidarRut($rut){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      //FALTA HACER QUE VALIDE USANDO LA PASSWORD TEMPORAL
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      $res = $query->row();
      return $res; // Devolvemos al controlador la fila que coincide con la b?squeda. (FALSE en caso que no existir coincidencias)
      
   }
   
   function cambiarContrasegna($rut,$password_nva){
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->update('usuario', array('PASSWORD_PRIMARIA'=>$password_nva)); //Ac? va el nombre de la tabla
      return TRUE;
   }

   function setPassSecundaria($email, $new_pass_temp, $date_valid) {
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      $this->db->set('VALIDEZ', $date_valid);
      $this->db->set('PASSWORD_TEMPORAL', md5($new_pass_temp));
      $this->db->update('usuario');
      if ($this->db->affected_rows() > 0) {
         return TRUE;
      }
      return FALSE;
   }

   function existe_mail($email) {
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      $query =$this->db->get('usuario');
      $user = $query->row();
      if ($user == FALSE) {
         return FALSE;
      }
      return $this->datos_usuario($user->RUT_USUARIO);
   }

   /*
   *  Retorna todos los datos de un usuario específico.
   *  Dichos datos son:
   *     Nombre, Apellido, Correo1, Correo2, TIPO_USUARIO
   *  
   */
   function datos_usuario($rut){
      // La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      // Se efectúa la captura de cualquier error relacionado con el acceso a la Base de Datos
      try{
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->get('usuario');
      }
      catch(Exception $e){
      // Si se captura un error de cualquier tipo, se devuelve falso.
         return FALSE;
      }
      // Se retorna la fila resultante de la consulta a la Base de Datos
      // En caso de que no haya una fila resultante, $query->row = 0 (Esto lo realiza la misma operación);
      $filaResultado = $query->row();
      if ($filaResultado == FALSE) {
         return FALSE;
      }
      if ($filaResultado->ID_TIPO == '2') { //Es coordinador
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();

         $this->db->select('usuario.*, NOMBRE1_COORDINADOR AS NOMBRE1, NOMBRE2_COORDINADOR AS NOMBRE2, APELLIDO1_COORDINADOR AS APELLIDO1, APELLIDO2_COORDINADOR AS APELLIDO2, TELEFONO_COORDINADOR AS TELEFONO');
         $this->db->join('coordinador', 'coordinador.rut_usuario3 = usuario.rut_usuario');
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->get('usuario');
         return $query->row();
      }
      else if ($filaResultado->ID_TIPO == '1') { //Es Profesor
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();

         $this->db->select('usuario.*, NOMBRE1_PROFESOR AS NOMBRE1, NOMBRE2_PROFESOR AS NOMBRE2, APELLIDO1_PROFESOR AS APELLIDO1, APELLIDO2_PROFESOR AS APELLIDO2, TELEFONO_PROFESOR AS TELEFONO');
         $this->db->join('profesor', 'profesor.rut_usuario2 = usuario.rut_usuario');
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->get('usuario');
         return $query->row();
      }
      else {
         return FALSE; //Tipo de usuario desconocido
      }
   }
}
?>
