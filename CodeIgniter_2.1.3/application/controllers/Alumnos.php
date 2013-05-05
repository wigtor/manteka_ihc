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
	public function verAlumnos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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

		//cargo el modelo de estudiantes
		$this->load->model('Model_estudiante');

        $datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes());
	      


		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_ver', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);

	}

	public function eliminarAlumno($rut_estudiante)
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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

		$this->load->model('Model_estudiante');
		$confirmacion = $this->Model_estudiante->EliminarEstudiante($rut_estudiante);
		$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),'mensaje_confirmacion'=>$confirmacion);//qu? rasca la wa del mensaje, despues lo arreglo con unos if y wa

		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_borrar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);


	}


	public function agregarAlumnos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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

		$this->load->model('Model_estudiante');

		        $datos_vista = array('carreras' => $this->Model_estudiante->VerCarreras(),'secciones' => $this->Model_estudiante->VerSecciones());
		      



		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_agregar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);


	}

	public function insertarAlumno()
	{

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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
		
		$this->load->model('Model_estudiante');

		$rut_estudiante = $this->input->get("rut_estudiante");
        $nombre1_estudiante = $this->input->get("nombre1_estudiante");
        $nombre2_estudiante = $this->input->get("nombre2_estudiante");;
        $apellido_paterno = $this->input->get("apellido_paterno");
        $apellido_materno = $this->input->get("apellido_materno");
        $correo_estudiante = $this->input->get("correo_estudiante");
        $cod_seccion = $this->input->get("cod_seccion");
        $cod_carrera = $this->input->get("cod_carrera");
		
        $confirmacion = $this->Model_estudiante->InsertarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$cod_seccion,$cod_carrera);
	    
		$datos_vista = array('carreras' => $this->Model_estudiante->VerCarreras(),'secciones' => $this->Model_estudiante->VerSecciones(),'mensaje_confirmacion'=>$confirmacion);
      

	 
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_agregar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	}

	public function borrarAlumnos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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


		$this->load->model('Model_estudiante');

	    $datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),'mensaje_confirmacion'=>2);

		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_borrar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);	
	}

	public function editarAlumnos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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

		$this->load->model('Model_estudiante');

        $datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),'mensaje_confirmacion'=>2);
	      


		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_editar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);

	}

	public function EditarEstudiante()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
		redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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

		$this->load->model('Model_estudiante');

		$rut_estudiante = $this->input->get("rut_estudiante");
	        $nombre1_estudiante = $this->input->get("nombre1_estudiante");
	        $nombre2_estudiante = $this->input->get("nombre2_estudiante");;
	        $apellido_paterno = $this->input->get("apellido_paterno");
	        $apellido_materno = $this->input->get("apellido_materno");
	        $correo_estudiante = $this->input->get("correo_estudiante");


	        $confirmacion = $this->Model_estudiante->ActualizarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante);

	        $datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),'mensaje_confirmacion'=>$confirmacion);
	      




		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_alumnos_editar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_alumnos', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);	
	}

	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verAlumnos();
	}
}

/* End of file Alumnos.php */
/* Location: ./application/controllers/Alumnos.php */
