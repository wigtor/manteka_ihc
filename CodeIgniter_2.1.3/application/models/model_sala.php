<?php
class Model_sala extends CI_Model {


	/**
	* Inserta una sala en la base de datos
	*
	* Guarda las variables a insertar en el array data luego se llama a la función insert y se guarda el resultado de la inserción
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $cod_sala codigo de sala a insertar
	* @param string $num_sala numero de sala a insertar
	* @param string $capacidad capacidad de la sala a insertar
	* @param string $ubicacion ubicacion de la sala a insertar
	*/
	public function agregarSala($num_sala, $ubicacion, $capacidad, $implementos) {
		
		// se convierte todo el texto de la ubicación en minúscula
		$ubicacion = strtolower($ubicacion);
		$data1 = array(	
					'NUM_SALA' => $num_sala,
					'UBICACION' => $ubicacion,
					'CAPACIDAD' => $capacidad
					
		);

		$this->db->trans_start();
		$datos2 = $this->db->insert('sala', $data1);

		$id_sala = $this->db->insert_id();
		if (is_array($implementos)) {
			foreach($implementos as $impl) {
				$data3 = array('ID_SALA' => $id_sala, 'ID_IMPLEMENTO' =>$impl);
				$datos = $this->db->insert('sala_implemento', $data3);
			}
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
	* Eliminar sala de la base de datos
	*
	* Recibe el codigo de la sala para que se elimine ésta y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la eliminación correctamente o no.
	*
	* @param string $cod_sala codigo de la sala que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function eliminarSala($idSalaEliminar) {

    	$this->db->trans_start();
		$this->db->where('ID_SALA', $idSalaEliminar);
		$datos=$this->db->delete('sala_implemento');
		$this->db->where('ID_SALA', $idSalaEliminar);
		$datos1=$this->db->delete('sala');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }
    


	
	
	
	/**
	* Obtiene los datos de todos los implementos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/
	public function getAllImplementos() {
		$this->db->select('ID_IMPLEMENTO AS id');
		$this->db->select('NOMBRE_IMPLEMENTO AS nombre');
		$this->db->select('DESCRIPCION_IMPLEMENTO AS descripcion');
		$this->db->order_by("NOMBRE_IMPLEMENTO", "asc");
		$query = $this->db->get('implemento');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
		/**
	* Obtiene los datos de todos los implementos de todas las salas en la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/
	public function VerTodosLosImplementosSala()
	{
		//$sql="SELECT * FROM sala_implemento "; //código MySQL
		$this->db->select('*');
		$this->db->from('sala_implemento');
		$query=$this->db->get();
		$datos1=$query->result();
		//$datos1=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		if (false != $datos1) {
		//while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
		foreach ($datos1 as $row1 ) {
			$cod=$row1->ID_IMPLEMENTO;
			//$sql1="SELECT * FROM implemento WHERE ID_IMPLEMENTO = '$cod'"; //código MySQL
			$this->db->select('*');
			$this->db->from('implemento');
			$this->db->where('ID_IMPLEMENTO', $cod);
			$query=$this->db->get();
			$datos=$query->result();
			//$datos=mysql_query($sql1); //enviar código MySQL
			if (false != $datos) {
			//while ($row=mysql_fetch_array($datos)) {
			foreach ($datos as $row) {
				$lista[$contador]=array();
				$lista[$contador][0] = $row1->ID_SALA;
				$lista[$contador][1] = $row1->ID_IMPLEMENTO;
				$lista[$contador][2] = $row->NOMBRE_IMPLEMENTO;
				$lista[$contador][3] = $row->DESCRIPCION_IMPLEMENTO;
			}}
			$contador++;
		}}
		return $lista;
	}

	
	
			/**
	* Obtiene los datos de todos los implementos de una sala en la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @param $cod_sala corresponde al valor del código de la sala asignado por el motor de base de datos al momento de ser ingresada
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/
	public function ImplementosParticulares($cod_sala)
	{
		//$sql="SELECT * FROM sala_implemento WHERE ID_SALA ='$cod_sala' "; //código MySQL
		$this->db->select('*');
		$this->db->from('sala_implemento');
		$this->db->where('ID_SALA', $cod_sala);
		$query=$this->db->get();
		$datos1=$query->result();
		//$datos1=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		if (false != $datos1) {
		//while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
		foreach ($datos1 as $row1) {
			
			$cod=$row1->ID_IMPLEMENTO;
			//$sql1="SELECT * FROM implemento WHERE ID_IMPLEMENTO = '$cod'"; //código MySQL
			$this->db->select('*');
			$this->db->from('implemento');
			$this->db->where('ID_IMPLEMENTO', $cod);
			$query=$this->db->get();
			$datos=$query->result();
			//$datos=mysql_query($sql1); //enviar código MySQL
			if (false != $datos) {
			//while ($row=mysql_fetch_array($datos)) {
			foreach ($datos as $row) {
				$lista[$contador]=array();
				$lista[$contador][0] = $row1->ID_SALA;
				$lista[$contador][1] = $row1->ID_IMPLEMENTO;
				$lista[$contador][2] = $row->NOMBRE_IMPLEMENTO;
				$lista[$contador][3] = $row->DESCRIPCION_IMPLEMENTO;
			}}
			$contador++;
		}}
		return $lista;
	}
	
				/**
	* Obtiene los datos de todos los implementos que no tiene la sala en la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento ausente y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @param $cod_sala corresponde al valor del código de la sala asignado por el motor de base de datos al momento de ser ingresada
	* @return array $lista Contiene la información de todos los implementos ausentes en la sala del sistema
	*/
	public function ImplementosAusentes($cod_sala)
	{
		//$sql="SELECT * FROM implemento WHERE ID_IMPLEMENTO NOT IN(SELECT ID_IMPLEMENTO FROM sala_implemento WHERE ID_SALA ='$cod_sala' )";
		$this->db->select('ID_IMPLEMENTO');
		$this->db->from('sala_implemento');
		$this->where('ID_SALA', $cod_sala);
		$query=$this->db->get();
		$datos1=$query->result();

		$this->db->select('*');
		$this->from('implemento');
		$this->where_not_in('implemento.ID_IMPLEMENTO', $datos1);
		$query=$this->db->get();
		$datos2=$query->result();
		//$datos2=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		if (false != $datos2) {
		//while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
		foreach ($datos2 as $row1) {
			$lista[$controlador] = array();
			$lista[$contador][0] = $cod_sala;
			$lista[$contador][1] = $row1->ID_IMPLEMENTO;
			$lista[$contador][2] = $row1->NOMBRE_IMPLEMENTO;
			$lista[$contador][3] = $row1->DESCRIPCION_IMPLEMENTO;
			$contador++;
		}
		}
		return $lista;
	}




	/**
	* Obtiene los datos de todas las salas de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todas las salas en el sistema
	*/
	public function getAllSalas()
	{
		//$sql="SELECT * FROM sala ORDER BY NUM_SALA"; //código MySQL
		$this->db->select('sala.ID_SALA AS cod');
		$this->db->select('sala.NUM_SALA AS num');
		$this->db->select('sala.UBICACION AS ubic');
		$this->db->select('sala.CAPACIDAD AS cap');
		$this->db->from('sala');
		$this->db->order_by("sala.NUM_SALA", "asc");
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
		
		
	/**
	* Edita la información de una sala en la base de datos
	*
	* Guarda las variables a actualizar en el array data luego se llama a la función update y se guarda el resultado de la actualización
	* en la variable 'datos'. Finalmente se retorna 1 o -1 si es que se realizó la operación correctamente o no.
	*
	* @param string $cod_sala codigo de la sala a la que se le actualizan los demás datos
	* @param string $num_sala numero de la sala editar de la sala
	* @param string $capacidad capacidad a editar de la sala
	* @param string $ubicacion ubicaciona  editar de la sala
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
	public function actualizarSala($cod_sala,$num_sala,$ubicacion,$capacidad,$implementos)
	{
		if($cod_sala=="" || $num_sala=="" || $ubicacion=="" || $capacidad=="") return 2;
		
		
		// se convierte todo el texto de la ubicación en minúscula
		$ubicacion = strtolower($ubicacion);
		$data = array(	
					'ID_SALA' => $cod_sala,
					'NUM_SALA' => $num_sala,					
					'UBICACION' => $ubicacion,			
					'CAPACIDAD' => $capacidad 
		);
		$this->db->where('ID_SALA', $cod_sala);
		$this->db->update('sala',$data); 
		$contador = 0;
		//$sql="DELETE FROM sala_implemento WHERE ID_SALA = '$cod_sala' "; //código MySQL
		$this->db->where('ID_SALA', $cod_sala);
		$datos=$this->db->delete('sala_implemento');
		//$datos=mysql_query($sql); //enviar código MySQL

		if(is_array($implementos)){

			foreach ($implementos as $imp){
				$data2 = array(
					'ID_SALA' => $cod_sala,
					'ID_IMPLEMENTO' => $imp
					);
				$datos = $this->db->insert('sala_implemento', $data2);
			}
		}
         
		if($data == true){
			return 1;
		}
		else{
			return -1;
		}
		
    }


    /**
    *
    *	@return Salas retornadas según el filtro
    */
    public function getSalasByFilter($texto, $textoFiltrosAvanzados)
	{
		$this->db->select('sala.NUM_SALA AS num_sala');
		$this->db->select('sala.CAPACIDAD AS capacidad');
		$this->db->select('sala.UBICACION AS ubicacion');
		$this->db->select('GROUP_CONCAT(DISTINCT implemento.NOMBRE_IMPLEMENTO SEPARATOR \' \' ) AS implementos');
		$this->db->select('sala.ID_SALA AS id');
		$this->db->from('sala');
		$this->db->join('sala_implemento','sala_implemento.ID_SALA = sala.ID_SALA', 'LEFT OUTER');
		$this->db->join('implemento','sala_implemento.ID_IMPLEMENTO = implemento.ID_IMPLEMENTO', 'LEFT OUTER');
		$this->db->order_by('NUM_SALA', 'asc');

		if ($texto != "") {
			$this->db->like("NUM_SALA", $texto);
			$this->db->or_like("CAPACIDAD", $texto);
			$this->db->or_like("NOMBRE_IMPLEMENTO", $texto);
		}

		else {
			
			//Sólo para acordarse
			define("BUSCAR_POR_NUM", 0);
			define("BUSCAR_POR_CAPACIDAD", 1);
			define("BUSCAR_POR_IMP", 2);
			
			if($textoFiltrosAvanzados[BUSCAR_POR_NUM] != ''){
				$this->db->like("NUM_SALA", $textoFiltrosAvanzados[BUSCAR_POR_NUM]);
			}			
			if ($textoFiltrosAvanzados[BUSCAR_POR_CAPACIDAD] != '') {
				$this->db->like("CAPACIDAD", $textoFiltrosAvanzados[BUSCAR_POR_CAPACIDAD]);

			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_IMP] != '') {
				$this->db->like("NOMBRE_IMPLEMENTO", $textoFiltrosAvanzados[BUSCAR_POR_IMP]);
			}
		}
		$this->db->group_by("sala.ID_SALA");
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	/**
	* Obtiene los implementos que actualmente tiene una sala
	*
	* Se crea la consulta para luego ser ejecutada. Esta retornará la fila de la sala correspondiente y se devolverá como un array con los resultas
	*
	* @param $cod_sala corresponde al valor del código de la sala asignado por el motor de base de datos al momento de ser ingresada
	* @return $query->result() que contiene la información de todos los implementos de la sala.
	*/

	private function getImpFromSala($cod_sala)
	{
		$this->db->select('implemento.ID_IMPLEMENTO AS codigo_implemento');
		$this->db->select('NOMBRE_IMPLEMENTO AS nombre_implemento');
		$this->db->select('DESCRIPCION_IMPLEMENTO AS descr_implemento');
		$this->db->from('sala');
		$this->db->join('sala_implemento','sala.ID_SALA = sala_implemento.ID_SALA');
		$this->db->join('implemento','sala_implemento.ID_IMPLEMENTO = implemento.ID_IMPLEMENTO');
		$this->db->where('sala.ID_SALA',$cod_sala);

		$query = $this->db->get();

		if ($query == FALSE){
			return array();
		}

		return $query->result();
	}

	/**
	* Obtiene todas las caracteristicas de una sala almacenada en el sistema
	*
	* Se crea la consulta para luego ser ejecutada. Luego con un ciclo se guardan los datos de la sala y el detalle de sus implementos.
	*
	* @param $id_sala corresponde al valor del código de la sala asignado por el motor de base de datos.
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/

	public function getDetallesSala($id_sala) {
		$this->db->select('sala.NUM_SALA AS num_sala');
		$this->db->select('sala.ID_SALA AS id_sala');
		$this->db->select('sala.CAPACIDAD AS capacidad');
		$this->db->select('sala.UBICACION AS ubicacion');
		$this->db->select('GROUP_CONCAT(DISTINCT implemento.NOMBRE_IMPLEMENTO SEPARATOR \' \' ) AS implementos');
		$this->db->join('sala_implemento','sala_implemento.ID_SALA = sala.ID_SALA', 'LEFT OUTER');
		$this->db->join('implemento','sala_implemento.ID_IMPLEMENTO = implemento.ID_IMPLEMENTO', 'LEFT OUTER');
		$this->db->where('sala.ID_SALA',$id_sala);
		$this->db->group_by("sala.ID_SALA");
		$this->db->order_by('NUM_SALA', 'asc');
		$query = $this->db->get('sala');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}

	/**
	* Obtiene los datos de todos los implementos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* 
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/
	public function VerTodosLosImplementosSimple()
	{
		$this->db->select('ID_IMPLEMENTO AS codigo_implemento');
		$this->db->select('NOMBRE_IMPLEMENTO AS nombre_implemento');
		$this->db->select('DESCRIPCION_IMPLEMENTO AS descr_implemento');
		$query = $this->db->get('implemento');

		if ($query == FALSE){
			return array();
		}

		return $query->result();
	}
	
		/**
	* Dado un número de sala se comprueba si este ya existe
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo el número de casa sala y se compara con el que se desea ingresar
	* Finalmente se retorna 1 si ya existe y cero si no
	*
	* @param $num_sala es el numero de la sala entregado por el usuario
	* @return $var es 1 es el valor de existencia del número de la sala, siendo si 1 y no 2
	*/
	public function numSalaExiste($num_sala) {
		$this->db->select('COUNT(ID_SALA) AS resultado');
		$query = $this->db->where('NUM_SALA', $num_sala);
		$query = $this->db->get('sala');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	* Dado un número de sala y un código se comprueba si este ya existe
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo el número de casa sala y código y se compara con el que se desea editar
	* comprobando que el código de la sala a editar sea distinto al consultado
	* Finalmente se retorna 1 si ya existe y cero si no
	*
	* @param $num_sala es el numero de la sala entregado por el usuario
	* @param $cod_sala es el código de la sala asignado por el motor de la base de datos al momento de ser guardada
	* @return $var es 1 es el valor de existencia del número de la sala, siendo si 1 y no 2
	*/
	
	public function numSalaExceptoExiste($num_sala, $id_sala) {
		$this->db->select('COUNT(ID_SALA) AS resultado');
		$query = $this->db->where('ID_SALA !=', $id_sala);
		$query = $this->db->where('NUM_SALA', $num_sala);
		$query = $this->db->get('sala');
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->row()->resultado > 0) {
			return TRUE;
		}
		return FALSE;
	}
}

?>
