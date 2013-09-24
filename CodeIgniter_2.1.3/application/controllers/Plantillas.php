<?php

/**
 * El presente archivo corresponde al controlador asociado a la gestión de las plantillas del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Controladores
 * @author Diego García (DGM)
**/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'controllers/Master.php';

/**
 * Esta clase implementa los métodos que permiten la gestión de las plantillas en el sistema Manteka.
 *
 * @package Manteka
 * @subpackage Controladores
 * @author Diego García (DGM)
 **/
class Plantillas extends MasterManteka {

	/**
    * Muestra la vista para agregar plantillas, valida el formulario para la creación de plantillas y a través del modelo
	* respectivo, agrega plantillas al sistema.
    * 
    * Si el formulario para la creación de plantillas no ha sido enviado, sólo se muestra la vista para agregar plantillas.
	* En caso contrario primero se valida el formulario y si la validación es correcta se envian los datos al modelo para
	* crear la plantilla. Luego independientemente del resultado de la validación, se muestra la vista para agregar plantillas
    * indicando el resultado de las operaciones efectuadas.	
	*
    * @author Diego García (DGM)
	* @param int | array $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista,
	*   					  según el resultado de las validaciones y de las operaciones efectuadas por el controlador.
	*   					  También se utiliza para devolver a la vista los valores del formulario enviado, cuando
	*   					  la validación del formulario no es exitosa.
	*						  Si el formulario de la vista para agregar plantillas no ha sido enviado, entonces este parámetro
	*						  toma su valor por defecto que es null.
    **/
	public function agregarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_COORDINADOR);
			$subMenuLateralAbierto = 'agregarPlantilla';
			$muestraBarraProgreso = FALSE;
			$this->cargarTodo("Correos", "cuerpo_plantillas_agregar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function postAgregarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/* Si la validación es exitosa, se crea la plantilla en la base de datos a través del modelo de plantillas. */
			$nombre = $this->input->post("txtNombrePlantilla");
			$asunto = $this->input->post("txtAsunto");
			$cuerpo = $this->input->post("editor");
			$this->load->model('Model_plantilla');
			$rut_usuario = $this->session->userdata('rut');
			$resultado=$this->Model_plantilla->agregarPlantilla($rut_usuario, $nombre, $asunto, $cuerpo);

			if ($resultado == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha agregar la plantilla con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Plantillas/agregarPlantilla"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Agregar plantilla"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function editarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			/* Se muestra la vista para editar (actualizar) plantillas en el sistema. */
			$this->load->model('Model_plantilla');
			$datos_cuerpo = array();
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$subMenuLateralAbierto = 'editarPlantilla';
			$muestraBarraProgreso = FALSE;
			$this->cargarTodo("Correos", "cuerpo_plantillas_editar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
	}


   /**
    * Muestra la vista para editar plantillas, valida el formulario para la edición de plantillas y a través del modelo
	* respectivo, actualiza las plantillas en la base de datos.
    * 
    * Si el formulario para la actualización de plantillas no ha sido enviado, sólo se muestra la vista para actualizar plantillas.
	* En caso contrario primero se valida el formulario y si la validación es correcta se envian los datos al modelo para
	* actualizar la plantilla. Luego independientemente del resultado de la validación, se muestra la vista para actualizar plantillas
    * indicando el resultado de las operaciones efectuadas.	
	*
    * @author Diego García (DGM)
	* @param int | array $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista,
	*   					  según el resultado de las validaciones y de las operaciones efectuadas por el controlador.
	*   					  También se utiliza para devolver a la vista los valores del formulario enviado, cuando
	*   					  la validación del formulario no es exitosa.
	*						  Si el formulario de la vista para editar plantillas no ha sido enviado, entonces este parámetro
	*						  toma su valor por defecto que es null.
    **/
	public function postEditarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/* Si la validación del formulario es exitosa, se intenta actualizar la plantilla en la base de datos. */
			$this->load->model('Model_plantilla');
			$id_plantilla = $this->input->post('id_plantilla');
			$nombrePlantilla = $this->input->post('txtNombrePlantilla');
			$asunto = $this->input->post('txtAsunto');
			$cuerpo = $this->input->post('editor');
			$rut_usuario = $this->session->userdata('rut');
			$resultado = $this->Model_plantilla->editarPlantilla($rut_usuario, $id_plantilla, $nombrePlantilla, $asunto, $cuerpo);
			if ($resultado == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha editado la plantilla con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Plantillas/editarPlantilla"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Editar plantilla"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


   /**
    * Muestra la vista para eliminar plantillas y envía la clave primaria de una plantilla al modelo, para eliminarla cuando ha
	* sido seleccionada en la vista de eliminación de plantillas.
    * 
    * Si no se ha enviado una plantilla para su eliminación, solamente se muestra la vista la para la eliminación de plantillas.
	* En caso contrario se intenta la eliminación de la plantilla y luego se muestra la vista de elimianación de plantillas
	* indicando el resultado obtenido.
	*
    * @author Diego García (DGM)
	* @param int $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista.
    **/
	public function eliminarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$this->load->model('Model_plantilla');
			$datos_cuerpo = array();
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$subMenuLateralAbierto = 'eliminarPlantilla';
			$muestraBarraProgreso = FALSE;
			$this->cargarTodo("Correos", "cuerpo_plantillas_eliminar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
		}
	}

	public function postEliminarPlantilla() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/* Si la validación del formulario es exitosa, se intenta actualizar la plantilla en la base de datos. */
			$this->load->model('Model_plantilla');
			$id_plantilla = $this->input->post('idPlantilla');
			$rut_usuario = $this->session->userdata('rut');
			$resultado = $this->Model_plantilla->eliminarPlantilla($rut_usuario, $id_plantilla);
			if ($resultado == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha editado la plantilla con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Plantillas/editarPlantilla"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Editar plantilla"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	/**
	* Se buscan plantillas de forma asincrona para mostrarlos en la vista
	*
	**/
	public function getPlantillasAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		$rut_usuario = $this->session->userdata('rut');
		$this->load->model('Model_plantilla');
		$resultado = $this->Model_plantilla->getPlantillasByFilter($rut_usuario, $textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'plantillas', $this->session->userdata('rut'));
			
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'plantillas', $this->session->userdata('rut'));
			}
			
		}
		echo json_encode($resultado);
	}

	/**
	* Método que responde a una solicitud de post para pedir los datos de un módulo temático
	* Recibe como parámetro el código del módulo temático
	*/
	public function getDetallesPlantillaAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$id_plantilla = $this->input->post('id_plantilla_post');
		$rut_usuario = $this->session->userdata('rut');
		$this->load->model('Model_plantilla');
		$resultado = $this->Model_plantilla->getDetallesPlantilla($rut_usuario, $id_plantilla);
		echo json_encode($resultado);
	}
}