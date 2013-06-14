<?php

/**
 * El presente archivo corresponde al controlador asociado a la gestión de las plantillas del sistema Manteka.
 *
 * @package Manteka
 * @subpackage Controladores
 * @author Diego García (DGM)
**/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'controllers/Master.php';

/**
 * Esta clase implementa los métodos que permiten la gestión de las plantillas en el sistema Manteka.
 *
 * @package Manteka
 * @subpackage Controladores
 * @author Diego García (DGM)
 **/
class Plantillas extends MasterManteka
{
   /**
    * Carga los elementos de Codeigniter necesarios para la validación de formularios.
    * 
    * Para facilitar la validación de los formularios relacionados con el CRUD de las plantillas
	* se carga el helper de formularios y la librería para validarlos.
    * 
    * @author Diego García (DGM)
    **/
	public function __construct()
	{
		parent::__construct();
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
    }
	
   /**
    * Muestra la vista para agregar plantillas, valida el formulario para la creación de plantillas y a través del modelo
	* respectivo, agrega plantillas al sistema.
    * 
    * Si el formulario para la creación de plantillas no ha sido enviado, sólo se muestra la vista para agregar plantillas.
	* En caso contrario primero se valida el formulario y si la validación es correcta se envian los datos al modelo para
	* crear la plantilla. Luego independientemente del resultado de la validación, se muestra la vista para agregar plantillas
    * indicando el resultado de las operaciones efectuadas.	
	*
    * @author Diego García (DGM)
	* @param int | array $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista,
	*   					  según el resultado de las validaciones y de las operaciones efectuadas por el controlador.
	*   					  También se utiliza para devolver a la vista los valores del formulario enviado, cuando
	*   					  la validación del formulario no es exitosa.
	*						  Si el formulario de la vista para agregar plantillas no ha sido enviado, entonces este parámetro
	*						  toma su valor por defecto que es null.
    **/
	public function agregarPlantillas($msj=null)
	{
		/* Si el formulario para agregar plantillas no ha sido enviado entonces sólo se muestra la vista para agregar plantillas al sistema. */
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
		/* Si el formulario ha sido enviado, se realizan las validaciones de este. */
		else
		{
			$this->form_validation->set_rules('txtNombrePlantilla', '"Nombre de la plantilla"', 'required|is_unique[PLANTILLA.NOMBRE_PLANTILLA]');
			$this->form_validation->set_rules('txtAsunto', '"Asunto"', 'required');
			$this->form_validation->set_rules('editor', '"Cuerpo del mensaje"', 'required');
			$this->form_validation->set_message('is_unique', 'Ya existe una plantilla con el nombre especificado. Utilice otro nombre.');
			$msj=array();
			/* Si la validación es incorrecta, entonces se obtienen los valores del formulario enviado para enviarlos de vuelta al formulario, indicando
			además el motivo del fracaso de la validación. */
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
				/* Si la validación es exitosa, se crea la plantilla en la base de datos a través del modelo de plantillas. */
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
						/* Si hay un error en la inserción de la plantilla en la base de datos, se obtienen los valores del formulario enviado para enviarlos de vuelta al formulario, indicando
						además el error producido. */
						$msj[0]=2;
						$msj[1]=$_POST['txtNombrePlantilla'];
						$msj[2]=$_POST['txtAsunto'];
						$msj[3]=html_entity_decode($_POST['editor']);
					}
				}
				/* Si hay un error en la conexión a la base de datos se obtienen los valores del formulario enviado para enviarlos de vuelta al formulario, indicando
				además el error producido. */
				catch(Exception $e)
				{
					$msj[0]=2;
					$msj[1]=$_POST['txtNombrePlantilla'];
					$msj[2]=$_POST['txtAsunto'];
					$msj[3]=html_entity_decode($_POST['editor']);
				}
			}
			/* Se muestra la vista para agregar plantillas al sistema. */
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
	
   /**
    * Muestra la vista para editar plantillas, valida el formulario para la edición de plantillas y a través del modelo
	* respectivo, actualiza las plantillas en la base de datos.
    * 
    * Si el formulario para la actualización de plantillas no ha sido enviado, sólo se muestra la vista para actualizar plantillas.
	* En caso contrario primero se valida el formulario y si la validación es correcta se envian los datos al modelo para
	* actualizar la plantilla. Luego independientemente del resultado de la validación, se muestra la vista para actualizar plantillas
    * indicando el resultado de las operaciones efectuadas.	
	*
    * @author Diego García (DGM)
	* @param int | array $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista,
	*   					  según el resultado de las validaciones y de las operaciones efectuadas por el controlador.
	*   					  También se utiliza para devolver a la vista los valores del formulario enviado, cuando
	*   					  la validación del formulario no es exitosa.
	*						  Si el formulario de la vista para editar plantillas no ha sido enviado, entonces este parámetro
	*						  toma su valor por defecto que es null.
    **/
	public function editarPlantillas($msj=null)
	{
		/* Si el formulario para actualizar plantillas ha sido enviado, entonces se procede a su validación y si la validación es correcta
		a través del modelo, se actualiza la plantilla en la base de datos.*/
		if(isset($_POST['idPlantilla']) && isset($_POST['nombrePlantilla']) && isset($_POST['asunto'])  && isset($_POST['editor']))
		{
			$this->form_validation->set_rules('nombrePlantilla', '"Nombre de la plantilla"', 'required');
			$this->form_validation->set_rules('asunto', '"Asunto"', 'required');
			$this->form_validation->set_rules('editor', '"Cuerpo del mensaje"', 'required');
			$this->load->model('model_plantilla');
			$resultado=true;
			/* Se valida que el nuevo nombre asignado a la plantilla no exista en el sistema. */
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
					/* Si la validación del formulario es exitosa, se intenta actualizar la plantilla en la base de datos. */
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
				/* Si la actualización falla, se obtienen los valores del formulario enviado para enviarlos de vuelta al formulario, indicando
				además el error producido. */
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
		/* Se muestra la vista para editar (actualizar) plantillas en el sistema. */
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
	
   /**
    * Muestra la vista para eliminar plantillas y envía la clave primaria de una plantilla al modelo, para eliminarla cuando ha
	* sido seleccionada en la vista de eliminación de plantillas.
    * 
    * Si no se ha enviado una plantilla para su eliminación, solamente se muestra la vista la para la eliminación de plantillas.
	* En caso contrario se intenta la eliminación de la plantilla y luego se muestra la vista de elimianación de plantillas
	* indicando el resultado obtenido.
	*
    * @author Diego García (DGM)
	* @param int $msj Variable utilizada para el paso de mensajes de éxito o error entre el controlador y la vista.
    **/
	public function borrarPlantillas($msj=null)
	{
		/* Si se ha seleccionado una plantilla para eliminar, se procede a su eliminación. */
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
		/* Se muestra la vista para eliminar plantillas. */
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