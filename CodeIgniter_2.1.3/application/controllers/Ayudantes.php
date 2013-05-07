<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ayudantes extends CI_Controller {
	
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
	public function verAyudantes()
	{
		//$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		//if ($rut == FALSE) {
			//redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		//}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$this->load->model('Model_ayudante');

        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());
      

		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_verAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verAyudantes();
	}

	/////////////////////////////////////////////////////////////////////////////////////

	public function agregarAyudantes()
	{
		//$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		//if ($rut == FALSE) {
			//redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		//}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$this->load->model('Model_ayudante');

	  
		$datos_vista = array('profesores' => $this->Model_ayudante->VerTodosLosProfesores(),'mensaje_confirmacion'=>2);
      
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_agregarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	public function insertarAyudante()
	{
		//$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		//if ($rut == FALSE) {
			//redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		//}

		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		
		
		$this->load->model('Model_ayudante');

		$rut_ayudante = $this->input->get("rut_ayudante");
        $nombre1_ayudante = $this->input->get("nombre1_ayudante");
        $nombre2_ayudante = $this->input->get("nombre2_ayudante");;
        $apellido_paterno = $this->input->get("apellido_paterno");
        $apellido_materno = $this->input->get("apellido_materno");
        $correo_ayudante = $this->input->get("correo_ayudante");
        $cod_profesores = $this->input->get("cod_profesores");

		
        $confirmacion = $this->Model_ayudante->InsertarAyudante($rut_ayudante,$nombre1_ayudante,$nombre2_ayudante,$apellido_paterno,$apellido_materno,$correo_ayudante,$cod_profesores);
	    
		$datos_vista = array('secciones' => $this->Model_ayudante->VerSecciones(),'mensaje_confirmacion'=>$confirmacion,'profesores' => $this->Model_ayudante->VerTodosLosProfesores());
      
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_agregarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);


		}
	
	

	public function editarAyudantes()
	{
		/*$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}*/
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		
		$this->load->model('Model_ayudante');

        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),'mensaje_confirmacion'=>2);
      

		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_editarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	
	
	public function EditarAyudante()
	{
		/*$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}*/
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		
		$this->load->model('Model_ayudante');

        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),'mensaje_confirmacion'=>2);
      

		$rut_ayudante = $this->input->get("rut_ayudante");
	    $nombre1_ayudante = $this->input->get("nombre1_ayudante");
		$nombre2_ayudante = $this->input->get("nombre2_ayudante");;
		$apellido_paterno = $this->input->get("apellido_paterno");
		$apellido_materno = $this->input->get("apellido_materno");
		$correo_ayudante = $this->input->get("correo_ayudante");


        $confirmacion = $this->Model_ayudante->ActualizarAyudante($rut_ayudante,$nombre1_ayudante,$nombre2_ayudante,$apellido_paterno,$apellido_materno,$correo_ayudante);

        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),'mensaje_confirmacion'=>$confirmacion);	  
	  
	  
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_editarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	
	

	public function borrarAyudantes()
	{
		/*$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}*/
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$this->load->model('Model_ayudante');

        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),'mensaje_confirmacion'=>2);
      

		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_borrarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	public function EliminarAyudante($rut_ayudante)
	{
		/*$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}*/
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$this->load->model('Model_ayudante');
		$confirmacion = $this->Model_ayudante->EliminarAyudante($rut_ayudante);
        $datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),'mensaje_confirmacion'=>$confirmacion);
      

		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_borrarAyudante', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}


}