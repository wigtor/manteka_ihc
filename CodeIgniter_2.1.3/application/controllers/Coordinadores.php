<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

/**
* Clase coordinadores del proyecto manteka.
*
* En esta clase se detallan los controladores necesarios para las operaciones crud de la tabla coordinadores.
*
* @package    Manteka
* @subpackage Controllers
* @author     Grupo 2 IHC 1-2013 Usach
*/
class Coordinadores extends MasterManteka {
	
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
	 
	  /**
      * Función de Inicio de Controlador.
      *
	  * Función en la cual el navegador va a redirigir la página principal de los coordinadores
	  * a la vista verCoordinadores	  
      * @param none.      
      * @return none
      */
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verCoordinadores();
	}

	
	 /**
      * Función que muestra los coordinadores del sistema.
      *
	  * Se muestra en pantalla todos los coordinadores con sus datos correspondientes,
	  * además se cargan todas las plantillas para el sitio.
      * @param none.      
      * @return none
      */
	public function verCoordinadores()
	{
		$datos_plantilla = array();
		$subMenuLateralAbierto = 'verCoordinadores'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Docentes", "cuerpo_coordinadores_ver", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

	}
    
	/**
      * Función en la que se ingresa un Coordinador al sistema.
      *
	  * Se cargan las plantillas correspondientes al sitio, y en el cuerpo un formulario en el cual 
	  * se deben ingresar todos los datos del Coordinador que se desea agregar.
      * @param none.      
      * @return none
      */
    public function agregarCoordinadores()
    {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('model_coordinadores');
			$rut = $this->input->post('rutEditar');
			$nombre1 = $this->input->post('nombre1');
			$nombre2 = $this->input->post('nombre2');
			$apellido1 = $this->input->post('apellido1');
			$apellido2 = $this->input->post('apellido2');
			$correo1 = $this->input->post('correo1');
			$correo2 = $this->input->post('correo2');
			$fono = $this->input->post('fono');

			$this->model_coordinadores->agregarCoordinador($rut, $nombre1 , $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono);

			$datos_plantilla["titulo_msj"] = "Coordinador agregado";
			$datos_plantilla["cuerpo_msj"] = "El nuevo coordinador fue agregado correctamente.";
			$datos_plantilla["tipo_msj"] = "alert-success";
			$datos_plantilla["redirecTo"] = 'Coordinadores/agregarCoordinadores';
			$datos_plantilla["nombre_redirecTo"] = "Agregar Coordinador";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);

		}
		else {
			
			$datos_cuerpo = array(); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
			//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

			/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
			* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
			*/
			$subMenuLateralAbierto = 'agregarCoordinadores'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_crear", "barra_lateral_profesores", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	
		}
    }
	
	
    /**
      * Función que edita un Coordinador.
      *
	  * Se muestra en pantalla todos los coordinadores con sus datos correspondientes,se escoge uno y
	  * se realiza la edición de los datos antiguos que se tenían del coordinador, los datos modificados son
	  * enviados al modelo para actualizar los datos en la base de datos
	  * 
      * @param none.      
      * @return none
      */
    public function editarCoordinadores()
    {
    	//SE DEBE COMPROBAR RUT ANTES O HAY UN PROBLEMA DE SEGURIDAD

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('model_coordinadores');
			$resetearPass = $this->input->post('resetContrasegna');
			$rutEditar = $this->input->post('rutEditar');
			$nombre1 = $this->input->post('nombre1');
			$nombre2 = $this->input->post('nombre2');
			$apellido1 = $this->input->post('apellido1');
			$apellido2 = $this->input->post('apellido2');
			$correo1 = $this->input->post('correo1');
			$correo2 = $this->input->post('correo2');
			$fono = $this->input->post('fono');

            //$this->model_coordinadores->modificarCoordinador($nombreActual,$rutActual,$nombreNuevo,$rutNuevo,$correo1Nuevo,$correo2Nuevo,$telefonoNuevo,$idNuevo,$tipoNuevo);
			if($resetearPass){
				$this->model_coordinadores->modificarPassword($rutEditar, $rutEditar);
			}
			$this->model_coordinadores->modificarCoordinador($rutEditar, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono);
			
			$datos_plantilla["titulo_msj"] = "Coordinador editado";
			$datos_plantilla["cuerpo_msj"] = "El coordinador fue editado correctamente.";
			$datos_plantilla["tipo_msj"] = "alert-success";
			$datos_plantilla["redirecTo"] = 'Coordinadores/editarCoordinadores';
			$datos_plantilla["nombre_redirecTo"] = "Editar coordinadores";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			
		}
		else {
			$datos_plantilla = array();
			$subMenuLateralAbierto = 'editarCoordinadores'; //Para este ejemplo, los informes no tienen submenu lateral
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$this->cargarTodo("Docentes", "cuerpo_coordinadores_modificar", "barra_lateral_profesores", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

		}
		
    }
	
	
	/**
      * Función que elimina un Coordinador.
      *
	  * Se muestra en pantalla todos los coordinadores con sus datos correspondientes, se debe escoger
	  * alguno y será eliminado del sistema.
	  *
	  * @param none.      
      * @return none
      */
    public function borrarCoordinadores()
    {
		$this->load->model('model_coordinadores');
		$datos_cuerpo_central['listado_coordinadores'] = $this->model_coordinadores->ObtenerTodosCoordinadores();
		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'borrarCoordinadores'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Docentes", "cuerpo_coordinadores_eliminar", "barra_lateral_profesores", $datos_cuerpo_central, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		return ;
		
    }

    public function postEliminarCoordinador(){
    	$rutEliminar = $this->input->post('rutToDelete');
		$respuesta = '';
		$this->load->model('model_coordinadores');
		$this->model_coordinadores->borrarCoordinadores($rutEliminar);

		$datos_plantilla["titulo_msj"] = "Coordinador eliminados";
		$datos_plantilla["cuerpo_msj"] = "El coordinador fue eliminado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'Coordinadores/borrarCoordinadores';
		$datos_plantilla["nombre_redirecTo"] = "Eliminar coordinador";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); $tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
    }

    /**
	* Método que responde a una solicitud de post para pedir los datos de un estudiante
	* Recibe como parámetro el rut del estudiante
	*/
	public function postDetallesCoordinador() {
		//Se comprueba que quien hace esta petición de ajax esté logueado
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}

		$rut = $this->input->post('rut');
		$this->load->model('model_coordinadores');
		$resultado = $this->model_coordinadores->getDetallesCoordinador($rut);
		echo json_encode($resultado);
	}

	public function postBusquedaCoordinadores() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$textoFiltro = $this->input->post('textoFiltroBasico');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');

		$this->load->model('model_coordinadores');
		$resultado = $this->model_coordinadores->getCoordinadoresByFilter($textoFiltro, $textoFiltrosAvanzados);
		
		/* ACÁ SE ALMACENA LA BÚSQUEDA REALIZADA POR EL USUARIO */
		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'coordinadores', $this->session->userdata('rut'));
			}
		}
		echo json_encode($resultado);
	}

}

/* End of file Coordinadores.php */
/* Location: ./application/controllers/Coordinadores.php */
