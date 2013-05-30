<?php
 
class Model_filtro extends CI_Model {
    public $rut = 0;
    var $nombre1 = '';
    var $nombre2  = '';
    var $apellido1='';
    var $apellido2='';
    var $correo='';
    var $cod_seccion='';
    var $cod_carrera='';

	public function cmp($a, $b){
		return strcmp($a["nombre1"],$b["nombre1"]);
	}

	public function getAll()
	{

		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE as correo');
		$query = $this->db->get('estudiante');
		$array1 = $query->result();

		$this->db->select('RUT_USUARIO2 AS rut');
		$this->db->select('NOMBRE1_PROFESOR AS nombre1');
		$this->db->select('NOMBRE2_PROFESOR AS nombre2');
		$this->db->select('APELLIDO1_PROFESOR AS apellido1');
		$this->db->select('APELLIDO2_PROFESOR AS apellido2');
		$query = $this->db->get('profesor');
		$array2 = $query->result();

		$this->db->select('RUT_AYUDANTE AS rut');
		$this->db->select('NOMBRE1_AYUDANTE AS nombre1');
		$this->db->select('NOMBRE2_AYUDANTE AS nombre2');
		$this->db->select('APELLIDO1_AYUDANTE AS apellido1');
		$this->db->select('APELLIDO2_AYUDANTE AS apellido2');
		$this->db->select('CORREO_AYUDANTE as correo');
		$query = $this->db->get('ayudante');
		$array3 = $query->result();

		$this->db->select('RUT_USUARIO3 AS rut');
		$this->db->select('NOMBRE1_COORDINADOR AS nombre1');
		$this->db->select('NOMBRE2_COORDINADOR AS nombre2');
		$this->db->select('APELLIDO1_COORDINADOR AS apellido1');
		$this->db->select('APELLIDO2_COORDINADOR AS apellido2');
		$query = $this->db->get('coordinador');
		$array4 = $query->result();

		$resulta=array_merge($array1,$array2,$array3,$array4);
		//usort($resulta, "cmp");
		return $resulta;
	}

	public function getAlumnosByCodigoCarrera($carrera)
	{
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE as correo');
		$this->db->select('CODIGO_CARRERA as carrera');
		$this->db->where('carrera',$carrera);
		$this->db->order_by("APELLIDO1_ESTUDIANTE", "asc");
		$query = $this->db->get('estudiante');
		return $query->result();
	}

	public function getAllCarreras(){
		$this->db->select('NOMBRE_CARRERA as carrera');
		$this->db->order_by('carrera');
		$query = $this->db->get('carrera');
		return $query->result();
	}
}

?>