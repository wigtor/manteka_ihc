<?php
 
class model_planificacion extends CI_Model {

  

    /**
	* Obtiene los datos de todos los módulos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada módulo y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los módulos del sistema
	*/

	public function selectPlanificacion(){

	/*	$sql = "SELECT  FROM WHERE  ";

		$data = mysql_query($sql);
		echo mysql_error();
		$filas;
		$i = 0;
		while ($fila = mysql_fetch_array($data)) {
			$filas[$i][0] = $fila['COD_SECCION'];
			$filas[$i][1] = $fila['NOMBRE1_PROFESOR'];
			$filas[$i][2] = $fila['NOMBRE2_PROFESOR'];
			$filas[$i][3] = $fila['APELLIDO1_PROFESOR'];
			$filas[$i][4] = $fila['APELLIDO2_PROFESOR'];
			$filas[$i][5] = $fila['NOMBRE_MODULO'];
			$filas[$i][6] = $fila['DESCRIPCION_SESION'];
			$filas[$i][7] = $fila['NUM_SALA'];
			$filas[$i][8] = $fila['COD_DIA'];
			$filas[$i][9] = $fila['COD_MODULO'];
			$i = $i + 1;
		}
		return $filas; */

		$columnas = 'seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO';
		$condiciones = '(seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO)';
		$desde = '`seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia`';

		$query = $this->db->select($columnas);
		
		$query = $this->db->where($condiciones);

		$query = $this->db->get($desde);

		$array = $query->result_array();
						
		return $array;

	}

	/*public function VerModulos(){
		$sql="SELECT * FROM MODULO_TEMATICO"; 
		$datos=mysql_query($sql); 
		$contador = 0;
		$lista;
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

SELECT seccion.COD_SECCION, profesor.NOMBRE1_PROFESOR, profesor.NOMBRE2_PROFESOR, profesor.APELLIDO1_PROFESOR, profesor.APELLIDO2_PROFESOR, modulo_tematico.NOMBRE_MODULO, sala.NUM_SALA, horario.NOMBRE_HORARIO, dia.NOMBRE_DIA, modulo.NUMERO_MODULO FROM `seccion`, `profesor`, `modulo_tematico`, `sala`, `horario`, `sala_horario`, `equipo_profesor`, `profe_equi_lider`, `seccion_mod_tem`, `modulo`, `dia` WHERE (seccion_mod_tem.COD_SECCION = seccion.COD_SECCION) AND (seccion_mod_tem.COD_MODULO_TEM  = modulo_tematico.COD_MODULO_TEM) AND (seccion_mod_tem.ID_HORARIO_SALA = sala_horario.ID_HORARIO_SALA) AND (sala_horario.COD_SALA = sala.COD_SALA) AND (sala_horario.COD_HORARIO = horario.COD_HORARIO) AND (modulo_tematico.COD_EQUIPO = equipo_profesor.COD_EQUIPO) AND (equipo_profesor.COD_EQUIPO = profe_equi_lider.COD_EQUIPO) AND (profe_equi_lider.LIDER_PROFESOR = 1) AND (profe_equi_lider.RUT_USUARIO2 = profesor.RUT_USUARIO2) AND (modulo_tematico.COD_MODULO_TEM = equipo_profesor.COD_MODULO_TEM) AND (dia.COD_DIA = horario.COD_DIA) AND (modulo.COD_MODULO = horario.COD_MODULO);
*/

}

?>