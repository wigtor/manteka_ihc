<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secciones extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() //Esto hace que el index sea la vista que se desee
	{

		$this->verSecciones();
	}

	public function verSecciones()
	{

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}

		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Secciones";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = 	FALSE; //No s? si se necesite ver la barra de progreso en este caso (Arm.)
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		//L?gica del controlador
		
		
		
		
		


		//Lógica del controlador
		//Cargamos el modelo correspondiente y le ordenamos retornar la lista de secciones
		$this->load->model('model_secciones');
		$secciones['secciones'] = $this->model_secciones->ObtenerTodasSecciones();
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_secciones_ver', $secciones, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "verSecciones"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_secciones', $datos_plantilla, true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);

	}


	public function agregarSecciones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Secciones";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_secciones_agregar', '', true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "agregarSecciones"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_secciones', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	
    
    public function modificarSecciones()
    {
    	//
    }

    public function borrarSecciones()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Secciones";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_secciones_borrar', '', true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "borrarSecciones"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_secciones', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
    }
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */