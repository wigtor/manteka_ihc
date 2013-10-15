<?php
class Model_calificaciones extends CI_Model {

	public function getEvaluacionesBySeccionAndProfesorAjax($id_seccion, $rut_profesor, $esCoordinador) {
		$this->db->select('sesion_de_clase.ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if ($esCoordinador == FALSE) {
			$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
			$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->order_by('planificacion_clase.FECHA_PLANIFICADA');
		$query = $this->db->get('sesion_de_clase');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}

?>
