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

	public function VerModulos(){
		$sql="SELECT * FROM MODULO_TEMATICO ORDER BY NOMBRE_MODULO"; 
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

}

?>