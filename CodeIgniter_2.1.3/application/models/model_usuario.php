<?php

/**
 * Modeo para operar sobre los datos referentes a las cuentas de usuario
 * del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información
 * @author Grupo 1
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
   *  Comprueba la existencia de un usuario con un correo ingresado
   *  como parámetro
   *
   *  @param string $email Correo electrónico del usuario que se desea encontrar
   *  @return array Datos del usuario encontrado. En caso de no encontrar devuelve array nulo (FALSE).
   */
   function existe_mail($email) {

      // Se prepara la consulta
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      $query =$this->db->get('usuario');

      // Se obtiene las filas coincidentes
      $user = $query->row();

      // Si no se encontraron filas, devolver FALSE
      if ($user == FALSE) {
         return FALSE;
      }

      // Devolver los datos del ususario encontrado
      return $this->datos_usuario($user->RUT_USUARIO);
   }

   /**
   *  Retorna todos los datos de un usuario específico.
   *  Dichos datos son:
   *     Nombre, Apellido, Correo1, Correo2, TIPO_USUARIO
   *  La obtención de los datos es independiente del tipo de cuenta que sea.
   *  Luego primero se busca el tipo de cuenta del usuario. En base a esto
   *  se busca en la tabla de coordinadores o profesores
   *
   *  @param string $rut RUT del usuario al que se le desean obtener los datos
   *  @return array Datos del usuario. En caso de que no se encuentre al usuario, se retorna FALSE
   */
   function datos_usuario($rut){
      // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
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
      // En caso de que no haya una fila resultante, se retorna FALSE
      $filaResultado = $query->row();
      if ($filaResultado == FALSE) {
         return FALSE;
      }

      // Es un usuario del tipo coordinador.
      // Luego se buscan sus datos en la tabla COORDINADOR
      if ($filaResultado->ID_TIPO == TIPO_USR_COORDINADOR) {

         // Se lipia la caché para realizar una nueva consulta
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();

         $this->db->select('RUT_USUARIO AS rut');
         $this->db->select('usuario.ID_TIPO');
         $this->db->select('PASSWORD_PRIMARIA');
         $this->db->select('PASSWORD_TEMPORAL');
         $this->db->select('VALIDEZ');
         $this->db->select('NOMBRE1_COORDINADOR AS nombre1');
         $this->db->select('NOMBRE2_COORDINADOR AS nombre2');
         $this->db->select('APELLIDO1_COORDINADOR AS apellido1');
         $this->db->select('APELLIDO2_COORDINADOR AS apellido2');
         $this->db->select('TELEFONO_COORDINADOR AS telefono');
         $this->db->select('CORREO1_USER AS email1');
         $this->db->select('CORREO2_USER AS email2');
         $this->db->select('NOMBRE_TIPO AS tipo_usuario');
         $this->db->join('coordinador', 'coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
         $this->db->join('tipo_user', 'usuario.ID_TIPO = tipo_user.ID_TIPO');
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->get('usuario');
         
         // Devolver las filas coincidentes, es decir, los datos del usuario
         return $query->row();
      }
      // Es un usuario del tipo profesor.
      // Luego se buscan sus datos en la tabla PROFESOR
      else if ($filaResultado->ID_TIPO == TIPO_USR_PROFESOR) {

         // Se lipia la caché para realizar una nueva consulta
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();

         $this->db->select('RUT_USUARIO AS rut');
         $this->db->select('usuario.ID_TIPO');
         $this->db->select('PASSWORD_PRIMARIA');
         $this->db->select('PASSWORD_TEMPORAL');
         $this->db->select('VALIDEZ');
         $this->db->select('NOMBRE1_PROFESOR AS nombre1');
         $this->db->select('NOMBRE2_PROFESOR AS nombre2');
         $this->db->select('APELLIDO1_PROFESOR AS apellido1');
         $this->db->select('APELLIDO2_PROFESOR AS apellido2');
         $this->db->select('TELEFONO_PROFESOR AS telefono');
         $this->db->select('CORREO1_USER AS email1');
         $this->db->select('CORREO2_USER AS email2');
         $this->db->select('NOMBRE_TIPO AS tipo_usuario');
         $this->db->join('profesor', 'profesor.RUT_USUARIO2 = usuario.RUT_USUARIO');
         $this->db->join('tipo_user', 'usuario.ID_TIPO = tipo_user.ID_TIPO');
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->get('usuario');
         // Devolver las filas coincidentes, es decir, los datos del usuario
         return $query->row();
      }

      // No se ha encontrado un tipo de usuario válido
      // Luego se retorna FALSE
      else {
         return FALSE;
      }
   }

   /**
   *  Cambia datos de perfil de un usuario específico.
   *  Los datos a cambiar son teléfono, correo principal y correo altenativo.
   *  El cambio debe ser transparente a si el usuario tiene cuenta del tipo coordinador o profesor.
   *  Por esta razón se recibe su tipo de cuenta como parámetro.
   *
   *  @param string $rut RUT del usuario al que se le cambian los datos
   *  @param string $tipo_usuario Tipo de cuenta del usuario
   *  @param int $telefono Nuevo teléfono del usuario
   *  @param string $mail1 Nuevo correo electrónico del usuario
   *  @param string $mail2 Nuevo correo altenativo del usuario
   *  @return int Tipo de cuenta del usuario ingresado. En caso de que no se realice la operación, se devuelve FALSE
   */

   function cambiarDatosUsuario($rut, $tipo_usuario, $telefono, $mail1, $mail2) {

      // Dado que los correos del usuario se guardan en una tabla independiente de su tipo de cuenta. Se actualizan sus correo directamente
      
      // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('RUT_USUARIO',$rut);
      $query = $this->db->update('usuario', array('CORREO1_USER'=>$mail1, 'CORREO2_USER'=>$mail2)); //Acá va el nombre de la tabla

      // Se limpia la caché de la consulta
      $this->db->stop_cache();
      $this->db->flush_cache();
      $this->db->stop_cache();

      // Si la cuenta del usuario es del tipo coordinador.
      // Se debe actualizar sus datos en la tabla COORDINADOR
      if ($tipo_usuario == 2) {
         
         // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
         $query = $this->db->where('RUT_USUARIO3',$rut);
         $query = $this->db->update('coordinador', array('TELEFONO_COORDINADOR'=>$telefono)); //Acá va el nombre de la tabla
      }
      
      // Si la cuenta del usuario es del tipo profesor.
      // Se debe actualizar sus datos en la tabla PROFESOR
      else if ($tipo_usuario == 1) {
         // La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
         $query = $this->db->where('RUT_USUARIO2',$rut);
         $query = $this->db->update('profesor', array('TELEFONO_PROFESOR'=>$telefono)); //Acá va el nombre de la tabla
      }

      // Caso contrario, el tipo de cuenta es desconocido
      else {
         return FALSE;
      }

      // Finalmente. Se retorna el tipo de cuenta del usuario
      return $tipo_usuario;
   }
}
?>
