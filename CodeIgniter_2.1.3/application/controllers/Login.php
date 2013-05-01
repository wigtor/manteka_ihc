<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	public function index()
	{
		$datos_plantilla["title"] = "ManteKA login";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$this->load->view('login', $datos_plantilla);
		
	}

	public function olvidoPass()
	{
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$this->load->view('olvidoPass', $datos_plantilla);
		
	}

	public function recuperaPassPost() {
		/* Acá va la lógica de enviar un correo, etc */



		/* Finalmente muestro la vista que indica que esto fue realizado correctamente */
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["titulo_msj"] = "Listo";
		$datos_plantilla["cuerpo_msj"] = "Se ha enviado un correo electrónico a su cuenta con su nueva contraseña";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Login/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
	}

	
	/*
		Esta función muestra la vista para cambiar la contraseña, pero lleva un argumento que se setea por defecto 
		en un array vacio, de esta forma cuando el usuario abre esa vista por primera vez el array está vacio
		Cuando la vista es rellamada para mostrarla nuevamente pero con mensajes de error, warnings o success entonces 
		este array contiene el mensaje a ser mostrado (ver más abajo como se llama con el array)
	*/
	public function cambiarContrasegna($mensajes_alert = array())
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";

		/* Esta parte hace que se muestren los mensajes de error, warnings, etc */
		if (count($mensajes_alert) > 0) {
			$datos_plantilla["mensaje_alert"] = $this->load->view('templates/mensajes/mensajeError', $mensajes_alert, true);
		}
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
	
	/*
		Por convención, las funciones que terminan en "Post" corresponden a las funciones que son llamadas cuando se envian datos
		al servidor a través de un formulario.
	*/
	public function cambiarContrasegnaPost() {
	
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		
		$this->form_validation->set_rules('contrasegna_actual', 'Contraseña actual', "required|xss_clean|callback_check_user_and_password[$rut]");
		$this->form_validation->set_rules('nva_contrasegna_rep', 'Confirmación de contraseña', 'required|min_length[5]|max_length[100]|matches[nva_contrasegna]|xss_clean');
		$this->form_validation->set_rules('nva_contrasegna', 'Contraseña nueva', 'required|min_length[5]|max_length[100]|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="error alert alert-error">', '</div>');
		if ($this->form_validation->run() == FALSE)
		{
			/* Se debe setear un array asociativo con 3 keys: "titulo_msj", "cuerpo_msj" y "tipo_msj"
			titulo_msj: puede ser cualquier texto que represente a grandes rasgos el mensaje
			cuerpo_msj: puede ser cualquier texto que represente a el detalle del mensaje
			tipo_msj: indica el tipo de mensaje, puede tomar los valores: "alert-error", "alert-warning", "alert-success", "alert-danger" y "alert-info"
			Luego se debe pasar este array como argumento al método del controlador que carga la vista con errores
			*/
			$mensaje_alert["titulo_msj"] = "Hay un problema para cambiar la contraseña";
			$mensaje_alert["cuerpo_msj"] = "Revise los campos señalados más abajo e intente nuevamente";
			$mensaje_alert['tipo_msj'] = "alert-error";
			$this->cambiarContrasegna($mensaje_alert); //Vuelvo a llamar el cambio de contraseña si hubo un error
		}
		else
		{
			$resultado = $this->model_usuario->cambiarContrasegna($rut ,md5($_POST['nva_contrasegna']));

			/* Cargo la vista que muestra el mensaje de que la operación se realizó correctamente */
			$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
			$datos_plantilla["title"] = "ManteKA";
			$datos_plantilla["menuSuperiorAbierto"] = "";
			$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
			$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
			$datos_plantilla["mostrarBarra_navegacion"] = FALSE;
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
			$datos_plantilla["barra_lateral"] = "";
			$datos_plantilla["titulo_msj"] = "Listo";
			$datos_plantilla["cuerpo_msj"] = "Se ha cambiado su contraseña";
			$datos_plantilla["tipo_msj"] = "alert-success";
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Correo/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "vista principal"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
			$this->load->view('templates/template_general', $datos_plantilla);
		}
	}
	
	public function check_user_and_password($current_password, $user) {
		$this->load->model('model_usuario');
		$logueo = $this->model_usuario->ValidarUsuario($user ,$current_password);
		if ($logueo) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('check_user_and_password', 'La %s es incorrecta');
			return FALSE;
		}
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */