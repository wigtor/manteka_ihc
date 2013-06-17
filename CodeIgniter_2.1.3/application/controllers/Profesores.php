<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Profesores extends MasterManteka {
	
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
	* Manda a la vista 'cuerpo_profesores_verProfesor' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se cargan los datos de la vista con la lista 'rs_profesores' que contiene toda la información de los
	* profesores del sistema. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function verProfesores()
	{
		$datos_plantilla = array();
		//cargo el modelo de profesores
		$this->load->model('Model_profesor');

		$datos_plantilla = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores());

		$subMenuLateralAbierto = 'verProfesores'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;

		$this->cargarTodo("Docentes", "cuerpo_profesores_verProfesor", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	
	}
	/**
	* Método que responde a una solicitud de post para pedir los datos de un profesor
	* Recibe como parámetro el rut del profesor
	*/
	public function postDetallesProfesor() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('rut');
		$this->load->model('Model_profesor');
		$resultado = $this->Model_profesor->getDetallesProfesor($rut);
		echo json_encode($resultado);
	}

	/**
	* Se buscan profesores de forma asincrona para mostrarlos en la vista
	*
	**/
	public function postBusquedaProfesores() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');

		$this->load->model('Model_profesor');
		$resultado = $this->Model_profesor->getProfesoresByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'profesores', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'profesores', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
		
	}
	
	/**
	* Manda a la vista 'cuerpo_profesores_agregarProfesor' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se envía un mensaje de confirmación con valor 2, que indica que se está cargando
	* por primera ves la vista de agregar profesor. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function agregarProfesores()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_agregarProfesor', '', true); //Esta es la linea que cambia por cada controlador

		$datos_vista = array('mensaje_confirmacion'=>2);
        $datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_agregarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		
		
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "agregarProfesores"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	/**
	* Inserta un profesor al sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_agregarProfesor'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se llama a la función InsertarProfesor para ingresar al profesor
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir el ingreso de otro profesor.
	*
	*/
	 public function insertarProfesor()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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
		$this->load->model('Model_profesor');

		$rut_profesor = $this->input->get("rut_profesor");
        $nombre1_profesor = $this->input->get("nombre1_profesor");
        $nombre2_profesor = $this->input->get("nombre2_profesor");;
        $apellido1_profesor = $this->input->get("apellido1_profesor");
        $apellido2_profesor = $this->input->get("apellido2_profesor");
        $correo_profesor = $this->input->get("correo_profesor");
		$correo_profesor1 = $this->input->get("correo_profesor1");
        $telefono_profesor = $this->input->get("telefono_profesor");
        $tipo_profesor = $this->input->get("tipo_profesor");
        $confirmacion = $this->Model_profesor->InsertarProfesor($rut_profesor,$nombre1_profesor,$nombre2_profesor,$apellido1_profesor,$apellido2_profesor,$correo_profesor,$correo_profesor1,$telefono_profesor, $tipo_profesor);
	    
		$datos_vista = array('mensaje_confirmacion'=>$confirmacion);
        $datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_agregarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior

		$this->load->view('templates/template_general', $datos_plantilla);
		
	}


	
	/**
	* Manda a la vista 'cuerpo_profesores_borrarProfesor' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se cargan los datos de la vista con la lista 'rs_profesores' que contiene toda la información de los
	* profesores del sistema y se envia un 'mensaje_confirmacion' que sirve en la vista para que ésta sepa que se está cargando la página por primera vez.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function borrarProfesores(){
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


		$this->load->model('Model_profesor');

        $datos_vista = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),'mensaje_confirmacion'=>2);
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_borrarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "borrarProfesores"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);	
	}

	/**
	* Elimina un profesor del sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_borrarProfesor'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se llama a la función EliminarProfesor para eliminar el profesor con el rut que se le pasa como parametro
	* y es el que se ha recibido como parametro en esta funcion desde la vista. El resultado de la operación de eliminar desde el modelo se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'rs_profesores' para que se de la opción a escojer un nuevo profesor a eliminar.
	* Finalmente se carga la vista con todos los datos.
	*
	* @param string $rut_profesor
	*/
	public function eliminarProfesores()
	{
		$rut_profesor = $this->input->post("rutEliminar");

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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


		$this->load->model('Model_profesor');
		$confirmacion = $this->Model_profesor->EliminarProfesor($rut_profesor);
		$datos_vista = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),'mensaje_confirmacion'=>$confirmacion);


		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_borrarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "borrarProfesores"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	

	/**
	* Manda a la vista 'cuerpo_profesores_editarProfesor' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se cargan los datos de la vista con la lista 'rs_profesores' que contiene la lista de todos los profesores para que desde ahí en la vista
	* se escoja un un profesor a editar.
	* También se envía un mensaje de confirmación con valor 2, que indica que se está cargando por primera ves la vista de editar profesor.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function editarProfesores() // Carga la vista de modificar profesores
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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

		//cargo el modelo de profesores
		$this->load->model('Model_profesor');
		$datos_vista = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores());
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_editarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["subVistaLateralAbierta"] = "editarProfesores"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	
	
	/**
	* Edita la información de un profesor del sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_editarProfesor'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesor, se llama a la función EditarProfesor para editar el profesor
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de esta operacion se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'rs_profesores' para que esté habilitada para nuevas ediciones.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
    public function EditarProfesor() // Modifica profesor
    {
    			$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
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
		
		//cargo el modelo de profesores
		$this->load->model('Model_profesor');
			
			$nombre_1 = $this->input->get("nombre_1");
			$nombre_2 = $this->input->get("nombre_2");
			$apellidoPaterno_profe= $this->input->get("apellidoPaterno_profe");
			$apellidoMaterno_profe= $this->input->get("apellidoMaterno_profe");
	        $run_profe = $this->input->get("run_profe");
	        $mail_profe = $this->input->get("mail_profe");;
	        $telefono_profe = $this->input->get("telefono_profe");
	        $modulo_profe = $this->input->get("modulo_profe");
	        $seccion_profe = $this->input->get("seccion_profe");
			$tipo_profe = $this->input->get("tipo_profe");
			
		 $confirmacion = $this->Model_profesor->EditarProfesor($run_profe,$telefono_profe,$tipo_profe, $nombre_1, $nombre_2, $apellidoPaterno_profe,$apellidoMaterno_profe);
		$datos_vista = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores());
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_profesores_editarProfesor', $datos_vista, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
    }


	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verProfesores();
	}
    
 
    
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */


