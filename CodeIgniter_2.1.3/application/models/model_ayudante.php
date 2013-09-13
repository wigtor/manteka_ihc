<?php

/**
* Clase que realiza las consultas a la base de datos relacionadas con los ayudantes
* @author Grupo 4
*/
class Model_ayudante extends CI_Model {

	/**
	* Inserta un ayudante en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante a insertar
	* @param string $nombre1_ayudante Primer nombre del ayudante a insertar
	* @param string $nombre2_ayudante Segundo nombre del ayudante a insertar
	* @param string $apellido1_ayudante Primer apellido del ayudante a insertar
	* @param string $apellido2_ayudante Segundo apellido del ayudante a insertar
	* @param string $correo_ayudante Correo del ayudante a insertar
	* @param string $cod_profesor Código del profesor asociado al ayudante
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/	
	public function agregarAyudante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $ruts_profesores) {
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_AYUDANTE,
			'PASSWORD_PRIMARIA' => md5($rut),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1,
			'NOMBRE2' => $nombre2,
			'APELLIDO1' => $apellido1,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $fono,
			'LOGUEABLE' => FALSE
		);
		$data2 = array('RUT_USUARIO' => $rut);

		$this->db->trans_start();
		$datos2 = $this->db->insert('usuario', $data1);
		$datos = $this->db->insert('ayudante', $data2);
		foreach($ruts_profesores as $rut_profe) {
			$data3 = array('RUT_USUARIO' => $rut, 'PRO_RUT_USUARIO' =>$rut_profe);
			$datos = $this->db->insert('ayu_profe', $data3);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }


	/**
	* Eliminar un ayudante de la base de datos
	*
	* Recibe el rut de un ayudante para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function eliminarAyudante($rut_ayudante)
	{
		$this->db->trans_start();
		$this->db->where('RUT_USUARIO', $rut_ayudante);
		$this->db->where('ID_TIPO', TIPO_USR_AYUDANTE);
		$datos= $this->db->delete('usuario');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	/**
	* Obtiene los datos de todos los ayudantes de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada ayudante y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return arreglo de 2 dimensiones que contiene en cada linea la información de un ayudante.
	*/	

		public function getAllAyudantes()
	{
		$this->db->select('RUT_USUARIO AS id');
		$this->db->select('RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS fono');
		$this->db->select('CORREO1_USER AS email1');
		$this->db->select('CORREO2_USER AS email2');
		$this->db->join('usuario', 'ayudante.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->order_by("APELLIDO1", "asc");
		$query = $this->db->get('ayudante');
		if ($query == FALSE) {
			$query = array();
			return $query;
		}
		return $query->result();
	}


	/**
	* Edita la información de un ayudante en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $rut_ayudante Rut del ayudante al que se le actualizan los demás datos
	* @param string $nombre1_ayudante Primer nombre a editar del ayudante
	* @param string $nombre2_ayudante Segundo nombre a editar del ayudante
	* @param string $apellido_paterno Apellido paterno del ayudante
	* @param string $apellido_materno Apellido mateno del ayudante
	* @param string $correo_ayudante Correo a editar del ayudante
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function actualizarAyudante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $ruts_profesores)
	{
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_AYUDANTE,
			'PASSWORD_PRIMARIA' => md5($rut),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1,
			'NOMBRE2' => $nombre2,
			'APELLIDO1' => $apellido1,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $fono,
			'LOGUEABLE' => FALSE
		);

		$this->db->trans_start();
		$this->db->where('ID_TIPO', TIPO_USR_AYUDANTE);
		$this->db->where('RUT_USUARIO', $rut);
		$datos2 = $this->db->update('usuario', $data1);
		/* //PENDIENTE
		foreach($ruts_profesores as $rut_profe) {
			$data3 = array('RUT_USUARIO' => $rut, 'PRO_RUT_USUARIO' =>$rut_profe);
			$datos = $this->db->insert('ayu_profe', $data3);
		}
		*/
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }


	/**
	* Función que obtiene los ayudantes que coinciden con cierta búsqueda
	*
	* Esta función recibe un texto para realizar una búsqueda y un tipo de atributo por el cual filtrar.
	* Se realiza una consulta a la base de datos y se obtiene la lista de ayudantes que coinciden con la búsqueda
	* Esta búsqueda se realiza mediante la sentencia like de SQL.
	*
	* @param int $tipoFiltro Un valor entre 1 a 4 que indica el tipo de filtro a usar.
	* @param string $texto Es el texto que se desea hacer coincidir en la búsqueda
	* @return Se devuelve un array de objetos ayudante con sólo su nombre y rut
	* @author Alex Ahumada
	*/
	public function getAyudantesByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('usuario.RUT_USUARIO AS id');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('NOMBRE_SECCION AS seccion');
		$this->db->join('ayu_profe', 'ayudante.RUT_USUARIO = ayu_profe.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'ayu_profe.ID_SECCION  = seccion.ID_SECCION ', 'LEFT OUTER');
		$this->db->order_by('APELLIDO1_AYUDANTE', 'asc');

		if (trim($texto) != "") {
			$this->db->like("usuario.RUT_USUARIO", $texto);
			$this->db->or_like("NOMBRE1", $texto);
			$this->db->or_like("NOMBRE2", $texto);
			$this->db->or_like("APELLIDO1", $texto);
			$this->db->or_like("APELLIDO2", $texto);
			$this->db->or_like("NOMBRE_SECCION", $texto);
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_RUT", 0);
			define("BUSCAR_POR_NOMBRE", 1);
			define("BUSCAR_POR_APELLIDO", 2);
			define("BUSCAR_POR_SECCION", 3);
			$this->db->like("usuario.RUT_USUARIO", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
				$this->db->where("(NOMBRE1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");
				//$this->db->like("(NOMBRE1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
				//$this->db->or_like("NOMBRE2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
				$this->db->where("(APELLIDO1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
				//$this->db->like("(APELLIDO1_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
				//$this->db->or_like("APELLIDO2_AYUDANTE", $textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_SECCION] != '') {
				$this->db->like("NOMBRE_SECCION", $textoFiltrosAvanzados[BUSCAR_POR_SECCION]);
			}
		}
		$query = $this->db->get('ayudante');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	/**
	* Obtiene los detalles de un ayudante
	* 
	* Se recibe un rut y se hace la consulta para obtener todos los demás atributos del ayudante
	* con ese rut. Los atributos del objeto obtenido son:
	* rut, nombre1, nombre2, apellido1, apellido2, fono, correo, nombre1_profe, nombre2_profe, apellido1_profe, apellido2_profe
	* 
	* @author Alex Ahumada
	* @param int $rut El rut del ayudante que se busca
	* @return Se retorna un objeto cuyos atributos son los atributos del ayudante, FALSE si no se encontró
	*/
	public function getDetallesAyudante($rut) {
		$this->db->select('ayudante.RUT_USUARIO AS id');
		$this->db->select('ayudante.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS fono');
		$this->db->select('CORREO1_USER AS correo');
		$this->db->select('CORREO2_USER AS correo2');
/* //PENDIENTE
		$this->db->select('NOMBRE1_PROFESOR AS nombre1_profe');
		$this->db->select('NOMBRE2_PROFESOR AS nombre2_profe');
		$this->db->select('APELLIDO1_PROFESOR AS apellido1_profe');
		$this->db->select('APELLIDO2_PROFESOR AS apellido2_profe');
*/
		$this->db->select('NOMBRE_SECCION AS seccion');
		$this->db->join('usuario', 'ayudante.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->join('ayu_profe', 'ayudante.RUT_USUARIO = ayu_profe.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'ayu_profe.ID_SECCION  = seccion.ID_SECCION ', 'LEFT OUTER');
		$this->db->join('profesor', 'profesor.RUT_USUARIO = ayu_profe.PRO_RUT_USUARIO', 'LEFT OUTER'); //QUIZÁ DEBA IR AL REVEZ
		$this->db->where('ayudante.RUT_USUARIO', $rut);
		$query = $this->db->get('ayudante');
		if ($query == FALSE) {
		 return array();
		}
		return $query->row();
	}
}

?>
