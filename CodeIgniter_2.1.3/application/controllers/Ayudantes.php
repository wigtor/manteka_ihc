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
		$datos_plantilla = array('profesores' => $this->Model_ayudante->VerTodosLosProfesores(),'mensaje_confirmacion'=>2);

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
		$this->load->model('Model_ayudante');

		$rut_ayudante = $this->input->post("rut_ayudante");
		$nombre1_ayudante = $this->input->post("nombre1_ayudante");
		$nombre2_ayudante = $this->input->post("nombre2_ayudante");;
		$apellido_paterno = $this->input->post("apellido1_ayudante");
		$apellido_materno = $this->input->post("apellido2_ayudante");
		$correo_ayudante = $this->input->post("correo_ayudante");
		$cod_profesores = $this->input->post("cod_profesores");

		$confirmacion = $this->Model_ayudante->InsertarAyudante($rut_ayudante,$nombre1_ayudante,$nombre2_ayudante,$apellido_paterno,$apellido_materno,$correo_ayudante,$cod_profesores);
	    

		//Debe estar en un if según lo que contenga $confirmacion
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "El ayudante fue ingresado con éxito.";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar ingresar el ayudante";
			$datos_plantilla["tipo_msj"] = "alert-error";
		}

		$datos_plantilla["redirecTo"] = 'Ayudantes/agregarAyudantes';
		$datos_plantilla["nombre_redirecTo"] = "Agregar ayudante";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
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

		if($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "El ayudante fue editado con éxito.";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar editar el ayudante";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		


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

	/**
	*Elimina la información de un ayudante del sistema y luego carga los datos para volver a la vista 'cuerpo_profesores_editarAyudante'
	*
	* 
	* Se cargan los datos para las plantillas de la página de realización.
	* Se carga el modelo de ayudantes, se llama a la función EliminarAyudante 
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de esta operacion se recibe en la variable 'confirmacion'
	* la que de acuerdo el valor se envía el mensaje de error o realización correspondiente, dando la opción de volver a la vista Borrar Ayudantes
	* 
	*
	*
	*/
	public function EliminarAyudante()
	{
		$this->load->model('Model_ayudante');
		$rut_ayudante = $this->input->post('rutToDelete');
		$confirmacion = $this->Model_ayudante->EliminarAyudante($rut_ayudante);
		
		if ($confirmacion == 1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "El ayudante fue eliminado con éxito.";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar eliminar el ayudante";
			$datos_plantilla["tipo_msj"] = "alert-error";
		}
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

	/**
	* Método que responde a una busqueda de ayudantes a través de un filtro. Si esta búsqueda no se ha realizado antes, se guarda en el historial
	* para una próxima oportunidad.
	*
	*/

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