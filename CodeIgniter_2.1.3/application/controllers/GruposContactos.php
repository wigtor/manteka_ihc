<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

/**
* Controlador para la administraci�n b�sica de correos electr�nicos.
*
* Permite ver y eliminar los correos recibidos, as� como tambi�n
* gestionar el env�o de emails y otras operaciones relacionadas con la
* administraci�n de correos electr�nicos. 
*
* @package Correo
* @author Grupo 3
*
*/
class GruposContactos extends MasterManteka {
	

	public function agregarGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi�n iniciada
		}
		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		$this->load->model('Model_ayudante');
		$this->load->model('Model_usuario');
		$datos_cuerpo = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
 							 'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());
		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como par�metro al m�todo cargarTodo()
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

		$datos_plantilla["titulo_msj"] = "Grupo modificado";
		$datos_plantilla["cuerpo_msj"] = "El Grupo de Contactos fue modificado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'GruposContactos/editarGrupos';
		$datos_plantilla["nombre_redirecTo"] = "Editar Grupo de Contactos";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); 
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);		
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

		$datos_plantilla["titulo_msj"] = "Grupo agregado";
		$datos_plantilla["cuerpo_msj"] = "El nuevo Grupo de Contactos fue agregado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'GruposContactos/agregarGrupos';
		$datos_plantilla["nombre_redirecTo"] = "Agregar Grupo de Contactos";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); 
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
	
	
	
	
	
	public function editarGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi�n iniciada
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
								 'rutes' => $grupo[0],
								 'id_grupo' => $idGrupo
								 );
				$cuerpo_to_charge = "cuerpo_grupo_modificar_2";
			}
			else {
				$datos_cuerpo = array('rs_nombres_contacto' =>$this->model_grupos_contacto->VerGrupos($rut));
				$cuerpo_to_charge = "cuerpo_grupo_modificar";
			}
			
							 
			/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
			* se deben introducir en un array, para luego pasarlo como par�metro al m�todo cargarTodo()
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

	public function getDatosGrupo(){
		//Se comprueba que quien hace esta petici�n de ajax est� logueado
		if (!$this->isLogged()) {
			//echo 'No est�s logueado!!';
			return;
		}
		
		$id_grupo = $this->input->post('id');
		$this->load->model('model_grupos_contacto');
		$resultado = $this->model_grupos_contacto->getDatosGrupo($id_grupo);
		echo json_encode($resultado);
	}
	public function eliminarGrupo(){
		//Se comprueba que quien hace esta petici�n de ajax est� logueado
		if (!$this->isLogged()) {
			return;
		}
		$id_grupo = $this->input->post('id');
		$this->load->model('model_grupos_contacto');
		$resultado = $this->model_grupos_contacto->eliminarGrupo($id_grupo);
		echo json_encode($resultado);
	}
	

	public function verGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi�n iniciada
		}
		$this->load->model('model_grupos_contacto');
		$datos_cuerpo = array('rs_nombres_contacto' =>$this->model_grupos_contacto->VerGrupos($rut));
		$subMenuLateralAbierto = 'verGrupos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_grupo_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	public function borrarGrupos()
	{
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi�n iniciada
		}
		$this->load->model('model_grupos_contacto');
		$datos_cuerpo = array('rs_nombres_contacto' =>$this->model_grupos_contacto->VerGrupos($rut));
		$subMenuLateralAbierto = 'borrarGrupos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_grupos_eliminar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	public function grupoAgregado(){
		$rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesi�n iniciada
		if ($rut == FALSE) {
			redirect('/Login/', ''); //Se redirecciona a login si no tiene sesi�n iniciada
		}
		$datos_plantilla["titulo_msj"] = "Grupo agregado";
		$datos_plantilla["cuerpo_msj"] = "El nuevo Grupo de Contactos fue agregado correctamente.";
		$datos_plantilla["tipo_msj"] = "alert-success";
		$datos_plantilla["redirecTo"] = 'GruposContactos/agregarGrupos';
		$datos_plantilla["nombre_redirecTo"] = "Agregar Grupo de Contactos";
		$datos_plantilla["redirectAuto"] = TRUE;
		$tipos_usuarios_permitidos = array(); 
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
	}
    public function getGrupos(){
		//
		$this->load->model('model_grupos_contacto');
		$rut = $this->session->userdata['rut'];
		$respuesta = $this->model_grupos_contacto->VerGrupos($rut);
		echo json_encode($respuesta);

	}

}
/* End of file Grupo.php */
/* Location: ./application/controllers/Grupo.php */
