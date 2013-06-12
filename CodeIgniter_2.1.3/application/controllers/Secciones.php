

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Secciones extends MasterManteka {


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

		$this->verSecciones();
	}

	/**
	* Ver una seccion del sistema y luego carga los datos para volver a la vista 'cuerpo_secciones_ver'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de secciones,finalmente se carga la vista nuevamente con todos los datos para permitir ver otra seccion.
	*
	*/
	public function verSecciones()
	{
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'rs_estudiantes'=>$this->Model_secciones->VerTodosLosEstudiantes($cod_seccion),'secc' =>$this->Model_secciones->VerSeccion($cod_seccion));
		$this->cargarTodo("Secciones", 'cuerpo_secciones_ver', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	/**
	* Agregar una seccion del sistema y luego carga los datos para volver a la vista 'cuerpo_secciones_agregar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de secciones, se llama a la función AgregarSeccion para insertar la seccion
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la inserción de otra seccion.
	*/
	public function agregarSecciones()
	{	
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$nombre_seccion1 = $this->input->post("rs_seccion");
		$nombre_seccion2 = $this->input->post("rs_seccion2");
		$confirmacion = $this->Model_secciones->AgregarSeccion($nombre_seccion1,$nombre_seccion2);
        $datos_vista = array('mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_agregar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}

	
 
 	/**
	* Editar una seccion del sistema y luego carga los datos para volver a la vista 'cuerpo_secciones_editar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de secciones, se llama a la función AtualizarSeccion para editar la seccion
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la edición de otra seccion.
	*
	*/
    public function editarSecciones()
    {
	//Se comprueba que quien hace esta petición este logueado
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "editarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
		$nombre_seccion1 = $this->input->post("rs_seccion");
		$nombre_seccion2 = $this->input->post("rs_seccion2");
		$confirmacion = $this->Model_secciones->ActualizarSeccion($cod_seccion,$nombre_seccion1,$nombre_seccion2);
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_editar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
    }

		/**
	* Borrar una seccion del sistema y luego carga los datos para volver a la vista 'cuerpo_secciones_borrar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de secciones, se llama a la función EliminarSeccion para borrar la seccion
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la eliminación de otra seccion.
	*
	*/
    public function borrarSecciones()
    {
		//Se comprueba que quien hace esta petición este logueado
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "borrarSecciones"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
		$cod_seccion1 = $this->input->post("rs_seccion");
		$confirmacion = $this->Model_secciones->EliminarSeccion($cod_seccion1);
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(),'rs_estudiantes'=>$this->Model_secciones->VerTodosLosEstudiantes($cod_seccion),'secc' =>$this->Model_secciones->VerSeccion($cod_seccion),'mensaje_confirmacion'=>$confirmacion);
		$this->cargarTodo("Secciones", 'cuerpo_secciones_borrar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}


/**
* Se realiza la asiganción de una sección a los datos que corrresponde a la seccionn seleccionada
* primero se realiza la rutina de comprobacion de usuaraio con la sesión iniciado
* luego se defienen como vacios los datos de la vista 
* se indiaca el valor del meni lateral que debe permanecer abierto
* Se limita el acceso solo a los coordinadores
* Se carga el modelo de secciones 
* Se realiza la operación de asiganción a la seccion correspondiente llamando al modelo
**/	
	public function asignarAsecciones()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}



		$datos_vista = 0;		
		$subMenuLateralAbierto = "asignarAseccion"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones(), 'modulos' => $this->Model_secciones->verModulosPorAsignar(), 'salas' => $this->Model_secciones->verSalasPorAsignar());
		$this->cargarTodo("Secciones", 'cuerpo_secciones_asignar', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);



	}

	/**
	* Se eliminnan la asignaciones de una sección determinada 
	* primero se realiza la rutina de comprobacion de usuaraio con la sesión iniciado
	* luego se defienen como vacios los datos de la vista 
	* se indiaca el valor del meni lateral que debe permanecer abierto
	* Se limita el acceso solo a los coordinadores
	* Se carga el modelo de secciones 
	* Se realiza la operación de  elimnar asignacionae invocando la función en el modelo	
	**/

	public function borrarAsignacion()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_vista = 0;		
		$subMenuLateralAbierto = "borrarAsignar"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		
		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post("cod_seccion");
        $datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones());
		$this->cargarTodo("Secciones", 'cuerpo_secciones_eliminarAsignacion', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);



	}


	/**
	* Funciaón que realiza un pos de los detalle de la fincion desde el
	* modelo a la vista utilizando json para la comunicación asincrona
	*
	*
	**/

	public function postDetalleSeccion() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$cod_seccion = $this->input->post('seccion');
		$this->load->model('Model_secciones');
		$resultado = $this->Model_secciones->getDetalleSeccion($cod_seccion);
		echo json_encode($resultado);
	}

	/**
	* Se eliminnan la asignaciones de una sección determinada 
	* primero se realiza la rutina de comprobacion de usuaraio con la sesión iniciado
	* luego se defienen como vacios los datos de la vista 
	* se indiaca el valor del meni lateral que debe permanecer abierto
	* Se limita el acceso solo a los coordinadores
	* Se carga el modelo de secciones 
	* Se realiza la operación de  elimnar asignacionae invocando la función en el modelo	
	**/

	public function eliminarAsignacion()
	{

		$this->load->model('Model_secciones');
		$cod_seccion = $this->input->post('cod_seccion');

		$confirmacion = $this->Model_secciones->EliminarAsignacion($cod_seccion);
		//$datos_vista = array('mensaje_confirmacion'=>$confirmacion);//


		/*$subMenuLateralAbierto = "borrarAsignar"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$datos_vista = array('seccion' =>$this->Model_secciones->VerTodasSecciones());
		$this->cargarTodo("Secciones", 'cuerpo_secciones_eliminarAsignacion', "barra_lateral_secciones", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	*/

		// mostramos el mensaje de operacion realizada
		$datos_plantilla["titulo_msj"] = "Accion Realizada";
		$datos_plantilla["cuerpo_msj"] = "Se ha eliminado la asignacion de la seccion";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Secciones/borrarAsignacion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Eliminar Asignación"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);


	}

	
	public function postDetalleModulos() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$nombre_modulo = $this->input->post('nombre_modulo');
		$this->load->model('Model_secciones');
		$resultado = $this->Model_secciones->verProfeSegunModulo($nombre_modulo);
		echo json_encode($resultado);
	}

	public function postDetalleSala() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$sala = $this->input->post('sala');
		$this->load->model('Model_secciones');
		$resultado = $this->Model_secciones->verHorarioSegunSala($sala);
		echo json_encode($resultado);
	}

	
	
	
}
