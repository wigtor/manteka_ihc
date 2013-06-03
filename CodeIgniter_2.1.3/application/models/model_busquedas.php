<?php
class model_busquedas extends CI_Model {
   

	function getBusquedasAnteriores($letras, $rut) {
		$this->db->select('PALABRA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->order_by('TIMESTAMP_BUSQUEDA', 'asc');
		$this->db->like('PALABRA', $letras);
		$query = $this->db->get('historiales_busqueda');
		if ($query == FALSE) {
			return array();
		}
		$resultado = $query->result_array();
		$datos = array();
		$contador = 0;		
		foreach ($resultado as $row) {
			$datos[$contador] = $row['PALABRA'];
			$contador = $contador +1;
		}
		return $datos;
		//return array('caca', 'hola', '123', '222', 'chupalo', 'hola mundo');
	}

	function insertarNuevaBusqueda($texto, $tipo_busqueda, $rutUsuario) {
		$this->db->select('ID');
		$this->db->where('RUT_USUARIO', $rutUsuario);
		$this->db->where('PALABRA', $texto);
		$query = $this->db->get('historiales_busqueda');
		if ($query->num_rows() > 0)
			{
   			$row = $query->row();
   			$id = $row->ID;
			$this->db->stop_cache();
			$this->db->flush_cache();
			$this->db->stop_cache();

			$this->db->where('ID', $id);
			$this->db->update('historiales_busqueda', array('TIMESTAMP_BUSQUEDA' => time()));
		}
		else {
			// Se limpia la caché para una nueva consulta
			$this->db->stop_cache();
			$this->db->flush_cache();
			$this->db->stop_cache();
			$this->db->insert('historiales_busqueda', array('PALABRA'=>$texto, 
								'TIPO_BUSQUEDA'=>$tipo_busqueda,
								'RUT_USUARIO'=>$rutUsuario));
		}
	}
}

?>
