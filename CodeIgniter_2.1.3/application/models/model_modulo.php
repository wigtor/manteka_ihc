<?php
 
class Model_modulo extends CI_Model {
 
	/** 
	* Obtiene la lista de profesores de un equipo determinado
	*
	* @param int $cod_equipo codigo del equipo de profesores que se quiere obtener
	* @return $profes lista de profesores que peretencen al equipo
	*/	
	public function profesEditarModulo($cod_equipo){
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
	public function VerModulos(){
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_MODULO_TEM;
			$lista[$contador][2] = $row->COD_EQUIPO;
			$lista[$contador][3] = $row->NOMBRE_MODULO;
			$lista[$contador][4] = $row->DESCRIPCION_MODULO;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	/**
	*
	* Obtiene la lista de los profesores que pertenecen a algún equipo
	*
	* @return $lista lista con todos lo profes que pertencen a un equipo
	*
	*/
	public function VerEquipoModulo(){
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
	
	/**
	*
	* Obtiene la lista de los requisitos que estén asociados a algún módulo
	*
	* @return $lista lista de todos los requisitos que estan asicioados con algun módulo
	*/
	public function VerRequisitoModulo(){
		$this->db->select('*');
		$this->db->from('requisito_modulo');
		$this->db->join('requisito', 'requisito.COD_REQUISITO = requisito_modulo.COD_REQUISITO');
		$query = $this->db->get();	
		if ($query == FALSE) {
			return array();
		}
		
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_MODULO_TEM;
			$lista[$contador][1] = $row->COD_REQUISITO;
			$lista[$contador][2] = $row->NOMBRE_REQUISITO;
			$contador = $contador + 1;
		}
		return $lista;
	}

	/**
	*
	* Obtiene la lista de los nombres de todos los módulos
	*
	* @return $lista con todos los nombres de modulos temticos
	*
	*/
	public function listaNombreModulos(){	
  		$query = $this->db->get('modulo_tematico');	
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
   		$lista = array();
   		$contador = 0;
   		foreach ($datos as $row) {
   			$lista[$contador] = $row->NOMBRE_MODULO;
            $contador++;
   		}
   		return $lista;  	
	}
	
	/**
	* Obtiene la lista de todas las sesiones de la bd
	* 
	* @return $lista todas la sesiones
	*/
	public function listaSesionesParaEditarModulo(){
		$query = $this->db->get('sesion');	
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_SESION;
			$lista[$contador][1] = $row->COD_MODULO_TEM;
			$lista[$contador][2] = $row->DESCRIPCION_SESION;
			$lista[$contador][3] = $row->NOMBRE_SESION;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	/**
	* Obtiene de todas las sesiones que no tengan un módulo asignado
	*
	* @return $lista lista con todas las sesiones que no poseen modulo temático
	*
	*/
	public function listaSesionesParaAddModulo(){
		$this->db->select('*');
		$this->db->from('sesion');
		$this->db->where('COD_MODULO_TEM',null); 
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
			$lista[$contador][1] = "";
			$lista[$contador][2] = $row->DESCRIPCION_SESION;
			$lista[$contador][3] = $row->NOMBRE_SESION;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	/**
	* Obtiene la lista de todos los requisitos de la base de datos
	*
	* @return $lista todos los requisitos que exiten en la base de datos
	*/
	public function listaRequisitosParaAddModulo(){
		$query = $this->db->get('requisito');	
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_REQUISITO;
			$lista[$contador][1] = $row->NOMBRE_REQUISITO;
			$lista[$contador][2] = $row->DESCRIPCION_REQUISITO;
			$contador = $contador + 1;
		}
		return $lista;
	}

	/**
	*
	* obtiene la lista de todos los requisitos con su información e indicando si están asociados a un cierto código de módulo
	*
	* @param int $cod_mod codico del modulo tematico que se quiere editar
	* @return $lista_r lista cpn los requisitos del modulo tematico que se quiere editar
	*/
	public function listaRequisitosParaEditarModulo($cod_mod){		
		$this->db->select('*');
		$this->db->from('requisito');
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result(); 
		$contador = 0;
		$lista_r = array();
		foreach ($datos as $row) { 
			$lista_r[$contador] = array();
			$lista_r[$contador][0] = $row->COD_REQUISITO;
			$lista_r[$contador][1] = $row->NOMBRE_REQUISITO;
			$lista_r[$contador][2] = $row->DESCRIPCION_REQUISITO;
			$lista_r[$contador][3] = 0;
			$contador = $contador + 1;
		}
		
		$this->db->select('*');
		$this->db->from('requisito_modulo');
		$this->db->where('COD_MODULO_TEM', $cod_mod); 
		$query = $this->db->get();	
		if ($query == FALSE) {
			return array();
		}
	    $datos = $query->result();
		$contador = 0;
		$lista = array();
		
		if($query->num_rows() > 0){
			foreach ($datos as $row) {  
				$lista[$contador] = array();
				$lista[$contador][0] = $row->COD_MODULO_TEM;
				$lista[$contador][1] = $row->COD_REQUISITO;
				$contador = $contador + 1;
			}
		}
		
		$contador = 0;
		$contador2 = 0;
		while($contador < count($lista_r)){
			while($contador2 < count($lista)){
				if($lista_r[$contador][0] == $lista[$contador2][1]){
					$lista_r[$contador][3] = 1;
				}
				$contador2++;
			}
			$contador2 = 0;
			$contador++;
		}
		return $lista_r;
	}
	
	/**
	*
	* Inserta un nuevo módulo en la BD
	* 
	* Crea un nuevo modulo temático en la base de datos con los datos entregados como parametros
	*
	* @param string $nombre_modulo nombre del nuevo modulo
	* @param $sesiones sesiones de nuevo modulo
	* @param string $descripcion_modulo descripción del nuevo módulo
	* @param $profesor_lider profesor lider del nuevo módulo
	* @param $equipo_profesores equipo de profesores del nuevo modulo
	* @param $requisitos requisitos del nuevo modulo
	* @return 1 en caso de exito 
	* @return -1 en caso de fallo
	*
	*/
	public function InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos){
			//0 insertar modulo
			$data = array(					
					'NOMBRE_MODULO' => $nombre_modulo ,
					'DESCRIPCION_MODULO' => $descripcion_modulo 
					);
			$confirmacion0 = $this->db->insert('modulo_tematico',$data);
			//
			$cod_modulo = $this->db->insert_id();
			
			//1 insertar equipo
			$data = array(					
					'COD_MODULO_TEM' => $cod_modulo
				);
			$confirmacion1 = $this->db->insert('equipo_profesor',$data);
			//
			$cod_equipo = $this->db->insert_id();	
			
			//actualizar mod_tem 4
			$data = array(					
					'COD_EQUIPO'=>$cod_equipo
			);
			$this->db->where('COD_MODULO_TEM', $cod_modulo);
			$confirmacion4 = $this->db->update('modulo_tematico',$data);
			//
			
			//2 insertar equipo profesores			
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
			$contador = 0;
			$confirmacion3 = true;
			while ($contador<count($sesiones)){
			$data = array(					
					'COD_MODULO_TEM' => $cod_modulo
					);
					$this->db->where('COD_SESION', $sesiones[$contador]);
					$datos = $this->db->update('sesion',$data);

				if($datos != true){
					$confirmacion3 = false;
				}
	
				$contador = $contador + 1;
			}
			//5 insertar requisito modulo
			$contador = 0;
			$confirmacion5 = true;
			if($requisitos != null){
			while ($contador<count($requisitos)){
			$data = array(					
					'COD_REQUISITO' => $requisitos[$contador],
					'COD_MODULO_TEM' => $cod_modulo
					);
			$datos = $this->db->insert('requisito_modulo',$data);
				if($datos != true){
					$confirmacion5 = false;
				}
	
				$contador = $contador + 1;
				}
			}
			//fin inserciones
			if($confirmacion0 == false || $confirmacion1 == false || $confirmacion2 == false || $confirmacion3 == false || $confirmacion4 == false || $confirmacion5 == false){
				return -1;
				}
			return 1;
	}
	
	/**
	*
	* Elimina un módulo de la BD
	*
	* 
	* 
	* @param int $cod_modulo codigo del moduo que se eliminará
	* @return 1 en caso de eliminarse exitosamente
	* @return -1 en caso de fallar la consulta 
	**/
	public function EliminarModulo($cod_modulo)
    {
		$this->db->where('COD_MODULO_TEM', $cod_modulo);
		$datos = $this->db->delete('modulo_tematico'); 		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
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
		$this->db->select('COD_MODULO_TEM AS cod_mod');
		$this->db->select('COD_EQUIPO AS cod_equipo');
		$this->db->select('NOMBRE_MODULO AS nombre_mod');
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
	public function EditarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos,$cod_equipo,$cod_mod){
		//0 insertar modulo
		$data = array(					
				'NOMBRE_MODULO' => $nombre_modulo ,
				'DESCRIPCION_MODULO' => $descripcion_modulo 
				);
		$this->db->where('COD_MODULO_TEM', $cod_mod);
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
		$this->db->select('COD_MODULO_TEM');
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
			$lista[$contador][1] = $row->COD_MODULO_TEM;
			$contador = $contador + 1;
		}
		$contador = 0;
		while($contador < count($lista)){
			if($lista[$contador][1] == $cod_mod){
				$data = array(		
					'COD_MODULO_TEM' => null
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
				'COD_MODULO_TEM' => $cod_mod
				);
				$this->db->where('COD_SESION', $sesiones[$contador]);
				$datos = $this->db->update('sesion',$data);

			if($datos != true){
				$confirmacion3 = false;
			}

			$contador = $contador + 1;
		}
		
		//requisitos
		$this->db->delete('requisito_modulo', array('COD_MODULO_TEM' => $cod_mod)); 
				
		$contador = 0;
		$confirmacion5 = true;
		if($requisitos != null){
			while ($contador<count($requisitos)){
				$data = array(					
						'COD_REQUISITO' => $requisitos[$contador],
						'COD_MODULO_TEM' => $cod_mod
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
	public function listaSesionesParaVerModulo($cod_mod){
		$query = $this->db->get_where('sesion', array('COD_MODULO_TEM' => $cod_mod));
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
	**********/
	public function listaProfesoresVerModulo($cod_equipo){
		$this->db->select('*');
		$this->db->from('profesor');
		$this->db->join('profe_equi_lider', 'profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2');
		$this->db->where('profe_equi_lider.COD_EQUIPO', $cod_equipo); 
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	/**
	*
	* Obtiene la  lista de los requisitos de un cierto módulo
	*
	* Se consulta a la base de datos por los requisito del modulo cuyo codigo es el parametro $cod_mod
	* de existir dichos requisito se retornan y de no existir se retorna un array vacío
	*  
	* @param int $cod_mod codigo del modulo para el que se obtiene sus requisistos 
	* @return $query->result() en caso de encontrarse requisitos
	* @return array() en caso de fallar la consulta
	*/
	public function listaRequisitosVerModulo($cod_mod){
		$this->db->select('*');
		$this->db->from('requisito');
		$this->db->join('requisito_modulo', 'requisito_modulo.COD_REQUISITO = requisito.COD_REQUISITO');
		$this->db->where('requisito_modulo.COD_MODULO_TEM', $cod_mod); 
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	/**
	* Muestra todos los profes que no pertenecen al equipo de profesores que posee un modulo
	*
	* Se obtienen todos los profesores desde la base de datos luego se obtienen los profesores que perotencen al equpio de $lider
	* se realiza la diferenecia entre las dos listas de profesores y fienalmente se entregan los profes que no pertenencen al modulo tematico
	*
	* @param string $lider corresponde al profesor lider del modulo seleccionado
	* @return $profes2 lista de profesores
	*
	**/
	public function VerTodosLosProfesoresAddModulo($lider){
		$this->db->select('*');
		$this->db->from('profesor');
		$query = $this->db->get();
		$datos = $query->result();
		$contador = 0;
		$profes = array();
		foreach ($datos as $row){  
			$profes[$contador] = array();
			$profes[$contador][0] = $row->RUT_USUARIO2;
			$profes[$contador][1] = $row->NOMBRE1_PROFESOR;
			$profes[$contador][2] = $row->APELLIDO1_PROFESOR;
			$contador = $contador + 1;
		}
		
		$this->db->select('RUT_USUARIO2');
		$this->db->select('LIDER_PROFESOR');
		$this->db->from('profe_equi_lider');
		$query = $this->db->get();
		$datos = $query->result();
		
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->LIDER_PROFESOR;
			$lista[$contador][1] = $row->RUT_USUARIO2;
			$contador = $contador + 1;
		}
		$contador = 0;
		$contador2 = 0;
		$contador3 = 0;

		$profes2 = array();
		$esta =false;
		while($contador < count($profes)){
			while($contador2 < count($lista)){
				if($profes[$contador][0] == $lista[$contador2][1] && $lista[$contador2][0] == $lider){
					$esta=true;
					$contador2 = count($lista);
				}
				$contador2++;
			}
			if(!$esta){
				$profes2[$contador3] = array();
				$profes2[$contador3][0] = $profes[$contador][0];
				$profes2[$contador3][1] = $profes[$contador][1];
				$profes2[$contador3][2] = $profes[$contador][2];
				$contador3++;		
			}
			$esta =false;
			$contador2 = 0;
			$contador++;
		}
		return $profes2;

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
		$this->db->select('DESCRIPCION_MODULO AS descripcion');
		$this->db->select('COD_MODULO_TEM AS id');
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
   * Realiza una consulta a la base de datos para obtener el detalle del modulo con el codigo contenido en $cod 
   * luego si no se encuentra retorna un array vacio y si tiene exito la fila con el detalle
   *
   * @param int $cod codigo del modulo que se quiere obtener el detalle
   * @return array() array vacío en caso de fallar
   * @return $query->row() fila con los datos del detalle del modulo solicitado
   *
   **/
	public function getDetallesModulo($cod)
	{
		$this->db->select('COD_MODULO_TEM AS cod_mod');
		$this->db->select('COD_EQUIPO AS cod_equipo');
		$this->db->select('NOMBRE_MODULO AS nombre_mod');
		$this->db->select('DESCRIPCION_MODULO AS descripcion');
		$this->db->where('COD_MODULO_TEM', $cod);
		$this->db->order_by('NOMBRE_MODULO','asc');
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}
}
?>