<?php
 
class model_planificacion extends CI_Model {

  

 /**
* Obtiene la planifiación desde la base de datos
*
* @param null
* @return $array
*/
 

	public function selectPlanificacion(){


		/*$columnas = 'seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO';
		$condiciones = '(seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO)';
		$desde = '`seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia`';

		$query = $this->db->select($columnas);
		
		$query = $this->db->where($condiciones);

		$query = $this->db->get($desde);

		$array = $query->result_array();*/

		$this->db->select('seccion.NOMBRE_SECCION as nombre_seccion');
		$this->db->select('NOMBRE_MODULO AS modulo');
		$this->db->select('NUM_SALA AS sala');
		$this->db->select('profesor.NOMBRE1_PROFESOR as nombre1');
		$this->db->select('APELLIDO1_PROFESOR as apellido1');
		$this->db->select('APELLIDO2_PROFESOR as apellido2');
		$this->db->select('NOMBRE_HORARIO as horario');
		$this->db->select('modulo.COD_MODULO as bloque');
		$this->db->select('modulo.NUMERO_MODULO as hora');
		$this->db->select('dia.NOMBRE_DIA as dia');
		$this->db->from('seccion');
		//$this->db->where('seccion.COD_SECCION', $cod_seccion);
		$this->db->join('seccion_mod_tem', 'seccion_mod_tem.COD_SECCION=seccion.COD_SECCION');
		$this->db->join('modulo_tematico', 'modulo_tematico.COD_MODULO_TEM=seccion_mod_tem.COD_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('sala_horario', 'seccion_mod_tem.ID_HORARIO_SALA=sala_horario.ID_HORARIO_SALA', 'LEFT OUTER');
		$this->db->join('sala','sala_horario.COD_SALA=sala.COD_SALA', 'LEFT OUTER');
		$this->db->join('horario','sala_horario.COD_HORARIO=horario.COD_HORARIO', 'LEFT OUTER');
		$this->db->join('equipo_profesor', 'modulo_tematico.COD_EQUIPO=equipo_profesor.COD_EQUIPO', 'LEFT OUTER');
		$this->db->join('profe_seccion','profe_seccion.COD_SECCION= seccion.COD_SECCION', 'LEFT OUTER');
		$this->db->join('profesor','profe_seccion.RUT_USUARIO2=profesor.RUT_USUARIO2', 'LEFT OUTER');
		$this->db->join('modulo','modulo.COD_MODULO=horario.COD_MODULO', 'LEFT OUTER');
		$this->db->join('dia','dia.COD_DIA=horario.COD_DIA', 'LEFT OUTER');

		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		
		$lista = array();
		$contador=0;

		$datos=$query->result();

		foreach ($datos as $row){

			$lista[$contador]=array();
			$lista[$contador][0] = $row->nombre_seccion;
			$lista[$contador][1] = $row->nombre1;
			$lista[$contador][2] = $row->apellido1;
			$lista[$contador][3] = $row->apellido2;
			$lista[$contador][4] = $row->modulo;
			$lista[$contador][5] = $row->sala;
			$lista[$contador][6] = $row->bloque;
			$lista[$contador][7] = $row->hora;
			$lista[$contador][8] = $row->dia;

			$contador=$contador+1;

		}
		
		
	
		return $lista;

		
						
		//return $array;

	}

	/*

SELECT seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO FROM `seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia` WHERE (seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO);
*/

}

?>