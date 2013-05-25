<?php
 
class Model_modulo extends CI_Model {
    public $cod_modulo_tem = 0;
    var $rut_usuario2 = '';
    var $cod_equipo  = '';
    var $nombre_modulo = '';
    var $descripcion_modulo = '';

    /**
	* Obtiene los datos de todos los módulos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada módulo y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los módulos del sistema
	*/

	public function VerModulos(){//esta función será modificada
		$sql="SELECT * FROM MODULO_TEMATICO"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_MODULO_TEM'];
			$lista[$contador][1] = $row['RUT_USUARIO2'];
			$lista[$contador][2] = $row['COD_EQUIPO'];
			$lista[$contador][3] = $row['NOMBRE_MODULO'];
			$lista[$contador][4] = $row['DESCRIPCION_MODULO'];

			$contador = $contador + 1;
		}
		return $lista;
	}
	public function listaNombreModulos(){
   		$query = $this->db->get('modulo_tematico');
   		$ObjetoListaResultados = $query->result();
   		$StringResultados = array();
   		$contador = 0;
   		foreach ($ObjetoListaResultados as $row) {
   			$StringResultados[$contador] = $row->NOMBRE_MODULO;
            $contador++;
   		}
   		return $StringResultados;  	
	}
	public function listaSesionesParaAddModulo(){
		$sql="SELECT * FROM MODULO_TEMATICO"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista = array();
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador] = array();
			$lista[$contador][0] = $row['COD_SESION'];
			$lista[$contador][1] = $row['COD_MODULO_TEM'];
			$lista[$contador][2] = $row['DESCRIPCION'];
			$contador = $contador + 1;
		}
		return $lista;
	}
	public function InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores){
			//0 insertar modulo
			$data = array(					
					'RUT_USUARIO2' => $profesor_lider ,
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
			
			//2 insertar equipo profesores			
			$contador = 0;
			$confirmacion2 = true;
			while ($contador<count($equipo_profesores)){
			$data = array(					
					'RUT_USUARIO2' => $equipo_profesores[$contador],
					'COD_EQUIPO' => $cod_equipo,
					'LIDER_PROFESOR' => $profesor_lider 
					);
			$datos = $this->db->insert('profe_equi_lider',$data);
				if($datos != true){
					$confirmacion2 = false;
				}
	
			$contador = $contador + 1;
			}
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
			if($confirmacion0 == false || $confirmacion1 == false || $confirmacion2 == false || $confirmacion3 == false){
				return -1;
				}
			return 1;
	}
	
	

	public function ModificarModulo($cod_modulo_tem,$rut_usuario2,$cod_equipo,$nombre_modulo,$descripcion_modulo)
	{
		$data = array(					
					'COD_MODULO_TEM' => $cod_modulo_tem ,
					'RUT_USUARIO2' => $rut_usuario2 ,
					'COD_EQUIPO' => $cod_equipo ,
					'NOMBRE_MODULO' => $nombre_modulo ,
					'DESCRIPCION_MODULO' => $descripcion_modulo
		);
		$this->db->where('COD_MODULO_TEM', $cod_modulo_tem);
        $datos = $this->db->update('modulo_tematico',$data);
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}		
    }

}

?>