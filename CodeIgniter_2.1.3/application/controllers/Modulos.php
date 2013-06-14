<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Modulos extends MasterManteka {
	
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
		//funcion por defecto
		$this->verModulos();
	}

	
	/**
	* Carga las barras y menus especificos para la vista verModulos
	*
	* Se carga el sub menu lateral abierto al que corresponda, se carga el tipo de usuario y finalmente se llama a la función cargar todo
	* que es la que carga la vista con el resto de los parametros de menu y barras laterales
	*
	*/
	public function verModulos()
	{  
		$subMenuLateralAbierto = "verModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;  $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_ver', "barra_lateral_planificacion", "", $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
	}
    
	/**
	* Carga las barras y menus especificos para la vista agregarModulo como también envia un conjunto de listasPhp para el funcionamiento de la vista
	*
	* Carga el modelo de modulos y luego carga los datos de vista con la listas de profesores,sesiones y requisitos que son para asignar a un nuevo módulo
	* también se envía un mensaje de confirmación que especifica que la vista se carga por primera vez y la lista de nombre de modulo para en la vista confirmar que no 
	* se agrega un modulo con un nombre que ya esté en uso.
	* Se carga el sub menu lateral abierto al que corresponda, se carga el tipo de usuario y finalmente se llama a la función cargar todo
	* que es la que carga la vista con el resto de los parametros de menu y barras laterales. Como también los datos de la vista.
	*
	*/
    public function agregarModulos()
    {
		$this->load->model("Model_modulo");

		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_modulo->VerTodosLosProfesoresAddModulo(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>2,'requisitos' => $this->Model_modulo->listaRequisitosParaAddModulo());
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	/**
	* Recibe los datos de la vista para agregar un nuevo modulo
	*
	* Se carga el modelo de modulos donde se encuentra la función para hacer la inserción
	* Se capturan las variables enviadas por post desde la vista  
	* Se le dan los valores a la función y lo que retorna se guarda en confirmación
	* esto se le envía a la vista para dar feedback al usuario
	* finalmente se carga toda la vista nuevamente como en agregarModulos
	*
	*/
	    public function HacerAgregarModulo()
    {
		$this->load->model("Model_modulo");

		
		$nombre_modulo = $this->input->post('nombre_modulo');
		$sesiones = $this->input->post('cod_sesion');
		$descripcion_modulo = $this->input->post('descripcion_modulo');
		$profesor_lider = $this->input->post('cod_profesor_lider');
		$equipo_profesores = $this->input->post('cod_profesor_equipo');
		$requisitos = $this->input->post('cod_requisito');
		
		$confirmacion = $this->Model_modulo->InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos);
		
		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'profesores' => $this->Model_modulo->VerTodosLosProfesoresAddModulo(),'sesiones' => $this->Model_modulo->listaSesionesParaAddModulo(),'mensaje_confirmacion'=>$confirmacion,'requisitos' => $this->Model_modulo->listaRequisitosParaAddModulo());
     
		$subMenuLateralAbierto = "agregarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	
	
	/**
	* Carga las barras y menus especificos para la vista edittar modulos como también envía  cierta información para el funcionamiento de ésta
	*
	* Carga el modelo de modulos para solicitar los nombres de modulos para que no se edite a uno ya en uso y se envía un mensaje de que la vista
	* recién se está cargando por primera vez. Luego se cargan los menus y barras lateras para cargar la vista.
	*
	*/
    public function editarModulos()
    {
	
		$this->load->model("Model_modulo");
		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'mensaje_confirmacion'=>2);
		$subMenuLateralAbierto = "editarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }
	/**
	* Recibe los datos de la vista para editar el modulo
	*
	* Se carga el modelo de modulos donde se encuentra la función para hacer la edición
	* Se capturan las variables enviadas por post desde la vista  
	* Se le dan los valores a la función y lo que retorna se guarda en confirmación
	* esto se le envía a la vista para dar feedback al usuario
	* finalmente se carga toda la vista nuevamente como en editarModulos
	*
	*/
	public function HacerEditarModulo()
    {
		$this->load->model("Model_modulo");

		
		$nombre_modulo = $this->input->post('nombre_modulo');
		$sesiones = $this->input->post('sesion');
		$descripcion_modulo = $this->input->post('descripcion_modulo');
		$profesor_lider = $this->input->post('cod_profesor_lider');
		$equipo_profesores = $this->input->post('profesores');
		$requisitos = $this->input->post('requisitos');
		$cod_equipo = $this->input->post('cod_equipo2');
		$cod_mod = $this->input->post('cod_modulo');

		$confirmacion = $this->Model_modulo->EditarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos,$cod_equipo,$cod_mod);

		$datos_vista = array('nombre_modulos' => $this->Model_modulo->listaNombreModulos(),'mensaje_confirmacion'=>$confirmacion);

	 
		$subMenuLateralAbierto = "editarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

    }

	/**
	* Carga las barras y menus especificos para la vista borrar modulos como también envía  cierta información para el funcionamiento de ésta
	*
	* envía a la vista un mensaje que indica que se carga por primera vez, luego carga los menus y barras necesarias para su funcionamiento.
	*
	*/
    public function borrarModulos()
    {
		
		$datos_vista = array('mensaje_confirmacion'=>2);
     
		$subMenuLateralAbierto = "borrarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_borrar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		

    }
	/**
	* Recibe el código del modulo desde la vista para eliminarlo
	*
	* Se carga el modelo de modulos donde se encuentra la función para eliminar
	* Se capturan el código enviado por post desde la vista  
	* Se le da el valor a la función y lo que retorna se guarda en confirmación
	* esto se le envía a la vista para dar feedback al usuario
	* finalmente se carga toda la vista nuevamente como en borrarModulos
	*
	*/
	public function hacerBorrarModulos()
    {
		
		$this->load->model("Model_modulo");
		$cod_modulo_eliminar = $this->input->post('cod_modulo_eliminar');
		$confirmacion = $this->Model_modulo->EliminarModulo($cod_modulo_eliminar);
	
		$datos_vista = array('mensaje_confirmacion'=>$confirmacion);
     
		$subMenuLateralAbierto = "borrarModulos"; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Planificacion", 'cuerpo_modulos_borrar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		

    }

	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los múdulos
	*
	*/
	public function verModulosEditar(){
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');

		$resultado = $this->Model_modulo->getAllModulos();
		echo json_encode($resultado);
	} 

	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos las sesiones 
	*
	*/
	public function obtenerSesionesEditar() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');

		$resultado = $this->Model_modulo->listaSesionesParaEditarModulo();
		echo json_encode($resultado);
	}
	
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todas las sesiones que corresponden a un cierto módulo
	*
	*/
	public function obtenerSesionesVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
		$resultado = $this->Model_modulo->listaSesionesParaVerModulo($cod_mod);
		echo json_encode($resultado);
	}
	
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los profesores que no tienen equipo o que pertenecen a un equipo en particular (cod_equipo)
	*
	*/
	public function obtenerProfes() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;$this->db->where('name', $name); 
		}
		$cod_equipo = $this->input->post('cod_equipo_post');
		$this->load->model('Model_modulo');
		$resultado = $this->Model_modulo->profesEditarModulo($cod_equipo);
		echo json_encode($resultado);
	}
	
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los profesores que pertenecen a un equipo en particular
	*
	*/
	public function obtenerProfesVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$cod_equipo = $this->input->post('cod_equipo_post');
		$this->load->model('Model_modulo');
		$resultado = $this->Model_modulo->listaProfesoresVerModulo($cod_equipo);
		echo json_encode($resultado);
	}
	
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los requisitos e diferenciando si estos están asociados a un módulo en particular
	*
	*/
	public function obtenerRequisitos() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
	
		$resultado = $this->Model_modulo->listaRequisitosParaEditarModulo($cod_mod);
		echo json_encode($resultado);
	}
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los requisitos asociados a un módulo en particular
	*
	*/
	public function obtenerRequisitosVer() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_modulo');
		$cod_mod = $this->input->post('cod_mod_post');
	
		$resultado = $this->Model_modulo->listaRequisitosVerModulo($cod_mod);
		echo json_encode($resultado);
	}
	

}

/* End of file Modulos.php */
/* Location: ./application/controllers/Modulos.php */