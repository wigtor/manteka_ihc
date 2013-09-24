<?php

class Model_seccion extends CI_Model {
	
	/**
	* Obtiene los datos de todos las secciones de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada seccion y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todas las secciones del sistema
	*/
	public function getAllSecciones() {
		return $this->getSeccionesByFilter('');
	}
	

	/**
	* Eliminar seccion de la base de datos
	*
	* Recibe el codigo de la seccion para que se elimine ésta y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la eliminacion correctamente o no.
	*
	* @param string $cod_sección codigo de la seccion que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function eliminarSeccion($cod_seccion) {

		/* se comprueba si la seccion tiene estudiantes*/
		$this->db->trans_start();
		$this->db->where('estudiante.ID_SECCION', $cod_seccion);
		$query = $this->db->update('estudiante', array('ID_SECCION' => NULL));

		
		$this->db->where('seccion.ID_SECCION', $cod_seccion);
		$query=$this->db->delete('seccion');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }
	
	
	/**
	* Agrega la información de una seccion en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'data'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $nombre_seccion1 letra del nombre de la seccion a editar
	* @param string $nombre_seccion2 número del nombre de la seccion a editar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function agregarSeccion($letra_seccion, $numero_seccion, $dia, $bloque) {
		$letra_seccion = strtoupper($letra_seccion);
		
		$this->db->trans_start();

		$this->db->select('ID_SECCION AS cod');
		$this->db->where('LETRA_SECCION', $letra_seccion);
		$this->db->where('NUMERO_SECCION', $numero_seccion);
		$query =$this->db->get('seccion');
		if ($query == FALSE) {
			$this->db->trans_complete();
			return array();
		}
		if ($query->num_rows() > 0) { //Ya existe una sección con el mismo nombre
			$this->db->trans_complete();
			return FALSE;
		}

		//Busco el horario
		$this->db->select('ID_HORARIO as id');
		$this->db->where('ID_MODULO', $bloque);
		$this->db->where('ID_DIA', $dia);
		$query = $this->db->get('horario');
		if ($query == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		$id_horario = 0; //Valor por default
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$id_horario = $row->id;
		}
		else { //Si no existe, inserto el horario (no debiese ocurrir con el poblado inicial)
			$this->db->flush_cache();
			$data0 = array(
				'ID_MODULO' => $bloque,
				'ID_DIA' => $dia);
			$resultadoInsert = $this->db->insert('horario', $data0);
			$id_horario = $this->db->insert_id();	
		}

		$this->db->flush_cache();

		$data1 = array(
			'LETRA_SECCION' => $letra_seccion,
			'NUMERO_SECCION' => $numero_seccion,
			'ID_HORARIO' => $id_horario);
		$resultadoInsert = $this->db->insert('seccion', $data1);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }

	/**
	* Agregar la información de una seccion en la base de datos
	*
	* Guarda las variables a agregar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'data'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $cod_seccion código de la sección que será actualizada
	* @param string $nombre_seccion1 letra del nombre de la seccion a agregar
	* @param string $nombre_seccion2 número del nombre de la seccion a agregar
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function actualizarSeccion($cod_seccion, $letra_seccion, $numero_seccion, $dia, $bloque) {
		
		$this->db->trans_start();

		//Busco el horario
		$this->db->select('ID_HORARIO as id');
		$this->db->where('ID_MODULO', $bloque);
		$this->db->where('ID_DIA', $dia);
		$query = $this->db->get('horario');
		if ($query == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		$id_horario = 0; //Valor por default
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$id_horario = $row->id;
		}
		else { //Si no existe, inserto el horario (no debiese ocurrir con el poblado inicial)
			$this->db->flush_cache();
			$data0 = array(
				'ID_MODULO' => $bloque,
				'ID_DIA' => $dia);
			$resultadoInsert = $this->db->insert('horario', $data0);
			$id_horario = $this->db->insert_id();	
		}

		$this->db->flush_cache();


		$data = array(
					'LETRA_SECCION' => $letra_seccion,
					'NUMERO_SECCION' => $numero_seccion,
					'ID_HORARIO' => $id_horario);
		$this->db->where('ID_SECCION', $cod_seccion);
		$confirmacion0 = $this->db->update('seccion', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }
 
 	/**
 	* Determina si una sección ya existe en el sistema, al momento de editar una sección
 	*
 	* Transforma la letra de la sección a mayuscula, por cosas de convención, y forma el nombre de la seccion con el formato estandar
 	* Revisa si existe la seccion, en la base de datos, y dependiendo si existe entrega un resultado al controlador
 	*
 	* @param string $cod_seccion código de la sección a editar
 	* @param string $nombre_seccion1 letra del nombre de la sección a editar
 	* @param string $nombre_seccion2 digitos del nombre de la sección a editar
 	* @return int $var 1 si la sección ya existe y 0 si la sección no existe
 	*/
	public function existeSeccion($letra, $numero) {
		$letra = strtoupper($letra);

		$this->db->select('COUNT(seccion.ID_SECCION) AS resultado');
		$this->db->where('LETRA_SECCION', $letra);
		$this->db->where('NUMERO_SECCION', $numero);
		$query = $this->db->get('seccion');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
	}


	public function existeSeccionExcepto($excepto_id, $letra, $numero) {
		$letra = strtoupper($letra);

		$this->db->select('COUNT(seccion.ID_SECCION) AS resultado');
		$this->db->where('LETRA_SECCION', $letra);
		$this->db->where('NUMERO_SECCION', $numero);
		$this->db->where('ID_SECCION !=', $excepto_id);
		$query = $this->db->get('seccion');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	* Entrega las secciones, correspondiente a un filtro
	* 
	* Se eligen todas las secciones que tienen un nombre similar al filtro,
	* que esta dado por el parámetro $texto
	* Finalmente, se entregan todas las secciones que cumplen con el filtro
	*
	* @param string $texto filtro de busqueda para elegir secciones
	* @return array conjunto de secciones que coinciden con el filtro entregado
	*/

	public function getSeccionesByFilter($texto) {
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS nombre');
		$this->db->select('ID_SECCION AS id');
		$this->db->select('LETRA_SECCION AS letra');
		$this->db->select('NUMERO_SECCION AS numero');
		$this->db->order_by('LETRA_SECCION', 'asc');
		//$this->db->order_by('NUMERO_SECCION', 'asc');

		define("BUSCAR_POR_NOMBRE", 0);
		if ($texto != "") {
			$this->db->where("(LETRA_SECCION LIKE '%".$texto."%' OR NUMERO_SECCION LIKE '%".$texto."%')");
		}
		$query = $this->db->get('seccion');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	/**
	* Obtener detalles de las secciones
	*
	* Obtiene el detalle de la sección que se le pida a travez de del dato seleccionado en la vista
	*
	* @param $cod_seccion codigo seccion de la que se obtendrán los detalles
	* @return $lista arreglo que coniene el detalle de la sección solicitada
	*/

	public function getDetallesSeccion($id_seccion) {
		$this->db->select('seccion.ID_SECCION as id_seccion');
		$this->db->select('CONCAT_WS(\'-\', LETRA_SECCION, NUMERO_SECCION ) AS seccion');
		$this->db->select('LETRA_SECCION AS letra_seccion');
		$this->db->select('NUMERO_SECCION AS numero_seccion');
		$this->db->select('NOMBRE_MODULO AS modulo');
		$this->db->select('sala.NUM_SALA AS sala');
		$this->db->select('usuario.NOMBRE1 as nombre1');
		$this->db->select('usuario.APELLIDO1 as apellido1');
		$this->db->select('usuario.APELLIDO2 as apellido2');
		$this->db->select('CONCAT(ABREVIATURA_DIA,modulo_horario.ID_MODULO) as horario', FALSE);
		$this->db->select('horario.ID_MODULO as modulo_horario');
		$this->db->select('NOMBRE_DIA as dia');
		$this->db->select('dia_horario.ID_DIA as id_dia');
		$this->db->select('modulo_horario.ID_MODULO as id_modulo_horario');
		$this->db->select('date_format(HORA_INI, \'%H:%i\') AS hora_clase', FALSE);
		$this->db->where('seccion.ID_SECCION', $id_seccion);

		$this->db->join('sesion_de_clase', 'sesion_de_clase.ID_SESION = seccion.ID_SESION', 'LEFT OUTER');
		$this->db->join('modulo_tematico', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('planificacion_clase','sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION', 'LEFT OUTER'); //Para saber en que se encuentra actualmente
		$this->db->join('horario','seccion.ID_HORARIO = horario.ID_HORARIO', 'LEFT OUTER');
		$this->db->join('dia_horario','horario.ID_DIA = dia_horario.ID_DIA', 'LEFT OUTER');
		$this->db->join('modulo_horario','horario.ID_MODULO = modulo_horario.ID_MODULO', 'LEFT OUTER');
		$this->db->join('sala','planificacion_clase.ID_SALA = sala.ID_SALA', 'LEFT OUTER');
		$this->db->join('ayu_profe','ayu_profe.ID_AYU_PROFE = planificacion_clase.ID_AYU_PROFE', 'LEFT OUTER');
		$this->db->join('profesor','ayu_profe.PRO_RUT_USUARIO = profesor.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('ayudante','ayu_profe.RUT_USUARIO = ayudante.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('usuario','usuario.RUT_USUARIO = profesor.RUT_USUARIO', 'LEFT OUTER');
		//PENDIENTE JOIN CON USUARIO AYUDANTE
		$query = $this->db->get('seccion');

		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		else {
			return $query->row();
		}
}

/**
	* ELlimina la asignación de una seccion a las tablas asociadas
	*
	* se obtienen la datos que se quieres desasociarn de la seccion para luego desasociarlas
	*
	* @param $cod_seccion codigo seccion de la se eliminaran las asignaciones
	* @return 1 si se realizó la operación con éxito y - 1 si la operación falló
	*/

public function eliminarAsignacion($cod_seccion)
{
	$this->db->select('sala_horario.ID_HORARIO_SALA as id_sala');
	$this->db->from('seccion_mod_tem');
	$this->db->where('seccion_mod_tem.ID_SECCION',$cod_seccion);
	$this->db->join('sala_horario', 'seccion_mod_tem.ID_HORARIO_SALA=sala_horario.ID_HORARIO_SALA');


	$query =$this->db->get();

	$lista=array();

	if ($datos1 = $query->row()){

		$lista[0] = $datos1->id_sala;

		$this->db->where('ID_SECCION', $cod_seccion);
		$datos2 = $this->db->delete('seccion_mod_tem');

		$this->db->where('ID_SECCION', $cod_seccion);
		$datos3 = $this->db->delete('profe_seccion');


		$this->db->where('ID_HORARIO_SALA', $lista[0]);
		$datos4 = $this->db->delete('sala_horario');
		
		}

	else{
		$lista[0]="";
		$datos2=false;
		$datos3=false;
		$datos4=false;

	}	

	if($datos2 == true && $datos3 == true && $datos4 == true ){
			return 1;
		}
		else{
			return -1;
		}

}

	/**
	* Entrega todos los módulos temáticos en el sistema
	*
	* Se obtienen el nombre y el código de todos los módulos temáticos de
	* la base de datos y se guardan en un arreglo
	*
	* @return array $array todos los módulos temáticos que hay en el sistema
	*/

public function verModulosPorAsignar(){

	$columnas = 'modulo_tematico.NOMBRE_MODULO, modulo_tematico.COD_MODULO_TEM';
	$desde = '`modulo_tematico`';
	$query = $this->db->select($columnas);
	$query = $this->db->get($desde);
	
	$array = $query->result_array();
						
	return $array;
}

	/**
	* Entrega todos los profesores de un módulo temático en particular
	*
	* Se obtienen el nombre, el apellido y el rut de todos los profesores que estan asignados a un módulo temático
	* Este modulo tematico se encuentra dado por el parametro '$modulo'
	*
	* @param string $modulo nombre del módulo temático al que se le quieren buscar los profesores
	* @return array $array todos los profesores asignados al módulo temático
	*/

public function verProfeSegunModulo($modulo){

	$columnas = 'profesor.NOMBRE1_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.RUT_USUARIO2';
	$condiciones  = '(modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO)AND(profe_equi_lider.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.NOMBRE_MODULO = \''.$modulo.'\')';
	$desde = 'profesor, equipo_profesor, modulo_tematico, profe_equi_lider';

	$query = $this->db->select($columnas);
	$query = $this->db->where($condiciones);
	$query = $this->db->get($desde);
	$array = $query->result_array();
						
	return $array;
}

	/**
	* Entrega todas las salas del sistema
	*
	* Se obtienen el número y el código de todas las salas en la base de datos
	* Finalmente, se guardan en un arreglo para entregarlo al controlador
	*
	* @return array $array todas las salas del sistema
	*/

public function verSalasPorAsignar(){

	$columnas = '`sala.NUM_SALA`, `sala.COD_SALA`';
	$desde = '`sala`';
	$query = $this->db->select($columnas);
	$query = $this->db->get($desde);
	
	$array = $query->result_array();
						
	return $array;

}

	/**
	* Asigna una sección a sus correspondientes parametros
	* Estos parametros son: módulo tematico, profesor, sala y horario
	* Primero se obtiene el horario para hacer la relacion entre este y la sala
	* Luego, se asocian la sección con el profesor
	* Finalmente, se obtiene el código del horario_sala recien ingresado, para hacer la
	* asociacion de la sección con el módulo temático, el horario y la sala
	* 
	* @param $cod_seccion el código de la sección que será asignada
	* @param $cod_profesor el código del profesor al que se le asigna la sección
	* @param $cod_modulo el código del módulo tematico al que se le asigna la sección
	* @param $cod_sala el código de la sala a la que se le asigna la sección
	* @param $nombre_dia el nombre del dia al que se le asigna la sección
	* @param $numero_modulo el número del bloque al que se le asigna la sección
	* @return 1 si la operación se realizó con éxito y - 1 si la operación falló
	**/
	public function AsignarSeccion($cod_seccion, $cod_profesor, $cod_modulo, $cod_sala, $nombre_dia, $numero_modulo){
		/*Se busca el código del horario correspondiente al dia y al bloque*/
		if(strcmp($nombre_dia,"Miercoles") != 0) {
			$dia_abreviado = substr($nombre_dia, 0, 1);
		}else{
			$dia_abreviado = 'W';
		}
		$columnas = 'horario.COD_HORARIO as cod';
		$condiciones = '(dia.COD_ABREVIACION_DIA = \''.$dia_abreviado.'\') AND (modulo.NUMERO_MODULO = \''.$numero_modulo.'\') AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO)';
		$desde = 'dia, modulo, horario';
		$this->db->select($columnas);
		$this->db->where($condiciones);
		$query = $this->db->get($desde);
		//$cod_horario = $query->result_array()[0]['COD_HORARIO'];
		$datos1=$query->result();
		$lista1=array();
		$contador=0;

		foreach ($datos1 as $row) {
			$lista1[$contador]=array();
			$lista1[$contador][0]=$row->cod;
			$contador=$contador+1;
		}

		$cod_horario= $lista1[0][0];

		/*Se asocian la sala con el horario, para luego ser asociados a la sección*/
		$sala_horario = array(
				'COD_SALA' => $cod_sala,
				'COD_HORARIO' => $cod_horario
			);
		$this->db->insert('sala_horario',$sala_horario);

		/*Se asocia el profesor a la sección*/
		$profe_seccion = array(
				'ID_SECCION' => $cod_seccion,
				'RUT_USUARIO2' => $cod_profesor
			);
		$this->db->insert('profe_seccion',$profe_seccion);

		/*Se asocia el módulo, el horario y la sala a la sección*/
		$this->db->select('ID_HORARIO_SALA as cod_sala');
		$condiciones = '(sala_horario.COD_SALA = \''.$cod_sala.'\') AND (sala_horario.COD_HORARIO = \''.$cod_horario.'\')';
		$this->db->where($condiciones);
		$query2 = $this->db->get('sala_horario');
		//$id_horario_sala = $query2->result_array()[0]['ID_HORARIO_SALA'];
		$datos2=$query2->result();

		$lista2=array();
		$contador1=0;

		foreach ($datos2 as $row1) {
			$lista2[$contador1]=array();
			$lista2[$contador1][0]=$row1->cod_sala;
			$contador1=$contador1+1;
		}

		$id_horario_sala=$lista2[0][0];

		$seccion_mod_tem = array(
				'ID_SECCION' => $cod_seccion,
				'COD_MODULO_TEM' => $cod_modulo,
				'ID_HORARIO_SALA' => $id_horario_sala
			);
		$this->db->insert('seccion_mod_tem',$seccion_mod_tem);

		if($sala_horario == true && $profe_seccion == true && $seccion_mod_tem == true){
			return 1;
		}else{
			return -1;
		}
	}

	/**
	* Obtiene los datos de todos las secciones, de la base de datos, que no estan asignadas.
	*
	* Se crea la consulta y luego se ejecuta ésta.
	* Luego con un ciclo se va extrayendo la información de cada seccion y se va guardando en un arreglo de dos dimensiones.
	* Finalmente se retorna la lista con los datos.
	*
	* @return array $lista Contiene la información de todas las secciones del sistema que no estan asignadas
	*/
	public function VerSeccionesNoAsignadas()
	{
		$this->db->select('seccion.ID_SECCION');
		$this->db->from('seccion, profe_seccion, seccion_mod_tem');
		$condiciones = '(seccion.ID_SECCION = profe_seccion.ID_SECCION) AND (seccion.ID_SECCION = seccion_mod_tem.ID_SECCION)';
		$this->db->where($condiciones);
		$queryNotIn = $this->db->get();
		$datosNotIn = $queryNotIn->result_array();
		$whereNotIn = array();
		foreach($datosNotIn as $row){
			array_push($whereNotIn, $row['ID_SECCION']);
		}
		$this->db->select('seccion.ID_SECCION AS cod, seccion.NOMBRE_SECCION AS nombre');
		$this->db->from('seccion');
		if(count($whereNotIn)!=0){
			$this->db->where_not_in('ID_SECCION', $whereNotIn);
		}
		$this->db->order_by("NOMBRE_SECCION", "asc");
		$query = $this->db->get();
		if($query == FALSE){
			return array();
		}else{
			$datos = $query->result();
		}

		$lista=array();

		$contador=0;
			if($datos != false){
				foreach ($datos as $row) {
					$lista[$contador]=array();
					$lista[$contador][0]=$row->cod;
					$lista[$contador][1]=$row->nombre;
					$contador=$contador+1;
				}
			}
		return $lista;
	}

	/**
	* Verifica si un horario ya esta asignado a una sala
	*
	* Obtiene el horario correspondiente al dia, entregado por el parámetro '$dia', y al
	* bloque, entregado por el parámetro '$bloque'
	* Luego, verifica que no haya una sala con ese horario ocupado
	* Finalmente, retorna un valor dependiendo si la sala esta asignada en ese horario o no
	*
	* @param string $dia nombre del dia del horario a verificar
	* @param string $bloque numero del bloque del horario a verificar
	* @return int 1 o 0 dependiendo si ya esta asignado el horario a una sala
	*/

	public function getVerificaHorarios($dia, $bloque){
		/*Se busca el código del horario correspondiente al dia y al bloque*/
		if(strcmp($dia,"Miercoles")!=0){
			$dia_abreviado = substr($dia,0,1);
		}else{
			$dia_abreviado = 'W';
		}
		$columnas = 'horario.COD_HORARIO';
		$condiciones = '(dia.COD_ABREVIACION_DIA = \''.$dia_abreviado.'\') AND (modulo.NUMERO_MODULO = \''.$bloque.'\') AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO)';
		$desde = 'dia, modulo, horario';
		$this->db->select($columnas);
		$this->db->where($condiciones);
		$query = $this->db->get($desde);
		$resultado = $query->result_array();
		if(count($resultado)>0){
			$cod_horario = $resultado[0]->COD_HORARIO;
		}else{
			return 0; //No existe el horario
		}
		//$cod_horario = $query->result_array()[0]['COD_HORARIO'];

		/*Se revisa si el horario ya le pertenece a otra sala*/
		$this->db->select('sala_horario.ID_HORARIO_SALA');
		$this->db->from('sala_horario');
		$this->db->where('sala_horario.COD_HORARIO = \''.$cod_horario.'\'');
		$query2 = $this->db->get();
		if(count($query2->result_array())>0){
			return 1; //Ya existe el horario
		}else{
			return 0; //No existe el horario
		}
	}

	/**
	* Obtiene los datos de todos las secciones, de la base de datos, que estan asignadas.
	*
	* Se crea la consulta y luego se ejecuta ésta.
	* Luego con un ciclo se va extrayendo la información de cada seccion y se va guardando en un arreglo de dos dimensiones.
	* Finalmente se retorna la lista con los datos.
	*
	* @return array $lista Contiene la información de todas las secciones del sistema que estan asignadas
	*/
	public function VerSeccionesAsignadas()
	{
		$this->db->select('seccion.ID_SECCION');
		$this->db->from('seccion, profe_seccion, seccion_mod_tem');
		$condiciones = '(seccion.ID_SECCION = profe_seccion.ID_SECCION) AND (seccion.ID_SECCION = seccion_mod_tem.ID_SECCION)';
		$this->db->where($condiciones);
		$queryNotIn = $this->db->get();
		$datosNotIn = $queryNotIn->result_array();
		$where = "";
		if(count($datosNotIn)!=0){
			foreach($datosNotIn as $row){
				$this->db->or_where('seccion.ID_SECCION',$row['ID_SECCION']);
			}
		}else{
			return array();
		}
		$this->db->select('seccion.ID_SECCION AS cod, seccion.NOMBRE_SECCION AS nombre');
		$this->db->from('seccion');
		$this->db->order_by("NOMBRE_SECCION", "asc");
		$query = $this->db->get();
		if($query == FALSE){
			return array();
		}else{
			$datos = $query->result();
		}

		$lista=array();

		$contador=0;
			if($datos != false){
				foreach ($datos as $row) {
					$lista[$contador]=array();
					$lista[$contador][0]=$row->cod;
					$lista[$contador][1]=$row->nombre;
					$contador=$contador+1;
				}
			}
		return $lista;
	}

}


?>