<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Alumnos extends MasterManteka {

	/**
	* Manda a la vista 'cuerpo_alumnos_ver' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'rs_estudiantes' que contiene toda la información de los
	* estudiantes del sistema y la lista 'carreras' que contiene información de las carreras en el sistema. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function verAlumnos()
	{
		
		//cargo el modelo de estudiantes
		$this->load->model('Model_estudiante');

		$datos_vista = array('rs_estudiantes' => array());

		$subMenuLateralAbierto = "verAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Alumnos", 'cuerpo_alumnos_ver', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}
	
	/**
	* Manda a la vista 'cuerpo_alumnos_editar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'secciones' que contienen los datos necesarios para que el usuario
	* escoja en la vista este parametro para  editar la información del alumno.
	* También se envía un mensaje de confirmación con valor 2, que indica que se está cargando por primera ves la vista de editar alumnos.
	* Se envía también la lista de todos los estudiantes para que de ahí se escoja al que se quiere editar en la vista.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function editarAlumnos()//carga la vista para editar alumnos
	{

		$this->load->model('Model_estudiante');
		$datos_vista = array('rs_estudiantes' => array(),'mensaje_confirmacion' => 2,'secciones' => $this->Model_estudiante->VerSecciones());


		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		
		$subMenuLateralAbierto = 'editarAlumnos'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Alumnos", "cuerpo_alumnos_editar", "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}
	
	/**
	* Manda a la vista 'cuerpo_alumnos_borrar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'rs_estudiantes' que contiene toda la información de los
	* estudiantes del sistema y se envia un 'mensaje_confirmacion' que sirve en la vista para que ésta sepa que se está cargando la página por primera vez.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function borrarAlumnos()//carga la vista para borrar alumnos
	{
		$this->load->model('Model_estudiante');

		$datos_vista = array('rs_estudiantes' => array(),'mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = "borrarAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Alumnos", 'cuerpo_alumnos_borrar', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}
	
	/**
	* Elimina un estudiante del sistema y luego carga los datos para volver a la vista 'cuerpo_alumnos_borrar'
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
	public function eliminarAlumno()// alimina un alumno y de ahí carga la vista para seguir eliminando 
	{

		//$this->load->model('Model_estudiante');
		$this->load->model('Model_estudiante');
		$rut_estudiante = $this->input->post('rut_estudiante');

		$confirmacion = $this->Model_estudiante->EliminarEstudiante($rut_estudiante);
		//$datos_vista = array('rs_estudiantes' => array(),'mensaje_confirmacion'=>$confirmacion);//


		//$subMenuLateralAbierto = "borrarAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		//$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		//$tipos_usuarios_permitidos = array();
		//$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		//$this->cargarTodo("Alumnos", 'cuerpo_alumnos_borrar', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	

		// mostramos el mensaje de operacion realizada
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha borrado el alumno con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la eliminación en base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Alumnos/borrarAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Borrar Alumno"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}




	/**
	* Manda a la vista 'cuerpo_alumnos_agregar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se cargan los datos de la vista con la lista 'carreras' y 'secciones' que contienen los datos necesarios para que el usuario
	* escoja en la vista estos parametros necesarios para ingresar un nuevo alumno. También se envía un mensaje de confirmación con valor 2, que indica que se está cargando
	* por primera ves la vista de cargar alumnos. Finalmente se carga la vista con todos los datos.
	*
	*/
	public function agregarAlumnos()//carga la vista agregar alumnos
	{

		$this->load->model('Model_estudiante');

		$datos_vista = array('lista_rut' => $this->Model_estudiante->getAllRut(),'carreras' => $this->Model_estudiante->VerCarreras(),'secciones' => $this->Model_estudiante->VerSecciones(),'mensaje_confirmacion'=>2);

		$subMenuLateralAbierto = "agregarAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Alumnos", 'cuerpo_alumnos_agregar', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	

	}

	
	/**
	* Inserta un estudiante al sistema y luego carga los datos para volver a la vista 'cuerpo_alumnos_agregar'
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
	public function insertarAlumno()//inserta alumno
	{

		
		$this->load->model('Model_estudiante');

		$rut_estudiante = $this->input->post("rut_estudiante");
		$nombre1_estudiante = $this->input->post("nombre1_estudiante");
		$nombre2_estudiante = $this->input->post("nombre2_estudiante");;
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$correo_estudiante = $this->input->post("correo_estudiante");
		$cod_seccion = $this->input->post("seccion_seleccionada");
		$cod_carrera = $this->input->post("cod_carrera");
		
		$confirmacion = $this->Model_estudiante->InsertarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$cod_seccion,$cod_carrera);

		// mostramos el mensaje de operacion realizada
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Accion Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el alumno con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Accion No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Alumnos/agregarAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Agregar Alumno"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}


	

	
	/**
	* Edita la información de un estudiante del sistema y luego carga los datos para volver a la vista 'cuerpo_alumnos_editar'
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de estudiantes, se llama a la función ActualizarEstudiante para editar el estudiante
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de esta operacion se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Luego se cargan los datos de la vista con la lista 'secciones' y 'rs_estudiantes' para que esté habilitada para nuevas ediciones.
	* Finalmente se carga la vista con todos los datos.
	*
	*/
	public function EditarEstudiante()//edita estudiante
	{
		$datos_vista = array();
		$subMenuLateralAbierto = "editarAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Alumnos", 'cuerpo_alumnos_editar', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}

	/**
	*
	* Obtiene para la vista los estudiantes de una sección determinada
	*
	* Se consulta el estado de logueado del usuario si lo esta se llama a la función
	* en el modelo para obtener los datos de los estudianes que pertencenede a la sección $cod_seccion 
	* obtenida de la vista.
	**/

	public function obtenerAlumnosSeccion() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$cod_seccion = $this->input->post('cod_seccion_post');
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getEstudiantesSeccion($cod_seccion);
		echo json_encode($resultado);
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
		$rut_estudiante = $this->input->post("rutEditar");
		$nombre1_estudiante = $this->input->post("nombreunoEditar");
		$nombre2_estudiante = $this->input->post("nombredosEditar");
		$apellido_paterno = $this->input->post("apellidopaternoEditar");
		$apellido_materno = $this->input->post("apellidomaternoEditar");
		$correo_estudiante = $this->input->post("correoEditar");
		$cod_seccion = $this->input->post("seccion_seleccionada");

		$this->load->model('Model_estudiante');
		$confirmacion = $this->Model_estudiante->ActualizarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$cod_seccion);
		
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha editado el alumno con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la actualización de la base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Alumnos/editarAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Editar Alumno"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);


	}

	/**
	*
	* Carga la vista para el cambio de sección. 
	*
	*Se cargan a través del modelo las seccines de estudiantes que serán mostradasn en pantalla.
	*
	*
	**/
	
	public function cambiarSeccionAlumnos()
	{

		$this->load->model('Model_estudiante');

		$datos_vista = array('secciones' => $this->Model_estudiante->VerSecciones());

		$subMenuLateralAbierto = "cambiarSeccionAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Alumnos", 'cuerpo_alumnos_cambiarSeccion', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);


	}
	

	/**
	* Esta función cambia de forma masiva a los estudiantes selecionandos a una nueva sección selecionada
	* Primero se carga el modelo de estudiantes 
	* Se determina desde que sección y a cual sección se cambiarán los alumnos
	* Se obtiene la lista de selecionados que seránm cambiaados de sección
	* Se cargan los datos a la vista
	*
	**/

	public function HacerCambiarSeccionAlumnos()
	{
		//@ViewBag.Test = data[0]; // Data will be set to P1
		$this->load->model('Model_estudiante');
		$seccion1 = $this->input->post('cod_seccion1');
		$cambiarDesde = $this->input->post('direccion');
		$seccion2 = $this->input->post('cod_seccion2');
		
		
		
		if($cambiarDesde == 1){
			$lista_seleccionados = $this->input->post('seleccionadosS1');
			$seccionOUT = $this->input->post('cod_seccion2');
			$confirmacion = $this->Model_estudiante->CambioDeSecciones($seccionOUT,$lista_seleccionados);
		}
		else{
			$lista_seleccionados = $this->input->post('seleccionadosS2');
			$seccionOUT = $this->input->post('cod_seccion1');
			$confirmacion = $this->Model_estudiante->CambioDeSecciones($seccionOUT,$lista_seleccionados);
		}
		//echo count($lista_seleccionados);
		if($confirmacion != 1){
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error al intertar cambiar de sección";
			$datos_plantilla["tipo_msj"] = "alert-error";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha cambiado de sección correctamente";
			$datos_plantilla["tipo_msj"] = "alert-success";

		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Alumnos/cambiarSeccionAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		$datos_plantilla["nombre_redirecTo"] = "Cambio de sección alumnos"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}

	
	/**
	*
	* Carga la vista ver alumnos por defecto al entrar en la seccion alumnos
	*
	**/

	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verAlumnos();
	}


	/**
	* Método que responde a una solicitud de post para pedir los datos de un estudiante
	* Recibe como parámetro el rut del estudiante
	*/
	public function postDetallesAlumnos() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
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
	* Se buscan alumnos de forma asincrona para mostrarlos en la vista
	*
	**/
	public function postBusquedaAlumnos() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getAlumnosByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'alumnos', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'alumnos', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

	/**
	*
	* Se obtienen todas las secciones que hay ingresadas en manteka
	*
	**/

	public function postGetSecciones() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_estudiante');

		$resultado = $this->Model_estudiante->getSecciones();
		echo json_encode($resultado);
	}
	
	/**
	*
	* Se comprueba si existe el rut
	*
	* Se obtiene un rut desde la vista y se comprueba si este
	* existe en el sitema se deveulve el resultado de forma asincrona
	*
	*
	**/


	public function rutExisteC() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_estudiante');
		$rut = $this->input->post('rut_post');

		$resultado = $this->Model_estudiante->rutExisteM($rut);
		echo json_encode($resultado);
	}

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
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

	function cargaMasivaAlumnos()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '100';	


		$this->load->library('upload', $config);


		$subMenuLateralAbierto = "cargaMasivaAlumnos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;

		


		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$datos_vista = $error;

			$this->cargarTodo("Alumnos", 'cuerpo_alumnos_cargaMasiva', "barra_lateral_alumnos", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
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
					$datos_plantilla["redirecTo"] = "Alumnos/cargaMasivaAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de alumnos"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					$tipos_usuarios_permitidos = array();
					$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
					
					
				} else  {
					$datos_plantilla["titulo_msj"] = "Acción Realizada";
					$datos_plantilla["cuerpo_msj"] = "El archivo se ha cargado exitosamente.";
					$datos_plantilla["tipo_msj"] = "alert-success";
					$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
					$datos_plantilla["redirecTo"] = "Alumnos/cargaMasivaAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
					//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
					$datos_plantilla["nombre_redirecTo"] = "Carga masiva de alumnos"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
					$tipos_usuarios_permitidos = array();
					$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
					$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
				}
			}else{

				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "El archivo no tiene el formato correcto.";
				$datos_plantilla["tipo_msj"] = "alert-error";
				$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Alumnos/cargaMasivaAlumnos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Carga masiva de alumnos"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				$tipos_usuarios_permitidos = array();
				$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
				$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			}


		}
	}


}

/* End of file Alumnos.php */
/* Location: ./application/controllers/Alumnos.php */
