<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class About extends MasterManteka {
	
	 
	public function acercaNosotros()
	{
		
		$datos_cuerpo = array(); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = ''; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo('', "cuerpo_about", '', $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->acercaNosotros();
	}
}

/* End of file Informes.php */
/* Location: ./application/controllers/Ayuda.php */