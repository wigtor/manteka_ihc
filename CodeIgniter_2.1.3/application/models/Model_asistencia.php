<?php
class Model_asistencia extends CI_Model {

	public function agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_sesion_de_clase) {
		
		$this->db->trans_start();
		$data1 = array('PRESENTE_ASISTENCIA' => $asistio, 
			'JUSTIFICADO_ASISTENCIA' => $justificado, 
			'COMENTARIO_ASISTENCIA' => $comentario);
		$data2 = array('RUT_USUARIO' => $rut, 
			'ID_SESION' => $id_sesion_de_clase,
			'PRESENTE_ASISTENCIA' => $asistio, 
			'JUSTIFICADO_ASISTENCIA' => $justificado, 
			'COMENTARIO_ASISTENCIA' => $comentario);

		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_SESION', $id_sesion_de_clase);
		$primeraResp = $this->db->get('asistencia');
		if ($primeraResp == FALSE) {
			return array();
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia
			$this->db->flush_cache();
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_SESION', $id_sesion_de_clase);
			$datos2 = $this->db->update('asistencia', $data1);
		}
		else {
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$datos2 = $this->db->insert('asistencia', $data2);
		}
		//echo $this->db->last_query();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public function getAsistenciaBySeccion() {

	}
}

?>
