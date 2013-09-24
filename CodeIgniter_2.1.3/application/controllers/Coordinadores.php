<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

/**
* Clase coordinadores del proyecto manteka.
*
* En esta clase se detallan los controladores necesarios para las operaciones crud de la tabla coordinadores.
*
* @package    Manteka
* @subpackage Controllers
* @author     Grupo 2 IHC 1-2013 Usach
*/
class Coordinadores extends MasterManteka {

	/**
	* Función de Inicio de Controlador.
	*
	* Función en la cual el navegador va a redirigir la página principal de los coordinadores
	* a la vista verCoordinadores	  
	* @param none.      
	* @return none
	*/
	public function index() {
		$this->verCoordinadores();
	}

	
	/**
	* Función que muestra los coordinadores del sistema.
	*
	* Se muestra en pantalla todos los coordinadores con sus datos correspondientes,
	* además se cargan todas las plantillas para el sitio.
	* @param none.      
	* @return none
	*/
	public function verCoordinadores() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_plantilla = array();
			$subMenuLateralAbierto = 'verCoordinadores'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_ver", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Función en la que se ingresa un Coordinador al sistema.
	*
	* Se cargan las plantillas correspondientes al sitio, y en el cuerpo un formulario en el cual 
	* se deben ingresar todos los datos del Coordinador que se desea agregar.
	* @param none.      
	* @return none
	*/
	public function agregarCoordinador() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'agregarCoordinador'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_agregar", "barra_lateral_profesores", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Función en la que se ingresa un Coordinador al sistema.
	*
	* Se cargan las plantillas correspondientes al sitio, y en el cuerpo un formulario en el cual 
	* se deben ingresar todos los datos del Coordinador que se desea agregar.
	* @param none.      
	* @return none
	*/
	public function postAgregarCoordinador() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_coordinador');
			$rut = $this->input->post('rut');
			$rut =  substr($rut, 0, -1); //Quito el dígito verificador del rut
			$nombre1 = $this->input->post('nombre1');
			$nombre2 = $this->input->post("nombre2");
			if (trim($nombre2) == '') {
				$nombre2 = NULL;
			}
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
			$correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo2");
			if (trim($correo2) == '') {
				$correo2 = NULL;
			}
			$fono = $this->input->post("telefono");
			if (trim($fono) == '') {
				$fono = NULL;
			}

			$this->Model_coordinador->agregarCoordinador($rut, $nombre1 , $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono);

			$datos_plantilla["titulo_msj"] = "Coordinador agregado";
			$datos_plantilla["cuerpo_msj"] = "El nuevo coordinador fue agregado correctamente.";
			$datos_plantilla["tipo_msj"] = "alert-success";
			$datos_plantilla["redirecTo"] = 'Coordinadores/agregarCoordinador';
			$datos_plantilla["nombre_redirecTo"] = "Agregar Coordinador";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Función que edita un Coordinador.
	*
	* Se muestra en pantalla todos los coordinadores con sus datos correspondientes,se escoge uno y
	* se realiza la edición de los datos antiguos que se tenían del coordinador, los datos modificados son
	* enviados al modelo para actualizar los datos en la base de datos
	* 
	* @param none.      
	* @return none
	*/
	public function editarCoordinador() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_plantilla = array();
			$subMenuLateralAbierto = 'editarCoordinador'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_editar", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

		}
	}


	/**
	* Función que edita un Coordinador.
	*
	* Se muestra en pantalla todos los coordinadores con sus datos correspondientes,se escoge uno y
	* se realiza la edición de los datos antiguos que se tenían del coordinador, los datos modificados son
	* enviados al modelo para actualizar los datos en la base de datos
	* 
	* @param none.      
	* @return none
	*/
	public function postEditarCoordinador() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_coordinador');
			$resetearPass = $this->input->post('resetContrasegna');
			$rut = $this->input->post('rut');
			//$rut =  substr($rut, 0, -1); //Quito el dígito verificador del rut
			$nombre1 = $this->input->post('nombre1');
			$nombre2 = $this->input->post("nombre2");
			if (trim($nombre2) == '') {
				$nombre2 = NULL;
			}
			$apellido1 = $this->input->post("apellido1");
			$apellido2 = $this->input->post("apellido2");
			$correo1 = $this->input->post("correo1");
			$correo2 = $this->input->post("correo2");
			if (trim($correo2) == '') {
				$correo2 = NULL;
			}
			$fono = $this->input->post("telefono");
			if (trim($fono) == '') {
				$fono = NULL;
			}

			if($resetearPass) {
				$this->Model_coordinador->modificarPassword($rut, $rut);
			}
			$this->Model_coordinador->actualizarCoordinador($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono);

			$datos_plantilla["titulo_msj"] = "Coordinador editado";
			$datos_plantilla["cuerpo_msj"] = "El coordinador fue editado correctamente.";
			$datos_plantilla["tipo_msj"] = "alert-success";
			$datos_plantilla["redirecTo"] = 'Coordinadores/editarCoordinador';
			$datos_plantilla["nombre_redirecTo"] = "Editar coordinadores";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);

		}
	}
	
	
	/**
      * Función que elimina un Coordinador.
      *
	  * Se muestra en pantalla todos los coordinadores con sus datos correspondientes, se debe escoger
	  * alguno y será eliminado del sistema.
	  *
	  * @param none.      
      * @return none
      */
    public function eliminarCoordinador() {
    	if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
    	if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model('Model_coordinador');
			$rut = $this->session->userdata('rut');
			$datos_cuerpo_central = array();
			
			$subMenuLateralAbierto = 'eliminarCoordinador'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_eliminar", "barra_lateral_profesores", $datos_cuerpo_central, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
			return ;
		}
	}


	public function postEliminarCoordinador() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$rutEliminar = $this->input->post('rutEliminar');
			$respuesta = '';
			$this->load->model('Model_coordinador');
			$rutdeSesion = $this->session->userdata('rut');
			if($rutEliminar == $rutdeSesion) {
				$datos_plantilla["titulo_msj"] = "Coordinador no puede ser eliminado";
				$datos_plantilla["cuerpo_msj"] = "El usuario no puede eliminarse así mismo.";
				$datos_plantilla["tipo_msj"] = "alert-error";
				$datos_plantilla["redirecTo"] = 'Coordinadores/eliminarCoordinador';
				$datos_plantilla["nombre_redirecTo"] = "Eliminar coordinador";
				$datos_plantilla["redirectAuto"] = TRUE;
				$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
				$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			}
			else {
				$respuesta = $this->Model_coordinador->eliminarCoordinador($rutEliminar);
				if($respuesta == FALSE){
					$datos_plantilla["titulo_msj"] = "Coordinador no puede ser eliminado";
					$datos_plantilla["cuerpo_msj"] = "Existen sólo este coordinador en el sistema en este momento, es imposible utilizar ManteKA sin un coordinador.";
					$datos_plantilla["tipo_msj"] = "alert-success";
					$datos_plantilla["redirecTo"] = 'Coordinadores/eliminarCoordinador';
					$datos_plantilla["nombre_redirecTo"] = "Eliminar coordinador";
					$datos_plantilla["redirectAuto"] = TRUE;
					$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
				}
				else{
					$datos_plantilla["titulo_msj"] = "Coordinador eliminado";
					$datos_plantilla["cuerpo_msj"] = "El coordinador fue eliminado correctamente.";
					$datos_plantilla["tipo_msj"] = "alert-success";
					$datos_plantilla["redirecTo"] = 'Coordinadores/eliminarCoordinador';
					$datos_plantilla["nombre_redirecTo"] = "Eliminar coordinador";
					$datos_plantilla["redirectAuto"] = TRUE;
					$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
				}
			}
		}
    }


    /**
	* Método que responde a una solicitud de post para pedir los datos de un estudiante
	* Recibe como parámetro el rut del estudiante
	*/
	public function getDetallesCoordinadorAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('rut');
		$this->load->model('Model_coordinador');
		$resultado = $this->Model_coordinador->getDetallesCoordinador($rut);
		echo json_encode($resultado);
	}


	public function getCoordinadoresAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		$this->load->model('Model_coordinador');
		$resultado = $this->Model_coordinador->getCoordinadoresByFilter($textoFiltro, $textoFiltrosAvanzados, NULL);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'coordinadores', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}
	

	public function getCoordinadoresElimAjax() {
		if (!$this->input->is_ajax_request()) {
			return ;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		$rutExcepto = $this->session->userdata('rut');
		$this->load->model('Model_coordinador');
		$resultado = $this->Model_coordinador->getCoordinadoresByFilter($textoFiltro, $textoFiltrosAvanzados, $rutExcepto);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'coordinadores', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

}

/* End of file Coordinadores.php */
/* Location: ./application/controllers/Coordinadores.php */
