<?php

/**
* Clase que realiza las consultas a la base de datos relacionadas con los historiales de búsqueda
* @author Grupo 1
*/
class model_busquedas extends CI_Model {
   
 	/**
 	* Función que retorna las palabras de las búsquedas realizadas anteriormente
 	* 
 	* @param string $letras Es la palabra que se ha introducido para buscar
 	* @param int $rut Es el rut del usuario que está realizando la búsqueda
 	* @param string $tipo_busqueda Es el tipo de búsqueda en que se está realizando (coordinadores, profesores, ayudantes, correos, etc)
 	* @author Víctor Flores
 	*/
	function getBusquedasAnteriores($letras, $rut, $tipo_busqueda) {
		$this->db->select('PALABRA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('TIPO_BUSQUEDA', $tipo_busqueda);
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
	}

	/**
	* Función que agrega al historial de búsqueda una nueva entrada o actualiza el timestamp de alguna ya existente
	* 
	* Primero se comprueba que el texto introducido no es vacio, de esta forma nunca se almacenan estas búsquedas sin texto
	* Se Comprueba si el texto buscado ya está en alguna busqueda anterior, si ya existe entonces se hace update cambiando el 
	* timestamp de la búsqueda a la fecha y hora actual, en caso de que no exista se realiza un insert a la tabla usando el timestamp actual
	* 
	* @param string $texto Es el texto que se ha introducido en la búsqueda
	* @param string $tipo_busqueda Es el tipo de búsqueda que se está realizando, sobre que datos (coordinadores, profesores, ayudantes, correos, etc)
	* @param int $rutUsuario Es el rut del usuario que está realizando la búsqueda
	*/
	function insertarNuevaBusqueda($texto, $tipo_busqueda, $rutUsuario) {
		if (trim($texto) == '') {
			return ; //Se descartan las búsquedas vacias
		}
 		$this->db->select('ID');
		$this->db->where('RUT_USUARIO', $rutUsuario);
		$this->db->where('PALABRA', $texto);
		$this->db->where('TIPO_BUSQUEDA', $tipo_busqueda);
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