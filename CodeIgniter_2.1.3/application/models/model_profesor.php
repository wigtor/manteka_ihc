<?php

class Model_profesor extends CI_Model {

	/**
	* Obtiene una lista con todos los profesores y su informacion de usuario.
	*
	* Obtiene una listac con todos los profesores uniendo su informacion con la presente en la tabla usuarios.
	*
	* @param none
	* @return array datos de los profesores
	*/
	function getAllProfesores() {
		$this->db->select('profesor.RUT_USUARIO AS id');
		$this->db->select('profesor.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE1 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS fono');
		$this->db->select('CORREO1_USER AS email1');
		$this->db->select('CORREO2_USER AS email2');
		$this->db->join('usuario', 'profesor.RUT_USUARIO = usuario.RUT_USUARIO');
		$query = $this->db->get('profesor');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	* Inserta un profesor en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos', esto corresponde a la inserción en la tabla usuarios. Siguiente se debe insertar en la tabla profesores, donde se repite el procedimiento. 
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_profesor Rut del profesor a insertar
	* @param string $nombre1_profesor Primer nombre del profesor a insertar
	* @param string $nombre2_profesor Segundo nombre del profesor a insertar
	* @param string $apellido1_profesor Primer apellido del profesor a insertar
	* @param string $apellido2_profesor Segundo apellido del profesor a insertar
	* @param string $correo_profesor Correo del profesor a insertar
	* @param string $correo_profesor1 Correo Alternativo del profesor a insertar
	* @param string $telefono_profesor Telefono del profesor a insertar
	* @param string $tipo_profesor Tipo del profesor a insertar
	* @return boolean TRUE o FALSE en caso de éxito o fracaso en la operación
	*/
	public function agregarProfesor($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $tipo_profesor) {
		
		$pass = $rut;
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_PROFESOR,
			'PASSWORD_PRIMARIA' => md5($pass),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1,
			'NOMBRE2' => $nombre2,
			'APELLIDO1' => $apellido1,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $telefono,
			'LOGUEABLE' => TRUE
		);
		$data2 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO_PROFESOR' => $tipo_profesor
		);

		$this->db->trans_start();
		$datos2 = $this->db->insert('usuario', $data1);

		$datos = $this->db->insert('profesor', $data2);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    
    }


    public function rutExiste($rut) {
		$this->db->select('COUNT(RUT_USUARIO) AS resultado');
		$query = $this->db->where('RUT_USUARIO', $rut);
		$query = $this->db->get('usuario');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
    }


    public function getTiposProfesores() {
    	$this->db->select('ID_TIPO_PROFESOR AS id');
		$this->db->select('TIPO_PROFESOR AS nombre_tipo');
		$query = $this->db->get('tipo_profesor');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
    }


	/**
	* Edita la información de un profesor en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $run_profe Rut del profesor al que se le actualizan los demás datos
	* @param string $telefono_profe Correo a editar del profesor
	* @param string $tipo_profe Correo a editar del profesor
	* @param string $nom1 Primer nombre a editar del profesor
	* @param string $nom2 Segundo nombre a editar del profesor
	* @param string $ape1 Apellido paterno del profesor
	* @param string $ape2 Apellido mateno del profesor
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function actualizarProfesor($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $tipo_profe, $resetPass)
    {
    	$datos1 = array(
				'NOMBRE1' => $nombre1,
				'NOMBRE2' => $nombre2,
				'APELLIDO1' => $apellido1,
				'APELLIDO2' => $apellido2,
				'TELEFONO' => $telefono,
				'CORREO1_USER' => $correo1,
				'CORREO2_USER' => $correo2);
		if($resetPass){
			$datos1['PASSWORD_PRIMARIA'] = md5($rut);
		}

		$this->db->trans_start();

		$this->db->where('ID_TIPO', TIPO_USR_PROFESOR);
		$this->db->where('RUT_USUARIO', $rut);
		$res = $this->db->update('usuario', $datos1);

		$this->db->where('RUT_USUARIO',$rut);
		$res = $this->db->update('profesor', array('ID_TIPO_PROFESOR' => $tipo_profe));

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }


	/**
	*Obtiene todos los datos de un profesor en específico desde la base de datos
	*
	*Se genera una consulta en la cual se busca un  rut de un profesor determinado. Una vez que se encuentra, se guarda en un arreglo.
	*
	*@param string $rut corresponde al rut del profesor del cual se quieren obtener los datos
	*@return se retorna la fila que contiene la información correspondiente al profesor buscato.
	*/
	public function getDetallesProfesor($rut) {
		$this->db->select('usuario.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS telefono');
		$this->db->select('profesor.ID_TIPO_PROFESOR AS id_tipo_profesor');
		$this->db->select('TIPO_PROFESOR AS tipo_profesor');
		$this->db->select('CORREO1_USER AS correo1');
		$this->db->select('CORREO2_USER AS correo2');
		//$this->db->select('GROUP_CONCAT( NOMBRE_MODULO) AS moduloTem');
		$this->db->select('NOMBRE_MODULO AS moduloTem');
		//$this->db->select('GROUP_CONCAT( NOMBRE_SECCION) AS seccion');
		$this->db->select('NOMBRE_SECCION AS seccion');
		$this->db->join('usuario', 'profesor.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->join('tipo_profesor', 'profesor.ID_TIPO_PROFESOR = tipo_profesor.ID_TIPO_PROFESOR');
		$this->db->join('profesor_seccion', 'profesor.RUT_USUARIO = profesor_seccion.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'profesor_seccion.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('sesion_de_clase', 'seccion.ID_SECCION = sesion_de_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->join('modulo_tematico', 'sesion_de_clase.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->where('profesor.RUT_USUARIO', $rut);
		//$this->db->group_by('RUT_USUARIO');
		$query = $this->db->get('profesor');
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}

	public function getProfesoresByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('profesor.RUT_USUARIO AS id');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('APELLIDO1 AS apellido1');
		//$this->db->select('GROUP_CONCAT( NOMBRE_MODULO) AS moduloTem');
		$this->db->select('NOMBRE_MODULO AS moduloTem');
		//$this->db->select('GROUP_CONCAT( NOMBRE_SECCION) AS seccion');
		$this->db->select('NOMBRE_SECCION AS seccion');
		$this->db->join('usuario', 'profesor.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->join('tipo_profesor', 'profesor.ID_TIPO_PROFESOR = tipo_profesor.ID_TIPO_PROFESOR');
		$this->db->join('profesor_seccion', 'profesor.RUT_USUARIO = profesor_seccion.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'profesor_seccion.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('sesion_de_clase', 'seccion.ID_SECCION = sesion_de_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->join('modulo_tematico', 'sesion_de_clase.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM', 'LEFT OUTER');
		//$this->db->group_by('profesor.RUT_USUARIO');
		$this->db->order_by('APELLIDO1', 'asc');

		if ($texto != "") {
			$this->db->like("profesor.RUT_USUARIO", $texto);
			$this->db->or_like("NOMBRE1", $texto);
			$this->db->or_like("NOMBRE2", $texto);
			$this->db->or_like("APELLIDO1", $texto);
			$this->db->or_like("APELLIDO2", $texto);
			$this->db->or_like("NOMBRE_MODULO", $texto);
		}

		else {
			
			//Sólo para acordarse
			define("BUSCAR_POR_RUT", 0);
			define("BUSCAR_POR_NOMBRE", 1);
			define("BUSCAR_POR_APELLIDO", 2);
			define("BUSCAR_POR_MOD_TEM", 3);
			define("BUSCAR_POR_SECCION", 4);
			
			if($textoFiltrosAvanzados[BUSCAR_POR_RUT] != ''){
				$this->db->like("profesor.RUT_USUARIO", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			}
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
			if($textoFiltrosAvanzados[BUSCAR_POR_MOD_TEM] != '') {
				$this->db->like("NOMBRE_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_MOD_TEM]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_SECCION] != '') {
				$this->db->like("NOMBRE_SECCION", $textoFiltrosAvanzados[BUSCAR_POR_SECCION]);
			}
		}
		$query = $this->db->get('profesor');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	
	/**
	* Eliminar un profesor de la base de datos
	*
	* Recibe el rut de un profesor para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $rut_profesor Rut del profesor que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function eliminarProfesor($rut_profesor)
    {
		$this->db->where('RUT_USUARIO', $rut_profesor);
		$this->db->where('ID_TIPO', TIPO_USR_PROFESOR);
		$res = $this->db->delete('usuario');
		return $res;
    }


}

?>
