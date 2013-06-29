<?php
 
 /**
* Clase que realiza las consultas a la base de datos relacionadas con los filtros en el envío de correos
* @author Diego Gómez
*/

class Model_Rebotes extends CI_Model {
    public $rut = 0;

public function eliminarRebote($codigo){
	$this->db->select('CUERPO_EMAIL as cuerpo');
	$this->db->select('RUT_USUARIO as rut');
	$this->db->where('COD_CORREO',$codigo);
	$query = $this->db->get('carta');

	$this->db->where('COD_CORREO',$codigo);
	$this->db->update('carta',array('ENVIADO_CARTA' => 0));
	if($query==FALSE){
		return array();
	}
	return $query->result();
}


public function notificacionRebote($cuerpo,$rut){
	$cuerpo_nuevo = 'Se le informa que el siguiente mensaje a fallado al ser enviado por razones desconocidas <br><fieldset><legend>Mensaje original</legend>'.$cuerpo.'</fieldset>';
	
	$data=array('RUT_USUARIO' => $rut,
					'COD2_CORREO' => 'rebote',
					'HORA' => date("H:i:s"),
					'FECHA' => date("Y-m-d"),
					'ASUNTO' => 'Notificacíon de mail rebotado',
					'CUERPO_EMAIL' => $cuerpo_nuevo);
	$this->db->insert('carta',$data);
}
}

?>