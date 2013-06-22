

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Salas extends MasterManteka {

	
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
		$this->verSalas();
	}

	/**
	* Ver una sala del sistema y luego carga los datos para volver a la vista 'cuerpo_salas_ver'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas,finalmente se carga la vista nuevamente con todos los datos para permitir ver otra sala.
	*
	*/
	public function verSalas()
	{
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "verSalas"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		//$datos_vista = array('sala' => $this->Model_sala->VerTodasLasSalas(), 'salaImplemento' => $this->Model_sala->VerTodosLosImplementosSala());
		$this->cargarTodo("Salas", 'cuerpo_salas_ver', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	/**
	* Agregar una sala del sistema y luego carga los datos para volver a la vista 'cuerpo_salas_agregar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función InsertarSala para insertar la sala
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la inserción de otra sala.
	*
	*/
	public function agregarSalas()
    {
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
		$datos_vista = 0;		
		$subMenuLateralAbierto = "agregarSalas"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		$datos_vista = array('implemento' => $this->Model_sala->VerTodosLosImplementos());
		$this->cargarTodo("Salas", 'cuerpo_salas_agregar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	public function ingresarSalas()
	{	
		
		
		$this->load->model('Model_sala');
        $num_sala = $this->input->get("num_sala");
        $ubicacion = $this->input->get("ubicacion");
        $capacidad = $this->input->get("capacidad");
		$implementos = $this->input->get("cod_implemento");
        $confirmacion = $this->Model_sala->InsertarSala($num_sala,$ubicacion,$capacidad,$implementos);
        
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha ingresado la sala con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error en el ingreso en base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Salas/agregarSalas"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		$datos_plantilla["nombre_redirecTo"] = "Agregar Salas"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);

	}
    
	/**
	* Editar una sala del sistema y luego carga los datos para volver a la vista 'cuerpo_salas_editar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función AtualizarSala para editar la sala
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la edición de otra sala.
	*
	*/
    public function editarSalas()
    {
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
    	$datos_vista = 0;		
		$subMenuLateralAbierto = "editarSalas"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		$datos_vista = array('implementos' => $this->Model_sala->VerTodosLosImplementosSimple());
	
		$this->cargarTodo("Salas", 'cuerpo_salas_editar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	
    }
	
	public function modificarSalas()
	{
		$this->load->model('Model_sala');
		$cod_sala = $this->input->post("codEditar");
		$cod_salaF=$this->input->post("cod_sala");
	    $num_sala = $this->input->post("num_sala");
		$ubicacion = $this->input->post("ubicacion");
		$capacidad = $this->input->post("capacidad");
		$implementos = $this->input->post("implementos");
        $confirmacion = $this->Model_sala->ActualizarSala($cod_salaF,$num_sala,$ubicacion,$capacidad,$implementos);  
		
        // se muestra mensaje de operación realizada
    	if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha modificado la sala con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error en la edición en base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Salas/editarSalas"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		$datos_plantilla["nombre_redirecTo"] = "Editar Salas"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
	/**
	* Borrar una sala del sistema y luego carga los datos para volver a la vista 'cuerpo_salas_eliminar'
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función EliminarSala para borrar la sala
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* que se le envía a la vista a través de la variable 'mensaje_confirmacion' para que de el feedback al usuario, en la vista, de como resulto la operación.
	* Finalmente se carga la vista nuevamente con todos los datos para permitir la eliminación de otra sala.
	*
	*/
	 public function borrarSalas()
    {
		//Se comprueba que quien hace esta petición este logueado
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
    	$datos_vista = 0;		
		$subMenuLateralAbierto = "borrarSalas"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->load->model('Model_sala');
		$datos_vista = array('sala' => $this->Model_sala->VerTodasLasSalas(), 'salaImplemento' => $this->Model_sala->VerTodosLosImplementosSala());
		$this->cargarTodo("Salas", 'cuerpo_salas_eliminar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	public function eliminarSalas()
    {
		$this->load->model('Model_sala');
		$cod_sala = $this->input->post("cod_sala");
		$confirmacion = $this->Model_sala->EliminarSala($cod_sala);
		
		if ($confirmacion==1){
			$datos_plantilla["titulo_msj"] = "Acción Realizada";
			$datos_plantilla["cuerpo_msj"] = "Se ha eliminado la sala con éxito";
			$datos_plantilla["tipo_msj"] = "alert-success";
		}
		else{
			$datos_plantilla["titulo_msj"] = "Acción No Realizada";
			$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error en la eliminación en base de datos";
			$datos_plantilla["tipo_msj"] = "alert-error";	
		}
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Salas/borrarSalas"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		$datos_plantilla["nombre_redirecTo"] = "Borrar Salas"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);

	}

    /**
    *	
    *
    *	@return json Resultado de la busqueda en forma de objeto json
    */
    public function postBusquedaSalas(){
    	if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');

		$this->load->model('Model_sala');
		$resultado = $this->Model_sala->getSalasByFilter($textoFiltro, $textoFiltrosAvanzados);
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'salas', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'salas', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);

    }

    public function postDetallesSala(){
    	//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$num_sala = $this->input->post('num_sala');
		$this->load->model('Model_sala');
		$resultado = $this->Model_sala->getDetallesSala($num_sala);
		echo json_encode($resultado);
    }

	public function numExiste() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sala');
		$num = $this->input->post('num_post');

		$resultado = $this->Model_sala->numSala($num);
		echo json_encode($resultado);
	}
	
	public function numExisteE() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sala');
		$num = $this->input->post('num_post');
		$cod = $this->input->post('cod_post');
		$resultado = $this->Model_sala->numSalaE($num,$cod);
		echo json_encode($resultado);
	}
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */