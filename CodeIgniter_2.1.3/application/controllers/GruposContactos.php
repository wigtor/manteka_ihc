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
	
	public function index() {
		$this->verGrupoContactos();
	}


	public function verGrupos() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'verGrupos'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_grupo_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function agregarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'agregarGrupoContacto'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_grupos_agregar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function postAgregarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_grupo_contacto');
			$rut = $this->session->userdata('rut');
			$str = $_POST['NOMBRE_FILTRO_CONTACTO'].$_POST['QUERY_FILTRO_CONTACTO'];
			$nombre_filtro = $_POST['NOMBRE_FILTRO_CONTACTO'];
			$rut_filtro = $_POST['QUERY_FILTRO_CONTACTO'];
			$rut_usuario = $rut;
			
			$confirmacion = $this->Model_grupo_contacto->agregarGrupoContacto($rut_usuario, $rut_filtro, $nombre_filtro);
			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ingresado el grupo de contacto con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirecTo"] = 'GruposContactos/agregarGrupoContacto';
			$datos_plantilla["nombre_redirecTo"] = "Agregar Grupo de Contactos";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function editarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'editarGrupoContacto'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_grupo_modificar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function postEditarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_grupo_contacto');
			$id_grupo = $this->input->post('id_grupo');
			$query_filtro = $this->input->post('query_filtro');
			$rut_usuario = $this->session->userdata('rut');
			$confirmacion = $this->Model_grupo_contacto->editarGrupoContacto($rut_usuario, $id_grupo, $query_filtro);
			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha modificado el grupo de contacto con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirecTo"] = 'GruposContactos/editarGrupoContacto';
			$datos_plantilla["nombre_redirecTo"] = "Editar Grupo de Contactos";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function eliminarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'eliminarGrupoContacto'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_grupos_eliminar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}


	public function postEliminarGrupoContacto() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->model('Model_grupo_contacto');
			$rut_usuario = $this->session->userdata('rut');
			$id_grupo = $this->input->post('id_grupo');
			$confirmacion = $this->Model_grupo_contacto->eliminarGrupo($rut_usuario, $id_grupo);
			// mostramos el mensaje de operacion realizada
			if ($confirmacion == TRUE) {
				$datos_plantilla["titulo_msj"] = "Accion Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha eliminado el grupo de contacto con éxito";
				$datos_plantilla["tipo_msj"] = "alert-success";
			}
			else {
				$datos_plantilla["titulo_msj"] = "Accion No Realizada";
				$datos_plantilla["cuerpo_msj"] = "Se ha ocurrido un error en el ingreso a la base de datos";
				$datos_plantilla["tipo_msj"] = "alert-error";	
			}
			$datos_plantilla["redirecTo"] = 'GruposContactos/editarGrupoContacto';
			$datos_plantilla["nombre_redirecTo"] = "Editar Grupo de Contactos";
			$datos_plantilla["redirectAuto"] = TRUE;
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarMsjLogueado($datos_plantilla, $tipos_usuarios_permitidos);
		}
	}


	public function getDatosGrupo(){
		//Se comprueba que quien hace esta petici�n de ajax est� logueado
		if (!$this->isLogged()) {
			//echo 'No est�s logueado!!';
			return;
		}
		
		$id_grupo = $this->input->post('id');
		$this->load->model('Model_grupo_contacto');
		$resultado = $this->Model_grupo_contacto->getDatosGrupo($id_grupo);
		echo json_encode($resultado);
	}


    public function getGrupos(){
		//
		$this->load->model('Model_grupo_contacto');
		$rut = $this->session->userdata['rut'];
		$respuesta = $this->Model_grupo_contacto->VerGrupos($rut);
		echo json_encode($respuesta);

	}

}
/* End of file Grupo.php */
/* Location: ./application/controllers/Grupo.php */
