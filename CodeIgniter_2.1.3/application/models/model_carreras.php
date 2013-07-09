<?php
	
/**
 * Modelo para operar sobre los datos referentes a los grupos
 * de contacto del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información.
 */
class model_carreras extends CI_Model{
	public $cod_carrera = 0;
	var $nombre_carrera= '';
     public function VerTodasCarreras()
	{
		

		$this->db->select('carrera.COD_CARRERA AS cod');
		$this->db->select('carrera.NOMBRE_CARRERA AS nombre');
		$this->db->from('carrera');
		$this->db->order_by("NOMBRE_CARRERA", "asc");
		$query =$this->db->get();
		$datos=$query->result();

		$lista=array();

		$contador=0;
			if($datos != false){
				foreach ($datos as $row) {
					$lista[$contador]=array();
					$lista[$contador][0]=$row->cod;
					$lista[$contador][1]=$row->nombre;
					$contador=$contador+1;
				}
			}
		return $lista;
	}

}
?>
