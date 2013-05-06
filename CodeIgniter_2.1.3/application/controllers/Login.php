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




	/******************************************************************************************************************************
	* Funciones de tipo GET
	* Acá se ponen las funciones que cargan vistas a través del método GET, sólo muestran vistas.
	******************************************************************************************************************************/

	/**
	* Función principal del controlador de Login, es llamado para mostrar la vista de login inicialmente.
	*/
	public function index()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
	    if ($rut == TRUE) {
	      redirect('/Correo/', '');         // En dicho caso, se redirige a la interfaz principal
	    }
	    
		$datos_plantilla["title"] = "ManteKA login";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$this->load->view('login', $datos_plantilla);
		
	}


	/**
	* Función que carga la vista para que el usuario recupere su contraseña, 
	* El usuario puede ingresar su email para así enviarle un correo con la contraseña temporal.
	*/
	public function olvidoPass()
	{
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$this->load->view('olvidoPass', $datos_plantilla);
		
	}

	/**
	* Función que se llama al presionar el botón para cerrar sesión.
	* 
	* Borra las cookies del usuario para eliminar su sesión.
	* Luego redirecciona al login. 
	*/
	function logout() {
		$this->session->unset_userdata('rut');
		$this->session->unset_userdata('email');
    	$this->session->unset_userdata('loggued_in');
		redirect('/Login/', ''); //   Lo regresamos a la pantalla de login y pasamos como par?metro el mensaje de error a presentar en pantalla
   	}


	/**
	* Esta función se usa sólo para enviar el correo de recuperación de contraseña
	* 
	* @param string $destino Es el mail del destinatario del correo.
	* @param string $subject Es el tema o título del correo.
	* @param string $mensaje Es el texto que contiene el correo.
	* @return bool Indica si se envió correctamente el correo. 
	*/
	private function enviarCorreo($destino, $subject, $mensaje) {
		try {
			$this->email->from('no-reply@manteka.cl', 'ManteKA');
			$this->email->to($destino);
			$this->email->subject($subject);
			$this->email->message($mensaje);


			$this->email->send();
			//echo $this->email->print_debugger();
			return TRUE;
		}
		catch (Exception $e) {
			return FALSE;
		}
	}


	/**
	* Esta función muestra la vista para cambiar la contraseña
	* 
	* Lleva un argumento que se setea por defecto en un array vacio, 
	* de esta forma cuando el usuario abre esa vista por primera vez el array está vacio
	* Cuando la vista es rellamada para mostrarla nuevamente pero con mensajes de error, warnings o success entonces 
	* este array contiene el mensaje a ser mostrado (ver más abajo como se llama con el array)
	* 
	* @param array $mensajes_alert Un arreglo con los mensajes de error que se mostrarán.
	*/
	public function cambiarContrasegna($mensajes_alert = array())
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





	/******************************************************************************************************************************
	* Funciones de tipo POST
	* Por convención, las funciones que terminan en "Post" corresponden a las funciones que son llamadas cuando se envian datos
	* al servidor a través de un formulario.
	******************************************************************************************************************************/

	/**
	* Función llamada desde el login para loguear al usuario.
	* 
	* Valida las variables contra la base de datos, setea los mensajes de error y 
	* devuelve al login en caso de ser incorrectos los parámetros provienientes desde la vista.
	* En caso que el login resulte correcto, se setean las cookies con los datos del usuario logueado.
	*/
	public function LoginPost() {
		$Rut = $this->input->post('inputRut');
		$dv = $this->input->post('inputGuionRut');
		$this->form_validation->set_rules('inputGuionRut', 'Dígito verificador', "required"); //Se verifica sólo para que reaparezca al cargar la vista
		$this->form_validation->set_rules('inputRut', 'usuario', "required|callback_check_userRUT");
		$this->form_validation->set_rules('inputPassword', 'contraseña', "required|callback_check_user_and_password[$Rut]");
		
		if ($this->form_validation->run() == FALSE) {
			$this->index(); //Vuelvo a llamar el cambio de contraseña si hubo un error
		}
		else {
			try {
				$this->load->model('model_usuario');
	            $ExisteUsuarioyPassoword=$this->model_usuario->ValidarUsuario($_POST['inputRut'],$_POST['inputPassword']);   //   comprobamos que el usuario exista en la base de datos y la password ingresada sea correcta
	            if($ExisteUsuarioyPassoword) {   // La variable $ExisteUsuarioyPassoword recibe valor TRUE si el usuario existe y FALSE en caso que no. Este valor lo determina el modelo.
					if ($ExisteUsuarioyPassoword->ID_TIPO == 2) {
		            	$tipo_user = "coordinador";
		            }
					if ($ExisteUsuarioyPassoword->ID_TIPO == 1) {
		            	$tipo_user = "profesor";
		            }
					$newdata = array(
						'rut'  => $ExisteUsuarioyPassoword->RUT_USUARIO,
						'email'     => $ExisteUsuarioyPassoword->CORREO1_USER,
						'tipo_usuario' => $tipo_user,
						'id_tipo_usuario' => $ExisteUsuarioyPassoword->ID_TIPO,
						'nombre_usuario' => $ExisteUsuarioyPassoword->NOMBRE1,
						'logged_in' => TRUE
	              	);
			      	$this->session->set_userdata($newdata);
					redirect('/Correo/', 'index');
				}
	            else { // Si no logró validar
			       	$this->session->unset_userdata('rut');
			      	$this->session->unset_userdata('email');
	              	$this->session->unset_userdata('tipo_usuario');
			      	$this->session->unset_userdata('loggued_in');
			      	redirect('/Login/', ''); // Lo regresamos a la pantalla de login
				}
			}
			catch (Exception $e) {
				redirect("/Otros", "databaseError");
			}
		}
	}


	/**
	* Función que es llamada cuando se envía la dirección de correo electrónico para recuperar la contraseña
	* 
	* Se verifica que el email introducido es válido y se verifica que existe en la base de datos
	* Si existe un error se vuelve a mostrar la vista olvidoPass()
	* Si no hubo error se setea la nueva contraseña en la base de datos y se le da cierto periodo de validez (2 días por ahora)
	* Luego se envía un correo con esta nueva contraseña a la dirección introducida y se muestra una 
	* vista con el resultado del envío del correo electrónico.
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
				$mensaje = "Su nueva contraseña es: ";
				$mensaje = $mensaje.$new_pass;
				$mensaje = $mensaje."\nEsta contraseña es válida hasta el día ".$fechaValidez.", luego no podrá utilizarla";
				$mensaje = $mensaje."\nA penas inicie sesión nuevamente cambie su contraseña.";
				$mensaje = $mensaje."\n\nEl equipo de ManteKA.";
				if ($this->enviarCorreo($destino, 'Recuperación de contraseña ManteKA', $mensaje) == FALSE) {
					$datos_plantilla["titulo_msj"] = "No se pudo enviar el correo";
					$datos_plantilla["cuerpo_msj"] = "Existe un problema con el servicio que envía correos electrónicos, comuniquese con el administrador.";
					$datos_plantilla["tipo_msj"] = "alert-error";

				}
				else {
					$datos_plantilla["titulo_msj"] = "Listo";
					$datos_plantilla["cuerpo_msj"] = "Se ha enviado un correo electrónico a la cuenta '".$destino."' con su nueva contraseña.";
					$datos_plantilla["tipo_msj"] = "alert-success";
				}
				


				/* Finalmente muestro la vista que indica que esto fue realizado correctamente */
				$datos_plantilla["title"] = "ManteKA";
				$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
				$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
				
				$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
				$datos_plantilla["redirecTo"] = "Login/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
				//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
				$datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
				$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
			}
		}
	}

	
	
	
	/**
	* Función que se llama cuando el usuario envía el formulario para cambiar la contraseña
	* 
	* Se comprueba que el usuario está logueado, la validez de las variables.
	* Se comprueba que la contraseña actual introducida es correcta.
	* Se comprueba de que las contraseñas nuevas y su repetición son iguales.
	* Si existen errores en las validaciones, se setean los mensajes de error y se llama la vista 
	* normal para cambiar la contraseña.
	*/
	public function cambiarContrasegnaPost() {
	
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$this->load->model('model_usuario');
		if ($this->input->post('contrasegna_actual')) {
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
				return ;
			}
			$resultado = $this->model_usuario->cambiarContrasegna($rut ,md5($this->input->post('nva_contrasegna')));
		}
		//Falta implementar función que actualiza los datos del usuario como los mails y el teléfono
		$tipo = $this->session->userdata('id_tipo_usuario');
		$mail1 = $this->input->post("correo1");
		$mail2 = $this->input->post("correo2");
		$telefono = $this->input->post("telefono");
		$resultado = $this->model_usuario->cambiarDatosUsuario($rut, $tipo, $telefono, $mail1, $mail2);
		

		/* Cargo la vista que muestra el mensaje de que la operación se realizó correctamente */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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
		$datos_plantilla["cuerpo_msj"] = "Se ha actualizado el perfil del usuario";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
		$datos_plantilla["redirecTo"] = "Correo/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
		//$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
		$datos_plantilla["nombre_redirecTo"] = "vista principal"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
		$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}
	

	/**
	* Función de apoyo a las validaciones, comprueba el usuario y la contraseña en la base de datos.
	* 
	* @param string $current_password La contraseña actual que se desea comprobar.
	* @param string $rut El rut del usuario que se desea comprobar junto a la contraseña.
	* @param return bool Indica con TRUE si el son correctos el usuario y la contraseña según la base de datos.
	*/
	public function check_user_and_password($current_password, $rut) {
		try {
			$this->load->model('model_usuario');
			$logueo = $this->model_usuario->ValidarUsuario($rut ,$current_password);
			if ($logueo) {
				return TRUE;
			}
			else {
				$this->form_validation->set_message('check_user_and_password', 'La %s es incorrecta');
				return FALSE;
			}
		}
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	* Función de apoyo a las validaciones, comprueba que el rut existe en la base de datos.
	* 
	* @param string $rut El rut del usuario que se desea comprobar en la base de datos.
	* @param return bool Indica con TRUE si el rut existe.
	*/
	public function check_userRUT($rut) {
		try {
			$this->load->model('model_usuario');
			$logueo = $this->model_usuario->ValidarRut($rut);
			if ($logueo) {
				return TRUE;
			}
			else {
				$this->form_validation->set_message('check_userRUT', 'El %s no esta en el sistema');
				return FALSE;
			}
		}
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	* Función de apoyo a las validaciones, comprueba que el email introducido existe en la base de datos.
	* 
	* @param string $email La dirección de correo que se desea comprobar.
	* @param return bool Indica con TRUE si el email existe y pertenece a algún usuario.
	*/
	public function check_mail_exist($email) {
		try {
			$this->load->model('model_usuario');
			if ($this->model_usuario->existe_mail($email)) {
				return TRUE;
			}
			else {
				$this->form_validation->set_message('check_mail_exist', 'El %s no existe en ManteKA, intente nuevamente.');
				return FALSE;
			}
		}
		catch (Exception $e) {
			redirect("/Otros", "databaseError");
		}
	}


	/**
	* Función que genera una contraseña aleatória.
	* 
	* @return string Un string de 8 caracteres alfanuméricos con la contraseña generada.
	*/
	private function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}


  	/**
   	* Función para autentificarse en el sistema mediante una cuenta Google.
   	* 
   	* El Controlador solicita la autentificación a Google.
   	* Una vez realizado esto, el usuario se autentifica normalmente.
   	* 
   	* @param string $provider Es el proveedor del login, por ahora sólo es válido utilizar "google".
   	*/
   public function signInGoogle($provider){
    $rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
    if ($rut == TRUE) {
      redirect('/Correo/', '');         // En dicho caso, se redirige a la interfaz principal
    }

    $this -> load -> spark('oauth2/0.4.0');
    //si el proveedor pasado es Google
    if($provider == 'google')
    {
        $provider = $this -> oauth2 -> provider($provider, array(
        'id' => '412900046548.apps.googleusercontent.com',
        'secret' => 'RN_R-d6BDT2XYwQdVHB5S9tO', ));
    }

    if (!$this -> input -> get('code')) {
        $url = $provider -> authorize();

        redirect($url);
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
            	if ($usuario->ID_TIPO == 2) {
	            	$tipo_user = "coordinador";
	            }
				if ($usuario->ID_TIPO == 1) {
	            	$tipo_user = "profesor";
	            }
              	$newdata = array(
					'rut'  => $usuario->RUT_USUARIO,
					'email'     => $usuario->CORREO1_USER,
					'tipo_usuario' => $tipo_user,
					'id_tipo_usuario' => $ExisteUsuarioyPassoword->ID_TIPO,
					'nombre_usuario' => $usuario->NOMBRE1,
					'logged_in' => TRUE
              );
              $this->session->set_userdata($newdata);
              redirect('/Correo/', '');         // En dicho caso, se redirige a la interfaz principal
            }
            else // En caso de no existir ningún usuario con correo = $mail
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
              $datos_plantilla["redirecFrom"] = "Login/signInGoogle/google"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
              $datos_plantilla["nombre_redirecFrom"] = "Volver"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
              $datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
              $this->load->view('templates/big_msj_deslogueado', $datos_plantilla);


            }

            
        } catch (OAuth2_Exception $e) {
            show_error('No se pudo loguear mediante Google :(: ' . $e);
        }
    }

   }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */