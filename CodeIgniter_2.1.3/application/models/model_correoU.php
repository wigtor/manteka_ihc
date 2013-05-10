<?php
 
class model_correoU extends CI_Model {
        public function InsertarCorreoU($rutRecept,$date){
        $this->COD_CORREO=$date;
        $this->RUT_ESTUDIANTE=$rutRecept ;
        $this->db->insert('carta_user',$this);
    }
}
 
?>