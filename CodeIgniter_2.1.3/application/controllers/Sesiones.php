

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
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;


		$this->load->model('Model_sesiones');

		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_ver', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	public function ingresarSesiones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSesiones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}

	public function agregarSesiones()
	{
		$this->load->model('Model_sesiones');
		$nombre_sesion = $this->input->post("nombre_sesion");
		$descripcion_sesion = $this->input->post("descripcion_sesion");
		$confirmacion = $this->Model_sesiones->AgregarSesion($nombre_sesion,$descripcion_sesion);

		// mostramos el mensaje de operacion realizada
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ingresado la sesión con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error en el ingreso a la base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Sesiones/ingresarSesiones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Ingresar Sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$subMenuLateralAbierto = "ingresarSesiones"; 
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}

    public function nombreExisteC() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sesiones');
		$nombre = $this->input->post('nombre_post');

		$resultado = $this->Model_sesiones->nombreExisteM($nombre);
		echo json_encode($resultado);
	}

	
    public function postDetallesSesion() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$codigo = $this->input->post('sesion');
		$this->load->model('Model_sesiones');
		$resultado = $this->Model_sesiones->getDetallesSesion($codigo);
		echo json_encode($resultado);
	}

	public function postBusquedaSesiones() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_sesiones');
		$resultado = $this->Model_sesiones->getSesionesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		echo json_encode($resultado);
	}
    
    public function eliminarSesion()// alimina un alumno y de ahí carga la vista para seguir eliminando 
	{

		$this->load->model('Model_sesiones');
		$codEliminar = $this->input->post('codEliminar');

		$confirmacion = $this->Model_sesiones->EliminarSesion($codEliminar);
		
		
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha eliminado la sesión con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error con la eliminación en la base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Sesiones/borrarSesiones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Borrar Sesiones"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
    
    public function borrarSesiones()//carga la vista para borrar alumnos
	{
		$this->load->model('Model_sesiones');
		$datos_vista = array('mensaje_confirmacion'=>2);//$datos_vista = array('mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = "borrarSesiones"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_eliminar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}
	public function editarSesiones()//carga la vista para borrar alumnos
	{
		$this->load->model('Model_sesiones');
		$nombre_sesion = $this->input->post('nombre_sesion');
		$descripcion_sesion = $this->input->post('descripcion_sesion');
		$codigo_sesion = $this->input->post('codigo_sesion');
		
		$confirmacion = $this->Model_sesiones->EditarSesion($nombre_sesion,$descripcion_sesion, $codigo_sesion);
        $datos_vista = array('mensaje_confirmacion'=>$confirmacion);

		$subMenuLateralAbierto = "editarSesiones"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}
		
	
}

