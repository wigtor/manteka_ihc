<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* @package MasterManteka
* @author Grupo 1
*
*/
class MasterManteka extends CI_Controller {


	protected function isLogged() {
		$rut = $this->session->userdata('rut');
		if ($rut == FALSE)
			return FALSE;
		$this->load->model('Model_usuario');
		$resultado = $this->Model_usuario->ValidarRut($rut);
		if ($resultado == FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	* Método que carga completamente una vista de manteka.
	* 
	* Se hace una comprobación del usuario si está logueado
	* 
	*/
	protected function cargarTodo($titulo, $cuerpo_a_cargar, $barra_lateral, $datos_cuerpo, $tipos_usuarios_permitidos, 
		$subMenuLateralAbierto = '' , $mostrarBarraProgreso = FALSE)
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		
		$esValido = FALSE;
		$permitidoAnonimo = FALSE;
		$esAnonimo = FALSE;
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
			if ($user_permitido == TIPO_USR_ANONYMOUS) {
				$esValido = TRUE;
				if ($user_permitido == $id_tipo_usuario) {
					$esAnonimo = TRUE;
				}
				$permitidoAnonimo = TRUE;
			}
		}

		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}
		if (!$permitidoAnonimo) {
			if ($rut == FALSE) {
				redirect('/Login/', '');
			}
		}

		//Se carga la cantidad de correos sin leer
		$this->load->model('Model_correo');
		$datos_plantilla["numNoLeidos"] = $this->Model_correo->cantidadRecibidosNoLeidos($rut);
		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = $titulo;

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		$datos_plantilla["barra_usuario"] = ''; $datos_plantilla["menu_superior"] = ''; $datos_plantilla["barra_navegacion"] = '';
		if (!$permitidoAnonimo || !$esAnonimo) {
			//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

			//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

			//Se carga la barra de navegación que contiene los botones undo-redo
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);
		}

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = $mostrarBarraProgreso;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Se cargan los diálogos
		$datos_cuerpo["dialogos"] = $this->load->view('templates/dialogos', '', TRUE);

		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view($cuerpo_a_cargar, $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = $subMenuLateralAbierto;

		//Se carga la barra lateral
		if($barra_lateral != '') {
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/'.$barra_lateral, $datos_plantilla, TRUE);
		}
		else {
			$datos_plantilla["barra_lateral"] = '';
		}

		//Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);

		$this->ejecutarCronjobs();
	}

	/**
	* Método que carga completamente la vista para mostrar un mensaje
	* 
	* Se hace una comprobación del usuario si está logueado
	* 
	*/
	protected function cargarMsjLogueado($datos_cuerpo, $tipos_usuarios_permitidos)
	{
		
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		
		
		$esValido = FALSE;
		$permitidoAnonimo = FALSE;
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
			if ($user_permitido == TIPO_USR_ANONYMOUS) {
				$esValido = TRUE;
				$permitidoAnonimo = TRUE;
			}
		}

		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}

		if (!$permitidoAnonimo) {
			if ($rut == FALSE) {
				redirect('/Login/', '');
			}
		}
		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = '';

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		$datos_plantilla["barra_usuario"] = ''; $datos_plantilla["menu_superior"] = ''; $datos_plantilla["barra_navegacion"] = '';
		if (!$permitidoAnonimo) {
			//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

			//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

			//Se carga la barra de navegación que contiene los botones undo-redo
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);
		}
		

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = FALSE;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Se cargan los diálogos
		$datos_cuerpo["dialogos"] = $this->load->view('templates/dialogos', '', TRUE);

		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = '';

		//Se carga la barra lateral
		$datos_plantilla["barra_lateral"] = '';

		//Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);

		$this->ejecutarCronjobs();
	}

	/**
	*	Método para cargar vistas del tipo "Ver información"
	*
	*	Al igual que el método "cargarTodo", se encarga de estructurar toda la vista final.
	*	A través de los argumentos obtenidos por parámetro, emite la información
	*	necesaria para poder ver el módulo "Ver" de algún controlador específico.
	*	
	*	@param 
	*
	*/
	protected function cargarVerInfo($titulo, $barra_lateral, $tipos_usuarios_permitidos,
		$nombreVista,
		$jsFile, $nombreFuncionFiltro, 
		$idInputFiltro, $idSelectFiltro,
		$listaOpciones, $listaInfo,
		$subMenuLateralAbierto = '')
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		if ($rut == FALSE)
			redirect('/Login/', '');
		$esValido = FALSE;
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
		}
		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}

		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = $titulo;

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

		//Se carga la barra de navegación que contiene los botones undo-redo
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = FALSE;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Nombre del archivo JavaScript que utiliza
		$datos_cuerpo["nombreJS"] = $jsFile;

		//Nombre de lo que se está viendo. Ej: "Alumno", "Ayudante"
		$datos_cuerpo["nombreView"] = $nombreVista;

		//ID del objeto input html
		$datos_cuerpo["idInputFiltro"] = $idInputFiltro;

		//Nombre de la función Javascript que se utiliza cuando se cambia el filtro
		$datos_cuerpo["nombreFncCambiarTipoFiltro"] = $nombreFuncionFiltro;

		//ID del objeto select html
		$datos_cuerpo["idSelectFiltro"] = $idSelectFiltro;

		//Opciones del Filtro, posee su ID y el nombre que lo representa
		$datos_cuerpo["OpcionesFiltro"] = $listaOpciones;

		//Información que muestra la vista
		$datos_cuerpo["ListaInformacion"] = $listaInfo;

		//Se cargan los diálogos
		$datos_cuerpo["dialogos"] = $this->load->view('templates/dialogos', '', TRUE);

		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view($cuerpo_a_cargar, $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = $subMenuLateralAbierto;

		//Se carga la barra lateral
		if($barra_lateral != ''){
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/'.$barra_lateral, $datos_plantilla, TRUE);
		}
		else{
			$datos_plantilla["barra_lateral"] = '';
		}
		
		//	Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);
		
		$this->ejecutarCronjobs();
	}


	/**
	*	Función que envía un correo hacia un destinatario desde el correo especificado.
	* 
	* 	@param string $destino Es el mail del destinatario del correo.
	* 	@param string $subject Es el tema o título del correo.
	* 	@param string $mensaje Es el texto que contiene el correo.
	* 	@return bool indica si se envió correctamente el correo. 
	*/
	protected function enviarMail($destino, $subject, $mensaje, $adjuntos) {

		/*
		*	Se intenta enviar el correo, capturando un error en caso
		*	de que no se pueda realizar.
		*/
		try {
			$this->setTimeZone();
			$this->load->library('email', $this->getConfigMail());
			$this->email->from('no-reply@manteka.cl', 'ManteKA');		// Envío del correo desde e-mail "no-reply@manteka.cl". Autor ManteKA
			$this->email->to($destino);									// Destinatario del correo
			$this->email->subject("[ManteKA] ".$subject);				// Asunto del correo
			$this->email->message($mensaje);							// Mensaje del correo
			if($adjuntos != "") {
				foreach ($adjuntos as $adjunto) {
					$this->email->attach("adjuntos/".$adjunto[1]);
				}
			}
			if (!$this->email->send()) {								// Envío del correo
				//echo $this->email->print_debugger();
				return FALSE;
			}
			return TRUE;												// Retorna verdadero en caso de que se haya enviado satisfactoriamente
		}
		catch (Exception $e) {
			return FALSE;												// Se captura el error, y se retorna Falso en caso de que haya habido problemas
		}
	}


	private function getConfigMail() {
		$configuracion = array();
		$configuracion['smtp_host'] = 'ssl://smtp.googlemail.com';
		$this->config->load('config');
		$configuracion['smtp_user'] = $this->config->item('mail_manteka');
		$configuracion['smtp_pass'] = $this->config->item('password_mail_manteka');
		$configuracion['smtp_port'] = '465';
		$configuracion['starttls'] = true;
		$configuracion['mailtype'] = 'html';
		$configuracion['protocol'] = 'smtp';
		$configuracion['newline']   = "\r\n";
		return $configuracion;
	}


	public function invalidSession() {
		$datos_plantilla["titulo_msj"] = "Sesión inválida";
		$datos_plantilla["cuerpo_msj"] = "Su sesión ha expirado o no se encuentra autenticado.";
		$datos_plantilla["tipo_msj"] = "alert-error";	
		
		$datos_plantilla["redirectAuto"] = FALSE;
		$datos_plantilla["redirecTo"] = "Login/index";
		$datos_plantilla["nombre_redirecTo"] = "Iniciar sesión";
		$tipos_usuarios_permitidos = array(TIPO_USR_ANONYMOUS);
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}


	/**
	* Método que ejecuta los cronjobs que se encuentren en la base de datos
	* 
	*/
	private function ejecutarCronjobs() {
		$this->load->model('Model_cronJob');
		$cronJobs = $this->Model_cronJob->getAllCronJobsPorHacer(); //Obtengo sólo los que cumplen con la fecha y hora para ser realizados
		$cantidadCronJobs = count($cronJobs);
		//echo 'Cantidad de cronjobs obtenida: '.$cantidadCronJobs;


		try {
			$this->config->load('config');
			$direccion = $this->config->item('mail_manteka');
			$pass = $this->config->item('password_mail_manteka');
			for ($i = 0; $i < $cantidadCronJobs; $i=$i+1) {
				$inbox = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', $direccion, $pass); 

				//Busca los mails según el asunto especificado y si no ha sido visto aún
				$emails = '';
				if ($inbox) { //Evita que si hay un fail, salgan más fails
					$emails = imap_search($inbox, 'SUBJECT "Delivery Status Notification (Failure)" UNSEEN');
				}

				if($emails == ''){
				
				}else{
					//Se revisa cada mail seleccionado
				    foreach($emails as $email_number) {
				    	//Se consigue el código del mail rebotado
				  		$message = imap_body($inbox, $email_number);
				  		$str = strstr($message,'Ver mensaje en su contexto:');
				  		$str = substr($str, 27);
						echo '<!-- BORRADOS CORRECTAMENTE LOS MAILS REBOTADOS -->'; //Esto saldrá como un comentario html
				    	$this->load->model('Model_mail_rebote');
				    	$resultado = $this->Model_mail_rebote->eliminarRebote($str);
				    	$this->Model_mail_rebote->notificacionRebote($resultado['cuerpo'],$resultado['rut']);
					}
				}
				if ($inbox) { //Evita que si hay un fail, salgan más fails
					imap_close($inbox);
				}
								//exec("c:\\".$ruta);
								//shell_exec($ruta . "> /dev/null 2>/dev/null &");
								//echo ' Ejecutando '.$ruta;
			}
			/*con antiguo
			$ejecutable_php = C:\\wamp\\bin\\php\\php5.4.3\\php
			for ($i = 0; $i < $cantidadCronJobs; $i=$i+1) {
				$ruta = $cronJobs[$i]->rutaPhp;
				if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
					//echo 'Es windows ';
					$toExec = 'start /b $ejecutable_php c:\\wamp\\scripts\\'.$ruta;
					//echo $toExec;
					$ppointer = popen($toExec, 'r');
				} else {
					$ppointer = popen('php ~/scripts/'.$ruta.' > /dev/null &', 'r');
				}
				pclose($ppointer);
				//exec("c:\\".$ruta);
				//shell_exec($ruta . "> /dev/null 2>/dev/null &");
				//echo ' Ejecutando '.$ruta;
			}*/
		}
		catch (Exception $e) {
			echo '<!-- Ha ocurrido un error al ejecutar un cronjob, revise que la ruta sea correcta -->';
		}

	}
	
	protected function setTimeZone() {
		date_default_timezone_set("Chile/Continental");
	}
}