<?php
 
class model_correoA extends CI_Model {
        public function InsertarCorreoA($rutRecept,$date){
        $this->cod_correo=$date
        $this->rut_estudiante=$rutRecept ;
        $this->db->insert('CARTA_AYUDANTE',$this);
    }
}
 
?>