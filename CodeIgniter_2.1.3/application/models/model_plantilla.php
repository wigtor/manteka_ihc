<?php

/**
 * El presente archivo corresponde al modelo de la tabla 'plantilla' de la base de datos del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Modelos
 * @author Diego Garc�a (DGM)
 **/
 
/**
 * Esta clase implementa los m�todos que interactuan directamente con la tabla 'plantilla' de la base de datos
 * del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Modelos
 * @author Diego Garc�a (DGM)
 **/
class Model_plantilla extends CI_Model
{ 

   /**
    * Obtiene las plantillas existentes en el sistema.
    * 
    * Se realiza una consulta para obtener todas las plantillas almacenadas en el sistema.
	* Se obtienen todos los atributos de las plantillas y los resultados se ordenan alfab�ticamente
	* utilizando los nombres de dichas plantillas.
    * 
    * @author Diego Garc�a (DGM)
    * @return array Retorna un array de arrays, donde cada elemento del array principal corresponde a una plantilla, y
	* 		  		los elementos de los arrays secundarios corresponden a los atributos de las plantillas.
	*		  		Si no existen plantillas en el sistema, la funci�n retorna un array vac�o.
    **/
	public function ObtenerListaPlantillas()
	{
		$plantillas = array();
		$this->db->order_by('NOMBRE_PLANTILLA', 'DESC');
		$query=$this->db->get('plantilla');
		foreach($query->result() as $registro)
			array_push($plantillas, $registro); 
		return $plantillas;
	}
		
   /**
    * Guarda una plantilla en la base de datos.
    * 
    * Se inserta una plantilla en la tabla 'plantilla' de la base de datos.
	* Las validaciones pertinentes se realizan previamente en el controlador asociado a este modelo.
	* Al insertar una plantilla, se asigna autom�ticamente un id interno de tipo auto_increment.
    * 
    * @author Diego Garc�a (DGM)
	* @param string $nombre Corresponde al nombre asignado a la plantilla a guardar.
	* @param string $asunto Corresponde al asunto asignado a la plantilla a guardar.
	* @param string $cuerpo Corresponde al mensaje propiamente tal de la plantilla a guardar.
    * @return int Retorna 1 cuando la inserci�n es exitosa, y un valor distinto de 1 en caso contrario.
    **/
	public function InsertarPlantilla($nombre, $asunto, $cuerpo)
	{
		$data=array(
			'CUERPO_PLANTILLA' => $cuerpo,
			'NOMBRE_PLANTILLA' => $nombre,
			'ASUNTO_PLANTILLA' => $asunto
		);
		return $this->db->insert('plantilla',$data);
	}
	
   /**
    * Elimina una plantilla de la base de datos.
    * 
    * Se elimina una plantilla de la tabla 'plantilla' de la base de datos, utilizando el
	* n�mero identificador (clave primaria) de la plantilla, el cual es obtenido previamente en el controlador
	* asociado a este modelo.
    * 
    * @author Diego Garc�a (DGM)
	* @param int $plantilla Corresponde al n�mero identificador (clave primaria) de la plantilla a eliminar.
    * @return int Retorna 1 cuando la eliminaci�n es exitosa, y un valor distinto de 1 en caso contrario.
    **/
	public function EliminarPlantilla($plantilla)
    {
		return $this->db->delete('plantilla', array('ID_PLANTILLA'=>$plantilla));
    }
		
   /**
    * Actualiza una plantilla de la base de datos.
    * 
    * Se actualiza una plantilla de la tabla 'plantilla' de la base de datos, utilizando el
	* n�mero identificador (clave primaria) para se�alar la plantilla que se desea actualizar.
    * 
    * @author Diego Garc�a (DGM)
	* @param int $idPlantilla Corresponde al n�mero identificador (clave primaria) de la plantilla a actualizar.
	* @param string $nombre Corresponde al nuevo nombre que se asignar� a la plantilla que se va a actualizar.
	* @param string $asunto Corresponde al nuevo asunto que se asignar� a la plantilla que se va a actualizar.
	* @param string $cuerpo Corresponde al nuevo cuerpo del mensaje que se asignar� a la plantilla que se va a actualizar.
    * @return int Retorna 1 cuando la actualizaci�n es exitosa, y un valor distinto de 1 en caso contrario.
    **/
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
	
   /**
    * Verifica si no existe otra plantilla con el mismo nombre que la plantilla se�alada como argumento.
    * 
    * Se consulta si ya existe otra plantilla con el mismo nombre que la plantilla dada como argumento.
	* Si se encuentra una plantilla con el mismo nombre que el se�alado como argumento y su identificador es
	* distinto al identificador se�alado como argumento, entonces se devuelve false, en cualquier otro caso
	* se devuelve true.
    * 
    * @author Diego Garc�a (DGM)
	* @param int $idPlantilla Corresponde al n�mero identificador (clave primaria) de la plantilla a consultar.
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
}
?>