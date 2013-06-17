<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master
require_once 'index.php';
/**
 *	Clase controlador Login.
 *	Controlador encargado de presentar las vistas de autentificación (Login)
 *	y control de usuarios (Cambio de contraseña, perfil, contraseña olvidada).
 *	Método por defecto (index) carga la vista de Login.
 */
class Login extends MasterManteka {

	/******************************************************************************************************************************
	*	Funciones de tipo GET
	*	Acá se ponen las funciones que cargan vistas a través del método GET, sólo muestran vistas.
	******************************************************************************************************************************/

	/**
	*	Función principal del controlador de Login, es llamado para mostrar la vista de login inicialmente.
	*	Esta vista sólo es cargada en caso de que el usuario no haya iniciado sesión previamente (con la opción "Recuerdame").
	*	En dicho caso, será redirigido automáticamente a la vista principal del sistema.
	*/
	public function index()
	{
		$rut = $this->session->userdata('rut'); 		//Se comprueba si el usuario tiene sesión iniciada, mediante almacenamiento de cookies
	    if ($rut == TRUE) {
	      redirect('/Correo/', '');         			// En dicho caso, se redirige a la interfaz principal
	    }
	    $recordarme = $this->session->userdata('recordarme');
	    if ($recordarme == 1) {
	    	$datos_plantilla['rut_almacenado'] = $this->session->userdata('rut_almacenado');
	    	$datos_plantilla['dv_almacenado'] = $this->session->userdata('dv_almacenado');
	    	$datos_plantilla['recordarme'] = $this->session->userdata('recordarme');
	    }
	    
	    /*
	     *	Se cargan los datos relevantes en la vista en el arreglo "datos_plantilla"
	     *	Luego se carga la vista ingresando como parámetros el vector con datos específicos.
	     *	El vector posee el título de la vista y la cabecera que se debe cargar.
	     */
		$datos_plantilla["title"] = "ManteKA";															// Título de la Vista
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);			// Cabecera a cargar
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);	// Banner a cargar
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);					// Footer del sitio
		$this->load->view('login', $datos_plantilla);													// Se carga la vista
		
	}


	/**
	*	Función que carga la vista para que el usuario recupere su contraseña.
	*	El usuario puede ingresar su email para así enviarle un correo con la contraseña temporal.
	*	
	*/
	public function olvidoPass()
	{
		/*
	     *	Se cargan los datos relevantes en la vista en el arreglo "datos_plantilla"
	     *	Luego se carga la vista ingresando como parámetros el vector con datos específicos.
	     *	El vector posee el título de la vista y la cabecera que se debe cargar.
	     */

		$datos_plantilla["title"] = "ManteKA";															// Título de la Vista
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);			// Cabecera a cargar
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);	// Bannera a cargar
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);					// Footer del sitio
		$this->load->view('olvidoPass', $datos_plantilla);												// Se carga la vista
		
	}

	/**
	*	Función que se llama al presionar el botón para cerrar sesión.
	*	Borra las cookies del usuario para eliminar su sesión.
	*	Luego redirecciona al login. 
	*/
	function logout() {
		// Se regresa al usuario a la pantalla de login y se pasa como parámetro el mensaje de error a presentar en pantalla
		$this->session->unset_userdata('rut');					// Se quita de las cookies la variable rut
		$this->session->unset_userdata('email');				// Se quita de las cookies la variable mail
    	$this->session->unset_userdata('loggued_in');			// Se quita de las coockies la variable loggued_in
    	$this->session->unset_userdata('id_tipo_usuario');		// Se quita de las coockies la variable id_tipo_usuario
    	$this->session->unset_userdata('tipo_usuario');			// Se quita de las coockies la variables tipo_usuario
    	$this->session->unset_userdata('nombre_usuario');			// Se quita de las coockies la variables nombre_usuario

		redirect('/Login/', '');								// Redirección al método principal de Login
   	}


	/**
	*	Función que envía un correo hacia un destinatario desde el correo especificado.
	*	Esta función se usa sólo para enviar el correo de recuperación de contraseña
	* 
	* 	@param string $destino Es el mail del destinatario del correo.
	* 	@param string $subject Es el tema o título del correo.
	* 	@param string $mensaje Es el texto que contiene el correo.
	* 	@return bool indica si se envió correctamente el correo. 
	*/
	private function enviarCorreo($destino, $subject, $mensaje) {

		/*
		*	Se intenta enviar el correo, capturando un error en caso
		*	de que no se pueda realizar.
		*/
		try {
			$this->email->from('no-reply@manteka.cl', 'ManteKA');		// Envío del correo desde e-mail "no-reply@manteka.cl". Autor ManteKA
			$this->email->to($destino);									// Destinatario del correo
			$this->email->subject($subject);							// Asunto del correo
			$this->email->message($mensaje);							// Mensaje del correo
			if (!$this->email->send()) {										// Envío del correo
				//echo $this->email->print_debugger();
				return FALSE;
			}
			return TRUE;												// Retorna verdadero en caso de que se haya enviado satisfactoriamente
		}
		catch (Exception $e) {
			return FALSE;												// Se captura el error, y se retorna Falso en caso de que haya habido problemas
		}
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
	public function cambiarContrasegna($mensajes_alert = array())
	{
	    /*
	    *	Se cargan en un arreglo información para pasarla a la vista
	    *	una vez se cargue.
	    */
	    $datos_plantilla["rut_usuario"] = $rut_user = $this->session->userdata('rut');		// Rut del usuario
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');	// Nombre del usuario
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');		// Tipo de cuenta del usuario

		
		$this->load->model('model_usuario');												// Se carga el Modelo para utilizar sus funciones

		// Se busca al usuario con un rut específico
		// En caso de encontrarlo se obtienen todos sus datos
		$datos = $this->model_usuario->datos_usuario($rut_user);
		
		/* Esta parte hace que se muestren los mensajes de error, warnings, etc */
		if (count($mensajes_alert) > 0) {
			$datos_plantilla["mensaje_alert"] = $this->load->view('templates/mensajes/mensajeError', $mensajes_alert, true);
		}

		$datos_plantilla = array();
		$datos_plantilla["datos"] = $datos;
		$subMenuLateralAbierto = '';
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR; $tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("", "cuerpo_cambio_contrasegna", "", $datos_plantilla, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	
	}





	/******************************************************************************************************************************
	* Funciones de tipo POST
	* Por convención, las funciones que terminan en "Post" corresponden a las funciones que son llamadas cuando se envian datos
	* al servidor a través de un formulario.
	******************************************************************************************************************************/

	/**
	* Función llamada desde el login para loguear al usuario.
	* Valida las variables en la base de datos, setea los mensajes de error y 
	* devuelve al login en caso de ser incorrectos los parámetros provienientes desde la vista.
	* En caso que el login resulte correcto, se setean las cookies con los datos del usuario logueado.
	*/
	public function LoginPost() {
		$rut = $this->input->post('inputRut');
		$dv = $this->input->post('inputGuionRut');
		$this->form_validation->set_rules('inputGuionRut', 'Dígito verificador', "required"); // Se verifica sólo para que reaparezca al cargar la vista
		$this->form_validation->set_rules('inputRut', 'usuario', "required|callback_check_userRUT");
		$this->form_validation->set_rules('inputPassword', 'contraseña', "required|callback_check_user_and_password[$rut]");
		
		if ($this->form_validation->run() == FALSE) {
			$this->index(); // Se vuelve al Login en caso de error
		}
		else {
			try {
				$this->load->model('model_usuario');
				$inputPass = $this->input->post('inputPassword');
				//  Se coprueba que el usuario exista en la base de datos y la password ingresada sea correcta
	            $ExisteUsuarioyPassoword=$this->model_usuario->ValidarUsuario($rut, $inputPass);

	            //	La variable $ExisteUsuarioyPassoword recibe valor TRUE si el usuario existe y FALSE en caso que no. Este valor lo determina el modelo.
	            if($ExisteUsuarioyPassoword) {
	            	
	            	// Se obtiene el tipo de cuenta que posee el usuario
	            	$redireccionarA = "index";
					if ($ExisteUsuarioyPassoword->ID_TIPO == TIPO_USR_COORDINADOR) {
		            	$tipo_user = "coordinador";
		            	$redireccionarA = "index";
		            }
					if ($ExisteUsuarioyPassoword->ID_TIPO == TIPO_USR_PROFESOR) {
		            	$tipo_user = "profesor";
		            	$redireccionarA = "indexProfesor";
		            }


		            if ($this->input->post('recordarme_check')) {
	            		$recordarme = TRUE;
	            		$rut_almacenado = $rut;
	            		$dv_almacenado = $dv;
		            }
		            else {
		            	$recordarme = FALSE;
		            	$rut_almacenado = "";
		            	$dv_almacenado = "";
		            }
		            // Se crea un arreglo con los datos del usuario
					$newdata = array(
						'rut'  => $ExisteUsuarioyPassoword->rut,
						'rut_almacenado' => $rut_almacenado, //Usado para el "recordarme"
						'dv_almacenado' => $dv_almacenado,
						'email'     => $ExisteUsuarioyPassoword->correo1,
						'recordarme' => $recordarme,
						'tipo_usuario' => $tipo_user,
						'id_tipo_usuario' => $ExisteUsuarioyPassoword->ID_TIPO,
						'nombre_usuario' => $ExisteUsuarioyPassoword->nombre1
	              	);

	              	// Se setean nuevas cookies con los datos del usuario
			      	$this->session->set_userdata($newdata);

			      	// Redirección a la interfaz principal del sistema
					redirect('/Correo/'.$redireccionarA, "");
				}
				// Si no se logró validar
	            else {
	            	// Borrar las coockies seteadas bajo el rut de dicho usuario
			       	$this->session->unset_userdata('rut');
			      	$this->session->unset_userdata('email');
			      	$this->session->unset_userdata('loggued_in');
			      	$this->session->unset_userdata('id_tipo_usuario');		// Se quita de las coockies la variable id_tipo_usuario
    				$this->session->unset_userdata('tipo_usuario');			// Se quita de las coockies la variables tipo_usuario
    				$this->session->unset_userdata('nombre_usuario');			// Se quita de las coockies la variables nombre_usuario
			      	redirect('/Login/', '');							// Se regresa a la vista de autentificación
				}
			}
			/*
			*	En caso de que haya habido algún error en el proceso
			*	Se captura dicho error, y se redirige a una vista indicando que ha existido un error durante el procesamiento de la información
			*/
			catch (Exception $e) {
				redirect("/Otros", "databaseError");
			}
		}
	}


	/**
	*	Función que es llamada cuando se envía la dirección de correo electrónico para recuperar la contraseña
	*	Se verifica que el email introducido es válido y se verifica que existe en la base de datos
	*	Si existe un error se vuelve a mostrar la vista olvidoPass()
	*	Si no hubo error se setea la nueva contraseña en la base de datos y se le da cierto periodo de validez (2 días por ahora)
	*	Luego se envía un correo con esta nueva contraseña a la dirección introducida y se muestra una 
	*	vista con el resultado del envío del correo electrónico.
	*/
	public function recuperaPassPost() {
		$this->form_validation->set_rules('email', 'email', "required|email|xss_clean|callback_check_mail_exist");
		if ($this->form_validation->run() == FALSE)
		{
			$this->olvidoPass(); //Vuelvo a llamar el cambio de contraseña si hubo un error
		}
		else {

			/* Acá va la lógica de enviar un correo, etc */
			$destino = $this->input->post('email');
			$new_pass = $this->randomPassword();
			/* Seteo la nueva contraseña en el modelo y le doy un tiempo de validez */
			$this->load->model('model_usuario');
			$fechaValidez = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')."+86400 minutes"));//date("Y-m-d", strtotime(date("Y-m-d")." +1 day"));
			//echo 'FECHA VALIDEZ: '.$fechaValidez;
			$existeEmail = $this->model_usuario->setPassSecundaria($destino, $new_pass, $fechaValidez);
			if ($existeEmail) {

				// Se define el mensaje a ser enviado
				$mensaje = "Su nueva contraseña es: ";
				$mensaje = $mensaje.$new_pass;
				$mensaje = $mensaje."\nEsta contraseña es válida hasta el día ".$fechaValidez.", luego no podrá utilizarla";
				$mensaje = $mensaje."\nA penas inicie sesión nuevamente cambie su contraseña.";
				$mensaje = $mensaje."\n\nEl equipo de ManteKA.";

				// Si hubo un error al enviar el mensaje, indicar al usuario
				if ($this->enviarCorreo($destino, 'Recuperación de contraseña ManteKA', $mensaje) == FALSE) {
					$datos_plantilla["titulo_msj"] = "No se pudo enviar el correo";
					$datos_plantilla["cuerpo_msj"] = "Existe un problema con el servicio que envía correos electrónicos, comuniquese con el administrador.";
					$datos_plantilla["tipo_msj"] = "alert-error";

				}
				// Caso contrario, indicar que la operación ha sido satisfactoria
				else {
					$datos_plantilla["titulo_msj"] = "Listo";
					$datos_plantilla["cuerpo_msj"] = "Se ha enviado un correo electrónico a la cuenta '".$destino."' con su nueva contraseña.";
					$datos_plantilla["tipo_msj"] = "alert-success";
				}
				


				/* Finalmente se muestra la vista que indica que esto fue realizado correctamente */
				$datos_plantilla["title"] = "ManteKA";
				$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
				$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
				
				$datos_plantilla["redirectAuto"] = FALSE; // Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Login/index"; // Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);					// Footer del sitio
				$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
			}
		}
	}

	
	
	
	/**
	*	Función que se llama cuando el usuario envía el formulario para cambiar la contraseña
	*	Se comprueba que el usuario está logueado, la validez de las variables.
	*	Se comprueba que la contraseña actual introducida es correcta.
	*	Se comprueba de que las contraseñas nuevas y su repetición son iguales.
	*	Si existen errores en las validaciones, se setean los mensajes de error y se llama la vista 
	*	normal para cambiar la contraseña.
	*/
	public function cambiarContrasegnaPost() {
	
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); // Se redirecciona a login si no tiene sesión iniciada
		}

		// Se carga el modelo de usuarios
		$this->load->model('model_usuario');

		// Si existe contraseña actual
		if ($this->input->post('contrasegna_actual')) {
			// Se identifican las validaciones que deben realizarse para el cambio de contraseña
			$this->form_validation->set_rules('contrasegna_actual', 'Contraseña actual', "required|xss_clean|callback_check_user_and_password[$rut]");
			$this->form_validation->set_rules('nva_contrasegna_rep', 'Confirmación de contraseña', 'required|min_length[5]|max_length[100]|matches[nva_contrasegna]|xss_clean');
			$this->form_validation->set_rules('nva_contrasegna', 'Contraseña nueva', 'required|min_length[5]|max_length[100]|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="error alert alert-error">', '</div>');

			// Si la validación es incorrecta
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
				$this->cambiarContrasegna($mensaje_alert); //	Vuelvo a llamar el cambio de contraseña si hubo un error con el mensaje apropiado

				// Terminar
				return ;
			}

			// Caso contrario, cambiar la contraseña mediante el modelo
			$resultado = $this->model_usuario->cambiarContrasegna($rut ,md5($this->input->post('nva_contrasegna')));
		}
		
		//Falta implementar función que actualiza los datos del usuario como los mails y el teléfono
		$tipo = $this->session->userdata('id_tipo_usuario');
		$mail1 = $this->input->post("correo1");
		$mail2 = $this->input->post("correo2");
		$telefono = $this->input->post("telefono");
		$resultado = $this->model_usuario->cambiarDatosUsuario($rut, $tipo, $telefono, $mail1, $mail2);


		$datos_plantilla["titulo_msj"] = "Listo";
		$datos_plantilla["cuerpo_msj"] = "Se ha actualizado el perfil del usuario";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Correo/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "vista principal"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
	

	/**
	*	Función de apoyo a las validaciones, comprueba el usuario y la contraseña en la base de datos.
	* 
	*	@param string $current_password La contraseña actual que se desea comprobar.
	*	@param string $rut El rut del usuario que se desea comprobar junto a la contraseña.
	*	@param return bool Indica con TRUE si el son correctos el usuario y la contraseña según la base de datos.
	*/
	public function check_user_and_password($current_password, $rut) {

		// Intentar validad el usuario mediante el modelo
		try {

			// Se carga el modelo de usuarios
			$this->load->model('model_usuario');

			// Se intenta validar al usuario con su contraseña mediante el modelo
			$logueo = $this->model_usuario->ValidarUsuario($rut ,$current_password);

			// Si la autentificación es correcta, devolver TRUE
			if ($logueo) {
				return TRUE;
			}

			// Si la autentificación es false, retornar FALSE
			else {
				$this->form_validation->set_message('check_user_and_password', 'La %s es incorrecta');
				return FALSE;
			}
		}

		// En caso de que haya un error en la operación, señalarselo al usuario con una vista apropiada
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	*	Función de apoyo a las validaciones, comprueba que el rut existe en la base de datos.
	* 
	*	@param string $rut El rut del usuario que se desea comprobar en la base de datos.
	*	@param return bool Indica con TRUE si el rut existe.
	*/
	public function check_userRUT($rut) {

		// Intentar validar si existe un RUT específico en la base de datos
		try {

			// Se carga el modelo
			$this->load->model('model_usuario');

			// Validar la existencia del RUT
			$logueo = $this->model_usuario->ValidarRut($rut);

			// Si existe, devolver TRUE
			if ($logueo) {
				return TRUE;
			}

			// Si no existe, devolver FALSE
			else {
				$this->form_validation->set_message('check_userRUT', 'El %s no esta en el sistema');
				return FALSE;
			}
		}
		// En caso de que haya un error en la operación, señalarselo al usuario con una vista apropiada
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	*	Función de apoyo a las validaciones, comprueba que el email introducido existe en la base de datos.
	* 
	*	@param string $email La dirección de correo que se desea comprobar.
	*	@param return bool Indica con TRUE si el email existe y pertenece a algún usuario.
	*/
	public function check_mail_exist($email) {

		// Intentar validar si existe un correo en el sistema
		try {

			// Se carga el modelo
			$this->load->model('model_usuario');
			
			// Validar la existencia del mail en la base de datos, mediante el modelo

			// Si existe, retornar TRUE
			if ($this->model_usuario->existe_mail($email)) {
				return TRUE;
			}

			// Si no existe, retorar FALSE
			else {
				$this->form_validation->set_message('check_mail_exist', 'El %s no existe en ManteKA, intente nuevamente.');
				return FALSE;
			}
		}

		// En caso de que haya un error en la operación, señalarselo al usuario con una vista apropiada
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	*	Función que genera una contraseña aleatória.
	* 
	*	@return string Un string de 8 caracteres alfanuméricos con la contraseña generada.
	*/
	private function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";		// Alfabeto para la generación aleatoria de una cadena
	    $pass = array();
	    $alphaLength = strlen($alphabet) - 1; // Largo del alfabeto

    	// Algoritmo para la generación de caracteres aleatorios
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); // En base a un array de caracteres, retornar un string
	}


  	/**
   	*	Función para autentificarse en el sistema mediante una cuenta Google.
   	* 
   	*	El Controlador solicita la autentificación a Google.
   	*	Una vez realizado esto, el usuario se autentifica normalmente.
	*
   	*	Para esto se utiliza el protoloco OAuth 2.0 para utilizar la API de autentificación
   	*	de distintos proveedores. Para este caso se utiliza sólo Google
   	* 
   	*	@param string $provider Es el proveedor del login, por ahora sólo es válido utilizar "google".
   	*/
   public function signInGoogle($provider){
    $rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
    if ($rut == TRUE) {
      redirect('/Correo/', '');         	// En dicho caso, se redirige a la interfaz principal
    }

    /*
    *	Se carga la herramienta OAuth 2.0.
    *	Protocolo para la utilización de APIs de otros sistemas registrados
    */
    $this -> load -> spark('oauth2/0.4.0');

    
    // Si el proveedor pasado es Google
    if($provider == 'google')
    {
    	require_once APPPATH.'config/keys.php';
    	
    	$keys_array;
    	
    	if(defined('ENVIRONMENT')){
    		switch(ENVIRONMENT)
    		{
    			case 'development':
    				$keys_array = array(
    					'id' => constant('DEVELOPMENT-ID'),							// ID del cliente OAuth registrado con Google
    					'secret' => constant('DEVELOPMENT-PASS')					// Clave secreta del client
					);
					break;
				case 'production':
					$keys_array = array(
						'id' => constant('PRODUCTION-ID'),							// ID del cliente OAuth registrado con Google
						'secret' => constant('PRODUCTION-CLASS')					// Clave secreta del client
					);
					break;
				default:
					exit('The application environment is not set correctly.');
			}
    	}
    	else{
    		redirect('Otros');
    		return;

    	}
        $provider = $this -> oauth2 -> provider($provider, $keys_array);
    }

    if (!$this -> input -> get('code')) {								// Solicitud del acceso a la API del proveedor
		
		$url = $provider -> authorize();
		$url = $this->str_lreplace("approval_prompt=force", "approval_prompt=auto", $url);
        redirect($url);													// Redirección a este mismo método
		/*

        //$this -> load -> spark('curl/1.2.1');
		//$var = $this->proxy->site('http://facebook.com');

		$datos_plantilla["title"] = "ManteKA";															// Título de la Vista
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);			// Cabecera a cargar
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada','',true);			// Cabecera a cargar
		
		$this -> curl -> create($url);
		$this->curl->option(CURLINFO_HEADER_OUT, FALSE);
		$this->curl->option(CURLOPT_COOKIESESSION, FALSE);
		$this->curl->option(CURLOPT_SSL_VERIFYPEER, FALSE);
		$return = $this -> curl -> execute();
		
		if ($return== false) echo $this->curl->error_string;
		$datos_plantilla["url_google"] = $url;
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);					// Footer del sitio

		$this->load->view('templates/template_google',$datos_plantilla);
		*/

    } else {
        try {
            // Se posee de un Token exitoso enviado por google
            $token = $provider -> access($this->input->get('code'));

            // Se obtiene la información del usuario (Nombre, mail, dirección, foto)
            $user = $provider->get_user_info($token); 

            // Correo del usuario ingresado
            $mail = $user['email'];
            
            //Cargando modelo para validar correo del usuario ingresado con algún registro en la db
            $this->load->model('model_usuario');
            
            /*
              * Verificando si existe algún usuario con dicho correo electrónico. 
              * Resultado de la consulta del modelo. Falso de no encontrar nada o
              * Las filas correspondientes a los usuarios que posean dicho mail.
            */
            $usuario = $this->model_usuario->existe_mail($mail);
            if ($usuario)
            {
            	// Se obtiene el tipo de cuenta que posee el usuario
            	$redireccionarA = "index";

            	if ($usuario->ID_TIPO == TIPO_USR_COORDINADOR) {
	            	$redireccionarA = "index";
	            }
				if ($usuario->ID_TIPO == TIPO_USR_PROFESOR) {
	            	$redireccionarA = "indexProfesor";
	            }

	            // Se asume "Recordarme desclickeado"
	            $recordarme = FALSE;
            	$rut_almacenado = "";
            	$dv_almacenado = "";

	            // Se crea un arreglo con los datos encontrados del usuario
              	$newdata = array(
					'rut'  => $usuario->rut,
					'rut_almacenado' => $rut_almacenado, //Usado para el "recordarme"
					'dv_almacenado' => $dv_almacenado,
					'email'     => $usuario->email1,
					'recordarme' => $recordarme,
					'tipo_usuario' => $usuario->tipo_usuario,
					'id_tipo_usuario' => $usuario->ID_TIPO,
					'nombre_usuario' => $usuario->nombre1
              );
              
              // Carga los datos en las cookies
              $this->session->set_userdata($newdata);

              // Se redirige a la interfaz principal una vez que se ha autentificado
              redirect('/Correo/'.$redireccionarA, "");
            }

            // En caso de no existir ningún usuario con el correo ingresado
            // Se indica al usuario mediante una vista, brindándole de dos opciones, volver a la autentificación mediane Google o 
            // regresar al Login principal
            else
            {
              $datos_plantilla["titulo_msj"] = "Error";
              $datos_plantilla["cuerpo_msj"] = "El correo ingresado no se asocia a ningún usuario del sistema ManteKA";
              $datos_plantilla["tipo_msj"] = "alert-error";

              /* Finalmente muestro la vista que indica que esto fue realizado correctamente */
              $datos_plantilla["title"] = "ManteKA";
              $datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
              $datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
              
              $datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
              $datos_plantilla["redirecTo"] = "Login/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
              //$datos_plantilla["redirecFrom"] = "Login/signInGoogle/google"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
              //$datos_plantilla["nombre_redirecFrom"] = "Volver"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
              $datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
              $this->load->view('templates/big_msj_deslogueado', $datos_plantilla);


            }
        // En caso de que haya habido un error en la operación
        } catch (OAuth2_Exception $e) {
            show_error('No se pudo loguear mediante Google :(: ' . $e);
        }
    }

   }
   
   public function postLoguearse() {
		//Se comprueba que quien hace esta petición de ajax esté logueado

		$rut = $this->input->post('rutEnvio');
		$this->load->model('Model_estudiante');
		$resultado = $this->Model_estudiante->getDetallesEstudiante($rut);
		echo json_encode($resultado);
	}

	/**
	*	Función privada para apoyar la labor de otras funciones.
	*	Reemplaza la última ocurrencia del string $search por
	*	el string $replace, dentro del string $search
	*	
	*	@param string $search Última ocurrencia a encontrar
	*	@param string $replace Por lo que se debe reemplazar la ocurrencia encontrada
	*	@param string $subject String en el cual se busca la ocurrencia
	*/
	private function str_lreplace($search, $replace, $subject)
	{
	    $pos = strrpos($subject, $search);

	    if($pos !== false)
	    {
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }

	    return $subject;
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */