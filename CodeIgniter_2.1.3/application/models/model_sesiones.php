<?php
 
class Model_sesiones extends CI_Model {




	public function getDetallesSesion($codigo) {
		$this->db->select('COD_SESION AS codigo_sesion');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('NOMBRE_MODULO AS mod_tem');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->join('modulo_tematico', 'modulo_tematico.COD_MODULO_TEM = sesion.COD_MODULO_TEM', 'LEFT OUTER');
		$this->db->where('COD_SESION', $codigo);
		$query = $this->db->get('sesion');
		return $query->row();
	}

	public function getSesionesByFilter($texto, $textoFiltrosAvanzados)
	{

		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('NOMBRE_MODULO AS mod_tem');
		$this->db->select('COD_SESION AS id');
		$this->db->join('modulo_tematico', 'modulo_tematico.COD_MODULO_TEM = sesion.COD_MODULO_TEM', 'LEFT');
		$this->db->order_by('NOMBRE_SESION');
		
		if ($texto != "") {
			$this->db->like("NOMBRE_SESION", $texto);
			$this->db->or_like("NOMBRE_MODULO", $texto);
		}
		else{
			
			//Sólo para acordarse
			define("BUSCAR_POR_NOMBRE_SESION", 0);
			define("BUSCAR_POR_NOMBRE_MOD", 1);

			if($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_SESION] != ''){
				$this->db->like("NOMBRE_SESION", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_SESION]);
			}
			if($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_MOD] != ''){
				$this->db->like("NOMBRE_MODULO", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE_MOD]);
			}

		}

		$query = $this->db->get('sesion');
		
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function AgregarSesion($nombre_sesion,$descripcion_sesion)
	{	
		$data = array(	
					'NOMBRE_SESION' => $nombre_sesion,
					'DESCRIPCION_SESION' => $descripcion_sesion
		);
		$datos = $this->db->insert('sesion',$data); 
		
     	if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }

    public function VerTodasLasSesiones()
	{
		$sql="SELECT * FROM sesion ORDER BY COD_SESION"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_SESION'];
			$lista[$contador][1] = $row['COD_MODULO_TEM'];
			$lista[$contador][2] = $row['NOMBRE_SESION'];
			$lista[$contador][3] = $row['DESCRIPCION_SESION'];
			
			$contador = $contador + 1;
		}
		}
		return $lista;
		}

	public function EliminarSesion($codEliminar)
    {
		$this->db->where('COD_SESION', $codEliminar);
		$datos = $this->db->delete('sesion'); 
		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }

	public function EditarSesion($nombre_sesion,$descripcion_sesion, $codigo_sesion)
    {
		$data = array(					
					'NOMBRE_SESION' => $nombre_sesion ,
					'DESCRIPCION_SESION' => $descripcion_sesion
		);
		$this->db->where('COD_SESION', $codigo_sesion);
        $datos = $this->db->update('sesion',$data);
		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}	
    }

    public function nombreExisteM($nombre){
	//return $rut;
		$lista = array();
		$contador = 0;
		
		//lista usuarios
		$this->db->select('NOMBRE_SESION');
		$this->db->from('sesion');
		$query = $this->db->get();
		$datos = $query->result();
		foreach ($datos as $row) {
			$lista[$contador] = $row->NOMBRE_SESION;
			$contador++;
		}
		$contador = 0;
		while($contador < count($lista)){
			if(strtolower($lista[$contador]) == strtolower($nombre)){
				return -1;
			}
		$contador = $contador + 1;
		}
		return 1;
	}

	public function nombreExisteEM($nombre, $codigo){
		$sql="SELECT * FROM sesion ORDER BY COD_SESION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
		$var=0;
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			if($row['COD_SESION']!=$codigo){
				if( $row['NOMBRE_SESION']==$nombre){
				$var=1;
				}
			}
			$contador = $contador + 1;
		}}
		return $var;
	}

}

?>