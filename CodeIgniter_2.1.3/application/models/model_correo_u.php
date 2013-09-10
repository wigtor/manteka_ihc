<?php
 
class model_correo_u extends CI_Model {

	/**
   *  Identifica si en la base de datos existe un usuario con una contraseña identica a la ingresada como parámetro.
   *  En caso de validar al usuario, se retornan sus datos.
   *  Caso contrario se retorna un arreglo nulo
   *
   *  @param string $rutRecept del usuario recibe el mensaje
   *  @param string $date codigo del correo que se obtiene dependiendo de la fecha y hora
   */
    public function InsertarCorreoU($rutRecept,$date){
        $datos = array();
      $datos['COD_CORREO'] = $date;
      $datos['RUT_USUARIO'] = $rutRecept;
      $this->db->insert('cartar_user', $datos);
      return  $this->db->_error_message(); 
    }
}
 
?>