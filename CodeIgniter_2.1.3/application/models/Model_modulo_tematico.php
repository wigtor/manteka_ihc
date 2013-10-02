<?php
 
class Model_modulo_tematico extends CI_Model {
 
	/** 
	* Obtiene la lista de profesores de un equipo determinado
	*
	* @param int $cod_equipo codigo del equipo de profesores que se quiere obtener
	* @return $profes lista de profesores que peretencen al equipo
	*/	
	public function getProfesEquipo($id_equipo){
		$this->db->select('*');
		$this->db->from('profesor');
		$query = $this->db->get();	
		$datos = $query->result();
		$contador = 0;
		$profes = array();
		foreach ($datos as $row) {  
			$profes[$contador] = array();
			$profes[$contador][0] = "";
			$profes[$contador][1] = $row->RUT_USUARIO2;
			$profes[$contador][2] = $row->NOMBRE1_PROFESOR;
			$profes[$contador][3] = $row->NOMBRE2_PROFESOR;
			$profes[$contador][4] = $row->APELLIDO1_PROFESOR;
			$profes[$contador][5] = $row->APELLIDO2_PROFESOR;
			$profes[$contador][6] = 0;
			$profes[$contador][7] = -1;
			$profes[$contador][8] = -1;
			$contador = $contador + 1;
		}
		
		$this->db->select('*');
		$this->db->from('profe_equi_lider');
		//$this->db->where('COD_EQUIPO', $cod_equipo); 
		$query = $this->db->get();	
		$datos = $query->result();
		
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_EQUIPO;
			$lista[$contador][1] = $row->RUT_USUARIO2;
			$lista[$contador][2] = $row->LIDER_PROFESOR;
			$contador = $contador + 1;
		}
		$contador = 0;
		$contador2 = 0;
		while($contador < count($profes)){
			$profes[$contador][9] = 0;
			while($contador2 < count($lista)){
				if($profes[$contador][1] == $lista[$contador2][1]){
					if($profes[$contador][9] == 0){
						$profes[$contador][0] = $lista[$contador2][0];
						$profes[$contador][6] = $lista[$contador2][2];
						$profes[$contador][9]++;
					}
					else{
						$profes[$contador][7] = $lista[$contador2][0];
						$profes[$contador][8] = $lista[$contador2][2];					
					}
				}
				$contador2++;
			}
			$contador2 = 0;
			$contador++;
		}
		return $profes;
	}
	
	/**
	*
	* Obtiene la lista de los modulos con su información
	*
	* @return $lista contiene la lista de modulos tematicos con toda su información
	*/
	public function getAllModulosTematicos() {
		$this->db->select('ID_MODULO_TEM AS id');
		$this->db->select('NOMBRE_MODULO AS nombre');
		$this->db->select('DESCRIPCION_MODULO AS descripcion');
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
	/**
	*
	* Obtiene la lista de los profesores que pertenecen a algún equipo
	*
	* @return $lista lista con todos lo profes que pertencen a un equipo
	*
	*/
	public function getEquipoModuloTematico(){
		$this->db->select('*');
		$this->db->from('profesor');
		$this->db->join('profe_equi_lider', 'profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2');
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_EQUIPO;
			$lista[$contador][1] = $row->RUT_USUARIO2;
			$lista[$contador][2] = $row->NOMBRE1_PROFESOR;
			$lista[$contador][3] = $row->NOMBRE2_PROFESOR;
			$lista[$contador][4] = $row->APELLIDO1_PROFESOR;
			$lista[$contador][5] = $row->APELLIDO2_PROFESOR;
			$contador = $contador + 1;
		}
		return $lista;
	}
	

	public function getAllImplementos(){
		$this->db->select('ID_IMPLEMENTO AS id');
		$this->db->select('NOMBRE_IMPLEMENTO AS nombre');
		$this->db->select('DESCRIPCION_IMPLEMENTO AS descripcion');
		$query = $this->db->get('implemento');	
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	
	/**
	*
	* Inserta un nuevo módulo en la BD
	* 
	* Crea un nuevo modulo temático en la base de datos con los datos entregados como parametros
	*
	* @param string $nombre_modulo nombre del nuevo modulo
	* @param string $descripcion_modulo descripción del nuevo módulo
	* @param $profesor_lider profesor lider del nuevo módulo
	* @param $equipo_profesores equipo de profesores del nuevo modulo
	* @param $requisitos requisitos del nuevo modulo
	* @return 1 en caso de exito 
	* @return -1 en caso de fallo
	*
	*/
	public function agregarModulo($nombre, $descripcion, $profesor_lider, $equipo_profesores, $implementos) {
		$this->db->trans_start();

		//0 insertar modulo
		$data = array(
				'NOMBRE_MODULO' => $nombre,
				'DESCRIPCION_MODULO' => $descripcion 
				);
		$confirmacion0 = $this->db->insert('modulo_tematico', $data);
		
		$id_modulo = $this->db->insert_id();
		
		//1 insertar equipo
		$data = array(
				'ID_MODULO_TEM' => $id_modulo
			);
		$confirmacion1 = $this->db->insert('equipo_profesor', $data);
		
		$id_equipo = $this->db->insert_id();
		
		//3 insertar lider del equipo
		$data = array(
				'RUT_USUARIO' => $profesor_lider,
				'ID_EQUIPO' => $id_equipo,
				'LIDER_PROFESOR' => TRUE 
				);
		$datos = $this->db->insert('profe_equi_lider', $data);

		//4 insertar equipo profesores
		if (is_array($equipo_profesores)) {
			foreach($equipo_profesores as $rut_profe) {
				$data = array(
					'RUT_USUARIO' => $rut_profe,
					'ID_EQUIPO' => $id_equipo,
					'LIDER_PROFESOR' => FALSE
					);
				$datos = $this->db->insert('profe_equi_lider', $data);
			}
		}

		//5 insertar implementos requisito modulo
		if (is_array($implementos)) {
			foreach($implementos as $id_impl) {
				$data = array(
						'ID_IMPLEMENTO' => $id_impl,
						'ID_MODULO_TEM' => $id_modulo
						);
				$datos = $this->db->insert('implementos_modulo_tematico', $data);
			}
		}

		//6 insertar evaluación para ese módulo
		$data = array(					
				'ID_MODULO_TEM' => $id_modulo
			);
		$datos = $this->db->insert('evaluacion', $data);
		//fin inserciones
		
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
	* Elimina un módulo de la BD
	*
	* 
	* 
	* @param int $id_modulo codigo del moduo que se eliminará
	* @return 1 en caso de eliminarse exitosamente
	* @return -1 en caso de fallar la consulta 
	**/
	public function eliminarModulo($id_modulo) {

		$this->db->trans_start();

		//Elimino el equipo
		//$this->db->where('ID_MODULO_TEM', $id_modulo);
		//$datos = $this->db->delete('equipo_profesor');

		//Elimino las sesiones
		//$this->db->where('ID_MODULO_TEM', $id_modulo);
		//$datos = $this->db->delete('sesion_de_clase');

		//Elimino el módulo temático
		$this->db->where('ID_MODULO_TEM', $id_modulo);
		$datos = $this->db->delete('modulo_tematico');

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
	* Obtiene la lista de los modulos con su información
	*
	* 
	* @return $query->result() en caso de encontrarse los modulos
	* @return array() en caso de fallar la consulta
	*
	*/
	public function getAllModulos()
	{
		$this->db->select('ID_MODULO_TEM AS id');
		$this->db->select('NOMBRE_MODULO AS nombre');
		$this->db->select('DESCRIPCION_MODULO AS descripcion');
		$this->db->order_by('NOMBRE_MODULO','asc');
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
	/**
	*
	* Edita la información de un módulo en especifico
	*
	* Cambia la informacion de la base de datos de un modulo tematico determiando 
	* en $cod_mod por la información entregada como parametro en $nombre_modulo,$sesiones,
	* $descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos,$cod_equipo
	* 
	* @param string $nombre_modulo nuevo nombre del modulo temático
	* @param $sesiones nuevas sesiones del modulo temático
	* @param string $descripcion_modulo nueva descripción del modulo temático
	* @param string $profesor_lider nuevo pfofesor lider del modulo temático
	* @param $equipo_profesores nuevo equipo de profesores del modulo temático
	* @param $requisitos nuevos requisitos del modulo temático
	* @param int $cod_equipo nuevo codigo del equipo de profesores del modulo temático
	* @param int $cod_mod codigo del modulo temático a editar
	* @return 1 en caso de exito 
	* @return -1 en caso de fallo
	*
	*/
	public function editarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos, $cod_equipo, $cod_mod){
		//0 insertar modulo
		$data = array(					
				'NOMBRE_MODULO' => $nombre_modulo ,
				'DESCRIPCION_MODULO' => $descripcion_modulo 
				);
		$this->db->where('ID_MODULO_TEM', $cod_mod);
		$confirmacion0 = $this->db->update('modulo_tematico',$data);

		//2 actualizar equipo profesores
		$this->db->delete('profe_equi_lider', array('COD_EQUIPO' => $cod_equipo)); 
		
		$contador = 0;
		$confirmacion2 = true;
		while ($contador<count($equipo_profesores)){
		$data = array(					
				'RUT_USUARIO2' => $equipo_profesores[$contador],
				'COD_EQUIPO' => $cod_equipo,
				'LIDER_PROFESOR' => 0 
				);
		$datos = $this->db->insert('profe_equi_lider',$data);
			if($datos != true){
				$confirmacion2 = false;
			}

		$contador = $contador + 1;
		}
		$data = array(					
				'RUT_USUARIO2' => $profesor_lider,
				'COD_EQUIPO' => $cod_equipo,
				'LIDER_PROFESOR' => 1 
				);
		$datos = $this->db->insert('profe_equi_lider',$data);
		
		//3 asignar modulo a sesiones
		$this->db->select('COD_SESION');//desde acá para sacar mod tem =  cod_mod de sesiones
		$this->db->select('ID_MODULO_TEM');
		$this->db->from('sesion');
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_SESION;
			$lista[$contador][1] = $row->ID_MODULO_TEM;
			$contador = $contador + 1;
		}
		$contador = 0;
		while($contador < count($lista)){
			if($lista[$contador][1] == $cod_mod){
				$data = array(		
					'ID_MODULO_TEM' => null
				);
				$this->db->where('COD_SESION', $lista[$contador][0]);
				$this->db->update('sesion',$data);		
			}
			$contador++;
		}
		//hasta aca
		$contador = 0;
		
		$confirmacion3 = true;
		while ($contador<count($sesiones)){
		$data = array(					
				'ID_MODULO_TEM' => $cod_mod
				);
				$this->db->where('COD_SESION', $sesiones[$contador]);
				$datos = $this->db->update('sesion',$data);

			if($datos != true){
				$confirmacion3 = false;
			}

			$contador = $contador + 1;
		}
		
		//requisitos
		$this->db->delete('requisito_modulo', array('ID_MODULO_TEM' => $cod_mod)); 
				
		$contador = 0;
		$confirmacion5 = true;
		if($requisitos != null){
			while ($contador<count($requisitos)){
				$data = array(					
						'COD_REQUISITO' => $requisitos[$contador],
						'ID_MODULO_TEM' => $cod_mod
						);
				$datos = $this->db->insert('requisito_modulo',$data);
					if($datos != true){
						$confirmacion5 = false;
					}

				$contador = $contador + 1;
		}
		}
		//fin inserciones
		if( $confirmacion0 == false  || $confirmacion2 == false || $confirmacion3 == false || $confirmacion5 == false){
			return -1;
			}
		return 1;
	}

	/**
	*
	* Obtiene la lista de las sesiones asociadas a un cierto módulo
	*
	* Se obtiene la lista de sesiones correspondientes a un módulo temático a traves de una consulta la base de datos
	* utilizando avtive record
	*
	* @param int $cod_mod codigo del módulo temático 
	* @return $query->result() en caso de encontrarse las sesiones
	* @return array() en caso de fallar la consulta
	*****/
	public function getSesionesByModuloTematico($id_mod) {
		$this->db->select('ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->where('ID_MODULO_TEM', $id_mod);
		$query = $this->db->get('sesion_de_clase');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();	
	}

	/**
	*
	* Obtiene la lista de los profesores que son parte de un equipo en especifico
	*
	* Se consulta a la base de datos por medio de active record la lista de profesores que pertenecen al equipo
	* que dicta dicho modulo
	*
	* @param int $cod_equipo codigo del equipo que dicta un modulo
	* @return $query->result() en caso de encontrarse el equipo
	* @return array() en caso de fallar la consulta
	*/
	public function getProfesoresByModuloTematico($id_mod){
		$this->db->select('usuario.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('LIDER_PROFESOR AS esLider');
		$this->db->join('profe_equi_lider', 'usuario.RUT_USUARIO = profe_equi_lider.RUT_USUARIO');
		$this->db->join('equipo_profesor', 'profe_equi_lider.ID_EQUIPO = equipo_profesor.ID_EQUIPO');
		$this->db->where('equipo_profesor.ID_MODULO_TEM', $id_mod); 
		$query = $this->db->get('usuario');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	*
	* Obtiene la  lista de los requisitos de cierto módulo
	*
	* Se consulta a la base de datos por los requisito del modulo cuyo codigo es el parametro $cod_mod
	* de existir dichos requisito se retornan y de no existir se retorna un array vacío
	*  
	* @param int $cod_mod codigo del modulo para el que se obtiene sus requisistos 
	* @return $query->result() en caso de encontrarse requisitos
	* @return array() en caso de fallar la consulta
	*/
	public function getImplementosByModulo($id_mod) {
		$this->db->select('implemento.ID_IMPLEMENTO AS id');
		$this->db->select('NOMBRE_IMPLEMENTO AS nombre');
		$this->db->select('DESCRIPCION_IMPLEMENTO AS descripcion');
		$this->db->join('implementos_modulo_tematico', 'implementos_modulo_tematico.ID_IMPLEMENTO = implemento.ID_IMPLEMENTO');
		$this->db->where('implementos_modulo_tematico.ID_MODULO_TEM', $id_mod); 
		$query = $this->db->get('implemento');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getAllProfesoresWhitoutEquipo() {
		$this->db->select('profe_equi_lider.RUT_USUARIO');
		$this->db->select('profesor.RUT_USUARIO AS id');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->join('usuario', 'profesor.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->join('profe_equi_lider', 'profesor.RUT_USUARIO = profe_equi_lider.RUT_USUARIO', 'LEFT OUTER');
		$this->db->where('profe_equi_lider.RUT_USUARIO IS NULL', null, false);
		//$this->db->where('profesor.RUT_USUARIO', $rut);
		$this->db->order_by("APELLIDO1", "asc");
		$query = $this->db->get('profesor');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			$query = array();
			return $query;
		}
		return $query->result();
	}


	/**
	* Función que obtiene los modulos que coinciden con cierta búsqueda
	*
	* Esta función recibe un texto para realizar una búsqueda y un tipo de atributo por el cual filtrar.
	* Se realiza una consulta a la base de datos y se obtiene la lista de ayudantes que coinciden con la búsqueda
	* Esta búsqueda se realiza mediante la sentencia like de SQL.
	*
	* @param int $tipoFiltro Un valor entre 1 a 4 que indica el tipo de filtro a usar.
	* @param string $texto Es el texto que se desea hacer coincidir en la búsqueda
	* @return Se devuelve un array de objetos modulos
	* @author Alex Ahumada
	*/
	public function getModulosByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('NOMBRE_MODULO AS nombre');
		$this->db->select(' CONCAT( SUBSTRING(DESCRIPCION_MODULO ,1, 20 ), \'...\') AS descripcion', false);
		$this->db->select('ID_MODULO_TEM AS id');
		$this->db->order_by('NOMBRE_MODULO', 'asc');

		if (trim($texto) != "") {
			$this->db->like("NOMBRE_MODULO", $texto);
			$this->db->or_like("DESCRIPCION_MODULO", $texto);
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_NOMBRE", 0);
			define("BUSCAR_POR_DESCRIPCION", 1);
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
				$this->db->like("NOMBRE_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]);
			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_DESCRIPCION] != '') {
				$this->db->like("DESCRIPCION_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_DESCRIPCION]);
			}
		}
		$query = $this->db->get('modulo_tematico');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
   }

   /**
   * Obtiene el detalle de un modulo tematico
   * 
   * Realiza una consulta a la base de datos para obtener el detalle del modulo con el codigo contenido en $id_modulo 
   * luego si no se encuentra retorna un array vacio y si tiene exito la fila con el detalle
   *
   * @param int $id_modulo codigo del modulo que se quiere obtener el detalle
   * @return array() array vacío en caso de fallar
   * @return $query->row() fila con los datos del detalle del modulo solicitado
   *
   **/
	public function getDetallesModulo($id_modulo)
	{
		$this->db->select('modulo_tematico.ID_MODULO_TEM AS id_mod');
		$this->db->select('equipo_profesor.ID_EQUIPO AS id_equipo');
		$this->db->select('NOMBRE_MODULO AS nombre_modulo');
		$this->db->select('DESCRIPCION_MODULO AS descripcion_modulo');
		$this->db->select('NOMBRE1 AS nombre1_profe_lider');
		$this->db->select('NOMBRE2 AS nombre2_profe_lider');
		$this->db->select('APELLIDO1 AS apellido1_profe_lider');
		$this->db->select('APELLIDO2 AS apellido2_profe_lider');
		$this->db->select('usuario.RUT_USUARIO AS rut_profe_lider');
		$this->db->join('equipo_profesor', 'modulo_tematico.ID_MODULO_TEM = equipo_profesor.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('profe_equi_lider', 'equipo_profesor.ID_EQUIPO = profe_equi_lider.ID_EQUIPO', 'LEFT OUTER');
		$this->db->join('usuario', 'profe_equi_lider.RUT_USUARIO = usuario.RUT_USUARIO', 'LEFT OUTER');
		$this->db->where('modulo_tematico.ID_MODULO_TEM', $id_modulo);
		$this->db->where('LIDER_PROFESOR', TRUE);
		$this->db->order_by('NOMBRE_MODULO', 'asc');
		$query = $this->db->get('modulo_tematico');
		//echo $this->db->last_query(). '    ';
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}
}
?>