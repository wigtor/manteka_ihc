<?php
class model_log extends CI_Model
{

/**
* Función que ingresa un nuevo registro del borrador eliminado, guardando la fecha y hora de la eliminación, el asunto y el usuario que lo eliminó
* @author Diego Gómez (DGL)
* @param array $correos, contiene la información de los borradores que fueron eliminados
* @param int $rut, rut del usuario que eliminó el borrador
* @param date $date, fecha y hora en que se eliminó el borrador
*/
	public function LogBorradores($correos,$rut,$date){
		foreach ($correos as $correo) {
			$this->db->select('COD_CORREO AS codigo');
			$this->db->select('ASUNTO');
			$this->db->where('COD_BORRADOR',$correo);
			$query = $this->db->get('carta');
			date_default_timezone_set("Chile/Continental");

			foreach ($query->result() as $row) {
					$data=array('ASUNTO_AUDITORIA' => $row->ASUNTO,
					'TIPO_AUDITORIA' => 'borrador',
					'RUT_AUDITORIA' => $rut,
					'HORA_AUDITORIA' => date("H:i:s"),
					'FECHA_AUDITORIA' => date("Y-m-d"));
			}
			$this->db->insert('auditoria',$data);
		}
	}

/**
* Función que ingresa un nuevo registro del correo recibido eliminado, guardando la fecha y hora de la eliminación, el asunto y el usuario que lo eliminó
* @author Diego Gómez (DGL)
* @param array $correos, contiene la información de los correos recibidos que fueron eliminados
* @param int $rut, rut del usuario que eliminó el correo
* @param date $date, fecha y hora en que se eliminó el correo
*/
	public function LogRecibidos($correos,$rut,$date){
		foreach ($correos as $correo) {
			$this->db->select('COD_CORREO AS codigo');
			$this->db->select('ASUNTO');
			$this->db->where('COD_CORREO',$correo);
			$query = $this->db->get('carta');
			date_default_timezone_set("Chile/Continental");

			foreach ($query->result() as $row) {
					$data=array('ASUNTO_AUDITORIA' => $row->ASUNTO,
					'TIPO_AUDITORIA' => 'recibido',
					'RUT_AUDITORIA' => $rut,
					'HORA_AUDITORIA' => date("H:i:s"),
					'FECHA_AUDITORIA' => date("Y-m-d"));
			}
			$this->db->insert('auditoria',$data);
		}
	}

	/**
* Función que ingresa un nuevo registro del correo enviado eliminado, guardando la fecha y hora de la eliminación, el asunto y el usuario que lo eliminó
* @author Diego Gómez (DGL)
* @param array $correos, contiene la información de los correos enviados que fueron eliminados
* @param int $rut, rut del usuario que eliminó el correo
* @param date $date, fecha y hora en que se eliminó el correo
*/
	public function LogEnviados($correos,$rut,$date){
		foreach ($correos as $correo) {
			$this->db->select('COD_CORREO AS codigo');
			$this->db->select('ASUNTO');
			$this->db->where('COD_CORREO',$correo);
			$query = $this->db->get('carta');
			date_default_timezone_set("Chile/Continental");

			foreach ($query->result() as $row) {
					$data=array('ASUNTO_AUDITORIA' => $row->ASUNTO,
					'TIPO_AUDITORIA' => 'enviado',
					'RUT_AUDITORIA' => $rut,
					'HORA_AUDITORIA' => date("H:i:s"),
					'FECHA_AUDITORIA' => date("Y-m-d"));
			}
			$this->db->insert('auditoria',$data);
		}
	}

/** 
* Función que retorna el registro de los borradores, correos enviados o recibidos que han sido eliminados
* @author Diego Gómez (DGL)
* @param string $tipo, que determina el tipo de registro que se necesita (borradores, enviados o recibidos)
* @return se retorna un array con el nombre de usuario, asunto, y fecha de eliminación del log requerido, FALSE si no se encontró
*/
	public function getLogEliminados($tipo){
		$this->db->select('ID_TIPO');
		$this->db->select('COD_AUDITORIA AS codigo');
		$this->db->select('ASUNTO_AUDITORIA AS asunto');
		$this->db->select('RUT_AUDITORIA AS por');
		$this->db->select('FECHA_AUDITORIA AS fecha');
		$this->db->select('HORA_AUDITORIA AS hora');
		$this->db->from('auditoria');
		$this->db->join('usuario','usuario.RUT_USUARIO = auditoria.RUT_AUDITORIA');
		$this->db->where('TIPO_AUDITORIA',$tipo);
		$this->db->order_by('COD_AUDITORIA',"desc");
		$query = $this->db->get();
		$resultado = array();
		if($query == FALSE){
			return;
		}
		$correos = $query->result();
		foreach ($correos as $row) {

				$this->db->select('NOMBRE1_PROFESOR AS nombre');
				$this->db->select('APELLIDO1_PROFESOR AS apellido1');
				$this->db->select('APELLIDO2_PROFESOR AS apellido2');
				$this->db->where('RUT_USUARIO2',$row->por);
				$query1 = $this->db->get('profesor');

				$this->db->select('NOMBRE1_COORDINADOR AS nombre');
				$this->db->select('APELLIDO1_COORDINADOR AS apellido1');
				$this->db->select('APELLIDO2_COORDINADOR AS apellido2');
				$this->db->where('RUT_USUARIO3',$row->por);
				$query2 = $this->db->get('coordinador');

				if($query1->num_rows() > 0)
				{
					
					foreach ($query1->result() as $row1)
					{
						$de=array();
						$correos=array();
						$correo=array();
					   	array_push($de, $row1);
					   	array_push($correo,$row);
					   	
					   	$correos=  array_merge($correo,$de);
					   	array_push($resultado, $correos);
					   
					}
				}

				

				else if($query2->num_rows() > 0)
				{
					
					foreach ($query2->result() as $row2)
					{
						$de=array();
						$correos=array();
						$correo=array();
					   	array_push($de, $row2);
					   	array_push($correo,$row);
					   	
					   	$correos=  array_merge($correo,$de);
					   	array_push($resultado, $correos);
					   
					}	
				}

		}	
		return $resultado;
	}
}
?>