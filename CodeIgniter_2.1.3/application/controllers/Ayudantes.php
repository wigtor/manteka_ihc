<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class Ayudantes extends MasterManteka {
	
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
	 
	 	 
	/**
	* Manda a la vista 'cuerpo_profesores_verAyudante' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se cargan los datos de la vista con la lista 'rs_ayudantes' que contiene toda la información de los
	* ayudantes del sistema. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function verAyudantes()
	{
		$datos_plantilla = array();
		$subMenuLateralAbierto = 'verAyudantes'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Docentes", "cuerpo_profesores_verAyudante", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verAyudantes();
	}

	/**
	* Manda a la vista 'cuerpo_profesores_agregarAyudante' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se cargan los datos de la vista con la lista 'profesores' para que en la vista se escoja el profesor asociado al ayudante
	* También se envía un mensaje de confirmación con valor 2, que indica que se está cargando
	* por primera ves la vista de agregar ayudante. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function agregarAyudantes()
	{
		$this->load->model('Model_ayudante');
		$datos_plantilla = array('profesores' => array(),'mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = 'agregarAyudantes'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Docentes", "cuerpo_profesores_agregarAyudante", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	
	/**
	* Inserta un ayudante al sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_agregarAyudante'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se llama a la función InsertarAyudante para ingresar al ayudante
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'profesores' para que esté habilitada para nuevos ingresos.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function insertarAyudante()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}

		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
	
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

		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "agregarAyudantes"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', $datos_plantilla, true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	
	
	/**
	* Manda a la vista 'cuerpo_profesores_editarAyudante' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se cargan los datos de la vista con la lista 'rs_ayudantes' que contiene la lista de todos los ayudantes para que desde ahí en la vista
	* se escoja un un ayudante a editar.
	* También se envía un mensaje de confirmación con valor 2, que indica que se está cargando por primera ves la vista de editar ayudantes.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function editarAyudantes()
	{
		$this->load->model('Model_ayudante');
        $datos_plantilla = array('rs_ayudantes' => array(),'mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = 'editarAyudantes'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Docentes", "cuerpo_profesores_editarAyudante", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	/**
	* Edita la información de un ayudante del sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_editarAyudante'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se llama a la función ActualizarAyudante para editar el ayudante
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de esta operacion se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'rs_ayudantes' para que esté habilitada para nuevas ediciones.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function EditarAyudante()
	{
		$this->load->model('Model_ayudante');

		$rut_ayudante = $this->input->post("rutEditar");
		$nombre1_ayudante = $this->input->post("nombre1_ayudante");
		$nombre2_ayudante = $this->input->post("nombre2_ayudante");;
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$correo_ayudante = $this->input->post("correo_ayudante");


		$confirmacion = $this->Model_ayudante->ActualizarAyudante($rut_ayudante,$nombre1_ayudante,$nombre2_ayudante,$apellido_paterno,$apellido_materno,$correo_ayudante);

		$datos_plantilla["titulo_msj"] = "Ayudante editado";
		$datos_plantilla["cuerpo_msj"] = "El ayudante fue editado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'Ayudantes/editarAyudantes';
		$datos_plantilla["nombre_redirecTo"] = "Editar ayudantes";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
	
	/**
	* Manda a la vista 'cuerpo_profesores_borrarAyudante' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se cargan los datos de la vista con la lista 'rs_ayudantes' que contiene toda la información de los
	* ayudantes del sistema y se envia un 'mensaje_confirmacion' que sirve en la vista para que ésta sepa que se está cargando la página por primera vez.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function borrarAyudantes()
	{
		$this->load->model('Model_ayudante');
        $datos_vista = array('rs_ayudantes' => array(),'mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = 'borrarAyudantes'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Docentes", "cuerpo_profesores_borrarAyudante", "barra_lateral_profesores", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	/**
	* Elimina un ayudante del sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_borrarAyudante'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de ayudantes, se llama a la función EliminarAyudante para eliminar el ayudante con el rut que se le pasa como parametro
	* y es el que se ha recibido como parametro en esta funcion desde la vista. El resultado de la operación de eliminar desde el modelo se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'rs_ayudantes' para que se de la opción a escojer un nuevo ayudante a eliminar.
	* Finalmente se carga la vista con todos los datos.
	*
	* @param string $rut_estudiante
	*/
	public function EliminarAyudante()
	{
		$this->load->model('Model_ayudante');
		$rut_ayudante = $this->input->post('rutToDelete');
		$confirmacion = $this->Model_ayudante->EliminarAyudante($rut_ayudante);
		

		$datos_plantilla["titulo_msj"] = "Ayudante eliminado";
		$datos_plantilla["cuerpo_msj"] = "El ayudante fue eliminado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'Ayudantes/borrarAyudantes';
		$datos_plantilla["nombre_redirecTo"] = "Eliminar ayudantes";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);



	}



	/**
	* Método que responde a una solicitud de post para pedir los datos de un ayudante
	* Recibe como parámetro el rut del estudiante
	*/
	public function postDetallesAyudante() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('rut');
		$this->load->model('Model_ayudante');
		$resultado = $this->Model_ayudante->getDetallesAyudante($rut);
		echo json_encode($resultado);
	}

	public function postBusquedaAyudantes() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');

		$this->load->model('Model_ayudante');
		$resultado = $this->Model_ayudante->getAyudantesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'ayudantes', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'ayudantes', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

}