<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
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
	
	
	/******************************************************************************************************************************
	* Funciones de tipo GET
	* Acá se ponen las funciones que cargan vistas a través del método GET, sólo muestran vistas.
	******************************************************************************************************************************/

	/**
	* Función principal del controlador User, es llamado para mostrar la vista de gestión
	* de la cuenta de usuario
	*/
	public function index($mensajes_alert = array())
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
	    if ($rut == FALSE) {
	      redirect('/Login/', 'index');         // En dicho caso, se redirige a la interfaz principal
	    }
	    
	    $datos_plantilla["rut_usuario"] = $rut_user = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";

		
		$this->load->model('model_usuario');

		if ($datos = $this->model_usuario->datos_usuario($rut_user))
		{
			$newdata = array(
					'rut'  => $datos->RUT_USUARIO,
					'email1'	=>	$datos->CORREO1_USER,
					'email2'	=>	$datos->CORREO2_USER,
					'tipo_usuario' => $datos->ID_TIPO,
					'nombre1'	=>	$datos->NOMBRE1,
					'nombre2'	=>	$datos->NOMBRE2,
					'nombre'	=>  $datos->NOMBRE1." ".$datos->NOMBRE2,
					'apellido1'	=>	$datos->APELLIDO1,
					'apellido2'	=>	$datos->APELLIDO2,
					'apellido'  =>  $datos->APELLIDO1." ".$datos->APELLIDO2,
					'telefono'	=>	$datos->TELEFONO,
					'logged_in' => TRUE
              	);
		}
		else{

		}

		$datos_plantilla["datos"] = $newdata;
		
		/* Esta parte hace que se muestren los mensajes de error, warnings, etc */
		if (count($mensajes_alert) > 0) {
			$datos_plantilla["mensaje_alert"] = $this->load->view('templates/mensajes/mensajeError', $mensajes_alert, true);
		}

		// Cargando y armando la página
		$datos_plantilla["menuSuperiorAbierto"] = ""; //Ningún botón está presionado
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_cambio_contrasegna', '', true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = ""; //$this->load->view('templates/barras_laterales/barra_lateral_planificacion', '', true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */