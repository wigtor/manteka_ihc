<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Profesores extends MasterManteka {
	
	public function index() {
		$this->verProfesores();
	}


	/**
	* Manda a la vista 'cuerpo_profesores_ver' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se cargan los datos de la vista con la lista 'rs_profesores' que contiene toda la información de los
	* profesores del sistema. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function verProfesores() {
		$datos_plantilla = array();

		$subMenuLateralAbierto = 'verProfesores'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);

		$this->cargarTodo("Docentes", "cuerpo_profesores_ver", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	
	}

	
	/**
	* Manda a la vista 'cuerpo_profesores_agregarProfesor' los datos necesarios para su funcionamiento
	*
	* 
	* Se cargan los datos para las plantillas de la página.
	* Se envía un mensaje de confirmación con valor 2, que indica que se está cargando
	* por primera ves la vista de agregar profesor. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function agregarProfesor() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_profesor');
			$datos_vista['tipos_profesores'] = $this->Model_profesor->getTiposProfesores();

			$subMenuLateralAbierto = "agregarProfesor"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", 'cuerpo_profesores_agregar', "barra_lateral_profesores", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
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
	 public function postAgregarProfesor() {
		if (!$this->isLogged()) {
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_profesor');

			$rut = $this->input->post("rut");
			$rut =  substr($rut, 0, -1); //Quito el dígito verificador del rut
			$nombre1 = $this->input->post("nombre1");
			$nombre2 = $this->input->post("nombre2");
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
			$correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo2");
			$telefono = $this->input->post("telefono");
			$tipo_profesor = $this->input->post("tipo_profesor");
			$confirmacion = $this->Model_profesor->agregarProfesor($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $tipo_profesor);

			if($confirmacion != TRUE){
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intentar insertar el profesor";
				$datos_plantilla["tipo_msj"] = "alert-error";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el profesor con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";

			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Profesores/agregarProfesor"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Agregar profesor"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}

	
	/**
	* Manda a la vista 'cuerpo_profesores_borrarProfesor' los datos necesarios para su funcionamiento
	*
	* 
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de profesores, se cargan los datos de la vista con la lista 'rs_profesores' que contiene toda la información de los
	* profesores del sistema y se envia un 'mensaje_confirmacion' que sirve en la vista para que ésta sepa que se está cargando la página por primera vez.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function eliminarProfesor() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "eliminarProfesor"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", 'cuerpo_profesores_eliminar', "barra_lateral_profesores", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
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
	public function postEliminarProfesor() {
		if (!$this->isLogged()) {
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$rut_profesor = $this->input->post("rutEliminar");

			$this->load->model('Model_profesor');
			$confirmacion = $this->Model_profesor->eliminarProfesor($rut_profesor);
			

			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha borrado el profesor con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la eliminación en base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Profesores/eliminarProfesor"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Eliminar profesor"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Modifica los datos de un profesor y luego carga la vista de realización de acuerdo al resultado que le arroje el modelo
	*
	*En primer lugar se reciben los nuevos datos del  profesor que se desea editar mediante el método POST
	*Luego se envian estos datos al modelo para que se realice la actualización en la base de datos. A partir de esto se recibe un -1 en caso de error
	*o un 1 en caso de transacción exitosa, por lo que de acuerdo a esta respuesta se muestra la vista de acción realizada o acción no realizada 
	*
	*
	*/
	public function editarProfesor() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_profesor');
			$datos_vista['tipos_profesores'] = $this->Model_profesor->getTiposProfesores();
			$subMenuLateralAbierto = 'editarProfesor'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_profesores_editar", "barra_lateral_profesores", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

		}
	}


	public function postEditarProfesor() {
		if (!$this->isLogged()) {
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_profesor');
			$rut = $this->input->post("rut");
			//$rut =  substr($rut, 0, -1); //Quito el dígito verificador del rut
			$nombre1 = $this->input->post("nombre1");
			$nombre2 = $this->input->post("nombre2");
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
	        $correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo2");
			$telefono = $this->input->post("telefono");
     
			$resetPass = $this->input->post('resetContrasegna');
			$tipo_profe = $this->input->post("tipo_profesor");
			
			$confirmacion = $this->Model_profesor->actualizarProfesor($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $tipo_profe, $resetPass);
			
			
			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "El profesor fue editado con éxito.";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error mientras se actualizaban los datos del profesor";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirecTo"] = 'Profesores/editarProfesor';
			$datos_plantilla["nombre_redirecTo"] = "Editar profesores";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);	
		}
	}


	public function rutExisteAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_profesor');
		$rut = $this->input->post('rut');

		$resultado = $this->Model_profesor->rutExiste($rut);
		echo json_encode($resultado);
	}


	/**
	* Método que responde a una solicitud de post para pedir los datos de un profesor
	* Recibe como parámetro el rut del profesor
	*/
	public function getDetallesProfesorAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
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
	public function getProfesoresAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
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
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'profesores', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'profesores', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

}

/* End of file Profesores.php */
/* Location: ./application/controllers/Profesores.php */


