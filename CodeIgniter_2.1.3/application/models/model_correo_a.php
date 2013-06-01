<?php
 
class model_correo_a extends CI_Model {

      /**
      *  Identifica si en la base de datos existe un usuario con una contraseña identica a la ingresada como parámetro.
      *  En caso de validar al usuario, se retornan sus datos.
      *  Caso contrario se retorna un arreglo nulo
      *
      *  @param string $rutRecept del ayudante que recibe el mensaje
      *  @param string $date codigo del correo que se obtiene dependiendo de la fecha y hora
      */
        public function InsertarCorreoA($rutRecept,$date){
        $datos = array();
      $datos['COD_CORREO'] = $date;
      $datos['RUT_AYUDANTE'] = $rutRecept;
      $this->db->insert('cartar_ayudante', $datos);
      return  $this->db->_error_message(); 
    }
}
 
?>