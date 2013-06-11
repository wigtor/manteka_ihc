<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planificacion extends CI_Controller {
	
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
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Planificacion";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		$this->load->model('model_planificacion');
		$filas =  array('lista' => $this->model_planificacion->selectPlanificacion());

	


		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_planificacion', $filas, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "verPlanificacion"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_planificacion', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);


		

		
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verPlanificacion();
	}
}

