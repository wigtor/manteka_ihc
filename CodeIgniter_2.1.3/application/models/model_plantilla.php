<?php
 
class Model_plantilla extends CI_Model {

	public function ObtenerListaPlantillas()
	{
		$plantillas = array();
		$this->db->order_by('NOMBRE_PLANTILLA', 'DESC');
		$query=$this->db->get('plantilla');
		foreach($query->result() as $registro)
			array_push($plantillas, $registro); 
		return $plantillas;
	}
	//$this->form_validation->set_message('is_unique', 'Ya existe una plantilla con el nombre especificado. Utilice otro nombre.');
	public function InsertarPlantilla($nombre, $asunto, $cuerpo)
	{
		$data=array(
			'CUERPO_PLANTILLA' => $cuerpo,
			'NOMBRE_PLANTILLA' => $nombre,
			'ASUNTO_PLANTILLA' => $asunto
		);
		return $this->db->insert('plantilla',$data);
	}
	
	public function EliminarPlantilla($plantilla)
    {
		return $this->db->delete('plantilla', array('ID_PLANTILLA'=>$plantilla));
    }
	
	public function EditarPlantilla($idPlantilla, $nombre, $asunto, $cuerpo)
	{
		$data=array(
			'CUERPO_PLANTILLA' => $cuerpo,
			'NOMBRE_PLANTILLA' => $nombre,
			'ASUNTO_PLANTILLA' => $asunto
		);
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		return $this->db->update('plantilla', $data);
	}
	
	public function NombreUnico($idPlantilla, $nombrePlantilla)
	{
		$resultado = false;
		$data=array(
			'NOMBRE_PLANTILLA' => $nombrePlantilla
		);
		$query = $this->db->get_where('plantilla', $data);
		if(count($query) == 1)
		{
			$registro = $query->result();
			if(count($registro)>0)
			{
				if($registro['0']->ID_PLANTILLA==$idPlantilla)
					$resultado=true;
			}
			else
				$resultado=true;
		}
		return $resultado;
	}
}

?>