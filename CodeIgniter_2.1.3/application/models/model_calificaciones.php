<?php
class Model_calificaciones extends CI_Model {

	public function agregarCalificacion($rut_profesor, $rut, $nota, $comentario, $id_evaluacion) {

		$this->db->trans_start();

		$this->db->select('VALOR_NOTA');
		$this->db->select('COMENTARIO_NOTA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_EVALUACION', $id_evaluacion);
		$primeraResp = $this->db->get('nota');
		//echo $this->db->last_query().'    ';
		if ($primeraResp == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia

			$this->db->flush_cache();
			$data1 = array('VALOR_NOTA' => $nota,
				'COMENTARIO_NOTA' => $comentario
			);
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_EVALUACION', $id_evaluacion);
			$this->db->update('nota', $data1);

			//Si hubo cambios, entonces hago insert en auditoría
			if ($this->db->affected_rows() > 0) {
				$row_original = $primeraResp->row();
				$notaOri = $row_original->VALOR_NOTA;
				$comentarioOri = $row_original->COMENTARIO_NOTA;
				$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'UPDATE', 
					'DATO_PRE_CAMBIO' => 'VALOR_NOTA=`'.$notaOri.'`, '.'COMENTARIO_NOTA=`'.$comentarioOri.'`', 
					'DATO_POST_CAMBIO' => 'VALOR_NOTA=`'.$nota.'`, '.'COMENTARIO_NOTA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'nota', 
					'QUERY'=> $this->db->last_query());
				$this->db->flush_cache();
				$this->db->insert('auditoria', $datos_auditoria);
			}
		}
		else {
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$data2 = array('RUT_USUARIO' =>$rut,
				'ID_EVALUACION' => $id_evaluacion,
				'VALOR_NOTA' => $nota,
				'COMENTARIO_NOTA' => $comentario
			);
			$this->db->insert('nota', $data2);

			$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'INSERT', 
					'DATO_PRE_CAMBIO' => NULL,
					'DATO_POST_CAMBIO' => 'VALOR_NOTA=`'.$nota.'`, '.'COMENTARIO_NOTA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'nota', 
					'QUERY'=> $this->db->last_query());
			$this->db->flush_cache();
			$this->db->insert('auditoria', $datos_auditoria);
			//echo $this->db->last_query().'    ';
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


	public function getEvaluacionesBySeccionAndProfesorAjax($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas) {
		$this->db->select('evaluacion.ID_EVALUACION AS id');
		$this->db->select('CONCAT(\'Nota: \', NOMBRE_MODULO) AS nombre', FALSE);
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('TRUE AS editable', FALSE);
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if (($esCoordinador == FALSE) && ($mostrarTodas == FALSE)) {
			if (count($modulosTematicosEnQueEsLider) < 1) {
				$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
				$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
			}
			foreach ($modulosTematicosEnQueEsLider as $modulo_tematico) {
				$this->db->or_where('modulo_tematico.ID_MODULO_TEM', $modulo_tematico->id);
			}
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->order_by('evaluacion.ID_EVALUACION');
		$this->db->group_by('evaluacion.ID_EVALUACION');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		$resultado = $query->result();

		//Agrego la columna para el promedio final
		$notaFinal = new stdClass();
		$notaFinal->id = -1;
		$notaFinal->nombre = "Promedio final acumulado";
		$notaFinal->fecha_planificada = "";
		$notaFinal->editable = FALSE;
		$resultado[count($resultado)] = $notaFinal;
		return $resultado;
	}


	public function cantidadCalificacionesBySeccionAndModuloTem($id_seccion, $id_modulo_tem) {
		$this->db->select('COUNT( DISTINCT evaluacion.ID_EVALUACION ) AS resultado');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
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
		$this->db->select('evaluacion.ID_EVALUACION AS id_evaluacion');
		$this->db->join('nota', 'evaluacion.ID_EVALUACION = nota.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->order_by('evaluacion.ID_MODULO_TEM');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosCalificacionesEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('nota.COMENTARIO_NOTA AS comentario');
		$this->db->select('evaluacion.ID_EVALUACION AS id_evaluacion');
		$this->db->join('nota', 'evaluacion.ID_EVALUACION = nota.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function calculaPromedio($rut_estudiante) {
		$this->db->select('CAST(AVG(nota.VALOR_NOTA) AS DECIMAL (10,2)) AS promedio', FALSE);
		$this->db->join('evaluacion', 'nota.ID_EVALUACION = evaluacion.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('nota');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		if ($query->num_rows() > 0) {
			$promedio = $query->row()->promedio;
			if ($promedio == NULL)
				return "";
			return $promedio;
		}
		return "";
	}
}

?>
