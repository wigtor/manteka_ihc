<?php
 
class model_correoU extends CI_Model {
        public function InsertarCorreoU($rutRecept){
        $this->cod_correo=date("mdHis") ;
        $this->rut_estudiante=$rutRecept ;
        $this->db->insert('CARTA_USER',$this);
    }
}
 
?>