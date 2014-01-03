<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class ActividadesMasivas extends MasterManteka {
	
	public function index() {
		//funcion por defecto
		$this->verActividades();
	}

	
	public function verActividades() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$subMenuLateralAbierto = "verActividades"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Planificacion", 'cuerpo_actividades_ver', "barra_lateral_planificacion", "", $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
		}
	}
    

    public function agregarActividad() {
    	if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model("Model_actividades_masivas");
			$datos_vista = array();

	 		$subMenuLateralAbierto = "agregarActividad"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_actividades_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
    }



	public function postAgregarActividad() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_actividades_masivas");

			
			$nombre = $this->input->post('nombre');
			$listaInstanciasActividades = $this->input->post('listaInstanciasActividades');
			if ($listaInstanciasActividades == FALSE) {
				$listaInstanciasActividades = array();
			}
			$listaInstancias = array(); //Como objetos
			foreach($listaInstanciasActividades as $instancia) {
				$obj = json_decode($instancia);
				$listaInstancias[] = $obj;
			}
			echo 'Largo lista: '.count($listaInstancias);
			$confirmacion = $this->Model_actividades_masivas->agregarActividadMasiva($nombre, $listaInstancias);

			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el actividad con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "ActividadesMasivas/agregarActividad"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Agregar actividad"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}
	
	
	
    public function editarActividad() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model("Model_actividades_masivas");
			$datos_vista = array();

			$subMenuLateralAbierto = "editarActividad"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_actividades_editar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
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
	public function postEditarActividad() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_actividades_masivas");

			
			$nombre = $this->input->post('nombre');

			$confirmacion = 1;//$this->Model_actividades_masivas->actualizarModulo($nombre, $descripcion, $profesor_lider, $equipo_profesores ,$implementos, $id_equipo,$id_modulo);
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
    public function eliminarActividad() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();

			$subMenuLateralAbierto = "eliminarActividad"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Planificacion", 'cuerpo_actividades_eliminar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);		
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
	public function postEliminarActividad() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model("Model_actividades_masivas");
			$idEliminar = $this->input->post('idEliminar');
			$confirmacion = $this->Model_actividades_masivas->eliminarActividadMasiva($idEliminar);

			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha eliminado el actividad con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en la eliminación con la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "ActividadesMasivas/eliminarActividad"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Eliminar actividad"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
    }


	/**
	*
	* Método que responde a una solicitud de post enviando la información de todos los múdulos
	*
	*/
	public function getAllActividadesAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$this->load->model('Model_actividades_masivas');

		$resultado = $this->Model_actividades_masivas->getAllActividades();
		echo json_encode($resultado);
	}

	/**
	* Se buscan módulos de forma asincrona para mostrarlos en la vista
	*
	**/
	public function getActividadesAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		
		$this->load->model('Model_actividades_masivas');
		$resultado = $this->Model_actividades_masivas->getActividadesByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'actividades', $this->session->userdata('rut'));
			
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'actividades', $this->session->userdata('rut'));
			}
			
		}
		echo json_encode($resultado);
	}

	/**
	* Método que responde a una solicitud de post para pedir los datos de un módulo temático
	* Recibe como parámetro el código del módulo temático
	*/
	public function getInstanciasActividadMasivaAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$id = $this->input->post('id_actividad');
		$this->load->model('Model_actividades_masivas');
		$resultado = $this->Model_actividades_masivas->getInstanciasActividadMasiva($id);
		echo json_encode($resultado);
	}

}

/* End of file Modulos.php */
/* Location: ./application/controllers/Modulos.php */