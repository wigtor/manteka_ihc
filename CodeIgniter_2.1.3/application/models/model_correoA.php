<?php
 
class model_correoA extends CI_Model {
        public function InsertarCorreoA($rutRecept,$date){
        $this->COD_CORREO=$date
        $this->RUT_ESTUDIANTE=$rutRecept ;
        $this->db->insert('carta_ayudante',$this);
    }
}
 
?>