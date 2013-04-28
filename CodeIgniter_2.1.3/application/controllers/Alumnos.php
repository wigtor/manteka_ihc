<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumnos extends CI_Controller {
	
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
	public function index()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Alumnos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', '', true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos', '', true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	public function crearAlumnos()
    {
    	//
    }
    
    public function modificarAlumnos()
    {
    	//
    }

    public function eliminarAlumnos()
    {
    	//
    }
    public function verAlumnos()
    {
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Alumnos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		//** FORMATO DE  RECEPCION EN LA VISTA => id  nombre  rut  apellido_paterno   apellido_materno  correo  carrera  seccion **//
		$listado_alumnos = [[0,"nombre1","17312767-7", "paterno1","materno1", "quedaditos@usach.cl", "informatica", "A-01"] ,
							[1,"nombre2","11111111-9", "paterno2","materno2", "quedadines@easypc.cl", "mecanica", "B-01"],
							[2,"nombre3","12345678-7", "paterno3","materno3", "quedadits@paginillas.cl", "arquitectura", "C-01"],
							[3,"nombre4","77777777-7", "paterno4","materno4", "quedados@gmail.cl", "medicina", "D-01"]];
		$datos_cuerpo['listado_alumnos'] = $listado_alumnos;
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_ver', $datos_cuerpo, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
    }
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */