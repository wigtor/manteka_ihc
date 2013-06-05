<?php
 
class model_planificacion extends CI_Model {

  

 /**
* Obtiene la planifiación desde la base de datos
*
* @param null
* @return $array
*/
 

	public function selectPlanificacion(){


		$columnas = 'seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO';
		$condiciones = '(seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO)';
		$desde = '`seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia`';

		$query = $this->db->select($columnas);
		
		$query = $this->db->where($condiciones);

		$query = $this->db->get($desde);

		$array = $query->result_array();
						
		return $array;

	}

	/*

SELECT seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO FROM `seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia` WHERE (seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO);
*/

}

?>