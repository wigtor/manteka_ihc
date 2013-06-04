<?php
 
class Model_sesiones extends CI_Model {



public function getAlumnosByFilter($tipoFiltro, $texto)
	{

		//Sólo para acordarse
		define("BUSCAR_POR_CODIGO", 1);

		$attr_filtro = "";
		if ($tipoFiltro == BUSCAR_POR_CODIGO) {
			$attr_filtro = "COD_SESION";
		}
		else {
			return array(); //No es válido, devuelvo vacio
		}

		$this->db->select('COD_SESION AS codigo');
		$this->db->select('COD_SECCION AS nommbre');
		$this->db->select('COD_MODULO_TEM AS nombre2');
		$this->db->select('APELLIDO_PATERNO AS apellido1');
		$this->db->select('APELLIDO_MATERNO AS apellido2');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->order_by('APELLIDO_PATERNO', 'asc');
		$this->db->like($attr_filtro, $texto);
		$query = $this->db->get('estudiante');
		return $query->result();
	}


	public function getDetallesEstudiante($rut) {
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO_PATERNO AS apellido1');
		$this->db->select('APELLIDO_MATERNO AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE AS correo');
		$this->db->select('NOMBRE_CARRERA AS carrera');
		$this->db->select('COD_SECCION AS seccion');
		$this->db->join('carrera', 'carrera.COD_CARRERA = estudiante.COD_CARRERA');
		$this->db->where('RUT_ESTUDIANTE', $rut);
		$query = $this->db->get('estudiante');
		return $query->row();
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
					'NOMBRE_SECCION' => $nombre
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

}

?>