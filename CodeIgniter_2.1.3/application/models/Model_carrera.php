<?php
	
/**
 * Modelo para operar sobre los datos referentes a los grupos
 * de contacto del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información.
 */
class Model_carrera extends CI_Model{

	public function getAllCarreras() {
		$this->db->select('carrera.COD_CARRERA AS id');
		$this->db->select('carrera.NOMBRE_CARRERA AS nombre');
		$this->db->select('carrera.DESCRIPCION_CARRERA AS descripcion');
		$this->db->order_by("NOMBRE_CARRERA", "asc");
		$query =$this->db->get('carrera');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}
?>
