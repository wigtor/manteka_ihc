<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Modulos extends MasterManteka {
	
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
		//funcion por defecto
		$this->verModulos();
	}

	public function verModulos()
	{
		$this->load->model("Model_modulo");

		$datos_vista = array('modulos' => $this->Model_modulo->verModulos(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'requisitos' => $this->Model_modulo->VerRequisitoModulo(),'equipos' => $this->Model_modulo->VerEquipoModulo(),'profesor_lider' => $this->Model_modulo->VerProfeLiderModulo());
     
		$subMenuLateralAbierto = "verModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_ver', "barra_lateral_modulos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
	}
    
    public function agregarModulos()
    {
		$this->load->model("Model_modulo");
		$this->load->model('Model_ayudante');

		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_ayudante->VerTodosLosProfesores(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>2);
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_agregar', "barra_lateral_modulos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	
	    public function HacerAgregarModulo()
    {
		$this->load->model("Model_modulo");
		$this->load->model("Model_secciones");
		$this->load->model('Model_ayudante');
		
		$nombre_modulo = $this->input->get('nombre_modulo');
		$sesiones = $this->input->get('cod_sesion[]');
		$descripcion_modulo = $this->input->get('descripcion_modulo');
		$profesor_lider = $this->input->get('cod_profesor_lider');
		$equipo_profesores = $this->input->get('cod_profesor_equipo[]');

		$confirmacion = $this->Model_modulo->InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores);
		
		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_ayudante->VerTodosLosProfesores(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>$confirmacion);
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_agregar', "barra_lateral_modulos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	
	

    public function editarModulos()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";
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

		$this->load->model("Model_modulo");
		$datos_vista = array('rs_modulos' => $this->Model_modulo->VerModulos());
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_modulos_editar', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "editarModulos"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_modulos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
    }

    public function borrarModulos()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";
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


		$this->load->model("Model_modulo");
		$datos_vista = array('rs_modulos' => $this->Model_modulo->VerModulos());
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_modulos_borrar', $datos_vista, true);

		$datos_plantilla["subVistaLateralAbierta"] = "borrarModulos"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_modulos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);

    }


}

/* End of file Modulos.php */
/* Location: ./application/controllers/Modulos.php */