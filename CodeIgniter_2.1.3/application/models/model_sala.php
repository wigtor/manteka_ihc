<?php
class Model_sala extends CI_Model {
   public $cod_sala = 0;
    var $num_sala = '';
    var $capacidad = '';
    var $ubicacion='';


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
	public function InsertarSala( $cod_sala, $num_sala, $ubicacion, $capacidad, $implementos) {
		if($num_sala=="") return 2;
		$data1 = array(					
					'COD_SALA' => $num_sala ,
					'NUM_SALA' => $num_sala ,
					'UBICACION' => $ubicacion ,
					'CAPACIDAD' => $capacidad
					
		);
		if($num_sala !="" && $ubicacion!="" && $capacidad!=""){
			$this->db->insert('SALA',$data1);}
		
	   $contador = 0;
   	   while ($contador <count($implementos)) {
		 $data2 = array(					
					'COD_SALA' => $num_sala,
					'COD_IMPLEMENTO' => $implementos[$contador]
		);
				if($implementos[$contador]!=null){
				$datos2 = $this->db->insert('sala_implemento',$data2);}
				$contador++;
         }

	
		if($data1){
			return 1;
		}
		else{
			return -1;
		}
		
    }

	/**
	* Eliminar sala de la base de datos
	*
	* Recibe el codigo de la sala para que se elimine éste y sus datos asociados de la base de datos. Se crea la consulta y luego se ejecuta ésta.
	* Finalmente se retorna 1 o -1 si es que se realizó la inserción correctamente o no.
	*
	* @param string $cod_sala codigo de la sala que se eliminará de la base de datos
	* @return int 1 o -1 en caso de éxito o fracaso en la operación
	*/
    public function EliminarSala($cod_sala)
    {

		$this->db->where('COD_SALA', $cod_sala);
		$this->db->delete('SALA_IMPLEMENTO'); 
		
		$this->db->where('COD_SALA', $cod_sala);
		$this->db->delete('SALA'); 


		if($datos == true){
			return 1;
		}
		else{
			return -1;
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
	public function VerTodosLosImplementos()
	{
		$sql="SELECT * FROM IMPLEMENTO ORDER BY NOMBRE_IMPLEMENTO"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_IMPLEMENTO'];
			$lista[$contador][1] = $row['NOMBRE_IMPLEMENTO'];
			$lista[$contador][2] = $row['DESCRIPCION_IMPLEMENTO'];
			$contador = $contador + 1;
		}
		
		return $lista;
	}
	
		/**
	* Obtiene los datos de todos los implementos de una determinada sala en la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada implemento y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los implementos del sistema
	*/
	public function VerTodosLosImplementosSala()
	{
		$sql="SELECT * FROM SALA_IMPLEMENTO "; //código MySQL
		$datos1=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista=array();
		while ($row1=mysql_fetch_array($datos1)) { //Bucle para ver todos los registros
			$cod=$row1['COD_IMPLEMENTO'];
			$sql1="SELECT * FROM IMPLEMENTO WHERE COD_IMPLEMENTO = '$cod'"; //código MySQL
			$datos=mysql_query($sql1); //enviar código MySQL
			while ($row=mysql_fetch_array($datos)) {
				$lista[$contador][0] = $row1['COD_SALA'];
				$lista[$contador][1] = $row1['COD_IMPLEMENTO'];
				$lista[$contador][2] = $row['NOMBRE_IMPLEMENTO'];
				$lista[$contador][3] = $row['DESCRIPCION_IMPLEMENTO'];
			}
			$contador++;
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
	public function VerTodasLasSalas()
	{
		$sql="SELECT * FROM SALA ORDER BY COD_SALA"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_SALA'];
			$lista[$contador][1] = $row['NUM_SALA'];
			$lista[$contador][2] = $row['UBICACION'];
			$lista[$contador][3] = $row['CAPACIDAD'];
			$contador = $contador + 1;
		}
		
		return $lista;
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
	public function ActualizarSala($cod_sala,$num_sala,$ubicacion,$capacidad,$implementos)
	{
		if($cod_sala=="") return 2;
		$data = array(	
					'COD_SALA' => $cod_sala,
					'NUM_SALA' => $num_sala,					
					'UBICACION' => $ubicacion,			
					'CAPACIDAD' => $capacidad 
		);
		$this->db->where('COD_SALA', $cod_sala);
		$this->db->update('SALA',$data); 
		$contador = 0;
   	    while ($contador <count($implementos)) {
			if($implementos[$contador]!=null){
			 if($contador==0){ // se ejecuta una sola vez
				$this->db->where('COD_SALA', $cod_sala);
				$this->db->delete('SALA_IMPLEMENTO'); 
			 }
			 $data2 = array(					
						'COD_SALA' => $cod_sala,
						'COD_IMPLEMENTO' => $implementos[$contador]
			);

				
				$datos2 = $this->db->insert('sala_implemento',$data2);}
				$contador++;
         }
         
		if($data == true){
			return 1;
		}
		else{
			return -1;
		}		
    }
}

?>
