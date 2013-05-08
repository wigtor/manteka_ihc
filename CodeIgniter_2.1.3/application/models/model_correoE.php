<?php
 
class model_correoE extends CI_Model {
        public function InsertarCorreoE($rutRecept,$date){
        $this->cod_correo=$date ;
        $this->rut_estudiante=$rutRecept ;
        $this->db->insert('CARTA_ESTUDIANTE',$this);
    }
}
 
?>