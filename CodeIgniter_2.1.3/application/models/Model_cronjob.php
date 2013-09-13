<?php

/**
 * Modelo para operar sobre los datos referentes a las cuentas de usuario
 * del sistema ManteKA.
 * Posee métodos para obtener información de la base de datos
 * y para setear nueva información
 * @author Grupo 1
 */
class Model_cronJob extends CI_Model{

	/**
	*  Método que obtiene los cronjobs que pueden ser realizados según el timestamp actual
	*  
	*  @return array Listado de objetos cronJobs
	*/
	function getAllCronJobsPorHacer(){
		try {
			//Con esto es atómica la operación
			$query1 = "START TRANSACTION;";
			$query2 = "SELECT PATH_PHP_TO_EXEC AS rutaPhp FROM cron_jobs WHERE PROXIMA_EJECUCION < NOW()";
			$query3 = "UPDATE cron_jobs SET PROXIMA_EJECUCION = TIMESTAMPADD( MINUTE, PERIODICITY_MINUTES, NOW() ) WHERE PROXIMA_EJECUCION < NOW()";
			$query4 = "COMMIT";
			$query = $this->db->query($query1);
			$query = $this->db->query($query2);
			$resultados = $query->result(); //Almacenos los resultados del select, antes de hacer update
			$query = $this->db->query($query3);
			$query = $this->db->query($query4);

			return $resultados;
		}
		catch (Exception $e) {
			echo '<!-- Ha ocurrido un error al ejecutar los cronjobs, revise que exista la tabla en la base de datos -->';
		}
	}
}
?>
