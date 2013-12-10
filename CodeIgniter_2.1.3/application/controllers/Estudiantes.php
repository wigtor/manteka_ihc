<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php';
define('CARGA_MASIVA_ASISTENCIA', 1);
define('CARGA_MASIVA_CALIFICACIONES', 2);
define('CARGA_MASIVA_ESTUDIANTE', 3);

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
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		$datos_vista = array('id_tipo_usuario' => $this->session->userdata('id_tipo_usuario'));
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
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
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
			$this->invalidSession();
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
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "eliminarEstudiante"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
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
			$this->invalidSession();
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
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
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
			$this->invalidSession();
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
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			//$this->load->model('Model_seccion');
			//$datos_vista['secciones'] = $this->Model_seccion->getAllSecciones();
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
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_estudiante');
			$cambiarDesde = 1; //Paso por defecto de izquierda a derecha
			
			
			
			if($cambiarDesde == 1) {
				$lista_seleccionados = $this->input->post('id_alumnos');
				$seccionOUT = $this->input->post('selectSeccionDestino');
				$confirmacion = $this->Model_estudiante->cambioDeSeccion($seccionOUT, $lista_seleccionados);
			}
			else {
				$lista_seleccionados = $this->input->post('id_alumnos2');
				$seccionOUT = $this->input->post('selectSeccionOrigen');
				$confirmacion = $this->Model_estudiante->cambioDeSeccion($seccionOUT, $lista_seleccionados);
			}
			if($confirmacion != TRUE) {
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
	public function cargaMasivaEstudiantes() {
		$subMenuLateralAbierto = "cargaMasivaEstudiantes"; //Para este ejemplo, los informes no tienen submenu lateral
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
		$titulo = "Carga masiva de estudiantes";
		$datos_vista = array();
		$rutProfesor = $this->session->userdata('rut');
		$this->cargaMasiva($subMenuLateralAbierto, 'cuerpo_estudiantes_cargaMasiva', $titulo, $tipos_usuarios_permitidos, CARGA_MASIVA_ESTUDIANTE, 'estudiantes', $datos_vista, $rutProfesor);
	}


	private function cargaMasiva($nombreMenuLateral, $nombre_cuerpo_vista, $titulo, $tipos_usuarios_permitidos, $tipoCarga, $deQueEsLaCarga, $datos_vista, $rutProfesor) {
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'text/plain|text/csv|csv';
		//$config['allowed_types']  = 'text/comma-separated-values|application/csv|application/excel|application/vnd.ms-excel|application/vnd.msexcel|text/anytext';
		$config['max_size']	= '1024';


		$this->load->library('upload', $config);


		$subMenuLateralAbierto = $nombreMenuLateral;
		$datos_vista['tipoCarga'] = $tipoCarga;
		$datos_vista['funcionControlador'] = $subMenuLateralAbierto;
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		//$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);

		if ( ! $this->upload->do_upload()) {
			$datos_vista['error'] = $this->upload->display_errors();
			$datos_vista['titulo'] = $titulo;
			$datos_vista['queSeCarga'] = $deQueEsLaCarga;

			$this->cargarTodo("Estudiantes", $nombre_cuerpo_vista, "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
		else {
			$data = array('upload_data' => $this->upload->data());

			
			$datos = $data['upload_data'];
			$nombre_archivo = $datos['full_path'];

			//falta valida aqui el archivo
			$stack = array();

			if ($tipoCarga == CARGA_MASIVA_ESTUDIANTE) {
				$this->load->model('Model_estudiante');
				$stack = $this->Model_estudiante->cargaMasiva($nombre_archivo, $rutProfesor);
			}
			else if ($tipoCarga == CARGA_MASIVA_ASISTENCIA) {
				$this->load->model('Model_asistencia');
				$id_seccion = $this->input->post('id_seccion');
				$stack = $this->Model_asistencia->cargaMasiva($nombre_archivo, $rutProfesor);
			}
			else if ($tipoCarga == CARGA_MASIVA_CALIFICACIONES) {
				$this->load->model('Model_calificaciones');
				$id_seccion = $this->input->post('id_seccion');
				$stack = $this->Model_calificaciones->cargaMasiva($nombre_archivo, $rutProfesor);
			}

			if ($stack !== FALSE) {

				if(count($stack) != 0) {

					$datos_plantilla["titulo_msj"] = "Han ocurrido errores";
					$linea = '';
					$datos_plantilla["cuerpo_msj"] = "A continuación se listan los errores encontrados";

					if ($tipoCarga == CARGA_MASIVA_ESTUDIANTE) {
						$mensajeErrorExtra = ", repare todos los problemas en el archivo de entrada y vuelva a intentarlo.<br><br>";
						$datos_plantilla["cuerpo_msj"] = $datos_plantilla["cuerpo_msj"].$mensajeErrorExtra;
					}

					if ($tipoCarga == CARGA_MASIVA_ASISTENCIA) {
						$mensajeErrorExtra = ", sin embargo se ha guardado la asistencia del resto de estudiantes.<br><br>";
						$datos_plantilla["cuerpo_msj"] = $datos_plantilla["cuerpo_msj"].$mensajeErrorExtra;
					}

					foreach ($stack as $key => $value) { //Cada linea procesada
						$linea = ' ';
						foreach ($value as $cadena) { //Cada columna por linea
							$linea = $linea.$cadena."; ";
						}
						$datos_plantilla["cuerpo_msj"] = $datos_plantilla["cuerpo_msj"]."Se encontró un error en la siguiente linea:</br>".$key.".-".$linea."</br><br>";
						//break;
					}
					$datos_plantilla["tipo_msj"] = "alert-error";
					$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
					$datos_plantilla["redirecTo"] = "Estudiantes/".$nombreMenuLateral; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de ".$deQueEsLaCarga; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					//$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
					
					
				} else  {
					$datos_plantilla["titulo_msj"] = "Acción Realizada";
					$datos_plantilla["cuerpo_msj"] = "El archivo se ha cargado exitosamente.";
					$datos_plantilla["tipo_msj"] = "alert-success";
					$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
					$datos_plantilla["redirecTo"] = "Estudiantes/".$nombreMenuLateral; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de ".$deQueEsLaCarga; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					//$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
				}
			}
			else {

				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "El archivo no tiene el formato correcto.";
				$datos_plantilla["tipo_msj"] = "alert-error";
				$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Estudiantes/".$nombreMenuLateral; //Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Carga masiva de ".$deQueEsLaCarga; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				//$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
				$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			}
		}
	}


	public function agregarAsistencia() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$datos_vista['ONLY_VIEW'] = FALSE;
			$this->load->model('Model_seccion');
			$rutProfesor = $this->session->userdata('rut');
			$datos_vista['IS_PROFESOR_LIDER'] = $this->esProfesorLider($rutProfesor);
			$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
			$verTodas = FALSE;
			$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);

			$subMenuLateralAbierto = 'agregarAsistencia'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", "cuerpo_asistencia_ver", "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}

	public function postAgregarAsistencia() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_asistencia');
			$rut_profesor = $this->session->userdata('rut');
			$asistencia = $this->input->post('asistencia');
			if ($asistencia == FALSE)
				$asistencia = array();
			$comentarios = $this->input->post('comentario');
			$id_sesion_de_clase = $this->input->post('sesion_de_clase');
			$id_seccion = $this->input->post('seccion'); //No es necesario más que para hacer control de reglas de negocio después
			//echo 'Se está implementando esto, largo array asistencia:'.count($asistencia).'  comentario:'.count($comentarios).'...';
			$confirmacion = TRUE;
			//echo 'Largo comentarios: '.count($comentarios).'  '.$comentarios.'caca ';
			foreach ($comentarios as $rut => $arrayComentarioBySesion) { //Comentarios tiene todos los ruts de la sección como key
				foreach ($arrayComentarioBySesion as $id_sesion_de_clase => $comentario) {
					$asistio = FALSE;
					if (array_key_exists ($rut, $asistencia)) { //Compruebo el primer índice (rut)
						if (array_key_exists ($id_sesion_de_clase, $asistencia[$rut])) { //Compruebo el segundo índice (id_evaluacion)
							$asistio = $asistencia[$rut][$id_sesion_de_clase];
							//echo 'Rut: '.$rut.' '.$asistio.' ';
							if ($asistio === "") {
								$asistio = NULL;
							}
							else if ($asistio == 0) {
								$asistio = FALSE;
							}
							else {
								$asistio = TRUE;
							}

							if ($comentario !== NULL) {
								if (trim($comentario) === "") { //Si el comentario es vacio
									$comentario = NULL;
								}
							}
						}
					}

					$justificado = !$asistio; //la negación de si asistió por defecto
					if ($comentario !== NULL) {
						if (trim($comentario) === "") { //Si el comentario es vacio
							$justificado = FALSE;
							$comentario = NULL;
						}
					}
					else { //Si no hay comentario
						$justificado = FALSE;
					}
					if (($asistio !== NULL) || ($comentario !== NULL) || ($justificado === TRUE)) {
						$confirmacion = $confirmacion && $this->Model_asistencia->agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_sesion_de_clase);
					}
				}
			}

			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha guardado la asistencia con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error al guardar la asistencia de algún estudiante";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = TRUE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/agregarAsistencia"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Agregar Asistencia"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function verAsistencia() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$datos_vista['ONLY_VIEW'] = TRUE;
			$this->load->model('Model_seccion');
			$rutProfesor = $this->session->userdata('rut');
			$esLider = $this->esProfesorLider($rutProfesor);
			$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
			$datos_vista['IS_PROFESOR_LIDER'] = $esLider;
			$verTodas = FALSE;
			$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);

			$subMenuLateralAbierto = 'verAsistencia'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", "cuerpo_asistencia_ver", "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function cargaMasivaAsistencia() {
		$subMenuLateralAbierto = "cargaMasivaAsistencia"; //Para este ejemplo, los informes no tienen submenu lateral
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$titulo = "Carga masiva de asistencia";
		$datos_vista = array();
		//$this->load->model('Model_seccion');
		$rutProfesor = $this->session->userdata('rut');
		//$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		//$verTodas = FALSE;
		//$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);
		$this->cargaMasiva($subMenuLateralAbierto, 'cuerpo_estudiantes_cargaMasiva', $titulo, $tipos_usuarios_permitidos, CARGA_MASIVA_ASISTENCIA, 'asistencia', $datos_vista, $rutProfesor);
	}


	public function verCalificaciones() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$datos_vista['ONLY_VIEW'] = TRUE;
			$this->load->model('Model_seccion');
			$rutProfesor = $this->session->userdata('rut');
			$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
			$datos_vista['IS_PROFESOR_LIDER'] = $this->esProfesorLider($rutProfesor);
			$verTodas = FALSE;
			$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);

			$subMenuLateralAbierto = 'verCalificaciones'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", "cuerpo_calificaciones_ver", "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function agregarCalificaciones() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$datos_vista['ONLY_VIEW'] = FALSE;
			$this->load->model('Model_seccion');
			$rutProfesor = $this->session->userdata('rut');
			$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
			$verTodas = FALSE;
			$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);
			$datos_vista['IS_PROFESOR_LIDER'] = $this->esProfesorLider($rutProfesor);

			$subMenuLateralAbierto = 'agregarCalificaciones'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarTodo("Estudiantes", "cuerpo_calificaciones_ver", "barra_lateral_estudiantes", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function cargaMasivaCalificaciones() {
		$subMenuLateralAbierto = "cargaMasivaCalificaciones"; //Para este ejemplo, los informes no tienen submenu lateral
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$titulo = "Carga masiva de calificaciones";
		$datos_vista = array();
		//$this->load->model('Model_seccion');
		$rutProfesor = $this->session->userdata('rut');
		//$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		//$verTodas = FALSE;
		//$datos_vista['secciones'] = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);
		$this->cargaMasiva($subMenuLateralAbierto, 'cuerpo_estudiantes_cargaMasiva', $titulo, $tipos_usuarios_permitidos, CARGA_MASIVA_CALIFICACIONES, 'calificaciones', $datos_vista, $rutProfesor);
	}


	private function esProfesorLider($rutProfesor) {
		$this->load->model('Model_profesor');
		$modulosTematicosProfesor = $this->Model_profesor->getModulosTematicosProfesor($rutProfesor);
		$esLider = FALSE;
		foreach ($modulosTematicosProfesor as $modTem) {
			$esProfesorLider = $this->Model_profesor->isProfesorLider($rutProfesor, $modTem->id);
			if ($esProfesorLider) {
				$esLider = TRUE;
			}
		}
		return $esLider;
	}


	public function postAgregarCalificaciones() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_calificaciones');
			$rut_profesor = $this->session->userdata('rut');
			$notas = $this->input->post('Calificaciones');
			if ($notas == FALSE)
				$notas = array();
			$comentarios = $this->input->post('comentario');
			$id_seccion = $this->input->post('seccion'); //No es necesario más que para hacer control de reglas de negocio después
			//echo 'Se está implementando esto, largo array notas:'.count($notas).'  comentario:'.count($comentarios).'...';
			$confirmacion = TRUE;
			//echo 'Largo comentarios: '.count($comentarios).'  '.$comentarios.'caca ';
			foreach ($comentarios as $rut => $arrayComentarioByEvaluacion) { //Comentarios tiene todos los ruts de la sección como key
				foreach ($arrayComentarioByEvaluacion as $id_evaluacion => $comentario) {
					$nota = NULL;
					if (array_key_exists ($rut, $notas)) { //Compruebo el primer índice (rut)
						if (array_key_exists ($id_evaluacion, $notas[$rut])) { //Compruebo el segundo índice (id_evaluacion)
							$nota = $notas[$rut][$id_evaluacion];
							if ($nota == 0) {
								$nota = NULL;
							}

							if ($comentario !== NULL) {
								if (trim($comentario) === "") { //Si el comentario es vacio
									$comentario = NULL;
								}
							}
							//echo 'NOTA: '.$nota.' comentario: '.$comentario.' rut_estudiante: '.$rut.'   ';


							$confirmacion = $confirmacion && $this->Model_calificaciones->agregarCalificacion($rut_profesor, $rut, $nota, $comentario, $id_evaluacion);
						}
					}
					else {
						$nota = NULL;
						$comentario = NULL;
						$confirmacion = $confirmacion && $this->Model_calificaciones->agregarCalificacion($rut_profesor, $rut, $nota, $comentario, $id_evaluacion);
						
					}
				}
			}

			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se han guardado las calificaciones con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error al guardar las calificaciones de algún estudiante";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = TRUE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Estudiantes/agregarCalificaciones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Agregar Calificaciones"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_PROFESOR, TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function getSeccionesByProfesorAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$verTodas = $this->input->post('verTodas');
		$this->load->model('Model_seccion');
		$rutProfesor = $this->session->userdata('rut');
		//$esLider = $this->esProfesorLider($rutProfesor);
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$resultado = $this->Model_seccion->getSeccionesByProfesor($rutProfesor, $id_tipo_usuario, $verTodas);
		echo json_encode($resultado);
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


	public function getAsistenciaEstudiantesBySeccionAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$id_seccion = $this->input->post('id_seccion');
		$only_view = $this->input->post('only_view');
		$rut_usuario = $this->session->userdata('rut');
		$this->load->model('Model_asistencia');
		$this->load->model('Model_profesor');
		$this->load->model('Model_estudiante');
		$this->load->model('Model_planificacion');
		$this->load->model('Model_modulo_tematico');
		if (($this->session->userdata('id_tipo_usuario') == TIPO_USR_COORDINADOR) || $only_view) {
			$esCoordinador = TRUE;
			$id_modulo_tem = NULL;
			$modulosTematicosEnQueEsLider = array();
		}
		else {
			$esCoordinador = FALSE;
			$modulosTematicosEnQueEsLider = $this->Model_profesor->getModulosTematicosProfesorLider($rut_usuario);
			//echo 'Cantidad mod es lider: '.count($modulosTematicosEnQueEsLider).'  ';
			//Podría tomar -1 si se está consultando una sección a la cual no le hace clases el profesor, sin embargo igualmente puede ser profesor lider
			$id_modulo_tem = $this->Model_modulo_tematico->getIdModuloTematicoByProfesorAndSeccion($rut_usuario, $id_seccion);
		}
		$listaEstudiantes = $this->Model_estudiante->getEstudiantesBySeccionForAsistencia($id_seccion);
		foreach ($listaEstudiantes as $estudiante) {
			$estudiante->asistencia = array(); //Array asociativo que usa como key las id de las sesiones de clase y el value es presente o no
			$estudiante->comentarios = array(); //Array asociativo que usa como key las id de las sesiones de clase y el value es el comentario de la inasistencia

			if (count($modulosTematicosEnQueEsLider) < 1) {
				$asistenciaDelEstudiante = $this->Model_asistencia->getAsistenciaEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
				$estudiante->asistencia = $asistenciaDelEstudiante;
				//Lo ordeno por num_sesion_seccion
				$comentariosDelEstudiante = $this->Model_asistencia->getComentariosAsistenciaEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
				$estudiante->comentarios = $comentariosDelEstudiante;
				
				$cantidadSesiones = $this->Model_planificacion->cantidadSesionesPlanificadasBySeccionAndModuloTem($id_seccion, $id_modulo_tem);
			}
			else {
				$cantidadSesiones = 0;
				foreach ($modulosTematicosEnQueEsLider as $modTem) {
					$id_modulo_tem = $modTem->id;
					$asistenciaTemp = $this->Model_asistencia->getAsistenciaEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
					$comentariosTemp = $this->Model_asistencia->getComentariosAsistenciaEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
					$estudiante->asistencia = array_merge($estudiante->asistencia, $asistenciaTemp);
					$estudiante->comentarios = array_merge($estudiante->comentarios, $comentariosTemp);
					$cantidadSesiones += $this->Model_planificacion->cantidadSesionesPlanificadasBySeccionAndModuloTem($id_seccion, $id_modulo_tem);

				}
			}
		}
		echo json_encode($listaEstudiantes);
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
		$id_tipo_usr_consultante = $this->session->userdata('id_tipo_usuario');
		$rut = $this->session->userdata('rut');
		
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getEstudiantesByFilter($textoFiltro, $textoFiltrosAvanzados, $rut, $id_tipo_usr_consultante);
		
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
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_seccion');

		$resultado = $this->Model_seccion->getAllSecciones();
		echo json_encode($resultado);
	}


	public function getEvaluacionesBySeccionAndProfesorAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$only_view = $this->input->post('only_view');
		$id_seccion = $this->input->post('seccion');
		$rut_profesor = $this->session->userdata('rut');
		$this->load->model('Model_profesor');
		$mostrarTodas = $only_view;
		if (($this->session->userdata('id_tipo_usuario') == TIPO_USR_COORDINADOR)) {
			$esCoordinador = TRUE;
			$modulosTematicosEnQueEsLider = array();
		}
		else {
			$esCoordinador = FALSE;
			$modulosTematicosEnQueEsLider = $this->Model_profesor->getModulosTematicosProfesorLider($rut_profesor);
		}
		//echo 'esCoordinador: '.$esCoordinador.'   ';
		$this->load->model('Model_calificaciones');
		$this->load->model('Model_profesor');
		$resultado = $this->Model_calificaciones->getEvaluacionesBySeccionAndProfesorAjax($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas);
		
		echo json_encode($resultado);
	}


	public function getCalificacionesEstudiantesBySeccionAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$id_seccion = $this->input->post('id_seccion');
		$only_view = $this->input->post('only_view');
		$rut_usuario = $this->session->userdata('rut');
		$this->load->model('Model_calificaciones');
		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		$this->load->model('Model_modulo_tematico');
		if (($this->session->userdata('id_tipo_usuario') == TIPO_USR_COORDINADOR) || $only_view) {
			$esCoordinador = TRUE;
			$id_modulo_tem = NULL;
			$modulosTematicosEnQueEsLider = array();
		}
		else {
			$esCoordinador = FALSE;
			$modulosTematicosEnQueEsLider = $this->Model_profesor->getModulosTematicosProfesorLider($rut_usuario);
			//Podría tomar -1 si se está consultando una sección a la cual no le hace clases el profesor, sin embargo igualmente puede ser profesor lider
			$id_modulo_tem = $this->Model_modulo_tematico->getIdModuloTematicoByProfesorAndSeccion($rut_usuario, $id_seccion);
		}
		//DE AQUÍ PARA ABAJO HAY QUE CAMBIAR
		$listaEstudiantes = $this->Model_estudiante->getEstudiantesBySeccionForAsistencia($id_seccion);
		//echo 'id_modulo_tem: '.$id_modulo_tem.'   ';
		foreach ($listaEstudiantes as $estudiante) {
			
			$estudiante->notas = array(); //Array asociativo que usa como key las id de las sesiones de clase y el value es presente o no
			$estudiante->comentarios = array(); //Array asociativo que usa como key las id de las sesiones de clase y el value es el comentario de la inasistencia
			if (count($modulosTematicosEnQueEsLider) < 1) {
				$estudiante->notas = $this->Model_calificaciones->getCalificacionesEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
				$estudiante->comentarios = $this->Model_calificaciones->getComentariosCalificacionesEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
				$cantidadCalificaciones = $this->Model_calificaciones->cantidadCalificacionesBySeccionAndModuloTem($id_seccion, $id_modulo_tem);
			}
			else {
				$cantidadCalificaciones = 0;
				foreach ($modulosTematicosEnQueEsLider as $modTem) {
					$id_modulo_tem = $modTem->id;
					$notasTemp = $this->Model_calificaciones->getCalificacionesEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
					$comentariosTemp = $this->Model_calificaciones->getComentariosCalificacionesEstudianteByModuloTematico($estudiante->rut, $id_modulo_tem);
					$estudiante->notas = array_merge($estudiante->notas, $notasTemp);
					$estudiante->comentarios = array_merge($estudiante->comentarios, $comentariosTemp);
					$cantidadCalificaciones += $this->Model_calificaciones->cantidadCalificacionesBySeccionAndModuloTem($id_seccion, $id_modulo_tem);

				}
			}
			
			//Agrego el promedio final
			$posicionUltimo = count($estudiante->notas);
			if ($posicionUltimo > 0) {
				
				$objetoNota = new stdClass();
				$objetoNota->nota = $this->Model_calificaciones->calculaPromedio($estudiante->rut);
				//echo 'nota:'.$objetoNota->nota.' c:'.count($estudiante->notas).' ';
				$objetoNota->id_evaluacion = -1;
				$estudiante->notas[$posicionUltimo] = $objetoNota;

				//$promedio = array($objetoNota);
				//array_merge($estudiante->notas, $promedio);

				$objetoComentario = new stdClass();
				$objetoComentario->comentario = NULL;
				$objetoComentario->id_evaluacion = -1;
				$estudiante->comentarios[$posicionUltimo] = $objetoComentario;
				//$comentarioPromedio = array($objetoComentario);
				//array_merge($estudiante->comentarios, $comentarioPromedio);
				
			}
			
			/*
			if ($posicionUltimo > 0) {
				$objetoNota = array();
				$objetoNota['nota'] = $this->Model_calificaciones->calculaPromedio($estudiante->rut);
				//echo 'nota:'.$objetoNota['nota'].' ';
				$objetoNota['id_evaluacion'] = -1;
				$promedio = array($objetoNota);
				array_merge($estudiante->notas, $promedio);

				$objetoComentario = array();
				$objetoComentario['comentario'] = NULL;
				$objetoComentario['id_evaluacion'] = -1;
				$comentarioPromedio = array($objetoComentario);
				array_merge($estudiante->comentarios, $comentarioPromedio);
			}
			*/

		}
		try {
			$aImprimir = json_encode($listaEstudiantes);
			echo $aImprimir;
		}
		catch (Exception $e) {
			echo 'Error en la wea';
		}
		
	}


	private function calculaPromedio($notas) {
		$cantidadNotas = 0;
		$acum = 0;
		foreach ($notas as $nota) {
			if ($nota["nota"] != "") {
				$acum = $acum + $nota["nota"];
				$cantidadNotas = $cantidadNotas + 1;
			}
		}
		if ($cantidadNotas != 0)
			return $acum/$cantidadNotas;
		return "";
	}


	public function getSesionesBySeccionAndProfesorAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}


		$this->load->model('Model_profesor');
		$only_view = $this->input->post('only_view');
		$id_seccion = $this->input->post('seccion');
		$rut_profesor = $this->session->userdata('rut');
		$mostrarTodas = $only_view;
		if (($this->session->userdata('id_tipo_usuario') == TIPO_USR_COORDINADOR)) {
			$esCoordinador = TRUE;
			$modulosTematicosEnQueEsLider = array();
		}
		else {
			$esCoordinador = FALSE;
			$modulosTematicosEnQueEsLider = $this->Model_profesor->getModulosTematicosProfesorLider($rut_profesor);
		}
		//echo 'caca:'.$only_view.'listo. esCoordinador:'.$esCoordinador.'caca ';return;
		$this->load->model('Model_sesion');
		$resultado = $this->Model_sesion->getSesionesPlanificadasBySeccionAndProfesor($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas);
		
		echo json_encode($resultado);
	}

}

/* End of file Estudiantes.php */
/* Location: ./application/controllers/Estudiantes.php */
