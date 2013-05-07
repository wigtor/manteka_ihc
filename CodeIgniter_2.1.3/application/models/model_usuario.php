<?php

/**
 * Modeo para operar sobre los datos referentes a las cuentas de usuario
 * del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información
 */
class model_usuario extends CI_Model{

   /**
   *  Identifica si en la base de datos existe un usuario con una contraseña identica a la ingresada como parámetro.
   *  En caso de validar al usuario, se retornan sus datos.
   *  Caso contrario se retorna un arreglo nulo
   *
   *  @param string $rut RUT del usuario que se desea validar
   *  @param string $password Contraseña del usuario que se desea validar
   *  @return array Datos del usuario validado. En caso de que no se valide, el arreglo es nulo
   */
   function ValidarUsuario($rut,$password){
      // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('RUT_USUARIO',$rut);
      $query = $this->db->where('PASSWORD_PRIMARIA',md5($password));
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla

      // Se obtiene la fila del resultado de la consulta a la base de datos
      $filaResultado = $query->row();

      // Si la fila es nula, es decir, el usuario no coincide con la contraseña, se valida con la contraseña secuandaria o temporal
      if ($filaResultado == FALSE) { //Si no validó usando la password primaria, uso la password secundaria

         // Se limpia la caché para una nueva consulta
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();

         // Consulta a la base de datos
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->where('PASSWORD_TEMPORAL',md5($password));
         $query = $this->db->where('VALIDEZ >', date('Y-m-d H:i:s')); //compruebo que esté dentro del periodo de validez
         $query = $this->db->get('usuario');
         //echo $this->db->last_query(); //Para hacer debug de la query

         // Nuevamente se obtienen la fila resultante a la consulta
         $filaResultado = $query->row();
      }

      // Se conprueba una vez más por si se encontró alguna coincidencia con la contraseña temporal
      if ($filaResultado == FALSE) {      // Si no hay coincidencia
         return FALSE;                    // retornar FALSE
      }

      // Cao contrario, retornar losd atos del usuario mediante la función datos->usuario
      return $this->datos_usuario($filaResultado->RUT_USUARIO);
   }


   /**
   *  Identifica si en la base de datos existe un usuario con un RUT específico ingresado coo parámetro
   *  En caso de encontrar al usuario, se retornan sus datos.
   *  Caso contrario se retorna un arreglo nulo
   *
   *  @param string $rut RUT del usuario que se desea encontrar
   *  @return array Datos del usuario encontrado. En caso de que no se encuentre, el arreglo es nulo
   */
   function ValidarRut($rut){
      // La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->where('RUT_USUARIO',$rut);
      $query = $this->db->get('usuario');
      
      // Resultado de la consulta
      $res = $query->row();
      return $res; // Se retorna la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
      
   }
   

   /**
   *  Asigna una nueva contraseña al usuario ingresado como parámetro
   *
   *  @param string $rut RUT del usuario que se desea encontrar
   *  @param string $password_nva
   *  @return bool Resultado de si se logró o no la operación
   */
   function cambiarContrasegna($rut,$password_nva){

      // Se intenta setear la nueva contraseña en el usuario indicado
      try{
         // La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->update('usuario', array('PASSWORD_PRIMARIA'=>$password_nva));
      }

      // En caso de que haya un error, se retorna falso
      catch (Exception $e)
      {
         return FALSE;
      }

      // Se retorna verdadero pues se logró la operación
      return TRUE;
   }

   /**
   *  Asigna una nueva contraseña temporal al usuario que posee
   *  el correo ingresado como parámetro
   *
   *  @param string $email Correo electrónico del usuario
   *  @param string $new_pass_temp Nueva contraseña temporal del usuario
   *  @param string $date_valid Fecha hasta la que es válida la contraseña
   *  @return bool Resultado de si se logró o no la operación
   */
   function setPassSecundaria($email, $new_pass_temp, $date_valid) {
      
      // Buscar por su correo principal o alternativo
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      
      // Setear la nueva fecha de válidez de la contraseña
      $this->db->set('VALIDEZ', $date_valid);

      // Setear el valor de la contraseña temporal
      $this->db->set('PASSWORD_TEMPORAL', md5($new_pass_temp));

      // Actualizar el dato en el usuario
      $this->db->update('usuario');
      
      // Si se afectaron más de una fila, se logró la operación
      if ($this->db->affected_rows() > 0) {
         return TRUE;      // Devolver TRUE
      }
      return FALSE;        // No se logró la operación, devolver FALSE
   }

   /**
   *  Asigna una nueva contraseña temporal al usuario que posee
   *  el correo ingresado como parámetro
   *
   *  @param string $email Correo electrónico del usuario
   *  @param string $new_pass_temp Nueva contraseña temporal del usuario
   *  @param string $date_valid Fecha hasta la que es válida la contraseña
   *  @return bool Resultado de si se logró o no la operación
   */
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


   function cambiarDatosUsuario($rut, $tipo_usuario, $telefono, $mail1, $mail2) {
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->update('usuario', array('CORREO1_USER'=>$mail1, 'CORREO2_USER'=>$mail2)); //Acá va el nombre de la tabla
      $this->db->stop_cache();
      $this->db->flush_cache();
      $this->db->stop_cache();
      if ($tipo_usuario == 2) { //Coordinador
         $query = $this->db->where('RUT_USUARIO3',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
         $query = $this->db->update('coordinador', array('TELEFONO_COORDINADOR'=>$telefono)); //Acá va el nombre de la tabla
      }
      else if ($tipo_usuario == 1) { //Profesor
         $query = $this->db->where('RUT_USUARIO2',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
         $query = $this->db->update('profesor', array('TELEFONO_PROFESOR'=>$telefono)); //Acá va el nombre de la tabla
      }
      else {
         return FALSE;
      }
      return $tipo_usuario;
   }
}
?>
