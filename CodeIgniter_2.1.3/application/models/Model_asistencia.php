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


	public function getAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('asistencia.PRESENTE_ASISTENCIA AS presente');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
		$query = $this->db->get('asistencia');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('asistencia.COMENTARIO_ASISTENCIA AS comentario');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
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
