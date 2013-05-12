<?php
 
class model_correoE extends CI_Model {

   /**
   *  Identifica si en la base de datos existe un usuario con una contraseña identica a la ingresada como parámetro.
   *  En caso de validar al usuario, se retornan sus datos.
   *  Caso contrario se retorna un arreglo nulo
   *
   *  @param string $rutRecept rut del estudiante que recibe el mensaje
   *  @param string $date codigo del correo que se obtiene dependiendo de la fecha y hora
   */
        public function InsertarCorreoE($rutRecept,$date){
        $this->COD_CORREO=$date ;
        $this->RUT_ESTUDIANTE=$rutRecept ;
        $this->db->insert('carta_estudiante',$this);
    }
}
 
?>