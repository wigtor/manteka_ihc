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
	
	
	public function cambiarContrasegna()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
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
		$datos_plantilla["barra_lateral"] = ""; //$this->load->view('templates/barras_laterales/barra_lateral_planificacion', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	
	}
	
	public function cambiarContrasegnaPost() {
	
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('contrasegna_actual', 'Contraseña actual', 'required');
		$this->form_validation->set_rules('nva_contrasegna_rep', 'Contraseña nueva', 'required|min_length[5]|max_length[100]');
		$this->form_validation->set_rules('nva_contrasegna', 'Contraseña nueva', 'required|min_length[5]|max_length[100]');
		if ($this->form_validation->run() == FALSE)
		{
			$this->cambiarContrasegna(); //Vuelvo a llamar el cambio de contraseña si hubo un error
		}
		else
		{
			$this->load->model('model_usuario');
			$logueo = $this->model_usuario->ValidarUsuario($rut ,$_POST['contrasegna_actual']);
			$hayErrores = FALSE;
			//Compruebo si son iguales las contraseñas
			if ($_POST['nva_contrasegna'] != $_POST['nva_contrasegna_rep']) {	
				//SETEAR ERRORES
				$this->form_validation->set_message('nva_contrasegna_rep', 'Las contraseñas no coinciden');
				$hayErrores = TRUE;
			}
			
			if ($logueo) {
				if ($hayErrores) {
					$this->cambiarContrasegna(); //Vuelvo a llamar el cambio de contraseña si hubo un error
				}
				else {
					$resultado = $this->model_usuario->cambiarContrasegna($rut ,md5($_POST['nva_contrasegna']));
					redirect('/Correo/', 'index'); //Voy a la pantalla principal si se cambió correctamente la contraseña
				}
			}
			else {
				//SETEAR ERRORES
				$this->form_validation->set_message('contrasegna_actual', 'La contraseña actual es incorrecta');
				$hayErrores = TRUE;
				$this->cambiarContrasegna(); //Vuelvo a llamar el cambio de contraseña si hubo un error
			}
			
			
		}
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */