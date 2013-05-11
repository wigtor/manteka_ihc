<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
class Correo extends CI_Controller {

	/**
	* Permite visualizar la bandeja de entrada de correos.
	*
	* Permite cargar el layout y la vista correspondiente a la bandeja
	* de entrada de correos electrónicos. Es decir, permite ver los
	* correos recibidos.
	*
	* El resultado de esta función es el renderizado de la vista correspondiente
	* a la bandeja de entrada.
	*
	* @author: Byron Lanas (BL)
	*/
	public function correosRecibidos()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
			redirect('/Login/', '');
			
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver los correos
		recibidos en forma correcta. */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"]=false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true);
		$datos_plantilla["subVistaLateralAbierta"] = "correosRecibidos";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);
	}
	
	/**
	* Permite visualizar la bandeja de salida de correos.
	*
	* Permite cargar el layout y la vista correspondiente a la bandeja
	* de salida de correos electrónicos. Es decir, permite ver los
	* correos enviados.
	*
	* El resultado de esta función es el renderizado de la vista correspondiente
	* a la bandeja de salida.
	*
	* @author: Claudio Rojas (CR)
	*
	*/
	public function correosEnviados()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
			redirect('/Login/', '');
			
		/* Carga el modelo del correo y obtiene un array con todos los correos enviados y sus
		respectivos destinatarios. */
		$this->load->model('model_correo');
		$datos=array('listaEnviados'=>$this->model_correo->VerCorreosUser($rut), 'msj'=>$msj);
		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver los correos
		enviados en forma correcta. */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviados_ver', $datos, true);
		$datos_plantilla["subVistaLateralAbierta"] = "correosEnviados";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);
	}
	
	/**
	* Permite eliminar uno o varios correos de la bandeja de correos enviados.
	*
	* A través del método post se obtienen los identificadores de los correos
	* que se desean eliminar, luego se procede a la eliminación a través del
	* de la función "EliminarCorreo" del modelo de correos, y finalmente se
	* redirecciona a la vista de correos enviados, adjuntando la variable
	* "estado" para señalar si la eliminación se realizó correctamente o no
	* y mostrar así un mensaje al usuario con el resultado de la operación.
	*
	* El resultado de esta función es la eliminación de los correos señalados
	* y un redireccionamiento a la bandeja de correos enviados, indicando el
	* resultado de la operación.
	*
	* @author: Diego García (DGM) y Claudio Rojas (CR)
	*
	*/
	public function eliminarCorreo()
	{
		$rut = $this->session->userdata('rut');
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		
		/* Sólo se eliminan correos si la variable post que contiene los correos a eliminar está definida*/
		if(isset($_POST['seleccion']))
		{
			$temp=$_POST['seleccion'];
			$correos = explode(";",$temp);
			$this->load->model('model_correo');
			$this->model_correo->EliminarCorreo($correos);
			if(isset($estado))
				unset($estado);
			$estado="1";
			redirect('/Correo/correosEnviados/'.$estado);
		}
		else
		{
			if(isset($estado))
				unset($estado);
			$estado="0";
			redirect('/Correo/correosEnviados/'.$estado);
		}	
	}

	/**
	* Permite visualizar la vista para el envío de nuevos correos.
	*
	* Permite cargar el layout y la vista correspondiente al envío
	* de nuevos correos electrónicos. Para lo cual, se obtiene de
	* la lista de todos los posibles destinatarios, antes de realizar
	* el renderizado de la vista.
	*
	* El resultado de esta función es el renderizado de la vista correspondiente
	* al envío de correos nuevos, suministrando además la lista de todos los posibles
	* destinatarios, agrupados en "profesores", alumnos y ayudantes.
	*
	* @author: Byron Lanas (BL)
	*/
	public function enviarCorreo()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
			redirect('/Login/', '');
			
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver la vista
		"enviar correo nuevo" en forma correcta. */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);

		/* Se obtiene la lista de todos los posibles destinatarios (porfesores, ayudantes y estudiantes) */
		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		//$this->load->model('Model_ayudante');
		$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
							 /*'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes()*/);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviar' , $datos_vista, true);
		
		/* Se renderiza el menú lateral en relación a la vista que está abierta. */
		$datos_plantilla["subVistaLateralAbierta"] = "enviarCorreo";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);
	}
	
	/**
	* Permite listar los posibles destinatarios de un correo.
	*
	* Permite obtener la lista de estudiantes, ayudantes y profesores registrados
	* en el sistema para renderizarlos dentro de una tabla, con el fin de que
	* el usuario que envía el correo, puede seleccionar al destinatario a partir
	* de dicha tabla.
	*
	* El resultado de esta función es la obtención de una tabla con la lista de
	* todos los posibles destinatarios agrupados por categoría: estudiantes, profesores
	* y ayudantes.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function cargarTabla() 
	{
		$tipo = $this->input->get('tipo');
		/* Si el usuario es de tipo 1, se carga sólo la lista de estudiantes */
		if($tipo==1){
			$this->load->model('Model_estudiante');	
			$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes());
			$this->load->view('templates/tabla_tipo_destinatario', $datos_vista);
		}
		/* Si el usuario no es de tipo 1, se cargan la lista de estudiantes, de profesores y de ayudantes. */
		$this->load->model('Model_profesor');
		$this->load->model('Model_ayudante');
		$datos_vista = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
							 'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes());
		$this->load->view('templates/tabla_tipo_destinatario', $datos_vista);
	}
	
	/**
	* Permite visualizar la bandeja de borradores de correos.
	*
	* Permite cargar el layout y la vista correspondiente a la bandeja
	* de borradores de correos electrónicos.
	*
	* El resultado de esta función es el renderizado de la vista correspondiente
	* a la bandeja de borradores.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function verBorradores()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
		redirect('/Login/', '');
		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver la
		bandeja de borradores en forma correcta. */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_borradores_ver', $datos_plantilla, true);
		
		/* Se renderiza el menú lateral en relación a la vista que está abierta. */
		$datos_plantilla["subVistaLateralAbierta"] = "verBorradores";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);
	}

	/**
	* Permite el envío de un nuevo correo electrónico.
	*
	* Esta función es la que realiza el envio de un correo propiamente tal.
	*
	* El resultado de esta función es un nuevo correo electrónico enviado
	* y el registro de dicho correo en las tablas correspondientes.
	* O un mensaje de error, en caso de que el correo no haya podido ser
	* enviado.
	* Se obtienen mediante método post, los datos del correo a enviar,
	* asi como también, el tipo de destinatario al cual va dirijido.
	* Además se cargan los modelos necesarios para guardar el correo
	* una vez que es enviado.
	*
	* @author: Byron Lanas (BL) y Diego García (DGM)
	*
	*/
	public function enviarPost()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
			redirect('/Login/', '');
			
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver la
		vista de correo enviado (o no enviado) en forma correcta. */
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
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
		
		/* Se obtienen los datos del correo a enviar, asi como también,
		el tipo de destinatario al cual va dirijido. Además se cargan los
		modelos necesarios para guardar el correo una vez que es enviado. */
		$this->load->model('model_correo');
		$this->load->model('model_correoE');
		$to = $this->input->post('to');
		$asunto =$this->input->post('asunto');
		$mensaje =$this->input->post('editor');
		$tipo=$this->input->post('tipo');
		$rutRecept=$this->input->post('rutRecept');
		$date=date("mdHis");

		/* Se intenta el envío del correo propiamente tal.
		Si el envío es exitoso, el correo, además de ser enviado, se guarda
		en las tablas correspondientes.
		Si el envío fracasa, se muestra un mensaje de error. */
		try 
		{
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from('no-reply@manteka.cl', 'ManteKA');
			$this->email->to($to);
			$this->email->subject($asunto);
			$this->email->message($mensaje);
			if(!$this->email->send())
				throw new Exception("error en el envio");
			$this->model_correo->InsertarCorreo($asunto,$mensaje,$rut,$tipo,$date);
			if($tipo=='CARTA_ESTUDIANTE')
				$this->model_correoE->InsertarCorreoE($rutRecept,$date);
			else if($tipo=='CARTA_USER')
				$this->model_correoU->InsertarCorreoU($rutRecept,$date);
			else if($tipo=='CARTA_AYUDANTE')
				$this->model_correoU->InsertarCorreoA($rutRecept,$date);
			;
		}
		catch (Exception $e) {
			if($e->getMessage()=="error en el envio")
				redirect("/Otros/sendMailError", "sendMailError");
			else
				redirect("/Otros", "databaseError");
		}
		
		/* Se renderiza el menú lateral en relación a la vista que está abierta. */
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos', $datos_plantilla, true);
		$datos_plantilla["subVistaLateralAbierta"] = "enviarCorreo";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);
	}
	
	/**
	* Establece como función principal a la función que renderiza la vista
	* de correos recibidos. 
	*
	* Cuando se hace una llamada al controlador, sin especificar una función
	* en particular, entonces se utiliza la función "correosRecibidos". Es
	* decir acá se establece cual será la función por defecto del controlador.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function index()
	{
		$this->correosRecibidos();	
	}
	
	/**
	* Función que permite renderizar la vista principal de la administración de correos
	* con características especiales cuando el usuario es un profesor.
	* 
	* Por ahora no hay nada implementado en la parte especial de lo que puede hacer un profesor,
	* solo se ha hecho esto para mostrar que existe una vista principal diferenciada según el
	* tipo de usuario que se autentifique en el sistema.
	*/
	public function indexProfesor()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		if ($rut == false)
			redirect('/Login/', '');
			
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver la
		vista principal de profesor en forma correcta. */
		$this->load->model('model_correo');
		$datos = array('correos' => $this->model_correo->VerCorreosUser($rut));
		$datos_plantilla["rut_usuario"] = $this->session->userdata('rut');
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $this->session->userdata('tipo_usuario');
		$datos_plantilla["title"] = "ManteKA";
		$datos_plantilla["menuSuperiorAbierto"] = "Correos";
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, true);
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior_profesor', $datos_plantilla, true);
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', true);
		$datos_plantilla["mostrarBarraProgreso"] = false;
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, true);
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', true);
		$datos_plantilla["cuerpo_central"] = $this->load->view('cuerpo_correos_enviados_ver', $datos, true);
		
		/* Se renderiza el menú lateral en relación a la vista que está abierta. */
		$datos_plantilla["subVistaLateralAbierta"] = "correosEnviados";
		$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/barra_lateral_correos', $datos_plantilla, true);
		$this->load->view('templates/template_general', $datos_plantilla);	
	}
}