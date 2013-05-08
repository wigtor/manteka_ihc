<?php
 
class model_correoE extends CI_Model {
        public function InsertarCorreoE($rutRecept,$date){
        $this->COD_CORREO=$date ;
        $this->RUT_ESTUDIANTE=$rutRecept ;
        $this->db->insert('carta_estudiante',$this);
    }
}
 
?>