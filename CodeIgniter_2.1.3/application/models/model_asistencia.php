<?php
class Model_asistencia extends CI_Model {

	public function agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_sesion_de_clase) {
		
		$this->db->trans_start();

		$this->db->select('PRESENTE_ASISTENCIA');
		$this->db->select('JUSTIFICADO_ASISTENCIA');
		$this->db->select('COMENTARIO_ASISTENCIA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_SESION', $id_sesion_de_clase);
		$primeraResp = $this->db->get('asistencia');
		//echo $this->db->last_query().'    ';
		if ($primeraResp == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia

			$this->db->flush_cache();
			$data1 = array('PRESENTE_ASISTENCIA' => $asistio, 
				'JUSTIFICADO_ASISTENCIA' => $justificado, 
				'COMENTARIO_ASISTENCIA' => $comentario);
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_SESION', $id_sesion_de_clase);
			$this->db->update('asistencia', $data1);

			//Si hubo cambios, entonces hago insert en auditoría
			if ($this->db->affected_rows() > 0) {
				$row_original = $primeraResp->row();
				$asistioOri = $row_original->PRESENTE_ASISTENCIA;
				$justificadoOri = $row_original->JUSTIFICADO_ASISTENCIA;
				$comentarioOri = $row_original->COMENTARIO_ASISTENCIA;
				$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'UPDATE', 
					'DATO_PRE_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistioOri.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificadoOri.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentarioOri.'`', 
					'DATO_POST_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistio.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificado.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia', 
					'QUERY'=> $this->db->last_query());
				$this->db->flush_cache();
				$this->db->insert('auditoria', $datos_auditoria);
			}
		}
		else {
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$data2 = array('RUT_USUARIO' => $rut, 
				'ID_SESION' => $id_sesion_de_clase,
				'PRESENTE_ASISTENCIA' => $asistio, 
				'JUSTIFICADO_ASISTENCIA' => $justificado, 
				'COMENTARIO_ASISTENCIA' => $comentario);
			$this->db->insert('asistencia', $data2);

			$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'INSERT', 
					'DATO_PRE_CAMBIO' => NULL,
					'DATO_POST_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistio.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificado.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia', 
					'QUERY'=> $this->db->last_query());
			$this->db->flush_cache();
			$this->db->insert('auditoria', $datos_auditoria);
			//echo $this->db->last_query().'    ';
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	public function getAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		//echo 'rut_estudiante: '.$rut_estudiante.' id_modulotem: '.$id_modulotem;
		$this->db->flush_cache();
		$this->db->select('asistencia.PRESENTE_ASISTENCIA AS presente');
		$this->db->select('sesion_de_clase.ID_SESION AS id_sesion');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('estudiante', 'asistencia.RUT_USUARIO = estudiante.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'estudiante.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		$this->db->where('planificacion_clase.ID_SESION', 'sesion_de_clase.ID_SESION', FALSE);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->group_by('asistencia.ID_SESION');
		$this->db->order_by('NUM_SESION_SECCION');
		$query = $this->db->get('asistencia');
		//echo $this->db->last_query().' ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->flush_cache();
		$this->db->select('asistencia.COMENTARIO_ASISTENCIA AS comentario');
		$this->db->select('sesion_de_clase.ID_SESION AS id_sesion');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('estudiante', 'asistencia.RUT_USUARIO = estudiante.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'estudiante.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		$this->db->where('planificacion_clase.ID_SESION', 'sesion_de_clase.ID_SESION', FALSE);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->group_by('asistencia.ID_SESION');
		$this->db->order_by('NUM_SESION_SECCION');
		$query = $this->db->get('asistencia');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function	getAsistenciaEstudiantesBySeccion($id_seccion, $rut_usuario){
		$this->db->select('estudiante.RUT_USUARIO AS rut');
		$this->db->where('estudiante.ID_SECCION', $id_seccion);
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		$AllestudiantesSeccion = $query->result();
		//echo 'Cantiad: '.count($AllestudiantesSeccion).' ';
		$resultado = array();
		$i = 0;
		foreach ($AllestudiantesSeccion as $rut_estudiante) {
			$this->db->flush_cache();
			$this->db->select('estudiante.RUT_USUARIO AS rut');
			$this->db->select('NOMBRE1 AS nombre1');
			$this->db->select('NOMBRE2 AS nombre2');
			$this->db->select('APELLIDO1 AS apellido1');
			$this->db->select('APELLIDO2 AS apellido2');
			$this->db->select('TELEFONO AS telefono');
			$this->db->select('CORREO1_USER AS correo1');
			$this->db->select('CORREO2_USER AS correo2');
			$this->db->select('carrera.COD_CARRERA AS cod_carrera');
			$this->db->select('carrera.NOMBRE_CARRERA AS carrera');
			$this->db->select('asistencia.PRESENTE_ASISTENCIA AS presente');
			$this->db->select('asistencia.JUSTIFICADO_ASISTENCIA AS justificado');
			$this->db->select('asistencia.COMENTARIO_ASISTENCIA AS comentario');
			$this->db->select('estudiante.RUT_USUARIO AS id');
			$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
			$this->db->join('carrera', 'estudiante.COD_CARRERA = carrera.COD_CARRERA');
			$this->db->join('asistencia', 'estudiante.RUT_USUARIO = asistencia.RUT_USUARIO', 'LEFT OUTER');
			$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante->rut);
			//$this->db->where('estudiante.ID_SECCION', $id_seccion);
			$this->db->where('asistencia.ID_SESION', $id_sesion);
			$query = $this->db->get('estudiante');
			//echo $this->db->last_query().' ';
			if ($query == FALSE) {
				return array();
			}
			if ($query->num_rows() > 0) {
				$resultado[$i] = $query->row();
			}
			else {
				$this->db->flush_cache();
				$this->db->select('estudiante.RUT_USUARIO AS rut');
				$this->db->select('NOMBRE1 AS nombre1');
				$this->db->select('NOMBRE2 AS nombre2');
				$this->db->select('APELLIDO1 AS apellido1');
				$this->db->select('APELLIDO2 AS apellido2');
				$this->db->select('TELEFONO AS telefono');
				$this->db->select('CORREO1_USER AS correo1');
				$this->db->select('CORREO2_USER AS correo2');
				$this->db->select('carrera.COD_CARRERA AS cod_carrera');
				$this->db->select('carrera.NOMBRE_CARRERA AS carrera');
				$this->db->select('estudiante.RUT_USUARIO AS id');
				$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
				$this->db->join('carrera', 'estudiante.COD_CARRERA = carrera.COD_CARRERA');
				//$this->db->join('asistencia', 'estudiante.RUT_USUARIO = asistencia.RUT_USUARIO', 'LEFT OUTER');
				$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante->rut);
				$query = $this->db->get('estudiante');
				//echo $this->db->last_query().'    ';
				if ($query == FALSE) {
					return array();
				}

				$resultado[$i] = $query->row(); //Siempre debiese haber al menos un resultado
			}
			$i = $i+1;
		}


		return $resultado;
	}
}

?>
