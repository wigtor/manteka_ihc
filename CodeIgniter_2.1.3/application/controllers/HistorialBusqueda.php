<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class HistorialBusqueda extends MasterManteka {

	/**
	* Método que responde a una solicitud de post para pedir los datos de un estudiante
	* Recibe como parámetro el rut del estudiante
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

/* End of file Alumnos.php */
/* Location: ./application/controllers/Alumnos.php */
