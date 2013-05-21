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
class Correo extends MasterManteka {

	/**
	* Permite visualizar la bandeja de entrada de correos.
	*
	* Permite cargar el layout y la vista correspondiente a la bandeja
	* de entrada de correos electrónicos. Es decir, permite ver los
	* correos recibidos.
	* El resultado de esta función es el renderizado de la vista correspondiente
	* a la bandeja de entrada.
	*
	* @author: Byron Lanas (BL)
	*/
	public function correosRecibidos()
	{

		$datos_cuerpo = array(); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'correosRecibidos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_correos", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	/**
	* Permite visualizar la bandeja de salida de correos.
	*
	* Permite cargar el layout y la vista correspondiente a la bandeja
	* de salida de correos electrónicos. Es decir, permite ver los
	* correos enviados.
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

			
		/* Carga el modelo del correo y obtiene un array con todos los correos enviados y sus
		respectivos destinatarios. */
		$this->load->model('model_correo');

		$datos_cuerpo = array('listaEnviados'=>$this->model_correo->VerCorreosUser($rut), 'msj'=>$msj); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'correosEnviados'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_correos_enviados_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);

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
	* El resultado de esta función es el renderizado de la vista correspondiente
	* al envío de correos nuevos, suministrando además la lista de todos los posibles
	* destinatarios, agrupados en "profesores", alumnos y ayudantes.
	*
	* @author: Byron Lanas (BL)
	*/
	public function enviarCorreo()
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */

			
		$this->load->model('Model_estudiante');
		//$this->load->model('Model_profesor');
		//$this->load->model('Model_ayudante');
		$datos_cuerpo = array('rs_estudiantes' => $this->Model_estudiante->VerTodosLosEstudiantes(),
							 /*'rs_profesores' => $this->Model_profesor->VerTodosLosProfesores(),
							 /*'rs_ayudantes' => $this->Model_ayudante->VerTodosLosAyudantes()*/);

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'enviarCorreo'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_correos_enviar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);


	}
	
	/**
	* Permite listar los posibles destinatarios de un correo.
	*
	* Permite obtener la lista de estudiantes, ayudantes y profesores registrados
	* en el sistema para renderizarlos dentro de una tabla, con el fin de que
	* el usuario que envía el correo, puede seleccionar al destinatario a partir
	* de dicha tabla.
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
	* El resultado de esta función es el renderizado de la vista correspondiente
	* a la bandeja de borradores.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function verBorradores()
	{


		$datos_cuerpo = array();

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'verBorradores'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_correos_borradores_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}

	/**
	* Permite el envío de un nuevo correo electrónico.
	*
	* Esta función es la que realiza el envio de un correo propiamente tal.
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

		/* Se obtienen los datos del correo a enviar, asi como también,
		el tipo de destinatario al cual va dirijido. Además se cargan los
		modelos necesarios para guardar el correo una vez que es enviado. */
		$this->load->model('model_correo');
		$this->load->model('model_correo_e');

		$to = $this->input->post('to');
		$asunto =$this->input->post('asunto');
		$mensaje =$this->input->post('editor');
		$tipo = $this->input->post('tipo');
		$rutRecept = $this->input->post('rutRecept');
		$date = date("mdHis");

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
				$this->model_correo_e->InsertarCorreoE($rutRecept,$date);
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
		
		$datos_cuerpo = array(); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'correosRecibidos'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$tipos_usuarios_permitidos[1] = TIPO_USR_PROFESOR;
		$this->cargarTodo("Correos", "cuerpo_correos", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);


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
		$this->correosRecibidos();
	}
}