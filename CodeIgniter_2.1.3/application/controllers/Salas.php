

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
        $num_sala = $this->input->get("num_sala");
        $ubicacion = $this->input->get("ubicacion");
        $capacidad = $this->input->get("capacidad");
		$implementos = $this->input->get("cod_implemento");
        $confirmacion = $this->Model_sala->InsertarSala($num_sala,$ubicacion,$capacidad,$implementos);
	    
	  
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
		$cod_sala = $this->input->post("codEditar");
		$cod_salaF=$this->input->post("cod_sala");
	    $num_sala = $this->input->post("num_sala");
		$ubicacion = $this->input->post("ubicacion");
		$capacidad = $this->input->post("capacidad");
		$implementos = $this->input->post("cod_implemento");
		$implementosA= $this->input->post("cod_implementoA");

        $confirmacion = $this->Model_sala->ActualizarSala($cod_salaF,$num_sala,$ubicacion,$capacidad,$implementos,$implementosA);
	  
	  
		$datos_vista = array('implementoA'=>$this->Model_sala->ImplementosAusentes($cod_sala),'mensaje_confirmacion'=>2,'rs_sala' => $this->Model_sala->VerTodasLasSalas(),'mensaje_confirmacion'=>2,'implemento' => $this->Model_sala->ImplementosParticulares($cod_sala),'mensaje_confirmacion'=>2,'sala' => $this->Model_sala->VerSala($cod_sala),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Salas", 'cuerpo_salas_editar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }

	 public function borrarSalas()
    {
    	$datos_vista = 0;		
		$subMenuLateralAbierto = "borrarSalas"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		$cod_sala = $this->input->post("codEliminar");
		$confirmacion = $this->Model_sala->EliminarSala($cod_sala);
		$datos_vista = array('sala' => $this->Model_sala->VerTodasLasSalas(),'mensaje_confirmacion'=>$confirmacion, 'salaImplemento' => $this->Model_sala->VerTodosLosImplementosSala(),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Salas", 'cuerpo_salas_eliminar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }

	
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */