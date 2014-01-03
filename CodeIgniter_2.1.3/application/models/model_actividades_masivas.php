<?php
 
class Model_actividades_masivas extends CI_Model {
 
	public function agregarActividadMasiva($nombre, $instancias) {
		$this->db->trans_start();

		//0 insertar modulo
		$data = array(
				'NOMBRE_ACT' => $nombre
				);
		$confirmacion0 = $this->db->insert('actividad_masiva', $data);
		
		$id_actividad = $this->db->insert_id();
		
		//4 insertar equipo profesores
		if (is_array($instancias)) {
			foreach($instancias as $instancia) {
				$data = array(
					'FECHA_ACT' => $instancia->fecha,
					'LUGAR_ACT' => $instancia->lugar,
					'ID_ACT' => $id_actividad
					);
				$datos = $this->db->insert('instancia_actividad_masiva', $data);
			}
		}
		//fin inserciones
		
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	

	public function eliminarActividadMasiva($id_actividad) {

		$this->db->trans_start();

		//Elimino el módulo temático
		$this->db->where('ID_ACT', $id_actividad);
		$datos = $this->db->delete('actividad_masiva');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }

    
	public function getAllActividadesMasivas()
	{
		$this->db->select('ID_ACT AS id');
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->order_by('NOMBRE_MODULO','asc');
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getInstanciasActividadMasiva($id_actividad) {
		$this->db->select('FECHA_ACT AS fecha');
		$this->db->select('LUGAR_ACT AS lugar');
		$this->db->select('ID_INSTANCIA_ACTIVIDAD_MASIVA AS id');
		$this->db->where('ID_ACT', $id_actividad);
		$query = $this->db->get('instancia_actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
	public function getActividadesByFilter($texto, $textoFiltrosAvanzados) {
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->select('ID_ACT AS id');
		$this->db->order_by('NOMBRE_ACT', 'asc');

		if ($texto != "") {
			$this->db->where("(NOMBRE_ACT LIKE '%".$texto."%')");
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_NOMBRE", 0);
			$this->db->like("NOMBRE_ACT", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]); //(inutil ya que existe sólo un campo de búsqueda)
		}
		$query = $this->db->get('actividad_masiva');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}
?>