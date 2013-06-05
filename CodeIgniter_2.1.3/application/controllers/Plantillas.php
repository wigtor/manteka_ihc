<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php';

class Plantillas extends MasterManteka
{
	public function __construct()
	{
		parent::__construct();
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
    }
	
	public function agregarPlantillas($msj=null)
	{
		if(!isset($_POST['txtNombrePlantilla']) && !isset($_POST['txtAsunto']) && !isset($_POST['editor']))
		{
			$rut=$this->session->userdata('rut');
			$datos_cuerpo=array('msj'=>$msj);
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
			$subMenuLateralAbierto = 'agregarPlantillas';
			$muestraBarraProgreso = false;
			$this->cargarTodo("Plantillas", "cuerpo_plantillas_agregar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
		else
		{
			$this->form_validation->set_rules('txtNombrePlantilla', '"Nombre de la plantilla"', 'required|is_unique[PLANTILLA.NOMBRE_PLANTILLA]');
			$this->form_validation->set_rules('txtAsunto', '"Asunto"', 'required');
			$this->form_validation->set_rules('editor', '"Cuerpo del mensaje"', 'required');
			$this->form_validation->set_message('is_unique', 'Ya existe una plantilla con el nombre especificado. Utilice otro nombre.');
			$msj=array();
			if ($this->form_validation->run()==false)
			{
				$msj[0]=0;
				$msj[1]=$_POST['txtNombrePlantilla'];
				$msj[2]=$_POST['txtAsunto'];
				$ejemplo='<p><span style="color:#FF0000"><strong><u>Ejemplo de plantilla:</u></strong></span><br /><br />Estimado %%nombre<br /><br />Te informamos que hoy %%fecha se han suspendido las clases del profesor %%profesor, <span style="color:#666666; font-size:12pt"><strong>debido a motivos de fuerza mayor.</strong></span><br /><br /><span style="color:lightblue">Cordialmente<br />Coordinador %%remitente </span></p>';
				$temp=html_entity_decode($_POST['editor']);
				if(strcmp($temp,$ejemplo)!=0)
					$msj[3]=html_entity_decode($_POST['editor']);
			}
			else
			{
				try
				{
					$nombre = $this->input->post("txtNombrePlantilla");
					$asunto = $this->input->post("txtAsunto");
					$cuerpo = $this->input->post("editor");
					$this->load->model('model_plantilla');
					$resultado=$this->model_plantilla->InsertarPlantilla($nombre, $asunto, $cuerpo);
					if($resultado==1)
					{
						$msj[0]=1;
						$msj[1]='';
						$msj[2]='';
					}
					else
					{
						$msj[0]=2;
						$msj[1]=$_POST['txtNombrePlantilla'];
						$msj[2]=$_POST['txtAsunto'];
						$msj[3]=html_entity_decode($_POST['editor']);
					}
				}
				catch(Exception $e)
				{
					$msj[0]=2;
					$msj[1]=$_POST['txtNombrePlantilla'];
					$msj[2]=$_POST['txtAsunto'];
					$msj[3]=html_entity_decode($_POST['editor']);
				}
			}
			$rut=$this->session->userdata('rut');
			$this->load->model('model_plantilla');
			$datos_cuerpo = array('msj'=>$msj);
			$tipos_usuarios_permitidos = array();
			$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
			$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
			$subMenuLateralAbierto = 'agregarPlantillas';
			$muestraBarraProgreso = false;
			$this->cargarTodo("Plantillas", "cuerpo_plantillas_agregar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
	}
	
	public function editarPlantillas($msj=null)
	{
		if(isset($_POST['idPlantilla']) && isset($_POST['nombrePlantilla']) && isset($_POST['asunto'])  && isset($_POST['editor']))
		{
			$this->form_validation->set_rules('nombrePlantilla', '"Nombre de la plantilla"', 'required');
			$this->form_validation->set_rules('asunto', '"Asunto"', 'required');
			$this->form_validation->set_rules('editor', '"Cuerpo del mensaje"', 'required');
			$this->load->model('model_plantilla');
			$resultado=true;
			if(trim($_POST['nombrePlantilla'])!= '')
				$resultado=$this->model_plantilla->NombreUnico($_POST['idPlantilla'], $_POST['nombrePlantilla']);
			$msj=array();
			if($this->form_validation->run()==false || $resultado==false)
			{
				$msj[0]='0';
				$msj[1]=$this->input->post('idPlantilla');
				$msj[2]=$this->input->post('nombrePlantilla');
				$msj[3]=$this->input->post('asunto');
				$msj[4]=html_entity_decode($_POST['editor']);
				if($resultado==false)
					$msj[5]=$resultado;
			}
			else
			{
				try
				{
					$this->load->model('model_plantilla');
					$id_plantilla=$this->input->post('idPlantilla');
					$nombrePlantilla=$this->input->post('nombrePlantilla');
					$asunto=$this->input->post('asunto');
					$cuerpo=$this->input->post('editor');
					$resultado=$this->model_plantilla->EditarPlantilla($id_plantilla, $nombrePlantilla, $asunto, $cuerpo);
					if($resultado==1)
					{
						$msj[0]='1';
						$msj[1]='';
						$msj[2]='';
						$msj[3]='';
						$msj[4]='';
					}
					else
					{
						$msj[0]='2';
						$msj[1]=$this->input->post('idPlantilla');
						$msj[2]=$this->input->post('nombrePlantilla');
						$msj[3]=$this->input->post('asunto');
						$msj[4]=html_entity_decode($_POST['editor']);
					}
				}
				catch(Exception $e)
				{
					$msj[0]='2';
					$msj[1]=$this->input->post('idPlantilla');
					$msj[2]=$this->input->post('nombrePlantilla');
					$msj[3]=$this->input->post('asunto');
					$msj[4]=html_entity_decode($_POST['editor']);
				}
			}
		}
		$rut=$this->session->userdata('rut');
		$this->load->model('model_plantilla');
		$datos_cuerpo = array('plantillas'=>$this->model_plantilla->ObtenerListaPlantillas(), 'msj'=>$msj);
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$subMenuLateralAbierto = 'editarPlantillas';
		$muestraBarraProgreso = false;
		$this->cargarTodo("Plantillas", "cuerpo_plantillas_editar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}
	
	public function borrarPlantillas($msj=null)
	{
		if(isset($_POST['idPlantilla']))
		{
			try
			{
				$this->load->model('model_plantilla');
				$id_plantilla=$this->input->post('idPlantilla');
				$resultado=$this->model_plantilla->EliminarPlantilla($id_plantilla);
				$msj='1';
				if($resultado!=1)
					$msj='2';
			}
			catch(Exception $e)
			{
				$msj='2';
			}
		}
		$rut=$this->session->userdata('rut');
		$this->load->model('model_plantilla');
		$datos_cuerpo = array('plantillas'=>$this->model_plantilla->ObtenerListaPlantillas(), 'msj'=>$msj);
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$subMenuLateralAbierto = 'borrarPlantillas';
		$muestraBarraProgreso = false;
		$this->cargarTodo("Plantillas", "cuerpo_plantillas_borrar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);	
	}
}