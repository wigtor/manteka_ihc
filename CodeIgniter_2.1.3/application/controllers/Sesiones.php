
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Sesiones extends MasterManteka {

	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verSesiones();
	}

 	 
	/**
	* Manda a la vista 'cuerpo_sesiones_ver' los datos necesarios para su funcionamiento
	*
	* Primero se carga los datos de la vista, en este caso con 0 poeque no se recibe ningun dato del modelo.
	* Luego, se determina el menu lateral correspondiente a verSesiones, para que quede seleccionado en el menu.
	* A continuacion, se indica que la vista no tendra la barra de progreso.
	* Posteriormente, se comprueba que el usuario tenga la sesión iniciada y que sea coordinador, en caso que no sea así se le redirecciona al login
	* Finalmente se carga la vista con todos los datos como parámetros en la funcion cargarTodo.
	*/
	public function verSesiones() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "verSesiones"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Planificacion", 'cuerpo_sesiones_ver', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Manda a la vista 'cuerpo_sesiones_agregar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Seguido a esto, se carga los datos de la vista, en este caso con 0 poeque no se recibe ningun dato del modelo.
	* Luego, se determina el menu lateral correspondiente a agregarSesiones, para que quede seleccionado en el menu.
	* A continuacion, se indica que la vista no tendra la barra de progreso.
	* Finalmente se carga la vista con todos los datos como parámetros en la funcion cargarTodo.
	*/
	public function agregarSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_modulo_tematico');
			$datos_vista['modulosTematicos'] = $this->Model_modulo_tematico->getAllModulosTematicos();
			$subMenuLateralAbierto = "agregarSesion"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_sesiones_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Inserta una sesion al sistema y luego carga los datos para volver a la vista 'cuerpo_sesiones_agregar'
	*
	* Se carga el modelo de sesiones, y a continuación se obtienen los datos de nombre y descripción de la sesion. 
	* Con los dichos datos que se capturan un paso antes en el controlador desde la vista con el uso del POST,
	* Se llama a la funcion AgregarSesion en el modelo.
	* El resultado de ésta, se recibe en la variable 'confirmacion'
	* A partir del valor de 'confirmacion' se ejecuta eñ mensaje accion realizada o accion no realizada.
	* Finalmente, se llama a la vista a la cual se redirecciona desde el mensaje de retroalimentacion, se especifica el submenu que estara seleccinado,
	* se determina el tipo de usuario y se llama a la funcion cargarMsjLogueado con los datos anteriores.
	*
	*/
	public function postAgregarSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sesion');
			$nombre_sesion = $this->input->post("nombre");
			$descripcion_sesion = $this->input->post("descripcion");
			$id_modTem = $this->input->post("id_moduloTem");
			$confirmacion = $this->Model_sesion->AgregarSesion($nombre_sesion, $descripcion_sesion, $id_modTem);

			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE){
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
			$datos_plantilla["redirecTo"] = "Sesiones/agregarSesion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Ingresar Sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Manda a la vista 'cuerpo_sesiones_eliminar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Seguido a esto, se carga los datos de la vista, en este caso con 0 poeque no se recibe ningun dato del modelo.
	* Luego, se determina el menu lateral correspondiente a borrarSesiones, para que quede seleccionado en el menu.
	* A continuacion, se indica que la vista no tendra la barra de progreso.
	* Finalmente se carga la vista con todos los datos como parámetros en la funcion cargarTodo.
	*/
    public function eliminarSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "eliminarSesion"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_sesiones_eliminar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
	}


    /**
	* Elimina una sesion del sistema y luego carga los datos para volver a la vista 'cuerpo_sesiones_eliminar'
	*
	* Se carga el modelo de sesiones, y a continuación se obtienen los datos de codigo de la sesion. 
	* Dicho dato se capturan un paso antes en el controlador desde la vista con el uso del POST,
	* Se llama a la funcion EliminarSesion en el modelo.
	* El resultado de ésta, se recibe en la variable 'confirmacion'
	* A partir del valor de 'confirmacion' se ejecuta eñ mensaje accion realizada o accion no realizada.
	* Finalmente, se llama a la vista a la cual se redirecciona, en este caso borrarSesiones, desde el mensaje de retroalimentacion;
	* Se especifica el submenu que estara seleccinado,
	* Se determina el tipo de usuario y se llama a la funcion cargarMsjLogueado con los datos anteriores.
	*
	*/
    public function postEliminarSesion() {
    	if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sesion');
			$codEliminar = $this->input->post('codEliminar');

			$confirmacion = $this->Model_sesion->eliminarSesion($codEliminar);
			
			
			if ($confirmacion == TRUE){
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
			$datos_plantilla["redirecTo"] = "Sesiones/eliminarSesion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Eliminar Sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Manda a la vista 'cuerpo_sesiones_editar' los datos necesarios para su funcionamiento
	*
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Seguido a esto, se carga los datos de la vista, en este caso con 0 poeque no se recibe ningun dato del modelo.
	* Luego, se determina el menu lateral correspondiente a editarSesiones, para que quede seleccionado en el menu.
	* A continuacion, se indica que la vista no tendra la barra de progreso.
	* Finalmente se carga la vista con todos los datos como parámetros en la funcion cargarTodo.
	*/
	public function editarSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "editarSesion"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_sesiones_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Edita una sesion del sistema y luego carga los datos para volver a la vista 'cuerpo_sesiones_editar'
	*
	* Se carga el modelo de sesiones, y a continuación se obtienen los datos de codigo, nombre y descripcion de la sesión. 
	* Dichos datos se capturan un paso antes en el controlador desde la vista con el uso del POST,
	* Se llama a la funcion EditarSesion en el modelo.
	* El resultado de ésta, se recibe en la variable 'confirmacion'
	* A partir del valor de 'confirmacion' se ejecuta eñ mensaje accion realizada o accion no realizada.
	* Finalmente, se llama a la vista a la cual se redirecciona, en este caso editarSesiones, desde el mensaje de retroalimentacion;
	* Se especifica el submenu que estara seleccinado,
	* Se determina el tipo de usuario y se llama a la funcion cargarMsjLogueado con los datos anteriores.
	*
	*/
	public function postEditarSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sesion');
			$nombre_sesion = $this->input->post('nombre_sesion');
			$descripcion_sesion = $this->input->post('descripcion_sesion');
			$codigo_sesion = $this->input->post('codigo_sesion');
			
			$confirmacion = $this->Model_sesion->EditarSesion($nombre_sesion,$descripcion_sesion, $codigo_sesion);
	        if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha editado la sesión con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error con la edición en la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Sesiones/editarSesion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Editar Sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Comprobar que el nombre de la sesion que se está editando no pertenezca a otra sesion ingresada en el sistema
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Luego, se carga el model de sesiones, se captura el nombre de la sesion y el código.
	* Finalmente se llama a la función nombreExisteEM que reside en el modelo, que retorna 1 
	* Si el nombre de la sesión existe y 0 en caso contrario.
	* @return json Resultado de la busqueda en forma de objeto json
	*/
	public function nombreExisteEC() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sesion');
		$nombre = $this->input->post('nombre_post');
		$codigo = $this->input->post('codigo_post');

		$resultado = $this->Model_sesion->nombreExisteEM($nombre,$codigo);
		echo json_encode($resultado);
	}
		
	
	/**
	* Comprobar que el nombre de la sesion que se ingresando no pertenezca a otra sesion existente ya en el sistema
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Luego, se carga el model de sesiones y se captura el nombre de la sesion
	* Finalmente se llama a la función nombreExisteM que reside en el modelo, que retorna -1 
	* Si el nombre de la sesión existe y 1 en caso contrario.
	* @return json Resultado de la busqueda en forma de objeto json
	*/
	public function nombreExisteAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sesion');
		$nombre = $this->input->post('nombre_post');

		$resultado = $this->Model_sesion->nombreExiste($nombre);
		echo json_encode($resultado);
	}


	/**
	* Obtener el detalle de una sesion determinada
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le 
	* Redirecciona al login. Siguiente a esto, se carga el model de sesion, se captura el codigo de la
	* Sesion. Finalmente se llama a la función getDetallesSesion del modelo, que retorna el detalle de la sesion.
	* @return json Resultado de la busqueda en forma de objeto json
	*/
	public function postDetallesSesion() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$codigo = $this->input->post('sesion');
		$this->load->model('Model_sesion');
		$resultado = $this->Model_sesion->getDetallesSesion($codigo);
		echo json_encode($resultado);
	}


	/**
	* Obtener los datos de las sesiones que coincidan con la búsqueda del filtro seleccionado.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le 
	* Redirecciona al login. Siguiente a esto, se capturan los tipos de filtros seleccionados. luego
	* Se carga el model de sesion, se realiza una nueva búsqueda dado el filtro básico, y una por cada filtro avanzado seleccionado. 
	* Finalmente se retorna el resultado de la búsqueda, dados los filtros seleccionados.
	* @return json Resultado de la busqueda en forma de objeto json
	*/
	public function postBusquedaSesiones() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_sesion');
		$resultado = $this->Model_sesion->getSesionesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		echo json_encode($resultado);
	}
}

