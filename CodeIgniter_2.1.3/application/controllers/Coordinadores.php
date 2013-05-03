<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coordinadores extends CI_Controller {
	
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
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verCoordinadores();
	}

	public function verCoordinadores()
	{
		//$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		//if ($rut == FALSE) {
		//	redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		//}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = TRUE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		$this->load->model('model_coordinadores');
		$ListaObjetosCoordinaciones = $this->model_coordinadores->ObtenerTodosCoordinadores();
		$contador = 0;
		$resultados = array();
		/*$resultados = array{ => array{
			'nombre'=>,
			'rut'=>,
			'e-mail_1'=>,
			'e-mail_2'=>,
			'telefono'=>,
			'tipo'=>,
			'id'=>,
			}
			
		}*/
		foreach ($ListaObjetosCoordinaciones as $row) {
			$resultados[$contador] = array(
				'nombre'=> $row->COORD_NOMBRE,
				'rut'=> $row->RUT_USUARIO,
				'e-mail_1'=> $row->CORREO1_USER,
				'e-mail_2'=> $row->CORREO2_USER,
				'telefono'=> $row->COORD_TELEFONO,
				'tipo'=> $row->ID_TIPO,
				'id'=> $row->ID_COORD,
			);
			$contador++;
		}
		$datos_plantilla['resultados'] = $resultados;






		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_coordinadores_ver', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	}
    
    public function crearCoordinacion()
    {
    	//
    }
    
    public function modificarCoordinacion()
    {
    	//
    }

    public function eliminarCoordinacion()
    {
    	//
    }


}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */