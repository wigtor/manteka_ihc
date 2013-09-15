<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Estudiantes extends MasterManteka {

	/**
	*
	* Carga la vista ver estudiantes por defecto al entrar en la seccion estudiantes
	*
	**/
	public function index() {
		$this->verEstudiantes();
	}

	/**
	* Manda a la vista 'cuerpo_estudiantes_ver' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'rs_estudiantes' que contiene toda la información de los
	* estudiantes del sistema y la lista 'carreras' que contiene información de las carreras en el sistema. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function verEstudiantes() {
		$datos_vista = array();
		$subMenuLateralAbierto = "verEstudiantes"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$this->cargarTodo("Estudiantes", 'cuerpo_estudiantes_ver', "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}
	
	/**
	* Manda a la vista 'cuerpo_estudiantes_editar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'secciones' que contienen los datos necesarios para que el usuario
	* escoja en la vista este parametro para  editar la información del estudiante.
	* También se envía un mensaje de confirmación con valor 2, que indica que se está cargando por primera ves la vista de editar estudiantes.
	* Se envía también la lista de todos los estudiantes para que de ahí se escoja al que se quiere editar en la vista.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function editarEstudiante() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_carrera');
			$this->load->model('Model_seccion');
			$datos_vista['carreras'] = $this->Model_carrera->getAllCarreras();
			$datos_vista['secciones'] = $this->Model_seccion->getAllSecciones();

			$subMenuLateralAbierto = 'editarEstudiante'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", "cuerpo_estudiantes_editar", "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	*
	* Se obtiene la información para editar un estudiante de la vista y se llama a la función en el modelo para 
	* onsertarla en la base de datos.
	*
	* Se obtienen lo datos moddificados de la vista, se carga el modelo de estudiantes se llama ala función
	* actualizar estudiante en el modelo  si la confimacion es positva se despliega el mensaje de exito si es negativa
	* se depliega el mesaje de error
	*
	**/
	public function postEditarEstudiante() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$rut = $this->input->post("rut");
			$nombre1 = $this->input->post("nombre1");
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
			$telefono = $this->input->post("telefono");
			if (trim($telefono) == '') {
				$telefono = NULL;
			}
			$id_seccion = $this->input->post("id_seccion");
			$cod_carrera = $this->input->post("cod_carrera");


			$this->load->model('Model_estudiante');
			$confirmacion = $this->Model_estudiante->actualizarEstudiante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $telefono, $cod_carrera, $id_seccion);
			
			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha editado el estudiante con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la actualización de la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/editarEstudiante"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Editar Estudiante"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);

		}
	}


	
	/**
	* Manda a la vista 'cuerpo_estudiantes_borrar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'rs_estudiantes' que contiene toda la información de los
	* estudiantes del sistema y se envia un 'mensaje_confirmacion' que sirve en la vista para que ésta sepa que se está cargando la página por primera vez.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function eliminarEstudiante() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "eliminarEstudiante"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$this->cargarTodo("Estudiantes", 'cuerpo_estudiantes_eliminar', "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
	}


	/**
	* Elimina un estudiante del sistema y luego carga los datos para volver a la vista 'cuerpo_estudiantes_borrar'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se llama a la función EliminarEstudiante para eliminar el estudiante con el rut que se le pasa como parametro
	* y es el que se ha recibido como parametro de esta funcion desde la vista. El resultado de la operación de eliminar desde el modelo se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'rs_estudiantes' para que se de la opción a escojer un nuevo estudiante a eliminar.
	* Finalmente se carga la vista con todos los datos.
	*
	* @param string $rut_estudiante
	*/
	public function postEliminarEstudiante() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_estudiante');
			$rut_estudiante = $this->input->post('rutEliminar');

			$confirmacion = $this->Model_estudiante->eliminarEstudiante($rut_estudiante);
			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha borrado el estudiante con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la eliminación en base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/eliminarEstudiante"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Borrar Estudiante"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Manda a la vista 'cuerpo_estudiantes_agregar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'carreras' y 'secciones' que contienen los datos necesarios para que el usuario
	* escoja en la vista estos parametros necesarios para ingresar un nuevo estudiante. También se envía un mensaje de confirmación con valor 2, que indica que se está cargando
	* por primera ves la vista de cargar estudiantes. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function agregarEstudiante() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_carrera');
			$this->load->model('Model_seccion');
			$datos_vista['carreras'] = $this->Model_carrera->getAllCarreras();
			$datos_vista['secciones'] = $this->Model_seccion->getAllSecciones();
			$subMenuLateralAbierto = "agregarEstudiante"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", 'cuerpo_estudiantes_agregar', "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
	}

	
	/**
	* Inserta un estudiante al sistema y luego carga los datos para volver a la vista 'cuerpo_estudiantes_agregar'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se llama a la función InsertarEstudiante para ingresar al estudiante
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de esta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'carreras' y 'secciones' para que esté habilitada para nuevos ingresos.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function postAgregarEstudiante() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_estudiante');
			$rut = $this->input->post("rut");
			$rut =  substr($rut, 0, -1); //Quito el dígito verificador del rut
			$nombre1 = $this->input->post("nombre1");
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
			$id_seccion = $this->input->post("id_seccion");
			if (trim($id_seccion) == '') {
				$id_seccion = NULL;
			}
			$cod_carrera = $this->input->post("cod_carrera");
			
			$confirmacion = $this->Model_estudiante->agregarEstudiante($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono, $id_seccion, $cod_carrera);

			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el estudiante con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/agregarEstudiante"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Agregar Estudiante"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}

	
	/**
	*
	* Carga la vista para el cambio de sección. 
	*
	*Se cargan a través del modelo las seccines de estudiantes que serán mostradasn en pantalla.
	*
	*
	**/
	
	public function cambiarSeccionEstudiantes() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_seccion');
			$datos_vista['secciones'] = $this->Model_seccion->getAllSecciones();
			$subMenuLateralAbierto = "cambiarSeccionEstudiantes"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", 'cuerpo_estudiantes_cambiarSeccion', "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}
	

	/**
	* Esta función cambia de forma masiva a los estudiantes selecionandos a una nueva sección selecionada
	* Primero se carga el modelo de estudiantes 
	* Se determina desde que sección y a cual sección se cambiarán los estudiantes
	* Se obtiene la lista de selecionados que seránm cambiaados de sección
	* Se cargan los datos a la vista
	*
	**/

	public function postCambiarSeccionEstudiantes() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_estudiante');
			$seccion1 = $this->input->post('cod_seccion1');
			$cambiarDesde = $this->input->post('direccion');
			$seccion2 = $this->input->post('cod_seccion2');
			
			
			
			if($cambiarDesde == 1) {
				$lista_seleccionados = $this->input->post('seleccionadosS1');
				$seccionOUT = $this->input->post('cod_seccion2');
				$confirmacion = $this->Model_estudiante->CambioDeSecciones($seccionOUT, $lista_seleccionados);
			}
			else {
				$lista_seleccionados = $this->input->post('seleccionadosS2');
				$seccionOUT = $this->input->post('cod_seccion1');
				$confirmacion = $this->Model_estudiante->CambioDeSecciones($seccionOUT, $lista_seleccionados);
			}
			if($confirmacion != 1) {
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intertar cambiar de sección";
				$datos_plantilla["tipo_msj"] = "alert-error";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha cambiado de sección correctamente";
				$datos_plantilla["tipo_msj"] = "alert-success";

			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/cambiarSeccionEstudiantes"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Cambio de sección estudiantes"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	*
	* Obtiene para la vista los estudiantes de una sección determinada
	*
	* Se consulta el estado de logueado del usuario si lo esta se llama a la función
	* en el modelo para obtener los datos de los estudianes que pertencenede a la sección $cod_seccion 
	* obtenida de la vista.
	**/

	public function getEstudiantesBySeccionAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$id_seccion = $this->input->post('id_seccion');
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getEstudiantesBySeccion($id_seccion);
		echo json_encode($resultado);
	}


	/**
	* Método que responde a una solicitud de post para pedir los datos de un estudiante
	* Recibe como parámetro el rut del estudiante
	*/
	public function getDetallesEstudianteAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('rut');
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getDetallesEstudiante($rut);
		echo json_encode($resultado);
	}


	/**
	* Se buscan estudiantes de forma asincrona para mostrarlos en la vista
	*
	**/
	public function getEstudiantesAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getEstudiantesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'estudiantes', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'estudiantes', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}


	/**
	*
	* Se obtienen todas las secciones que hay ingresadas en manteka
	*
	**/
	public function getAllSeccionesAjax() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_seccion');

		$resultado = $this->Model_seccion->getAllSecciones();
		echo json_encode($resultado);
	}
	

	/**
	*
	* Controla la carga masiva de estudiantes en el sistema
	*
	* Se realiza la configuración del archivo que esta permitido cargar en el sistema indicando la ruta, la extención y el tamaño
	* si no se ha subido ningun archivo entonces se despliega la vista correspondiente a la carga masiva
	* en caso contrario se evalua el resultado de la carga y se obtiene la ruta completa
	* se carga el modelo de estudiantes y se inicia la carga masiva en la base de datos
	* se carga la vista de exito con las filas erroneas si exitieran o en caso de falla critica se devuelve un error
	*
	*
	**/
	function cargaMasivaEstudiantes()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '100';	


		$this->load->library('upload', $config);


		$subMenuLateralAbierto = "cargaMasivaEstudiantes"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);

		


		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$datos_vista = $error;

			$this->cargarTodo("Estudiantes", 'cuerpo_estudiantes_cargaMasiva', "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			
			$datos = $data['upload_data'];
			$nombre_archivo = $datos['full_path'];

			//falta valida aqui el archivo

			$this->load->model('Model_estudiante');
			$stack = array();
			$stack = $this->Model_estudiante->cargaMasiva($nombre_archivo);
			
			if ($stack !== FALSE) {

				if(count($stack) != 0) {

					$datos_plantilla["titulo_msj"] = "Acción No Realizada";
					$linea = '';
					foreach ($stack as $key => $value) {
						foreach ($value as $cadena) {
							$linea = $linea.";".$cadena;
						}
							$datos_plantilla["cuerpo_msj"] = "Se encontró un error en la siguiente linea:</br>".$key.".-".$linea."</br> Vuelva intentarlo luego de arreglar el errror";
							break;
					}				
					$datos_plantilla["tipo_msj"] = "alert-error";
					$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
					$datos_plantilla["redirecTo"] = "Estudiantes/cargaMasivaEstudiantes"; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de estudiantes"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
					
					
				} else  {
					$datos_plantilla["titulo_msj"] = "Acción Realizada";
					$datos_plantilla["cuerpo_msj"] = "El archivo se ha cargado exitosamente.";
					$datos_plantilla["tipo_msj"] = "alert-success";
					$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
					$datos_plantilla["redirecTo"] = "Estudiantes/cargaMasivaEstudiantes"; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de estudiantes"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
				}
			}else{

				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "El archivo no tiene el formato correcto.";
				$datos_plantilla["tipo_msj"] = "alert-error";
				$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Estudiantes/cargaMasivaEstudiantes"; //Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Carga masiva de estudiantes"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
				$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			}
		}
	}
}

/* End of file Estudiantes.php */
/* Location: ./application/controllers/Estudiantes.php */
