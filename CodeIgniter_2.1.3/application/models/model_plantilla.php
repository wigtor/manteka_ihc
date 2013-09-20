<?php

/**
 * El presente archivo corresponde al modelo de la tabla 'plantilla' de la base de datos del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Modelos
 * @author Diego García (DGM)
 **/
 
/**
 * Esta clase implementa los métodos que interactuan directamente con la tabla 'plantilla' de la base de datos
 * del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Modelos
 * @author Diego García (DGM)
 **/
class Model_plantilla extends CI_Model {

	/**
	* Guarda una plantilla en la base de datos.
	* 
	* Se inserta una plantilla en la tabla 'plantilla' de la base de datos.
	* Las validaciones pertinentes se realizan previamente en el controlador asociado a este modelo.
	* Al insertar una plantilla, se asigna automáticamente un id interno de tipo auto_increment.
	* 
	* @author Diego García (DGM)
	* @param string $nombre Corresponde al nombre asignado a la plantilla a guardar.
	* @param string $asunto Corresponde al asunto asignado a la plantilla a guardar.
	* @param string $cuerpo Corresponde al mensaje propiamente tal de la plantilla a guardar.
	* @return int Retorna 1 cuando la inserción es exitosa, y un valor distinto de 1 en caso contrario.
	**/
	public function agregarPlantilla($rut_usuario, $nombre, $asunto, $cuerpo) {
		$data=array(
			'CUERPO_PLANTILLA' => $cuerpo,
			'NOMBRE_PLANTILLA' => $nombre,
			'ASUNTO_PLANTILLA' => $asunto,
			'RUT_USUARIO' => $rut_usuario,
		);
		$this->db->trans_start();
		$this->db->insert('plantilla',$data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
   /**
    * Elimina una plantilla de la base de datos.
    * 
    * Se elimina una plantilla de la tabla 'plantilla' de la base de datos, utilizando el
	* número identificador (clave primaria) de la plantilla, el cual es obtenido previamente en el controlador
	* asociado a este modelo.
    * 
    * @author Diego García (DGM)
	* @param int $plantilla Corresponde al número identificador (clave primaria) de la plantilla a eliminar.
    * @return int Retorna 1 cuando la eliminación es exitosa, y un valor distinto de 1 en caso contrario.
    **/
	public function eliminarPlantilla($rut_usuario, $id_plantilla) {
		$this->db->trans_start();
		$this->db->where('ID_PLANTILLA', $id_plantilla);
		$this->db->where('RUT_USUARIO', $rut_usuario); //Esto permite que no pueda eliminarse la plantilla de otro
		$this->db->delete('plantilla');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }

		
   /**
    * Actualiza una plantilla de la base de datos.
    * 
    * Se actualiza una plantilla de la tabla 'plantilla' de la base de datos, utilizando el
	* número identificador (clave primaria) para señalar la plantilla que se desea actualizar.
    * 
    * @author Diego García (DGM)
	* @param int $idPlantilla Corresponde al número identificador (clave primaria) de la plantilla a actualizar.
	* @param string $nombre Corresponde al nuevo nombre que se asignará a la plantilla que se va a actualizar.
	* @param string $asunto Corresponde al nuevo asunto que se asignará a la plantilla que se va a actualizar.
	* @param string $cuerpo Corresponde al nuevo cuerpo del mensaje que se asignará a la plantilla que se va a actualizar.
    * @return int Retorna 1 cuando la actualización es exitosa, y un valor distinto de 1 en caso contrario.
    **/
	public function editarPlantilla($rut_usuario, $id_plantilla, $nombre, $asunto, $cuerpo) {
		$data = array(
			'CUERPO_PLANTILLA' => $cuerpo,
			'NOMBRE_PLANTILLA' => $nombre,
			'ASUNTO_PLANTILLA' => $asunto
		);
		$this->db->trans_start();
		$this->db->where('ID_PLANTILLA', $id_plantilla);
		$this->db->where('RUT_USUARIO', $rut_usuario); //Esto permite que no pueda editarse la plantilla de otro
		$this->db->update('plantilla', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


   /**
    * Verifica si no existe otra plantilla con el mismo nombre que la plantilla señalada como argumento.
    * 
    * Se consulta si ya existe otra plantilla con el mismo nombre que la plantilla dada como argumento.
	* Si se encuentra una plantilla con el mismo nombre que el señalado como argumento y su identificador es
	* distinto al identificador señalado como argumento, entonces se devuelve false, en cualquier otro caso
	* se devuelve true.
    * 
    * @author Diego García (DGM)
	* @param int $idPlantilla Corresponde al número identificador (clave primaria) de la plantilla a consultar.
	* @param string $nombre Corresponde al nombre de la plantilla a consultar.
    * @return boolean $resultado Retorna false si ya existe otra plantilla con el mismo nombre de la plantilla a consultar, y true en caso contrario.
    **/
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


		/**
	* Obtiene las plantillas existentes en el sistema.
	* 
	* 
	**/
	public function getPlantillasByFilter($rut_usuario, $texto, $textoFiltrosAvanzados) {
		$this->db->select('NOMBRE_PLANTILLA AS nombre');
		$this->db->select('ASUNTO_PLANTILLA AS asunto');
		$this->db->select(' CONCAT( SUBSTRING(CUERPO_PLANTILLA ,1,20 ), \'...\') AS cuerpo', false);
		$this->db->select('plantilla.ID_PLANTILLA AS id');
		$this->db->where('RUT_USUARIO', $rut_usuario);
		$this->db->order_by('NOMBRE_PLANTILLA', 'DESC');

		if ($texto != "") {
			$this->db->like("ASUNTO_PLANTILLA", $texto);
			$this->db->or_like("NOMBRE_PLANTILLA", $texto);
			$this->db->or_like("CUERPO_PLANTILLA", $texto);
		}

		else {
			
			//Sólo para acordarse
			define("BUSCAR_POR_NOMBRE", 0);
			define("BUSCAR_POR_ASUNTO", 1);
			define("BUSCAR_POR_CUERPO", 2);
			
			if($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != ''){
				$this->db->like("NOMBRE_PLANTILLA", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_ASUNTO] != ''){
				$this->db->like("ASUNTO_PLANTILLA", $textoFiltrosAvanzados[BUSCAR_POR_ASUNTO]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_CUERPO] != ''){
				$this->db->like("CUERPO_PLANTILLA", $textoFiltrosAvanzados[BUSCAR_POR_CUERPO]);
			}
		}

		$query = $this->db->get('plantilla');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getDetallesPlantilla($rut_usuario, $id_plantilla) {
		$this->db->select('plantilla.ID_PLANTILLA AS id');
		$this->db->select('ASUNTO_PLANTILLA AS asunto');
		$this->db->select('NOMBRE_PLANTILLA AS nombre');
		$this->db->select('CUERPO_PLANTILLA AS cuerpo');
		$this->db->where('RUT_USUARIO', $rut_usuario);
		$this->db->where('ID_PLANTILLA', $id_plantilla);
		$this->db->order_by('NOMBRE_PLANTILLA', 'DESC');
		$query = $this->db->get('plantilla');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}
}

?>