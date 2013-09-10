<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Planificacion extends MasterManteka {
	
/**
* Transporta los datos de la capa de modelo a la vista
* Carga el modelo y transforma los datos en un arreglo que puede ser utilizado en la vista
* 
* @param null
* @return null
* 
*/
 
	public function verPlanificacion()
	{

		$datos_vista = 0;		
		$subMenuLateralAbierto = "verPlanificacion"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->load->model('model_planificacion');
        $datos_vista = array('lista' => $this->model_planificacion->selectPlanificacion());
		$this->cargarTodo("Planificacion", 'cuerpo_planificacion', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

		
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verPlanificacion();
	}
}

