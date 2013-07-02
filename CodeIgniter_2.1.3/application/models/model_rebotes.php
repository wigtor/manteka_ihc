<?php
 
 /**
* Clase que realiza las consultas a la base de datos relacionadas con los mail de rebotes
* @author Diego Gómez
*/

class Model_Rebotes extends CI_Model {

/** 
* Función que retorna el rut del usuario que envió el mail rebotado y el cuerpo del mail que rebotó, además
* además de eliminar el correo rebotado de la base de datos (se esconde del usuario, quedando de igual forma en la bd)
* @author Diego Gómez (DGL)
* @param int $codigo, código del mail que rebotó
* @return retorna un array con los atributos rut, del usuario que envió el correo y cuerpo mail del mail que rebotó
*/
public function eliminarRebote($codigo){
	$this->db->select('CUERPO_EMAIL as cuerpo');
	$this->db->select('RUT_USUARIO as rut');
	$this->db->where('COD_CORREO',$codigo);
	$query = $this->db->get('carta');

	$this->db->where('COD_CORREO',$codigo);
	$this->db->update('carta',array('ENVIADO_CARTA' => 0));
	foreach ($query->result_array() as $row) {
		return $row;
	}
}

/** 
* Funciíon que crea un mail para informar al usuario que rebotó un mail que envió, al cual se le concatena el mail original
* @author Diego Gómez (DGL)
* @param string $cuerpo, cuerpo del mail que rebotó
* @param int $rut, rut del usuario que envió el mail rebotado
*/
public function notificacionRebote($cuerpo,$rut){
	$cuerpo_nuevo = 'Se le informa que el siguiente mensaje a fallado al ser enviado por razones desconocidas <br><fieldset><legend>Mensaje original</legend>'.$cuerpo.'</fieldset>';
	date_default_timezone_set("Chile/Continental");
	$date = date("YmdHis");
	$data=array('RUT_USUARIO' => $rut,
					'COD2_CORREO' => $date,
					'HORA' => date("H:i:s"),
					'FECHA' => date("Y-m-d"),
					'ASUNTO' => 'Notificacíon de mail rebotado',
					'CUERPO_EMAIL' => $cuerpo_nuevo,
					'ENVIADO_CARTA' => 0);
	$this->db->insert('carta',$data);

	$this->db->select('COD_CORREO as cod');
	$this->db->where('COD2_CORREO',$date);
	$query = $this->db->get('carta');
	foreach ($query->result_array() as $row) {
		$codigo=$row['cod'];
	}
	$data=array('RUT_USUARIO' => $rut,
				'COD_CORREO' => $codigo,
				'RECIBIDO_CARTA_USER' => 1,
				'NO_LEIDO_CARTA_USER' => 1);
	$this->db->insert('cartar_user',$data);
}
}

?>