<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class Ayudantes extends MasterManteka {
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verAyudantes();
	}


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
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$this->cargarTodo("Docentes", "cuerpo_ayudantes_ver", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
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
	public function agregarAyudante()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_plantilla = array();
			$this->load->model('Model_profesor');
			$datos_plantilla['profesores'] = $this->Model_profesor->getAllProfesores();

			$subMenuLateralAbierto = 'agregarAyudante'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_ayudantes_agregar", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postAgregarAyudante()
	{
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_ayudante');
			$rut = $this->input->post("rut");
			$nombre1 = $this->input->post("nombre1");
			$nombre2 = $this->input->post("nombre2");;
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
			$correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo2");
			$telefono = $this->input->post("telefono");
			$rut_profesores = $this->input->post("id_profesores");
			echo $rut_profesores.'     ';return;
			$confirmacion = $this->Model_ayudante->agregarAyudante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $rut_profesores);


			//Debe estar en un if según lo que contenga $confirmacion
			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "El ayudante fue ingresado con éxito.";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar ingresar el ayudante";
				$datos_plantilla["tipo_msj"] = "alert-error";
			}

			$datos_plantilla["redirecTo"] = 'Ayudantes/agregarAyudante';
			$datos_plantilla["nombre_redirecTo"] = "Agregar ayudante";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
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
	public function editarAyudante()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_plantilla = array();
			$subMenuLateralAbierto = 'editarAyudante'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_ayudantes_editar", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postEditarAyudante()
	{
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_ayudante');
			$rut = $this->input->post("rut");
			$nombre1 = $this->input->post("nombre1");
			$nombre2 = $this->input->post("nombre2");;
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
			$correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo1");
			$telefono = $this->input->post("telefono");
			$ruts_profesores = array(); //PENDIENTE

			$confirmacion = $this->Model_ayudante->actualizarAyudante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $ruts_profesores);

			if($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "El ayudante fue editado con éxito.";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar editar el ayudante";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}

			$datos_plantilla["redirecTo"] = 'Ayudantes/editarAyudante';
			$datos_plantilla["nombre_redirecTo"] = "Editar ayudantes";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
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
	public function eliminarAyudante()
	{
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_plantilla = array();
			$subMenuLateralAbierto = 'eliminarAyudante'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_ayudantes_eliminar", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postEliminarAyudante()
	{
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_ayudante');
			$rut_ayudante = $this->input->post('rut');
			$confirmacion = $this->Model_ayudante->eliminarAyudante($rut_ayudante);
			
			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "El ayudante fue eliminado con éxito.";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar eliminar el ayudante";
				$datos_plantilla["tipo_msj"] = "alert-error";
			}
			$datos_plantilla["redirecTo"] = 'Ayudantes/eliminarAyudante';
			$datos_plantilla["nombre_redirecTo"] = "Eliminar ayudantes";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Método que responde a una solicitud de post para pedir los datos de un ayudante
	* Recibe como parámetro el rut del estudiante
	*/
	public function getDetallesAyudanteAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
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

	public function getAyudantesAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
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
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'ayudantes', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'ayudantes', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

}