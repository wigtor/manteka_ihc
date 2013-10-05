<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; 

class User extends MasterManteka {

	/**
	* Función principal del controlador User, es llamado para mostrar la vista de gestión
	* de la cuenta de usuario
	*/
	public function index() {
		datosUsuario();
	}


	/**
	*	Esta función muestra la vista para cambiar la contraseña
	*	Lleva un argumento que se setea por defecto en un array vacio, 
	*	de esta forma cuando el usuario abre esa vista por primera vez el array está vacio
	*	Cuando la vista es rellamada para mostrarla nuevamente pero con mensajes de error, warnings o success entonces 
	*	este array contiene el mensaje a ser mostrado (ver más abajo como se llama con el array)
	* 
	*	@param array $mensajes_alert Un arreglo con los mensajes de error que se mostrarán.
	*/
	public function datosUsuario($mensajes_alert = array()) {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}

		//if ($this->input->server('REQUEST_METHOD') == 'GET') {
			/*
			*	Se cargan en un arreglo información para pasarla a la vista
			*	una vez se cargue.
			*/
			$datos_plantilla["rut_usuario"] = $rut_user = $this->session->userdata('rut');		// Rut del usuario
			$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');	// Nombre del usuario
			$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');		// Tipo de cuenta del usuario


			$this->load->model('Model_usuario');												// Se carga el Modelo para utilizar sus funciones

			// Se busca al usuario con un rut específico
			// En caso de encontrarlo se obtienen todos sus datos
			$rut = $this->session->userdata('rut');
			$datos = $this->Model_usuario->datos_usuario($rut);

			/* Esta parte hace que se muestren los mensajes de error, warnings, etc */
			if (count($mensajes_alert) > 0) {
				$datos_plantilla["mensaje_alert"] = $this->load->view('templates/mensajes/mensajeError', $mensajes_alert, true);
			}


			$datos_plantilla["datos"] = $datos;
			$subMenuLateralAbierto = '';
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("", "cuerpo_cambio_contrasegna", "", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		//}
	}


	/**
	*	Función que se llama cuando el usuario envía el formulario para cambiar la contraseña
	*	Se comprueba que el usuario está logueado, la validez de las variables.
	*	Se comprueba que la contraseña actual introducida es correcta.
	*	Se comprueba de que las contraseñas nuevas y su repetición son iguales.
	*	Si existen errores en las validaciones, se setean los mensajes de error y se llama la vista 
	*	normal para cambiar la contraseña.
	*/
	public function postCambiarContrasegna() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			// Se carga el modelo de usuarios
			$this->load->model('Model_usuario');
			$rut = $this->session->userdata('rut');
			$contrasegna_actual = $this->input->post('contrasegna_actual');
			$nva_contrasegna = $this->input->post('nva_contrasegna');
			if ($this->Model_usuario->ValidarUsuario($rut, $contrasegna_actual)) {
				//Cambio la contraseña
				$confirmacion = $this->Model_usuario->cambiarContrasegna($rut , md5($nva_contrasegna));

				if ($confirmacion == TRUE){
					$datos_plantilla["titulo_msj"] = "Acción Realizada";
					$datos_plantilla["cuerpo_msj"] = "Se ha cambiado su contraseña con éxito";
					$datos_plantilla["tipo_msj"] = "alert-success";
				}
				else{
					$datos_plantilla["titulo_msj"] = "Acción No Realizada";
					$datos_plantilla["cuerpo_msj"] = "Ha ocurrio un error al cambiar su contraseña";
					$datos_plantilla["tipo_msj"] = "alert-error";	
				}
				$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Correo/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Inicio"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
				$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
			}
			else {
				//Muestro error de que la contraseña actual no es correcta
				$mensaje_alert["titulo_msj"] = "Hay un problema para cambiar la contraseña";
				$mensaje_alert["cuerpo_msj"] = "La contraseña actual introducida no es correcta";
				$mensaje_alert['tipo_msj'] = "alert-error";
				$this->datosUsuario($mensaje_alert); //	Vuelvo a llamar el cambio de contraseña si hubo un error con el mensaje apropiado

			}
		}
	}


	public function postCambiarDatosUsuario() {
		if (!$this->isLogged()) {
			$this->invalidSession();
			return;
		}

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			// Se carga el modelo de usuarios
			$this->load->model('Model_usuario');
			$rut = $this->session->userdata('rut');
			$mail1 = $this->input->post("correo1");
			$mail2 = $this->input->post("correo2");
			$telefono = $this->input->post("telefono");

			
			$confirmacion = $this->Model_usuario->cambiarDatosUsuario($rut, $telefono, $mail1, $mail2);

			if ($confirmacion == TRUE){
				$datos_plantilla["titulo_msj"] = "Acción Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se han actualizado sus datos con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else{
				$datos_plantilla["titulo_msj"] = "Acción No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Ha ocurrio un error al actualizar sus datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
			$datos_plantilla["redirecTo"] = "Correo/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
			//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
			$datos_plantilla["nombre_redirecTo"] = "Inicio"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		
		}
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */