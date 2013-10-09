<?php
 
class Model_planificacion extends CI_Model {

  

 /**
* Obtiene la planifiación desde la base de datos
*
* @param null
* @return $array
*/
 

	public function getPlanificaciones($texto, $textoFiltrosAvanzados) {
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS seccion');
		$this->db->select('NUM_SESION_SECCION as numero_sesion_seccion');
		$this->db->select('CONCAT_WS(\' \', NOMBRE1, APELLIDO1, APELLIDO2 ) AS profesor');
		$this->db->select('NOMBRE_MODULO AS modulo');
		$this->db->select('CONCAT(ABREVIATURA_DIA, modulo_horario.ID_MODULO ) AS bloque');
		$this->db->select('NOMBRE_DIA as dia');
		$this->db->select('HORA_INI as hora');
		$this->db->select('NUM_SALA AS sala');
		$this->db->select('FECHA_PLANIFICADA as fecha');
		$this->db->select('planificacion_clase.ID_PLANIFICACION_CLASE as id');

		$this->db->join('sala','planificacion_clase.ID_SALA = sala.ID_SALA', 'LEFT OUTER');
		$this->db->join('seccion','planificacion_clase.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('horario','seccion.ID_HORARIO = horario.ID_HORARIO', 'LEFT OUTER');
		$this->db->join('modulo_horario','horario.ID_MODULO = modulo_horario.ID_MODULO', 'LEFT OUTER');
		$this->db->join('dia_horario','horario.ID_DIA = dia_horario.ID_DIA', 'LEFT OUTER');
		$this->db->join('sesion_de_clase','planificacion_clase.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('modulo_tematico', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('ayu_profe','planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE', 'LEFT OUTER');
		$this->db->join('usuario','ayu_profe.PRO_RUT_USUARIO = usuario.RUT_USUARIO', 'LEFT OUTER');

		
		$this->db->order_by("seccion.ID_SECCION", "asc");
		$this->db->order_by("FECHA_PLANIFICADA", "asc");


		if ($texto != "") {
			$this->db->like("LETRA_SECCION", $texto);
			$this->db->or_like("NUMERO_SECCION", $texto);
			$this->db->or_like("NOMBRE1", $texto);
			$this->db->or_like("APELLIDO1", $texto);
			$this->db->or_like("APELLIDO2", $texto);
			$this->db->or_like("NOMBRE_MODULO", $texto);
			$this->db->or_like("NUM_SALA", $texto);
			$this->db->or_like("UBICACION", $texto);
			$this->db->or_like("dia_horario.ABREVIATURA_DIA", $texto);
			$this->db->or_like("modulo_horario.ID_MODULO", $texto);
			$this->db->or_like("HORA_INI", $texto);
			$this->db->or_like("NOMBRE_DIA", $texto);
		}

		else {
			
			//Sólo para acordarse
			define("BUSCAR_POR_SECCION", 0);
			define("BUSCAR_POR_PROFESOR", 1);
			define("BUSCAR_POR_MOD_TEM", 2);
			define("BUSCAR_POR_SALA", 3);
			define("BUSCAR_POR_BLOQUE", 4);
			define("BUSCAR_POR_HORA", 5);
			define("BUSCAR_POR_DIA", 6);
			
			if($textoFiltrosAvanzados[BUSCAR_POR_SECCION] != '') {
				$this->db->where("(LETRA_SECCION LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_SECCION]."%' OR NUMERO_SECCION LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_SECCION]."%')");
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_PROFESOR] != ''){
				$this->db->where("(NOMBRE1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_PROFESOR]."%' OR APELLIDO1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_PROFESOR]."%' OR APELLIDO2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_PROFESOR]."%')");
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_MOD_TEM] != '') {
				$this->db->like("NOMBRE_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_MOD_TEM]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_SALA] != '') {
				$this->db->where("(NUM_SALA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_SALA]."%' OR UBICACION LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_SALA]."%')");
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_BLOQUE] != '') {
				$this->db->like("modulo_horario.ID_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_BLOQUE]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_HORA] != '') {
				$this->db->like("HORA_INI", $textoFiltrosAvanzados[BUSCAR_POR_HORA]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_DIA] != '') {
				$this->db->like("NOMBRE_DIA", $textoFiltrosAvanzados[BUSCAR_POR_DIA]);
			}
		}
		$query = $this->db->get('planificacion_clase');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function agregarPlanificacion($seccion, $sesion, $rut_profesor, $sala, $fecha_planificada, $numero_sesion_seccion) {
		$this->db->trans_start();

		$this->db->select('ID_AYU_PROFE as id');
		$this->db->where('PRO_RUT_USUARIO', $rut_profesor);
		//$this->db->where('RUT_USUARIO', $rut_ayudante);
		$query = $this->db->get('ayu_profe');
		if ($query == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		$id_ayu_profe = 0; //Valor por default
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$id_ayu_profe = $row->id;
		}


		$data = array(
			'ID_SECCION' => $seccion,
			'ID_SESION' => $sesion,
			'ID_AYU_PROFE' => $id_ayu_profe,
			'ID_SALA' => $sala,
			'FECHA_PLANIFICADA' => $fecha_planificada,
			'NUM_SESION_SECCION' => $numero_sesion_seccion
			);
		$datos = $this->db->insert('planificacion_clase', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}

	}


	public function eliminarPlanificacion($id_planificacion) {
		$this->db->trans_start();
		$this->db->where('ID_PLANIFICACION_CLASE', $id_planificacion);
		$this->db->delete('planificacion_clase');
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	public function getSesionesByModuloTematicoAndSeccion($id_seccion, $id_mod_tem) {
		$this->db->select('NOMBRE_SESION AS nombre_sesion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('NUM_SESION_SECCION AS num_sesion_de_seccion');
		$this->db->select('sesion_de_clase.ID_SESION AS id');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION', 'LEFT OUTER');
		$this->db->where('planificacion_clase.ID_SECCION', $id_seccion);
		$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_mod_tem);
		$query = $this->db->get('sesion_de_clase');
		//echo $this->db->last_query().'    ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getAvanceSecciones() {
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS nombre_seccion');
		$this->db->select('NOMBRE_MODULO AS nombre_modulo_tem');
		$this->db->select('modulo_tematico.ID_MODULO_TEM AS id_mod_tem');
		$this->db->select('NOMBRE_SESION AS nombre_sesion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('NUM_SESION_SECCION AS num_sesion_de_seccion');
		$this->db->select('seccion.ID_SECCION AS id');
		$this->db->select('seccion.ID_SESION AS id_sesion');
		$this->db->join('sesion_de_clase', 'seccion.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('modulo_tematico', 'sesion_de_clase.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM', 'LEFT OUTER');
		//$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->where('planificacion_clase.ID_SESION', 'seccion.ID_SESION', FALSE);
		$this->db->or_where('seccion.ID_SESION IS NULL', NULL);
		$this->db->group_by('seccion.ID_SECCION');
		$this->db->order_by('LETRA_SECCION', 'asc');
		$this->db->order_by('NUMERO_SECCION', 'asc');
		$query = $this->db->get('seccion');
		//echo $this->db->last_query().'    ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getSesionesBySeccion($id_seccion) {
		$this->db->select('NOMBRE_SESION AS nombre_sesion');
		$this->db->select('NUM_SESION_SECCION AS num_sesion_de_seccion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('ID_PLANIFICACION_CLASE AS id');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->join('sesion_de_clase', 'planificacion_clase.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$query = $this->db->get('seccion');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getAllDias() {
		$this->db->select('ID_DIA AS id');
		$this->db->select('NOMBRE_DIA AS nombre');
		$this->db->order_by('ID_DIA', 'asc');
		$query = $this->db->get('dia_horario');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getAllBloquesHorarios() {
		$this->db->select('ID_MODULO AS id');
		$this->db->select('date_format(HORA_INI, \'%H:%i\') AS inicio', FALSE);
		$this->db->select('date_format(HORA_FIN, \'%H:%i\') AS fin', FALSE);
		$this->db->order_by('ID_MODULO', 'asc');
		$query = $this->db->get('modulo_horario');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}

?>