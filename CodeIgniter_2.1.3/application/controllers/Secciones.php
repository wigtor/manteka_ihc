

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Secciones extends MasterManteka {


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
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'rs_estudiantes'=>$this->Model_secciones->VerTodosLosEstudiantes($cod_seccion),'secc' =>$this->Model_secciones->VerSeccion($cod_seccion));
		$this->cargarTodo("Secciones", 'cuerpo_secciones_ver', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	
	public function agregarSecciones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$nombre_seccion1 = $this->input->post("rs_seccion");
		$nombre_seccion2 = $this->input->post("rs_seccion2");
		$confirmacion = $this->Model_secciones->AgregarSeccion($nombre_seccion1,$nombre_seccion2);
        $datos_vista = array('mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_agregar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}

	
    
    public function editarSecciones()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "editarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
		$nombre_seccion1 = $this->input->post("rs_seccion");
		$nombre_seccion2 = $this->input->post("rs_seccion2");
		$confirmacion = $this->Model_secciones->ActualizarSeccion($cod_seccion,$nombre_seccion1,$nombre_seccion2);
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_editar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
    }

    public function borrarSecciones()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "borrarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
		$cod_seccion1 = $this->input->post("rs_seccion");
		$confirmacion = $this->Model_secciones->EliminarSeccion($cod_seccion1);
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'rs_estudiantes'=>$this->Model_secciones->VerTodosLosEstudiantes($cod_seccion),'secc' =>$this->Model_secciones->VerSeccion($cod_seccion),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_borrar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	public function asignarAsecciones()
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
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_secciones_asignar', '', true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "asignarAseccion"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_secciones', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);



	}

	
	
}
/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */