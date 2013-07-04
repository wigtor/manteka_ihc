<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupo extends CI_Controller {
	

	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->verGrupoContactos();
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
	public function getContactosGrupoFlacoPiterStyle(){
		$id_grupo = $this->input->post('id');
		$this->load->model('model_grupos_contacto');
		$resultado = $this->model_grupos_contacto->getContactosGrupoFlacoPiterStyle($id_grupo);
		echo json_encode($resultado);
	}
	
	
	
	
	
}
/* End of file Grupo.php */
/* Location: ./application/controllers/Grupo.php */