<?php
class model_correo extends CI_Model{
   function todos(){
      $q = $this->db->get('AYUDANTE');
      $data=null;
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
                $data[] = $row;
        }
        return $data;
    }
}
?>
