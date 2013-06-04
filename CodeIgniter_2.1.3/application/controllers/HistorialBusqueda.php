<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php';

/**
* Clase que responde a las solicitudes de los ajax de historiales de búsqueda
* @author Grupo 1
*/
class HistorialBusqueda extends MasterManteka {

	/**
	* Método que recibe un string con una búsqueda y retorna las búsquedas pasadas que coincidan
	* 
	* @param string $tipo_busqueda indica si la búsqueda es de coordinadores, profesores, ayudantes, o estudiantes
	*/
	public function buscar($tipo_busqueda) {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$letras = $this->input->post('letras');
		$rutUsuario = $this->session->userdata('rut');
		$this->load->model('model_busquedas');
		$resultado = $this->model_busquedas->getBusquedasAnteriores($letras, $rutUsuario, $tipo_busqueda);
		echo json_encode($resultado);
	}
}

/* End of file HistorialBusqueda.php */
/* Location: ./application/controllers/HistorialBusqueda.php */
