<?php
class Model_asistencia extends CI_Model {

	public function agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_sesion_de_clase) {
		//echo 'Asistencia agregada con valor: '.$asistio.' para el estudiante con rut: '.$rut.' (REALMENTE AÚN NO SE HACE EN LA DB)<br>';
		$this->db->trans_start();
		$data = array('RUT_USUARIO' => $rut, 
			'ID_SESION' => $id_sesion_de_clase,
			'PRESENTE_ASISTENCIA' => $asistio, 
			'JUSTIFICADO_ASISTENCIA' => $justificado, 
			'COMENTARIO_ASISTENCIA' => $comentario);
		$datos2 = $this->db->insert('asistencia', $data);
		//echo $this->db->last_query();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
}

?>
