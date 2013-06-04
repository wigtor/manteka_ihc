<?php
 
class Model_sesiones extends CI_Model {




	public function getDetallesSesiones($sesion) {
		$this->db->select('COD_SESION AS cod_sesion');
		$this->db->select('COD_MODULO_TEM AS cod_mod_tem');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION AS descipcion');
		$this->db->join('modulo_tematico', 'modulo_tematico.COD_MODULO_TEM = sesion.COD_MODULO_TEM');
		$this->db->where('COD_SESION', $sesion);
		$query = $this->db->get('sesion');
		return $query->row();
	}

public function getSesionesByFilter($tipoFiltro, $texto)
	{

		//Sólo para acordarse
		define("BUSCAR_POR_NOMBRE", 1);
		define("BUSCAR_POR_CODIGO", 2);

		$attr_filtro = "";
		if ($tipoFiltro == BUSCAR_POR_NOMBRE) {
			$attr_filtro = "NOMBRE_SESION";
		}
		else if ($tipoFiltro == BUSCAR_POR_CODIGO) {
			$attr_filtro = "CODIGO_SESION";
		}
		else {
			return array(); //No es válido, devuelvo vacio
		}

		$this->db->select('COD_SESION AS cod_sesion');
		$this->db->select('COD_MODULO_TEM AS cod_mod_tem');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION AS descipcion');
		$this->db->join('modulo_tematico', 'modulo_tematico.COD_MODULO_TEM = sesion.COD_MODULO_TEM');
		$this->db->order_by('APELLIDO1_ESTUDIANTE', 'asc');
		$this->db->like($attr_filtro, $texto);
		$query = $this->db->get('sesion');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function AgregarSesion($nombre_sesion,$descripcion_sesion)
	{
		$sql="SELECT * FROM sesion ORDER BY COD_SECCION"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista=array();
		$var=0;
		if (false != $datos) {
			while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
				if( $row['NOMBRE_SESION']==$nombre_sesion){
					$var=1;
				}
				$contador = $contador + 1;
			}
		}	
		
		if($var!=1){
		$data = array(	
					'NOMBRE_SECCION' => $nombre_sesion,
					'DESCRIPCION_SESION' => $descripcion_sesion
		);
		$this->db->insert('sesion',$data); 
		
         
		if($data == true){
			return 1;
		}
		else{
			return -1;
		}}
		else return 3;
    }

    public function VerTodasLasSesiones()
	{
		$sql="SELECT * FROM sesion ORDER BY COD_SESION"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista = array();
		if (false != $datos) {
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][2] = $row['NOMBRE_SESION'];
			
			$contador = $contador + 1;
		}
		}
		return $lista;
		}

}

?>