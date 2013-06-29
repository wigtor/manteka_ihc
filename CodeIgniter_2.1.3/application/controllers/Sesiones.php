
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Sesiones extends MasterManteka {

	
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
	public function verSesiones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSesiones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_ver', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
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
	public function ingresarSesiones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSesiones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

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
	public function agregarSesiones()
	{
		$this->load->model('Model_sesiones');
		$nombre_sesion = $this->input->post("nombre_sesion");
		$descripcion_sesion = $this->input->post("descripcion_sesion");
		$confirmacion = $this->Model_sesiones->AgregarSesion($nombre_sesion,$descripcion_sesion);

		// mostramos el mensaje de operacion realizada
		if ($confirmacion==1){
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
		$datos_plantilla["redirecTo"] = "Sesiones/ingresarSesiones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Ingresar Sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$subMenuLateralAbierto = "ingresarSesiones"; 
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}

    /**
	* Comprobar que el nombre de la sesion que se ingresando no pertenezca a otra sesion existente ya en el sistema
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Luego, se carga el model de sesiones y se captura el nombre de la sesion
	* Finalmente se llama a la función nombreExisteM que reside en el modelo, que retorna -1 
	* Si el nombre de la sesión existe y 1 en caso contrario.
	* @return json Resultado de la busqueda en forma de objeto json
	*/
    public function nombreExisteC() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sesiones');
		$nombre = $this->input->post('nombre_post');

		$resultado = $this->Model_sesiones->nombreExisteM($nombre);
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
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$codigo = $this->input->post('sesion');
		$this->load->model('Model_sesiones');
		$resultado = $this->Model_sesiones->getDetallesSesion($codigo);
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
		
		$this->load->model('Model_sesiones');
		$resultado = $this->Model_sesiones->getSesionesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		echo json_encode($resultado);
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
    public function eliminarSesion()// alimina un alumno y de ahí carga la vista para seguir eliminando 
	{

		$this->load->model('Model_sesiones');
		$codEliminar = $this->input->post('codEliminar');

		$confirmacion = $this->Model_sesiones->EliminarSesion($codEliminar);
		
		
		if ($confirmacion==1){
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
		$datos_plantilla["redirecTo"] = "Sesiones/borrarSesiones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Borrar Sesiones"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
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
    public function borrarSesiones()//carga la vista para borrar alumnos
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_vista = 0;
		$subMenuLateralAbierto = "borrarSesiones"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_eliminar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
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
	public function cambiarSesiones()//carga la vista para borrar alumnos
	{
		$this->load->model('Model_sesiones');
		$nombre_sesion = $this->input->post('nombre_sesion');
		$descripcion_sesion = $this->input->post('descripcion_sesion');
		$codigo_sesion = $this->input->post('codigo_sesion');
		
		$confirmacion = $this->Model_sesiones->EditarSesion($nombre_sesion,$descripcion_sesion, $codigo_sesion);
        if ($confirmacion==1){
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
		$datos_plantilla["redirecTo"] = "Sesiones/editarSesiones"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Editar Sesiones"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
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
	public function editarSesiones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		$datos_vista = 0;		
		$subMenuLateralAbierto = "editarSesiones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_sesiones_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

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
		$this->load->model('Model_sesiones');
		$nombre = $this->input->post('nombre_post');
		$codigo = $this->input->post('codigo_post');

		$resultado = $this->Model_sesiones->nombreExisteEM($nombre,$codigo);
		echo json_encode($resultado);
	}
		
	
}

