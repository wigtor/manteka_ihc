<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

/**
* Controlador para la administración básica de correos electrónicos.
*
* Permite ver y eliminar los correos recibidos, así como también
* gestionar el envío de emails y otras operaciones relacionadas con la
* administración de correos electrónicos. 
*
* @package Correo
* @author Grupo 3
*
*/
class GruposContactos extends MasterManteka {
	

	public function agregarGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		$this->load->model('Model_ayudante');
		$this->load->model('Model_usuario');
		$datos_cuerpo = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
 							 'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());
		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'agregarGrupos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_grupos_agregar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);


	}
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verGrupoContactos();
	}
	
	public function editarGrupoContacto(){
		$this->load->model('model_grupos_contacto');
		//Este sirve para el modificar
		$this->model_grupos_contacto->modificarGrupo($_POST['ID_GRUPO'], $_POST['QUERY_FILTRO_CONTACTO']);
	}
	public function agregarGrupo(){
		$this->load->model('model_grupos_contacto');
		$rut = $this->session->userdata('rut');
		$str = $_POST['NOMBRE_FILTRO_CONTACTO'].$_POST['QUERY_FILTRO_CONTACTO'];
		$nombre_filtro = $_POST['NOMBRE_FILTRO_CONTACTO'];
		$rut_filtro = $_POST['QUERY_FILTRO_CONTACTO'];
		$rut_usuario = $rut;
		
		//Este sirve para el modificar
		//$arreglo_de_ruts=explode(",",$rut_filtro);
		
		$this->model_grupos_contacto->insertarGrupo($rut_usuario,$rut_filtro,$nombre_filtro);
	}
	
	
	
	
	
	public function editarGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesión iniciada
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model('Model_estudiante');
			$this->load->model('Model_profesor');
			$this->load->model('Model_ayudante');
			$this->load->model('Model_usuario');
			$this->load->model('model_grupos_contacto');
			$idGrupo = $this->input->post('id_grupo');;
			if ($idGrupo) {
				$grupo = $this->model_grupos_contacto->getGrupo($idGrupo);
				//var_dump($grupo[0]['ID_FILTRO_CONTACTO']);	
				
				$datos_cuerpo = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
								 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
	 							 'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes(),
								 'rutes' => $grupo[0]
								 );
				$cuerpo_to_charge = "cuerpo_grupo_modificar_2";
			}
			else {
				$datos_cuerpo = array('rs_nombres_contacto' =>$this->model_grupos_contacto->VerGrupos($rut));
				$cuerpo_to_charge = "cuerpo_grupo_modificar";
			}
			
							 
			/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
			* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
			*/
			//var_dump($datos_cuerpo['rs_profesores']);
			$subMenuLateralAbierto = 'editarGrupos'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
			$this->cargarTodo("Correos", $cuerpo_to_charge, "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
		else{
	
		$this->load->model('model_grupos_contacto');
		$datos_cuerpo = array('rs_nombres_contacto' =>$this->model_grupos_contacto->VerGrupos($rut));
		$subMenuLateralAbierto = 'editarGrupos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
			$this->cargarTodo("Correos", "cuerpo_grupo_modificar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		
		
		
		
		}


}
}
/* End of file Grupo.php */
/* Location: ./application/controllers/Grupo.php */