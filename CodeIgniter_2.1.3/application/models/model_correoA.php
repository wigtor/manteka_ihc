<?php
 
class model_correoA extends CI_Model {
        public function InsertarCorreoA($rutRecept){
        $this->cod_correo=date("mdHis") ;
        $this->rut_estudiante=$rutRecept ;
        $this->db->insert('CARTA_AYUDANTE',$this);
    }
}
 
?>