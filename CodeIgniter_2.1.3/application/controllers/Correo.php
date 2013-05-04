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
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
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
		
		//Acá ponen la lógica de su controlador, cargan el modelo, consultan a la base de datos, envian los correos, etc
		
		
		
		
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

	public function correosEnviados()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}

		//cargo el modelo del correo
		$this->load->model('model_correo');
		$datos = array('correos' => $this->model_correo->VerCorreosUser($rut));
		
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
		
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviados_ver', $datos, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	
		
	}

public function enviarCorreo()
{
$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
if ($rut == FALSE) {
redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
}

//cargo el modelo del correo

$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
$datos_plantilla["title"] = "ManteKA";
$datos_plantilla["menuSuperiorAbierto"] = "Correos";
$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
$datos_plantilla["mostrarBarraProgreso"] = true; //Cambiar en caso que no se necesite la barra de progreso
$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

$this->load->model('Model_estudiante');
//$this->load->model('Model_profesor');
//$this->load->model('Model_ayudante');

$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes());
//$datos_vista = array('rs_profesores' => $this->Model_profesor->VerTodosLosProfesores());
//$datos_vista = array('rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());



$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviar' , $datos_vista, true); //Esta es la linea que cambia por cada controlador
$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', '', true); //Esta linea también cambia según la vista como la anterior
$this->load->view('templates/template_general', $datos_plantilla);


}
public function verBorradores()
{
$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
if ($rut == FALSE) {
redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
}
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

//Acá ponen la lógica de su controlador, cargan el modelo, consultan a la base de datos, envian los correos, etc
$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_borradores_ver', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', '', true); //Esta linea también cambia según la vista como la anterior
$this->load->view('templates/template_general', $datos_plantilla);

}


public function enviarPost(){

	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
	if ($rut == FALSE) {
		redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
	}
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

	$this->load->model('model_correo');
	$this->load->model('model_correoE');

	$datos['correos']=$this->model_correo->todos();

	$to = $this->input->post('to');
	$asunto =$this->input->post('asunto');
	$mensaje =$this->input->post('editor');
	$tipo=$this->input->post('tipo');
	$rutRecept=$this->input->post('rutRecept');

	

	try {
			$this->email->from('no-reply@manteka.cl', 'ManteKA');
			$this->email->to($to);
			$this->email->subject($asunto);
			$this->email->message($mensaje);
			$config['protocol'] = 'mail';

			$this->email->send();
			$this->model_correo->InsertarCorreo($asunto,$mensaje,$rut,$tipo);

			if($tipo=='CARTA_ESTUDIANTE')
				$this->model_correoE->InsertarCorreoE($rutRecept);
			else if($tipo=='CARTA_USER')
				$this->model_correoU->InsertarCorreoU($rutRecept);
			else if($tipo=='CARTA_AYUDANTE')
				$this->model_correoU->InsertarCorreoA($rutRecept);
			;
			
		}
		catch (Exception $e) {
			
		}
	$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
	$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', '', true); //Esta linea también cambia según la vista como la anterior
	$this->load->view('templates/template_general', $datos_plantilla);

}

public function index() //Esto hace que el index sea la vista que se desee
{
$this->correosRecibidos();	
}
}




/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */