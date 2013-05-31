

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Sesiones extends MasterManteka {

	
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
		$this->verSesiones();
	}

	public function verSesiones()
	{
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSesiones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;


		/*$this->load->model('Model_sala');
		$datos_vista = array('sala' => $this->Model_sala->VerTodasLasSalas(), 'salaImplemento' => $this->Model_sala->VerTodosLosImplementosSala());*/

		$this->cargarTodo("Sesiones", 'cuerpo_sesiones_ver', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	public function agregarSesiones()
    {
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSesiones"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		

		/*$this->load->model('Model_sala');
		$cod_sala = $this->input->get("cod_sala");
        $num_sala = $this->input->get("num_sala");
        $ubicacion = $this->input->get("ubicacion");
        $capacidad = $this->input->get("capacidad");
		$implementos = $this->input->get("cod_implemento");
        $confirmacion = $this->Model_sala->InsertarSala($cod_sala,$num_sala,$ubicacion,$capacidad,$implementos);
	    
	  
		$datos_vista = array('implemento' => $this->Model_sala->VerTodosLosImplementos(),'mensaje_confirmacion'=>$confirmacion);*/
		$this->cargarTodo("Sesiones", 'cuerpo_sesiones_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	
    }

    public function postDetallesSesiones() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('cod');
		$this->load->model('Model_sesiones');
		$resultado = $this->Model_estudiante->getDetallesEstudiante($sesion);
		echo json_encode($resultado);
	}

	public function postBusquedaSesiones() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltro');
		$tipoFiltro = $this->input->post('tipoFiltro');
		$this->load->model('Model_sesiones');

		$resultado = $this->Model_estudiante->getByFilter($tipoFiltro, $textoFiltro);
		echo json_encode($resultado);
	}
    
    
	
	
}

