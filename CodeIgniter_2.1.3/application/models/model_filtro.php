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
		$this->db->select('CORREO1_USER as correo');
		$this->db->from('profesor');
		$this->db->join('usuario','profesor.RUT_USUARIO2 = usuario.RUT_USUARIO');
		$query = $this->db->get();
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
		$this->db->select('CORREO1_USER as correo');
		$this->db->from('coordinador');
		$this->db->join('usuario','coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
		$query = $this->db->get();
		$array4 = $query->result();
		if ($query == FALSE) {
			return array();
		}
		$resulta=array_merge($array1,$array2,$array3,$array4);
		//usort($resulta, "cmp");
		return $resulta;
	}

	public function getAllCarreras(){
		$this->db->select('NOMBRE_CARRERA as carrera');
		$this->db->select('COD_CARRERA as codigo');
		$this->db->order_by('carrera');
		$query = $this->db->get('carrera');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}



	public function getAlumnosByFiltro($profesor,$codigo,$seccion,$modulo_tematico,$bloque){
		$this->db->select('RUT_ESTUDIANTE AS rut');
		$this->db->select('NOMBRE1_ESTUDIANTE AS nombre1');
		$this->db->select('NOMBRE2_ESTUDIANTE AS nombre2');
		$this->db->select('APELLIDO1_ESTUDIANTE AS apellido1');
		$this->db->select('APELLIDO2_ESTUDIANTE AS apellido2');
		$this->db->select('CORREO_ESTUDIANTE AS correo');
		$this->db->select('estudiante.COD_CARRERA AS codigo');
		$this->db->from('estudiante');

		if($profesor!=""){
			$this->db->join('profe_seccion','estudiante.COD_SECCION = profe_seccion.COD_SECCION');
			$this->db->join('profesor','profe_seccion.RUT_USUARIO2 = profesor.RUT_USUARIO2');
			$this->db->where('profesor.RUT_USUARIO2',$profesor);
		}
		if($codigo!=""){
			$this->db->join('carrera','estudiante.COD_CARRERA = carrera.COD_CARRERA');
			$this->db->where('estudiante.COD_CARRERA',$codigo);
		}
		if($seccion!=""){
			$this->db->where('estudiante.COD_SECCION',$seccion);
		}
		if($modulo_tematico!=""){
			$this->db->join('seccion','estudiante.COD_SECCION = seccion.COD_SECCION');
			$this->db->join('seccion_mod_tem','seccion.COD_SECCION = seccion_mod_tem.COD_SECCION');
			$this->db->join('modulo_tematico','seccion_mod_tem.COD_MODULO_TEM = modulo_tematico.COD_MODULO_TEM');
			$this->db->where('modulo_tematico.COD_MODULO_TEM',$modulo_tematico);
		}
		if($bloque!=""){
			if($modulo_tematico==""){
				$this->db->join('seccion','estudiante.COD_SECCION = seccion.COD_SECCION');
				$this->db->join('seccion_mod_tem','seccion_mod_tem.COD_SECCION = seccion.COD_SECCION');
			}
			$this->db->join('sala_horario','sala_horario.ID_HORARIO_SALA = seccion_mod_tem.ID_HORARIO_SALA');
			$this->db->join('horario','horario.COD_HORARIO = sala_horario.COD_HORARIO');
			$this->db->where('horario.COD_HORARIO',$bloque);
		}
		$this->db->order_by("NOMBRE1_ESTUDIANTE","asc");
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function getAyudantesByFiltro($profesor,$seccion,$modulo_tematico,$bloque){
		$this->db->select('ayudante.RUT_AYUDANTE AS rut');
		$this->db->select('NOMBRE1_AYUDANTE AS nombre1');
		$this->db->select('NOMBRE2_AYUDANTE AS nombre2');
		$this->db->select('APELLIDO1_AYUDANTE AS apellido1');
		$this->db->select('APELLIDO2_AYUDANTE AS apellido2');
		$this->db->select('CORREO_AYUDANTE AS correo');
		$this->db->distinct();
		$this->db->from('ayudante');
		$this->db->join('ayu_profe','ayudante.RUT_AYUDANTE = ayu_profe.RUT_AYUDANTE');

		if($profesor!=""){
			$this->db->join('profesor','profesor.RUT_USUARIO2 = ayu_profe.RUT_USUARIO2');
			$this->db->where('profesor.RUT_USUARIO2',$profesor);
		}

		if($seccion!=""){
			$this->db->where('ayu_profe.COD_SECCION',$seccion);
		}
		if($modulo_tematico!=""){
			$this->db->join('seccion','ayu_profe.COD_SECCION = seccion.COD_SECCION');
			$this->db->join('seccion_mod_tem','seccion.COD_SECCION = seccion_mod_tem.COD_SECCION');
			$this->db->join('modulo_tematico','seccion_mod_tem.COD_MODULO_TEM = modulo_tematico.COD_MODULO_TEM');
			$this->db->where('modulo_tematico.COD_MODULO_TEM',$modulo_tematico);
		}
		if($bloque!=""){
			if($modulo_tematico==""){
				$this->db->join('seccion','ayu_profe.COD_SECCION = seccion.COD_SECCION');
				$this->db->join('seccion_mod_tem','seccion.COD_SECCION = seccion_mod_tem.COD_SECCION');
			}
			$this->db->join('sala_horario','sala_horario.ID_HORARIO_SALA = seccion_mod_tem.ID_HORARIO_SALA');
			$this->db->join('horario','horario.COD_HORARIO = sala_horario.COD_HORARIO');
			$this->db->where('horario.COD_HORARIO',$bloque);
		}
		$this->db->order_by("NOMBRE1_AYUDANTE","asc");
		$query = $this->db->get();
		//return $this->db->_error_message();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function getProfesoresByFiltro($seccion,$modulo_tematico,$bloque){
		$this->db->select('profe_seccion.RUT_USUARIO2 AS rut');
		$this->db->select('NOMBRE1_PROFESOR AS nombre1');
		$this->db->select('NOMBRE2_PROFESOR AS nombre2');
		$this->db->select('APELLIDO1_PROFESOR AS apellido1');
		$this->db->select('APELLIDO2_PROFESOR AS apellido2');
		$this->db->select('CORREO1_USER as correo');
		$this->db->distinct();
		$this->db->from('profesor');
		$this->db->join('usuario','profesor.RUT_USUARIO2 = usuario.RUT_USUARIO');

		if($seccion!=""){		
			$this->db->join('profe_seccion','profesor.RUT_USUARIO2 = profe_seccion.RUT_USUARIO2');
			$this->db->where('profe_seccion.COD_SECCION',$seccion);
		}
		if($modulo_tematico!=""){
			if($seccion==""){
				$this->db->join('profe_seccion','profesor.RUT_USUARIO2 = profe_seccion.RUT_USUARIO2');
			}
			$this->db->join('seccion','seccion.COD_SECCION = profe_seccion.COD_SECCION');
			$this->db->join('seccion_mod_tem','seccion.COD_SECCION = seccion_mod_tem.COD_SECCION');
			$this->db->join('modulo_tematico','seccion_mod_tem.COD_MODULO_TEM = modulo_tematico.COD_MODULO_TEM');
			$this->db->where('modulo_tematico.COD_MODULO_TEM',$modulo_tematico);
		}
		if($bloque!=""){
			if($modulo_tematico=="" && $seccion==""){
				$this->db->join('profe_seccion','profesor.RUT_USUARIO2 = profe_seccion.RUT_USUARIO2');
			}
			if($modulo_tematico==""){
				$this->db->join('seccion_mod_tem','seccion_mod_tem.COD_SECCION = profe_seccion.COD_SECCION');
			}
			$this->db->join('sala_horario','sala_horario.ID_HORARIO_SALA = seccion_mod_tem.ID_HORARIO_SALA');
			$this->db->join('horario','horario.COD_HORARIO = sala_horario.COD_HORARIO');
			$this->db->where('horario.COD_HORARIO',$bloque);
		}
		$this->db->order_by("NOMBRE1_PROFESOR","asc");
		$query = $this->db->get();
		if($query == FALSE){
			return array();
		}
		return $query->result();
	}

	public function getAllSecciones(){
		$this->db->select('COD_SECCION as codigo');
		$this->db->order_by("COD_SECCION","asc");
		$query = $this->db->get('seccion');
		return $query->result();
	}

	public function getAllHorarios(){
		$this->db->select('NOMBRE_HORARIO AS nombre');
		$this->db->select('COD_HORARIO AS codigo');
		$this->db->order_by("COD_DIA","asc");
		$query = $this->db->get('horario');
		return $query->result();
	}

	public function getAllModulosTematicos(){
		$this->db->select('NOMBRE_MODULO AS nombre');
		$this->db->select('COD_MODULO_TEM AS codigo');
		$this->db->order_by("NOMBRE_MODULO","asc");
		$query = $this->db->get('modulo_tematico');
		return $query->result();
	}
}

?>