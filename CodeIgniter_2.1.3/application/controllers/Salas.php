

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Salas extends MasterManteka {

	
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
		$this->verSalas();
	}

	public function verSalas()
	{
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSalas"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		$datos_vista = array('sala' => $this->Model_sala->VerTodasLasSalas(), 'salaImplemento' => $this->Model_sala->VerTodosLosImplementosSala());
		$this->cargarTodo("Salas", 'cuerpo_salas_ver', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	public function agregarSalas()
    {
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSalas"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		

		$this->load->model('Model_sala');
		$cod_sala = $this->input->get("cod_sala");
        $num_sala = $this->input->get("num_sala");
        $ubicacion = $this->input->get("ubicacion");
        $capacidad = $this->input->get("capacidad");
		$implementos = $this->input->get("cod_implemento");
        $confirmacion = $this->Model_sala->InsertarSala($cod_sala,$num_sala,$ubicacion,$capacidad,$implementos);
	    
	  
		$datos_vista = array('implemento' => $this->Model_sala->VerTodosLosImplementos(),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Salas", 'cuerpo_salas_agregar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	
    }
    
    public function editarSalas()
    {
    	$datos_vista = 0;		
		$subMenuLateralAbierto = "editarSalas"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		

		$this->load->model('Model_sala');

		$cod_sala = $this->input->get("cod_sala");
	    $num_sala = $this->input->get("num_sala");
		$ubicacion = $this->input->get("ubicacion");;
		$capacidad = $this->input->get("capacidad");

		$implementos = $this->input->get("cod_implemento");
		$salaImplementos = $this->input->get("cod_implementoSala");
		echo $implementos[0];

        $confirmacion = $this->Model_sala->ActualizarSala($cod_sala,$num_sala,$ubicacion,$capacidad,$implementos);
	  
	  
		$datos_vista = array('salaImplemento'=>$this->Model_sala->VerTodosLosImplementosSala(),'mensaje_confirmacion'=>$confirmacion,'rs_sala' => $this->Model_sala->VerTodasLasSalas(),'mensaje_confirmacion'=>$confirmacion,'implemento' => $this->Model_sala->VerTodosLosImplementos(),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Salas", 'cuerpo_salas_editar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }

    public function borrarSalas()
    {
    	//
    }
	
	
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */