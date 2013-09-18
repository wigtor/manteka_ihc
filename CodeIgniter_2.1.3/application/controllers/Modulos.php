<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Modulos extends MasterManteka {
	
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
	public function verModulos() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$subMenuLateralAbierto = "verModulos"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Planificacion", 'cuerpo_modulos_ver', "barra_lateral_planificacion", "", $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
		}
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
    public function agregarModulo() {
    	if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model("Model_modulo_tematico");
			$datos_vista = array();

			$datos_vista['posiblesProfesoresLider'] = $this->Model_modulo_tematico->getAllProfesoresWhitoutEquipo();
			$datos_vista['posiblesProfesoresEquipo'] = $this->Model_modulo_tematico->getAllProfesoresWhitoutEquipo();
			$datos_vista['requisitosModulo'] = $this->Model_modulo_tematico->getAllRequisitos();

	 		$subMenuLateralAbierto = "agregarModulo"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_modulos_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postAgregarModulo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_modulo_tematico");

			
			$nombre = $this->input->post('nombre');
			$descripcion = $this->input->post('descripcion');
			$profesor_lider = $this->input->post('id_profesorLider');
			$equipo_profesores = $this->input->post('id_profesoresEquipo');
			$requisitos = $this->input->post('id_requisitos');
			
			$confirmacion = $this->Model_modulo_tematico->agregarModulo($nombre, $descripcion, $profesor_lider, $equipo_profesores, $requisitos);

			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el módulo con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Modulos/agregarModulo"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Agregar módulo"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}
	
	
	/**
	* Carga las barras y menus especificos para la vista edittar modulos como también envía  cierta información para el funcionamiento de ésta
	*
	* Carga el modelo de modulos para solicitar los nombres de modulos para que no se edite a uno ya en uso y se envía un mensaje de que la vista
	* recién se está cargando por primera vez. Luego se cargan los menus y barras lateras para cargar la vista.
	*
	*/
    public function editarModulo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model("Model_modulo_tematico");
			$datos_vista = array();

			$datos_vista['posiblesProfesoresLider'] = $this->Model_modulo_tematico->getAllProfesoresForLider();
			$datos_vista['posiblesProfesoresEquipo'] = $this->Model_modulo_tematico->getAllProfesoresForEquipo();
			$datos_vista['requisitosModulo'] = $this->Model_modulo_tematico->getAllRequisitos();

			$subMenuLateralAbierto = "editarModulo"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_modulos_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postEditarModulo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_modulo_tematico");

			
			$nombre = $this->input->post('nombre');
			$descripcion = $this->input->post('descripcion');
			$profesor_lider = $this->input->post('id_profesorLider');
			$equipo_profesores = $this->input->post('id_profesoresEquipo');
			$requisitos = $this->input->post('id_requisitos');

			$id_equipo = $this->input->post('id_equipo');
			$id_modulo = $this->input->post('id_modulo');

			$confirmacion = $this->Model_modulo_tematico->actualizarModulo($nombre, $descripcion, $profesor_lider, $equipo_profesores ,$requisitos, $id_equipo,$id_modulo);
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha editado el módulo con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Modulos/editarModulo"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Editar módulo"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
    }

	/**
	* Carga las barras y menus especificos para la vista borrar modulos como también envía  cierta información para el funcionamiento de ésta
	*
	* envía a la vista un mensaje que indica que se carga por primera vez, luego carga los menus y barras necesarias para su funcionamiento.
	*
	*/
    public function eliminarModulo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();

			$subMenuLateralAbierto = "eliminarModulo"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_modulos_eliminar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
		}
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
	public function postEliminarModulo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_modulo_tematico");
			$id_modulo_eliminar = $this->input->post('id_moduloEliminar');
			$confirmacion = $this->Model_modulo_tematico->eliminarModulo($id_modulo_eliminar);

			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha eliminado el módulo con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la eliminación con la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Modulos/eliminarModulo"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Eliminar módulo"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
    }


	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los múdulos
	*
	*/
	public function getAllModulosTematicosAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo_tematico');

		$resultado = $this->Model_modulo_tematico->getAllModulos();
		echo json_encode($resultado);
	} 


	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos las sesiones 
	*
	*/
	public function getAllSesionesAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo_tematico');

		$resultado = $this->Model_modulo_tematico->getAllSesiones();
		echo json_encode($resultado);
	}


	/**
	*
	* Método que responde a una solicitud de post enviando la información de todas las sesiones que corresponden a un cierto módulo
	*
	*/
	public function getSesionesByModuloTematicoAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_modulo_tematico');
		$id_mod = $this->input->post('id_mod_post');
		echo 'caca';
		return;
		$resultado = $this->Model_modulo_tematico->getSesionesByModuloTematico($id_mod);
		echo json_encode($resultado);
	}


	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los profesores que no tienen equipo o que pertenecen a un equipo en particular (cod_equipo)
	*
	*/
	public function obtenerProfes() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;$this->db->where('name', $name); 
		}
		$cod_equipo = $this->input->post('cod_equipo_post');
		$this->load->model('Model_modulo_tematico');
		$resultado = $this->Model_modulo_tematico->profesEditarModulo($cod_equipo);
		echo json_encode($resultado);
	}
	
	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los profesores que pertenecen a un equipo en particular
	*
	*/
	public function getProfesoresByModuloTematicoAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$id_mod = $this->input->post('id_mod_post');
		$this->load->model('Model_modulo_tematico');
		$resultado = $this->Model_modulo_tematico->getProfesoresByModuloTematico($id_mod);
		echo json_encode($resultado);
	}

	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los requisitos asociados a un módulo en particular
	*
	*/
	public function getRequisitosByModuloTematicoAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_modulo_tematico');
		$id_mod = $this->input->post('id_mod_post');
	
		$resultado = $this->Model_modulo_tematico->getRequisitosByModulo($id_mod);
		echo json_encode($resultado);
	}


	/**
	* Se buscan módulos de forma asincrona para mostrarlos en la vista
	*
	**/
	public function getModulosTematicosAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_modulo_tematico');
		$resultado = $this->Model_modulo_tematico->getModulosByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'modulos', $this->session->userdata('rut'));
			
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'modulos', $this->session->userdata('rut'));
			}
			
		}
		echo json_encode($resultado);
	}

	/**
	* Método que responde a una solicitud de post para pedir los datos de un módulo temático
	* Recibe como parámetro el código del módulo temático
	*/
	public function getDetallesModuloTematicoAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$cod = $this->input->post('cod_modulo');
		$this->load->model('Model_modulo_tematico');
		$resultado = $this->Model_modulo_tematico->getDetallesModulo($cod);
		echo json_encode($resultado);
	}

}

/* End of file Modulos.php */
/* Location: ./application/controllers/Modulos.php */