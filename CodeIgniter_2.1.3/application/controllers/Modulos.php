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

  
		$subMenuLateralAbierto = "verModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_ver', "barra_lateral_planificacion", "", $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
	}
    
    public function agregarModulos()
    {
		$this->load->model("Model_modulo");

		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_modulo->VerTodosLosProfesoresAddModulo(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>2,'requisitos' => $this->Model_modulo->listaRequisitosParaAddModulo());
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	
	    public function HacerAgregarModulo()
    {
		$this->load->model("Model_modulo");

		
		$nombre_modulo = $this->input->post('nombre_modulo');
		$sesiones = $this->input->post('cod_sesion');
		$descripcion_modulo = $this->input->post('descripcion_modulo');
		$profesor_lider = $this->input->post('cod_profesor_lider');
		$equipo_profesores = $this->input->post('cod_profesor_equipo');
		$requisitos = $this->input->post('cod_requisito');
		
		$confirmacion = $this->Model_modulo->InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos);
		
		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_modulo->VerTodosLosProfesoresAddModulo(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>$confirmacion,'requisitos' => $this->Model_modulo->listaRequisitosParaAddModulo());
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	
	

    public function editarModulos()
    {
	
		$this->load->model("Model_modulo");
		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'mensaje_confirmacion'=>2);
		$subMenuLateralAbierto = "editarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }

    public function borrarModulos()
    {
		
		$this->load->model("Model_modulo");

		$datos_vista = array('mensaje_confirmacion'=>2);
     
		$subMenuLateralAbierto = "borrarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_borrar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		

    }
	
	public function hacerBorrarModulos()
    {
		
		$this->load->model("Model_modulo");
		$cod_modulo_eliminar = $this->input->post('cod_modulo_eliminar');
		$confirmacion = $this->Model_modulo->EliminarModulo($cod_modulo_eliminar);
	
		$datos_vista = array('mensaje_confirmacion'=>$confirmacion);
     
		$subMenuLateralAbierto = "borrarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_borrar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		

    }

	public function verModulosEditar(){
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');

		$resultado = $this->Model_modulo->getAllModulos();
		echo json_encode($resultado);
	}         
	public function obtenerSesionesEditar() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');

		$resultado = $this->Model_modulo->listaSesionesParaEditarModulo();
		echo json_encode($resultado);
	}
	
	public function obtenerSesionesVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
		$resultado = $this->Model_modulo->listaSesionesParaVerModulo($cod_mod);
		echo json_encode($resultado);
	}
	
	public function obtenerProfes() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;$this->db->where('name', $name); 
		}
		$cod_equipo = $this->input->post('cod_equipo_post');
		$this->load->model('Model_modulo');
		$resultado = $this->Model_modulo->profesEditarModulo($cod_equipo);
		echo json_encode($resultado);
	}
	public function obtenerProfesVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$cod_equipo = $this->input->post('cod_equipo_post');
		$this->load->model('Model_modulo');
		$resultado = $this->Model_modulo->listaProfesoresVerModulo($cod_equipo);
		echo json_encode($resultado);
	}
	
	
	public function obtenerRequisitos() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
	
		$resultado = $this->Model_modulo->listaRequisitosParaEditarModulo($cod_mod);
		echo json_encode($resultado);
	}
	
	public function obtenerRequisitosVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
	
		$resultado = $this->Model_modulo->listaRequisitosVerModulo($cod_mod);
		echo json_encode($resultado);
	}
	
	public function HacerEditarModulo()
    {
		$this->load->model("Model_modulo");

		
		$nombre_modulo = $this->input->post('nombre_modulo');
		$sesiones = $this->input->post('sesion');
		$descripcion_modulo = $this->input->post('descripcion_modulo');
		$profesor_lider = $this->input->post('cod_profesor_lider');
		$equipo_profesores = $this->input->post('profesores');
		$requisitos = $this->input->post('requisitos');
		$cod_equipo = $this->input->post('cod_equipo2');
		$cod_mod = $this->input->post('cod_modulo');

		$confirmacion = $this->Model_modulo->EditarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos,$cod_equipo,$cod_mod);

		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'mensaje_confirmacion'=>$confirmacion);

	 
		$subMenuLateralAbierto = "editarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Modulos", 'cuerpo_modulos_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
}

/* End of file Modulos.php */
/* Location: ./application/controllers/Modulos.php */