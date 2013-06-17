<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class Otros extends MasterManteka {
	
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
	* Función que se llama cuando se intenta entrar a una dirección que no existe.
	* 
	* Se muestra un mensaje de error indicando que la dirección introducida o que se ha intentado
	* de entrar no existe.
	*/
	public function notFound()
	{
		$datos_cuerpo = array();

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = ''; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("", "cuerpo_not_found", "", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}


	/**
	* Función que se llama cuando existe un error en la base de datos.
	* 
	* Se muestra un mensaje de error indicando que existe un error en la base de datos y se indica que se informe 
	* al administrador del sistema, si se está logueado se muestra la vista con los menu superiores correspondientes.
	* Si se está deslogueado se muestra el error sin menu superiores, ni barras.
	*/
	public function databaseError()
	{
		$datos_plantilla["titulo_msj"] = "Error en la base de datos";
		$datos_plantilla["cuerpo_msj"] = "Existe un problema para utilizar la base de datos, vuelva a intentar utilizar ManteKA más tarde o comuniquese con el administrador para informar del error.";
		$datos_plantilla["tipo_msj"] = "alert-danger";
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = ""; //ninguno abierto
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["barra_lateral"] = ""; //Esta linea también cambia según la vista como la anterior

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			//Caso en que no se está logueado
			$datos_plantilla["barra_usuario"] = "";
			$datos_plantilla["menu_superior"] = "";
			$datos_plantilla["barra_navegacion"] = "";
			$datos_plantilla["barra_progreso_atras_siguiente"] = "";
			
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Login/"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "inicio se sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$this->load->view('templates/big_msj_deslogueado', $datos_plantilla); //Esta es la linea que cambia por cada controlador

		}
		else {
			$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
			$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
			$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = ""; //No muestro los botones atrás siguiente
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Login/logout"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "inicio se sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
			$this->load->view('templates/template_general', $datos_plantilla);
		}
		
	}
	public function sendMailError()
	{
		$datos_plantilla["titulo_msj"] = "Error en la conexión";
		$datos_plantilla["cuerpo_msj"] = "No se pudo enviar el correo deseado, revise su conexión a internet o vuleva a intentarlo mas tarde.";
		$datos_plantilla["tipo_msj"] = "alert-danger";
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = ""; //ninguno abierto
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["barra_lateral"] = ""; //Esta linea también cambia según la vista como la anterior

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			//Caso en que no se está logueado
			$datos_plantilla["barra_usuario"] = "";
			$datos_plantilla["menu_superior"] = "";
			$datos_plantilla["barra_navegacion"] = "";
			$datos_plantilla["barra_progreso_atras_siguiente"] = "";
			
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Login/"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "inicio se sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$this->load->view('templates/big_msj_deslogueado', $datos_plantilla); //Esta es la linea que cambia por cada controlador

		}
		else {
			$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
			$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
			$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = ""; //No muestro los botones atrás siguiente
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Correo/correosRecibidos"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			$datos_plantilla["redirecFrom"] = "Correo/enviarCorreo"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "inbox"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
			$this->load->view('templates/template_general', $datos_plantilla);
		}
		
	}	

	/**
	* La función por defecto al ejecutar este controlador es el error de PageNotFound
	*/
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->notFound();
	}
}

/* End of file Otros.php */
/* Location: ./application/controllers/Otros.php */