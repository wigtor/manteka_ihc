<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class Ayuda extends MasterManteka {
	
	 
	public function preguntasFrecuentes() {
		
		$datos_cuerpo = array();
		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = ''; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);

		$this->cargarTodo('', "cuerpo_faq", '', $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->preguntasFrecuentes();
	}
}

/* End of file Informes.php */
/* Location: ./application/controllers/Ayuda.php */