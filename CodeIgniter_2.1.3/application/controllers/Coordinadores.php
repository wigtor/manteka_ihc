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
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		$this->load->model('model_coordinadores');
		$ListaObjetosCoordinadores = $this->model_coordinadores->ObtenerTodosCoordinadores();
		
		$resultados = [];
		foreach ($ListaObjetosCoordinadores as $coordinador ) {
			$array_modulos = $this->model_coordinadores->GetModulos($coordinador['id']);
			$coordinador['modulos'] = "";
			$coordinador['secciones'] = "";
			
			foreach ($array_modulos as $mod) {
				$array_secciones = $this->model_coordinadores->GetSeccion($mod['COD_MODULO_TEM']);
				foreach ($array_secciones as $sec) {
					if($coordinador['secciones']=="")
						$coordinador['secciones']= $sec['COD_SECCION'];
					else
						$coordinador['secciones']= $coordinador['secciones']. " , ".$sec['COD_SECCION'];
				}

				if($coordinador['modulos']=="")
					$coordinador['modulos'] = $mod['COD_MODULO_TEM'];
				else
					$coordinador['modulos'] = $coordinador['modulos'] ." , ". $mod['COD_MODULO_TEM'];
			}
			
			array_push($resultados, $coordinador);
		}
		
		
		
		$datos_plantilla['listado_coordinadores'] = $resultados;
		

		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_coordinadores_ver', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
		$this->load->view('templates/template_general', $datos_plantilla);
	}
    
    public function agregarCoordinadores()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('model_coordinadores');
			$this->model_coordinadores->agregarCoordinador($_POST['nombre'],$_POST['rut'],$_POST['contrasena'],$_POST['correo1'],$_POST['correo2'],$_POST['fono']);
			$datos_plantilla["titulo_msj"] = "Coordinador agregado";
			$datos_plantilla["cuerpo_msj"] = "El nuevo coordinador fue agregado correctamente.";
			$datos_plantilla["tipo_msj"] = "success-error";
			$datos_plantilla["redirecTo"] = 'Coordinadores/agregarCoordinadores';
			$datos_plantilla["nombre_redirecTo"] = "Agregar Coordinador";
			$datos_plantilla["redirectAuto"] = TRUE;
			$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
			
		}
		else{
			$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

			//si el metodo es post se recibe el formulario
			
			$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_coordinadores_crear', $datos_plantilla, true); //Esta es la linea que cambia por cada controlador
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
			$this->load->view('templates/template_general', $datos_plantilla);
		}

		
    }
    
    public function modificarCoordinadores()
    {
    	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";		
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('model_coordinadores');
			
            //$this->model_coordinadores->modificarCoordinador($nombreActual,$rutActual,$nombreNuevo,$rutNuevo,$correo1Nuevo,$correo2Nuevo,$telefonoNuevo,$idNuevo,$tipoNuevo);
			if($_POST['contrasena']){
				$this->model_coordinadores->modificarPassword($_POST['id'],$_POST['contrasena']);
			}
			$this->model_coordinadores->modificarCoordinador($_POST['id'],$_POST['nombre'],$_POST['correo1'],$_POST['correo2'],$_POST['fono']);
			$datos_plantilla["titulo_msj"] = "Coordinador modificado";
			$datos_plantilla["cuerpo_msj"] = "El coordinador fue modificado correctamente.";
			$datos_plantilla["tipo_msj"] = "success-error";
			$datos_plantilla["redirecTo"] = 'Coordinadores/modificarCoordinadores';
			$datos_plantilla["nombre_redirecTo"] = "Modificar Coordinador";
			$datos_plantilla["redirectAuto"] = TRUE;
			$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
			
		}else{
			$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
			$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

			$this->load->model('model_coordinadores');
			$datos_cuerpo_central['listado_coordinadores'] = $this->model_coordinadores->ObtenerTodosCoordinadores();

			$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_coordinadores_modificar', $datos_cuerpo_central, true); //Esta es la linea que cambia por cada controlador
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
			$this->load->view('templates/template_general', $datos_plantilla);
		}
		
    }

    public function borrarCoordinadores()
    {
    	   	$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('model_coordinadores');
			$this->model_coordinadores->borrarCoordinadores(explode(',', str_replace('id','',$_POST['lista_eliminar'])));
			$datos_plantilla["titulo_msj"] = "Coordinador(es) eliminados(s)";
			$datos_plantilla["cuerpo_msj"] = "El(Los) coordinador(es) fueron eliminados correctamente.";
			$datos_plantilla["tipo_msj"] = "success-error";
			$datos_plantilla["redirecTo"] = 'Coordinadores/borrarCoordinadores';
			$datos_plantilla["nombre_redirecTo"] = "Eliminar Coordinador";
			$datos_plantilla["redirectAuto"] = FALSE;
			$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);
			
		}else{
			$datos_plantilla["menuSuperiorAbierto"] = "Docentes";
			$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
			$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
			$datos_plantilla["mostrarBarraProgreso"] = FALSE; //Cambiar en caso que no se necesite la barra de progreso
			$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
			$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

			$this->load->model('model_coordinadores');
			$datos_cuerpo_central['listado_coordinadores'] = $this->model_coordinadores->ObtenerTodosCoordinadores();
			
			$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_coordinadores_eliminar', $datos_cuerpo_central, true); //Esta es la linea que cambia por cada controlador
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_profesores', '', true); //Esta linea también cambia según la vista como la anterior
			$this->load->view('templates/template_general', $datos_plantilla);
		}
		
		
    }


}

/* End of file Correo.php */
/* Location: ./application/controllers/Correo.php */