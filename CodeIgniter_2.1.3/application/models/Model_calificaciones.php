<?php
class Model_calificaciones extends CI_Model {

	public function getEvaluacionesBySeccionAndProfesorAjax($id_seccion, $rut_profesor, $esCoordinador) {
		$this->db->select('evaluacion.ID_EVALUACION AS id');
		$this->db->select('CONCAT(\'Nota: \', NOMBRE_MODULO) AS nombre', FALSE);
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if ($esCoordinador == FALSE) {
			$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
			$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->order_by('planificacion_clase.FECHA_PLANIFICADA');
		$this->db->group_by('evaluacion.ID_EVALUACION');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function cantidadCalificacionesBySeccionAndModuloTem($id_seccion, $id_modulo_tem) {
		$this->db->select('COUNT( DISTINCT evaluacion.ID_EVALUACION ) AS resultado');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if ($id_modulo_tem != NULL) {
			$this->db->where('modulo_tematico.ID_MODULO_TEM', $id_modulo_tem);
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$query = $this->db->get('evaluacion');
		if ($query == FALSE) {
			return 0;
		}
		//echo $this->db->last_query().'  ';
		return $query->row()->resultado;
	}

	public function getCalificacionesEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('nota.VALOR_NOTA AS nota');
		$this->db->join('evaluacion', 'nota.ID_EVALUACION = evaluacion.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$query = $this->db->get('nota');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosCalificacionesEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('nota.COMENTARIO_NOTA AS comentario');
		$this->db->join('evaluacion', 'nota.ID_EVALUACION = evaluacion.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$query = $this->db->get('nota');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}

?>
