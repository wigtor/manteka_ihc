<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correo extends CI_Controller {
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


	public function correosRecibidos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		//Ac? ponen la l?gica de su controlador, cargan el modelo, consultan a la base de datos, envian los correos, etc
		
		
		
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "correosRecibidos"; //Usen el mismo nombre del método desde que es llamado (el método actual)
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	public function correosEnviados()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}

		//cargo el modelo del correo
		$this->load->model('model_correo');
		$datos=array('listaEnviados'=>$this->model_correo->VerCorreosUser($rut), 'msj'=>$msj);
		
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviados_ver', $datos, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "correosEnviados"; //Usen el mismo nombre del método desde que es llamado (el método actual)
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	
		
	}

	public function eliminarCorreo($correo)
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		if(isset($_POST['seleccion']))
		{
			$temp=$_POST['seleccion'];
			$correos = explode(";",$temp);
			$this->load->model('model_correo');
			$this->model_correo->EliminarCorreo($correos);
			if(isset($estado))
				unset($estado);
			$estado="1";
			redirect('/Correo/correosEnviados/'.$estado);
		}
		else
		{
			if(isset($estado))
				unset($estado);
			$estado="0";
			redirect('/Correo/correosEnviados/'.$estado);
		}	
	}


public function enviarCorreo()
{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}

		//cargo el modelo del correo

		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');

		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		//$this->load->model('Model_ayudante');

		$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
							 /*'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes()*/);


		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviar' , $datos_vista, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "enviarCorreo"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);



	}
	public function cargarTabla() {
		$tipo = $this->input->get('tipo');
		if($tipo==1){
			$this->load->model('Model_estudiante');	
			$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes());
			$this->load->view('templates/tabla_tipo_destinatario', $datos_vista);
		}

		$this->load->model('Model_profesor');
		$this->load->model('Model_ayudante');

		$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
							 'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());

		$this->load->view('templates/tabla_tipo_destinatario', $datos_vista);
	}
	public function verBorradores()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
		redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
				$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
				$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		//Ac? ponen la l?gica de su controlador, cargan el modelo, consultan a la base de datos, envian los correos, etc
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_borradores_ver', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "verBorradores"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	}


	public function enviarPost() {

		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		$this->load->model('model_correo');
		$this->load->model('model_correoE');



		$to = $this->input->post('to');
		$asunto =$this->input->post('asunto');
		$mensaje =$this->input->post('editor');
		$tipo=$this->input->post('tipo');
		$rutRecept=$this->input->post('rutRecept');
		$date=date("mdHis");

	

	try {
		
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from('no-reply@manteka.cl', 'ManteKA');
			$this->email->to($to);
			$this->email->subject($asunto);
			$this->email->message($mensaje);

			if(!$this->email->send())
				throw new Exception("error en el envio");

			$this->model_correo->InsertarCorreo($asunto,$mensaje,$rut,$tipo,$date);
			if($tipo=='CARTA_ESTUDIANTE')
				$this->model_correoE->InsertarCorreoE($rutRecept,$date);
			else if($tipo=='CARTA_USER')
				$this->model_correoU->InsertarCorreoU($rutRecept,$date);
			else if($tipo=='CARTA_AYUDANTE')
				$this->model_correoU->InsertarCorreoA($rutRecept,$date);
			;
			
		}
		catch (Exception $e) {
			if($e->getMessage()=="error en el envio")
				redirect("/Otros/sendMailError", "sendMailError");
			else
				redirect("/Otros", "databaseError");
		}
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "enviarCorreo"; //Usen el mismo nombre de la sección donde debe estar
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);

	}

	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->correosRecibidos();	
	}


	/**
	* Método que carga la vista principal de un profesor
	* 
	* Por ahora no hay nada implementado en la parte de lo que puede hacer un profesor,
	* solo se ha hecho esto para mostrar que existe un login diferenciado por ahora
	*/
	public function indexProfesor() //Esto hace que el index sea la vista que se desee
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi?n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi?n iniciada
		}

		//cargo el modelo del correo
		$this->load->model('model_correo');
		$datos = array('correos' => $this->model_correo->VerCorreosUser($rut));
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior_profesor', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviados_ver', $datos, true); //Esta es la linea que cambia por cada controlador
		//Ahora se especifica que vista está abierta para mostrar correctamente el menu lateral
		$datos_plantilla["subVistaLateralAbierta"] = "correosEnviados"; //Usen el mismo nombre del método desde que es llamado (el método actual)
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true); //Esta linea tambi?n cambia seg?n la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);	
	}
}




/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */