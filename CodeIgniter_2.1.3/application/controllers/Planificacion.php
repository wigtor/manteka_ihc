<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class Planificacion extends MasterManteka {
	
	public function index() {
		$this->verPlanificacion();
	}


	public function verPlanificacion() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "verPlanificacion"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->load->model('model_planificacion');
			$datos_vista = array('lista' => $this->model_planificacion->selectPlanificacion());
			$this->cargarTodo("Planificacion", 'cuerpo_planificacion', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function agregarPlanificacion() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$subMenuLateralAbierto = "agregarPlanificacion"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->load->model('Model_seccion');
			$datos_vista['listadoSecciones'] = $this->Model_seccion->getAllSecciones();
			$this->load->model('Model_modulo_tematico');
			$datos_vista['listadoModulosTematicos'] = $this->Model_modulo_tematico->getAllModulos();
			$this->load->model('Model_sala');
			$datos_vista['listadoSalas'] = $this->Model_sala->getAllSalas();
			$this->load->model('Model_planificacion');
			$datos_vista['listadoDias'] = $this->Model_planificacion->getAllDias();;
			$datos_vista['listadoBloquesHorario'] = $this->Model_planificacion->getAllBloquesHorarios();

			$this->cargarTodo("Planificacion", 'cuerpo_planificacion_agregar', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	/**
	* Recibe los datos de la vista para hacer la asignación de secciones
	*
	* Se carga el modelo de secciones, donde se encuentra la función que realiza la asignación
	* Se capturan las variables enviadas por POST desde la vista
	* Se le dan los valores a la función y lo que retorna se guarda en confirmación
	* esto se le envía a la vista para dar feedback al usuario
	* Finalmente se carga toda la vista nuevamente en asignarAsecciones
	*
	**/
	public function postAgregarPlanificacion() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_planificacion');

			$seccion = $this->input->post('seccion');
			$moduloTematico = $this->input->post('moduloTematico'); //No se usa
			$sesion = $this->input->post('sesion');
			$profesor = $this->input->post('profesor');
			$sala = $this->input->post('sala');
			$dia = $this->input->post('dia');
			$bloque = $this->input->post('bloque');
			$fecha_planificada = $this->input->post('fecha_planificada');

			$confirmacion = $this->Model_planificacion->agregarPlanificacion($seccion, $sesion, $profesor, $sala, $dia, $bloque, $fecha_planificada);

	        if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha creado la planificación con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error en la planificación de la sección";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}

			$datos_plantilla["redirectAuto"] = TRUE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Planificacion/agregarPlanificacion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Agregar planificación"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
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

	public function eliminarPlanificacion() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$subMenuLateralAbierto = "eliminarPlanificacion"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);

			$datos_vista = array();
			//$datos_vista['seccion'] = $this->Model_seccion->VerSeccionesAsignadas();
			$this->cargarTodo("Planificacion", 'cuerpo_secciones_eliminarAsignacion', "barra_lateral_planificacion", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function postEliminarAsignacion() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_Planificacion');
			$id_planificacion = $this->input->post('id_planificacion');

			$confirmacion = $this->Model_Planificacion->eliminarPlanificacion($id_planificacion);

			if ($confirmacion == TRUE){
				// mostramos el mensaje de operacion realizada
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha eliminado la asignación de la sección";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrido un error con la eliminación en base de datos";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			
			
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Planificacion/eliminarPlanificacion"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Eliminar Asignación"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function getSesionesByModuloTematico() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$id_moduloTematico = $this->input->post('id_moduloTematico');
		$this->load->model('Model_sesion');
		$resultado = $this->Model_sesion->getSesionesByModuloTematico($id_moduloTematico);
		echo json_encode($resultado);
	}

	public function getProfesoresByModuloTematico() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$id_moduloTematico = $this->input->post('id_moduloTematico');
		$this->load->model('Model_profesor');
		$resultado = $this->Model_profesor->getProfesoresByModuloTematico($id_moduloTematico);
		echo json_encode($resultado);
	}
}

