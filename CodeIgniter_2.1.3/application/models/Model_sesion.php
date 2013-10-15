<?php

class Model_sesion extends CI_Model {


/**
* Se obtiene el los datos de un seción a partir de su código
*
* Se Realiza la consulta a la db por medio de active record para obtener los datos de la sesión
* correspondientes al codigo indicado como parametro 
*
* @param int $codigo corresponede al codigo de la sesión de la que se quiere obtener sus datos
* @return $query->row() resultado de la consulta que contiene la fila para el $codigo ingresado 
*
**/


public function getDetallesSesion($id_sesion) {
	$this->db->select('ID_SESION AS id');
	$this->db->select('NOMBRE_SESION AS nombre');
	$this->db->select('DESCRIPCION_SESION AS descripcion');
	$this->db->select('modulo_tematico.ID_MODULO_TEM AS id_moduloTematico');
	$this->db->select('NOMBRE_MODULO AS nombre_moduloTematico');
	$this->db->join('modulo_tematico', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
	$this->db->where('ID_SESION', $id_sesion);
	$query = $this->db->get('sesion_de_clase');
	if ($query == FALSE) {
		return array();
	}
	return $query->row();
}
/**
*
* Obtiene sesiones segun el filtro indicado
*
* Se indica un $texto que hace de filtro para los datos de la vista y un $textoFiltrosAvanzados que busca unicamente
* por una columna determinada
*
* @param string $texto
* @param string $textoFiltrosAvanzados
* @return $query->result() en caso de que la consulta resulte exitosa
* @return array() en caso de erro en la consulta retorna un arreglo vacío 
*
**/
public function getSesionesByFilter($texto, $textoFiltrosAvanzados)
{

	$this->db->select('NOMBRE_SESION AS nombre');
	$this->db->select(' CONCAT( SUBSTRING(DESCRIPCION_SESION ,1, 20 ), \'...\') AS descripcion', false);
	$this->db->select('NOMBRE_MODULO AS nombre_moduloTematico');
	$this->db->select('ID_SESION AS id');
	$this->db->join('modulo_tematico', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
	$this->db->order_by('NOMBRE_SESION');

	if ($texto != "") {
		$this->db->like("NOMBRE_SESION", $texto);
		$this->db->or_like("DESCRIPCION_SESION", $texto);
		$this->db->or_like("NOMBRE_MODULO", $texto);
	}
	else {
		//Sólo para acordarse
		define("BUSCAR_POR_NOMBRE_SESION", 0);
		define("BUSCAR_POR_DESCRIPCION_SESION", 1);
		define("BUSCAR_POR_NOMBRE_MODULO", 2);

		if($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_SESION] != ''){
			$this->db->like("NOMBRE_SESION", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_SESION]);
		}
		if($textoFiltrosAvanzados[BUSCAR_POR_DESCRIPCION_SESION] != ''){
			$this->db->like("DESCRIPCION_SESION", $textoFiltrosAvanzados[BUSCAR_POR_DESCRIPCION_SESION]);
		}
		if($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_MODULO] != ''){
			$this->db->like("NOMBRE_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_MODULO]);
		}

	}

	$query = $this->db->get('sesion_de_clase');
	//echo $this->db->last_query();
	if ($query == FALSE) {
		return array();
	}
	return $query->result();
}

	/**
	*
	* Agregar una sesión a la base de datos
	*
	* Se infgresa un nueva sesión en la vase de datos con los datos de los parametros $nombre_sesion y 
	* $descripcion sesión
	*
	* @param string $nombre_sesion es el nombre se la nueva sesión que se agregará
	* @param strin $descripcion_sesion es la descripción de la nueva sesion que se agregará
	* @return 1 si el resultado de la inserción en la base de datos es exitoso
	* @return -1 en caso de que falle la inserción en la base de datos
	**/

	public function agregarSesion($nombre_sesion, $descripcion_sesion, $id_moduloTem) {	 
		$this->db->trans_start();
		$data = array(
			'NOMBRE_SESION' => $nombre_sesion,
			'DESCRIPCION_SESION' => $descripcion_sesion,
			'ID_MODULO_TEM' => $id_moduloTem
			);
		$datos = $this->db->insert('sesion_de_clase',$data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	public function getSesionesByModuloTematico($id_moduloTematico) {
		$this->db->select('ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->where('ID_MODULO_TEM', $id_moduloTematico);
		$query = $this->db->get('sesion_de_clase');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getSesionesPlanificadasBySeccionAndProfesor($id_seccion, $rut_profesor, $esCoordinador = FALSE) {
		$this->db->select('sesion_de_clase.ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if ($esCoordinador == FALSE) {
			$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
			$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->order_by('planificacion_clase.FECHA_PLANIFICADA');
		$query = $this->db->get('sesion_de_clase');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getSesionesPlanificadasBySeccion($id_seccion) {
		$this->db->select('sesion_de_clase.ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$query = $this->db->get('sesion_de_clase');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	*
	* Elimina una sesión de la base de datos
	*
	* elimina la sesión de la base da datos de manteka cuyo codigo es entregado como parametro en $cod eliminar
	*
	* @param int $codEliminar el codigo de la sesión que se eliminará de la base de datos
	* @return 1 en caso de que la operación resulte exitosa
	* @return -1 en caso de que no se pueda realizar la operación correctamente
	**/

    public function eliminarSesion($codEliminar) {
    	$this->db->trans_start();

    	//Eliminar la planificación de clase




    	//Poner a null la sesión en que se encuentren las secciones
    	$this->db->select('ID_SECCION AS id');
    	$this->db->where('ID_SESION', $codEliminar);
    	$query = $this->db->get('seccion');
    	$this->db->flush_cache();//Limpio active record
    	if ($query != FALSE) {
	    	if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$datos = array('ID_SESION' => NULL);
					$this->db->where('ID_SECCION', $row->id);
					$this->db->insert('seccion', $datos);
					$this->db->flush_cache();
				}
			}
		}


    	//Finalmente elimino la sesión
		$this->db->where('ID_SESION', $codEliminar);
		$datos = $this->db->delete('sesion_de_clase');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

    /**
    *
    * Edita una sesión determinada de la base de datos
    *
    * Edita la sesion indicada por $codigo_sesion con los datos entregados en $nombre_sesion y 
    * $descripcion_sesion
    *
    * @param $nombre_sesion corresponde al nuevo nombre asigando a la sesión
    * @param $descripcion_sesion corresponde a la nueva descripcción asinada a ña sesión
    * @param $codigo_sesion corresponde al acodigo de la session que se desea editar
    * @return 1 en caso de que la operacion trermina con éxito
    * @return -1 en caso de que la operacion no se realice correctamente
    **/

    public function editarSesion($id_sesion, $nombre_sesion, $descripcion_sesion, $id_moduloTem) {
		$data = array(
			'NOMBRE_SESION' => $nombre_sesion,
			'DESCRIPCION_SESION' => $descripcion_sesion,
			'ID_MODULO_TEM' => $id_moduloTem
			);
		$this->db->trans_start();
    	$this->db->where('ID_SESION', $id_sesion);
    	$datos = $this->db->update('sesion_de_clase', $data);
    	$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }

    /**
    *
    * comprueba si existe un nombrfe de sesion en la base de datos
    *
    * realiza una consulta por medio de active record a la base da datos para saber la preexistencia del nombre en $nombre 
    * en la base de datos
    *
    * @param string $nombre corresponde al nombre que se quiere comprobar su exitencia en la bd
    * @return 1 en caso de que el nombre no se encuentre en la base de datos
    * @return -1 en caso de que si se encuentra el nombre en la base de datos
    **/

    public function nombreExiste($nombre){
    	$this->db->select('COUNT(ID_SESION) AS resultado', FALSE);
		$query = $this->db->where('NOMBRE_SESION', $nombre);
		$query = $this->db->get('sesion_de_clase');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
    }

     /**
    *
    * comprueba si existe un nombrfe de sesion en la base de datos
    *
    * realiza una consulta por medio de active record a la base da datos para saber la preexistencia del nombre en $nombre 
    * en la base de datos excluyendo el codigo de la sesión que se va a cambiar
    *
    * @param string $nombre corresponde al nombre que se quiere comprobar su exitencia en la bd  
    * @param int $codigo corresponde al codigo que se excluira de las busqueda  
    * @return 0 en caso de que el nombre no se encuentre en la base de datos
    * @return 1 en caso de que si se encuentra el nombre en la base de datos
    **/


    public function nombreExisteEM($nombre, $codigo){
		//$sql="SELECT * FROM sesion ORDER BY COD_SESION";
    	$this->db->select('*');
    	$this->db->from('sesion_de_clase');
    	$this->db->order_by("COD_SESION", "asc"); 
    	$query=$this->db->get();
    	$datos=$query->result();
		//$datos=mysql_query($sql); 
    	$contador = 0;
    	$lista=array();
    	$var=0;
    	if (false != $datos) {
		//while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
    		foreach ($datos as $row) {
    			if($row->COD_SESION!=$codigo){
    				if( $row->NOMBRE_SESION==$nombre){
    					$var=1;
    				}
    			}
    			$contador = $contador + 1;
    		}}
    		return $var;
    	}

    }

    ?>