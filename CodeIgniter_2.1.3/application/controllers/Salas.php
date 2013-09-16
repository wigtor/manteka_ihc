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
	public function verSalas() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$datos_vista = array();
		$subMenuLateralAbierto = "verSalas"; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$this->cargarTodo("Salas", 'cuerpo_salas_ver', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	/**
	* Es la vista que se muestra para agregar una sala.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se carga el modelo de sala, para poder ver todos los implementos que una sala puede tener.
	* Finalmente se cargan todos los datos.
	*
	*/
	public function agregarSala() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_vista = array();
			$this->load->model('Model_sala');
			$datos_vista['implemento'] = $this->Model_sala->getAllImplementos();

			$subMenuLateralAbierto = "agregarSala"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Salas", 'cuerpo_salas_agregar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
    }
	
	/**
	* Agregar una sala del sistema y mostrar si se realizó con éxito o no.
	* Primero se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función InsertarSala para insertar la sala
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* Si confirmación es 1 la acción se realizó y se muestra en una vista que la acción se realizó con
	* Éxito, si no un mensaje con el error, en ambos casos se muestra un enlace para volver a agregar salas.
	*
	*/
	public function postAgregarSala() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sala');
			$num_sala = $this->input->post("num_sala");
			$ubicacion = $this->input->post("ubicacion");
			$capacidad = $this->input->post("capacidad");
			$implementos = $this->input->post("cod_implemento");
			$confirmacion = $this->Model_sala->agregarSala($num_sala, $ubicacion, $capacidad, $implementos);

			if ($confirmacion == TRUE){
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
			$datos_plantilla["redirecTo"] = "Salas/agregarSala"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Agregar Sala"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}
    

	/**
	* Es la vista que se muestra para editar una sala.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se carga el modelo de sala, para poder ver todos los implementos que una sala tiene y estos se
	* Mostrarán marcados, y los implementos que la sala podría tener, los que se mostrarán sin marcar.
	* Finalmente se cargan todos los datos.
	*
	*/
    public function editarSala() {
    	if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
	    	$datos_vista = array();
	    	$this->load->model('Model_sala');
	    	$datos_vista['implementos'] = $this->Model_sala->getAllImplementos();

			$subMenuLateralAbierto = "editarSala"; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Salas", 'cuerpo_salas_editar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
    }
	
	/**
	* Modificar una sala del sistema y mostrar si se realizó con éxito o no.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función AtualizarSala para insertar la sala
	* con los datos que se capturan un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* Si confirmación es 1 la acción se realizó y se muestra en una vista que la acción se realizó con
	* Éxito, si no un mensaje con el error, en ambos casos se muestra un enlace para volver a editar salas.
	*
	*/
	public function postEditarSala() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sala');
			$cod_sala = $this->input->post("codEditar");
			$cod_salaF=$this->input->post("cod_sala");
			$num_sala = $this->input->post("num_sala");
			$ubicacion = $this->input->post("ubicacion");
			$capacidad = $this->input->post("capacidad");
			$implementos = $this->input->post("implementos");
			$confirmacion = $this->Model_sala->actualizarSala($cod_salaF, $num_sala, $ubicacion, $capacidad, $implementos);  

			// se muestra mensaje de operación realizada
			if ($confirmacion == TRUE){
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
			$datos_plantilla["redirecTo"] = "Salas/editarSala"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Editar Sala"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}

	/**
	* Es la vista que se muestra para borrar una sala.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se carga el modelo de sala, para poder ver todos los implementos que una sala tiene y estos se
	* Mostrarán marcados.Además para cargar los nombres de todas las salas exitentes.
	* Finalmente se cargan todos los datos.
	*/
	 public function eliminarSala() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			// se carga el modelo, los datos de la vista, las funciones a utilizar del modelo
			$datos_vista = array();		
			$subMenuLateralAbierto = "eliminarSala"; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarTodo("Salas", 'cuerpo_salas_eliminar', "barra_lateral_salas", $datos_vista, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
    }
	
	/**
	* Borrar una sala del sistema y mostrar si se realizó con éxito o no.
	* Primero se cargan los datos para las plantillas de la página.
	* Se carga el modelo de salas, se llama a la función EliminarSala para insertar la sala
	* con el código de sala capturado un paso antes en el controlador desde la vista con el uso del POST.
	* El resultado de ésta se recibe en la variable 'confirmacion'
	* Si confirmación es 1 la acción se realizó y se muestra en una vista que la acción se realizó con
	* Éxito, si no un mensaje con el error, en ambos casos se muestra un enlace para volver a borrar salas.
	*
	*/
	public function postEliminarSala() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_sala');
			$idSalaEliminar = $this->input->post("idSalaEliminar");
			$confirmacion = $this->Model_sala->eliminarSala($idSalaEliminar);
			
			if ($confirmacion == TRUE){
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
			$datos_plantilla["redirecTo"] = "Salas/eliminarSala"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["nombre_redirecTo"] = "Borrar Sala"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


    /**
	* Obtener los datos de las salas que coincidan con la búsqueda del filtro seleccionado.
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le 
	* Redirecciona al login. Siguiente a esto se capturan los tipos de filtros seleccionados, luego
	* Se carga el model de sala, se carga el modelo de búsquedas, se realiza una nueva búsqueda dado
	* el filtro básico, y una por cada filtro avanzado seleccionado. 
	* Finalmente se retorna el resultado de la búsqueda, dados los filtros seleccionados.
	* @return json Resultado de la busqueda en forma de objeto json
	*
	*/
    public function getSalasAjax() {
    	if (!$this->input->is_ajax_request()) {
			return;
		}
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
			$this->load->model('Model_busqueda');
			//Se debe insertar sólo si se encontraron resultados
			$this->Model_busqueda->insertarNuevaBusqueda($textoFiltro, 'salas', $this->session->userdata('rut'));
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->Model_busqueda->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'salas', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);

    }


	/**
	* Obtener el detalle de una sala determinada
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le 
	* Redirecciona al login. Siguiente a esto se carga el model de sala, se captura el numero de 
	* Sala a ya que el numero de sala es único en el sistema es equivalente a capturar el codigo.
	* Finalmente se llama a la función getDetallesSala del modelo, que retorna el detalle de la sala.
	* @return json Resultado de la busqueda en forma de objeto json
	*
	*/
    public function getDetallesSalaAjax(){
    	if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$num_sala = $this->input->post('num_sala');
		$this->load->model('Model_sala');
		$resultado = $this->Model_sala->getDetallesSala($num_sala);
		echo json_encode($resultado);
    }


	/**
	* Comprobar que el número de sala a ingresar no se encuentra en el sistema
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se 
	* Le redirecciona al login, siguiente a esto se carga el model de salas, se captura el numero 
	* De sala a ingresar.F inalmente se llama a la función numSala del modelo, que retorna 1 si el
	* Numero de sala Existe en el sistema, y 0 en caso contrario.
	* @return json Resultado de la busqueda en forma de objeto json
	*
	*/
	public function numSalaExisteAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$this->load->model('Model_sala');
		$num = $this->input->post('num_post');

		$resultado = $this->Model_sala->numSala($num);
		echo json_encode($resultado);
	}


	/**
	* Comprobar que el número de sala a que se está editando no pertenezca a otra sala del sistema
	* Primero se comprueba que el usuario tenga la sesión iniciada, en caso que no sea así se le redirecciona al login
	* Siguiente a esto se carga el model de salas, se captura el numero de sala a ingresar y el código
	* De la sala, para que cuando se haga la consulta de si existe una sala con el número consultado
	* Se descarte la misma sala, y aquello se logra con el código.
	* Finalmente se llama a la función numSala del modelo, que retorna 1 si el numero de sala
	* Existe en el sistema, y 0 en caso contrario.
	* @return json Resultado de la busqueda en forma de objeto json
	*
	*/
	public function numSalaExisteElimAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
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

/* End of file Salas.php */
/* Location: ./application/controllers/Salas.php */