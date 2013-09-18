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
	public function correosRecibidos($msj=null) {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			$rut = $this->session->userdata('rut');
			$this->load->model('Model_correo');

			$datos_cuerpo = array('msj'=>$msj,'cantidadCorreos'=>$this->Model_correo->cantidadRecibidos($rut));

			/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
			* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
			*/
			$subMenuLateralAbierto = 'correosRecibidos'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_correos", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function correosEnviados($msj=null) {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {

			$rut = $this->session->userdata('rut');
			/* Carga el modelo del correo y obtiene un array con todos los correos enviados y sus
			respectivos destinatarios. */
			$this->load->model('Model_correo');

			$datos_cuerpo = array( 'msj'=>$msj,'cantidadCorreos'=>$this->Model_correo->cantidadCorreos($rut)); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
			
			/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
			* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
			*/
			$subMenuLateralAbierto = 'correosEnviados'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_correos_enviados_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function eliminarCorreo() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'POST') {


			$rut = $this->session->userdata('rut');

			/* Sólo se eliminan correos si la variable post que contiene los correos a eliminar está definida*/
			if(isset($_POST['seleccion']))
			{
				$temp=$_POST['seleccion'];
				$correos = explode(";",$temp);
				$this->load->model('model_log');
				$date = date("YmdHis");
				$this->model_log->LogEnviados($correos,$rut,$date);
				$this->load->model('Model_correo');
				$this->Model_correo->EliminarCorreo($correos);
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
	}


	/**
	* Permite eliminar uno o varios correos de la bandeja de correos recibidos.
	*
	* A través del método post se obtienen los identificadores de los correos
	* que se desean eliminar, luego se procede a la eliminación a través del
	* de la función "EliminarCorreoRecibido" del modelo de correos, y finalmente se
	* redirecciona a la vista de correos recibidos, adjuntando la variable
	* "estado" para señalar si la eliminación se realizó correctamente o no
	* y mostrar así un mensaje al usuario con el resultado de la operación.
	* El resultado de esta función es la eliminación de los correos señalados
	* y un redireccionamiento a la bandeja de correos recibidos, indicando el
	* resultado de la operación.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function eliminarCorreoRecibido()
	{
		$rut = $this->session->userdata('rut');

		/* Sólo se eliminan correos si la variable post que contiene los correos a eliminar está definida*/
		$temp = $this->input->post("seleccion");
		if($temp != '')
		{	
			
			$correos = explode(";",$temp);
			$this->load->model('model_log');
			$date = date("YmdHis");
			$this->model_log->LogRecibidos($correos,$rut,$date);
			$this->load->model('Model_correo');
			$this->Model_correo->EliminarRecibidos($correos,$rut);
			
			if(isset($estado))
				unset($estado);
			$estado="1";
			redirect('/Correo/correosRecibidos/'.$estado);
		}
		else
		{
			if(isset($estado))
				unset($estado);
			$estado="0";
			redirect('/Correo/correosRecibidos/'.$estado);
		}	
	}


	/**
	* Permite eliminar uno o varios correos de la bandeja de borradores.
	*
	* A través del método post se obtienen los identificadores de los correos
	* que se desean eliminar, luego se procede a la eliminación a través del
	* de la función "EliminarBorradores" del modelo de correos, y finalmente se
	* redirecciona a la vista de borradores, adjuntando la variable
	* "estado" para señalar si la eliminación se realizó correctamente o no
	* y mostrar así un mensaje al usuario con el resultado de la operación.
	* El resultado de esta función es la eliminación de los correos señalados
	* y un redireccionamiento a la bandeja de borradores, indicando el
	* resultado de la operación.
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function eliminarBorradores()
	{
		$rut = $this->session->userdata('rut');

		/* Sólo se eliminan correos si la variable post que contiene los correos a eliminar está definida*/
		if(isset($_POST['seleccion']))
		{
			$temp=$_POST['seleccion'];
			$correos = explode(";",$temp);
			$this->load->model('model_log');
			$date = date("YmdHis");
			echo $this->model_log->LogBorradores($correos,$rut,$date);
			$this->load->model('Model_correo');
			echo $this->Model_correo->EliminarBorradores($correos);
			if(isset($estado))
				unset($estado);
			$estado="1";
			redirect('/Correo/verBorradores/'.$estado);
		}
		else
		{
			if(isset($estado))
				unset($estado);
			$estado="0";
			redirect('/Correo/verBorradores/'.$estado);
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
	public function enviarCorreo($codigo=null, $msj=null) {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			/* Verifica si el usuario que intenta acceder esta autentificado o no. */
			$datos_cuerpo = array();
			$subMenuLateralAbierto = 'enviarCorreo'; 
			$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
			$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
			$this->cargarTodo("Correos", "cuerpo_correos_enviar", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
		}
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
	public function verBorradores($msj=null) {
		$rut = $this->session->userdata('rut');
		$this->load->model('Model_correo');

		$datos_cuerpo = array( 'msj'=>$msj,'cantidadBorradores'=>$this->Model_correo->cantidadBorradores($rut));

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'verBorradores'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array(TIPO_USR_COORDINADOR, TIPO_USR_PROFESOR);
		$this->cargarTodo("Correos", "cuerpo_correos_borradores_ver", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}


	private function digitoVerificador($rut) {
		$invertir=strrev($rut); 
		$multiplicar = 2;
		$suma = 0;
		
		for ($i = 0; $i <= strlen($invertir); $i++)
		{  
			if ($multiplicar > 7) $multiplicar = 2;  
			$suma = $multiplicar * substr($invertir, $i, 1) + $suma; 
			$multiplicar = $multiplicar + 1; 
		} 
		$valor = 11 - ($suma % 11); 
		if ($valor == 11)
			$verificador = "0"; 
		elseif ($valor == 10)
			$verificador = "k"; 
		else
			$verificador = $valor; 
		return $verificador; 
	}

	/**
	* Permite el envío de un correo electrónico.
	*
	* Esta función es la que realiza el envío de un correo propiamente tal.
	* El resultado de esta función es un nuevo correo electrónico enviado
	* y el registro de dicho correo en las tablas correspondientes.
	* O un mensaje de error, en caso de que el correo no haya podido ser
	* enviado.
	* Se obtienen mediante método post, los datos del correo a enviar,
	* asi como también, los destinatarios a los cuales va dirijido.
	* Además se reemplazan las variables de plantillas si es que existen y 
	* se cargan los modelos necesarios para guardar el correo una vez que es enviado.
	*
	* @author: Byron Lanas (BL) y Diego García (DGM)
	*/
	public function enviarPost() {
		if(!$this->isLogged()){
			return;
		}

		/* Se cargan los modelos necesarios para guardar los correos enviados, con el
		fin de que aparezcan en la bandeja de recibidos y enviados según corresponda. */
		$this->load->model('Model_correo');
		$this->load->model('Model_correo_e');
		$this->load->model('Model_correo_u');
		$this->load->model('Model_correo_a');
		
		/* Se obtiene la información del correo a enviar. */
		$rutRecept=$this->input->post('rutRecept');
		$asunto=$this->input->post('asunto');
		$adjuntos = json_decode($this->input->post('adjuntos'));		
		$codigoBorrador=$this->input->post('codigoBorrador');
		$this->setTimeZone();
		$date=date("YmdHis");
		$cod=$this->Model_correo->getCodigo($date,$codigoBorrador);
		$mensaje=$this->input->post('editor');
		$archivosElim = json_decode($this->input->post('archivosElim'));
		
		/* Se asigna un hipervínculo al correo con el fin de que el usuario pueda ver el correo directamente en el sistema Manteka. */
		//$link="<br><a href='localhost/".config_item('dir_alias')."/index.php/Correo/correosRecibidos/".$date.":".$cod."'>Ver mensaje en su contexto:".$cod."</a>";
		$link2="<br><a href='".$_SERVER['HTTP_HOST']."/manteka/index.php/Correo/correosRecibidos/".$date.":".$cod."'>Ver mensaje en su contexto:".$cod."</a>";
		

		if($archivosElim != "") {
			foreach ($archivosElim as $archivo) {
				unlink("adjuntos/".$archivo);
			}
		}

		/* Se realiza el reemplazo de aquellas variables predefinidas que NO cambian según el destinatario.
		En este caso, dichas variables son %%hoy (fecha actual) y %%remitente (Nombre y apellido de quién envía el correo). */
		$variableHoyAsunto=substr_count($asunto, '%%hoy');
		$variableHoyCuerpo=substr_count($mensaje, '%%hoy');
		$variableRemitenteAsunto=substr_count($asunto, '%%remitente');
		$variableRemitenteCuerpo=substr_count($mensaje, '%%remitente');
		$variableHoy=$variableHoyAsunto + $variableHoyCuerpo;
		$variableRemitente=$variableRemitenteAsunto + $variableRemitenteCuerpo;
		$modeloUsuarioCargado=false;
		if($variableHoy > 0) {
			$asunto = str_replace('%%hoy', date("d/m/Y"), $asunto);
			$mensaje = str_replace('%%hoy', date("d/m/Y"), $mensaje);
		}
		if($variableRemitente > 0) {
			$this->load->model('Model_usuario');
			$modeloUsuarioCargado=true;
			$remitente=$this->Model_usuario->datos_usuario($rut);
			$remitente=trim($remitente->nombre1).' '.trim($remitente->apellido1);
			$asunto=str_replace('%%remitente', $remitente, $asunto);
			$mensaje=str_replace('%%remitente', $remitente, $mensaje);
		}
		
		/* Se realiza una copia del asunto y el mensaje del correo para ser utilizadas al momento de insertar el correo en la bandeja de enviados. */
		$mensajeAux=$mensaje;
		$asuntoAux=$asunto;
		
		/* Se obtiene un array con los ruts de los destinatarios. */
		$receptores=explode(",",$rutRecept);
		
		/* Se valida si las variables predefinidas cuyo valor cambia según el destinatario, son coherentes con la lista de destinatarios especificada.
		Es decir las variables predefinidas %%carrera_estudiante y %%seccion_estudiante sólo pueden ser utilizadas si todos los destinatarios son del tipo estudiante. */
		
		/* Primero se verifica si existen variables predefinidas propias de los estudiantes. */
		$variableModuloAsunto=substr_count($asunto, '%%modulo_estudiante');
		$variableModuloCuerpo=substr_count($mensaje, '%%modulo_estudiante');
		$variableCarreraAsunto=substr_count($asunto, '%%carrera_estudiante');
		$variableCarreraCuerpo=substr_count($mensaje, '%%carrera_estudiante');
		$variableSeccionAsunto=substr_count($asunto, '%%seccion_estudiante');
		$variableSeccionCuerpo=substr_count($mensaje, '%%seccion_estudiante');
		$variableModulo=$variableModuloAsunto + $variableModuloCuerpo;
		$variableCarrera=$variableCarreraAsunto + $variableCarreraCuerpo;
		$variableSeccion=$variableSeccionAsunto + $variableSeccionCuerpo;
		$variablesEstudiante=$variableModulo + $variableCarrera + $variableSeccion;
		
		/* Si hay variables exclusivas de los estudiantes y al menos un destinatario no es del tipo estudiante, entonces
		se vuelve a la vista para el envío de correos y se indica al usuario el error ocurrido. */
		if($variablesEstudiante > 0) {
			$hayEstudiantes=false;
			$hayProfesores=false;
			$hayCoordinadores=false;
			$hayAyudantes=false;
			$hayOtroTipoDestinatario=false;
			if(!$modeloUsuarioCargado) {
				$this->load->model('Model_usuario');
			}
			foreach($receptores as $receptor) {
				$estudiante=$this->Model_correo->getRutEst($receptor);
				$user=$this->Model_correo->getRutUser($receptor);
				$ayudante=$this->Model_correo->getRutAyu($receptor);
				if($estudiante != 0)
					$hayEstudiantes=true;
				else if($user != 0)
				{
					$usuario=$this->Model_usuario->datos_usuario($receptor);
					if($usuario->ID_TIPO == 1)
						$hayProfesores=true;
					else
						$hayCoordinadores=true;
					break(1);
				}
				else if($ayudante != 0)
				{
					$hayAyudantes=true;
					break(1);
				}
				else
				{
					$hayOtroTipoDestinatario=true;
					break(1);
				}
			}
			if($hayAyudantes || $hayProfesores || $hayCoordinadores || $hayOtroTipoDestinatario) {
				$msj='1';
				redirect('/Correo/enviarCorreo/'.$codigoBorrador.'/'.$msj);
			}
		}
		
		/* Se determina si se han definido las variables predefinidas %%nombre y %%rut en el correo a enviar. */
		$variableNombreAsunto=substr_count($asunto, '%%nombre');
		$variableNombreCuerpo=substr_count($mensaje, '%%nombre');
		$variableRutAsunto=substr_count($asunto, '%%rut');
		$variableRutCuerpo=substr_count($mensaje, '%%rut');
		$variableNombre=$variableNombreAsunto + $variableNombreCuerpo;
		$variableRut=$variableRutAsunto + $variableRutCuerpo;
		$envioPersonalizado=$variableNombre + $variableRut;
		
		/* Si existen variables predefinidas que cambian según el destinatario, el envio de los correos debe hacerse uno por uno.*/
		$error=array();
		if ($variablesEstudiante > 0 || $envioPersonalizado > 0) {
			$enviados=0;
			$this->load->model('model_estudiante');
			$this->load->model('model_ayudante');
			if(!$modeloUsuarioCargado) {
				$this->load->model('Model_usuario');
			}
			foreach ($receptores as $receptor) 
			{	
				try {
					$mensajePersonalizado=$mensaje;
					$asuntoPersonalizado=$asunto;
					$estudiante=$this->Model_correo->getRutEst($receptor);
					$user=$this->Model_correo->getRutUser($receptor);
					$ayudante=$this->Model_correo->getRutAyu($receptor);					
					if($estudiante != 0) {
						$datosEstudiante=$this->model_estudiante->getDetallesEstudiante($receptor);
						$seccionEstudiante=$datosEstudiante->seccion;
						$this->load->model('model_secciones');
						$moduloEstudiante=$this->model_secciones->getDetallesSeccion($seccionEstudiante);
						$moduloEstudiante=trim($moduloEstudiante[1]);
						$to=$datosEstudiante->correo;
						$nombreEstudiante=trim($datosEstudiante->nombre1).' '.trim($datosEstudiante->apellido1);
						$rutEstudiante=trim($datosEstudiante->rut);
						$largoRut=strlen($rutEstudiante);
						$cientosRut=substr($rutEstudiante,$largoRut-3,3);
						$milesRut=substr($rutEstudiante,$largoRut-6,3);
						$millonesRut=substr($rutEstudiante,0,$largoRut-6);
						$rutEstudiante=$millonesRut.'.'.$milesRut.'.'.$cientosRut.'-'.$this->digitoVerificador($rutEstudiante);
						$carreraEstudiante=trim($datosEstudiante->carrera);
						$seccionEstudiante=trim($datosEstudiante->nombre_seccion);
						$asuntoPersonalizado=str_replace('%%nombre', $nombreEstudiante, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%rut', $rutEstudiante, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%carrera_estudiante', $carreraEstudiante, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%seccion_estudiante', $seccionEstudiante, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%modulo_estudiante', $moduloEstudiante, $asuntoPersonalizado);
						$mensajePersonalizado=str_replace('%%nombre', $nombreEstudiante, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%rut', $rutEstudiante, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%carrera_estudiante', $carreraEstudiante, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%seccion_estudiante', $seccionEstudiante, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%modulo_estudiante', $moduloEstudiante, $mensajePersonalizado);
					}
					else if($user != 0) {
						$datosUsuario=$this->Model_usuario->datos_usuario($receptor);
						$to=$datosUsuario->email1;
						$nombreUsuario=trim($datosUsuario->nombre1).' '.trim($datosUsuario->apellido1);
						$rutUsuario=trim($datosUsuario->rut);
						$largoRut=strlen($rutUsuario);
						$cientosRut=substr($rutUsuario,$largoRut-3,3);
						$milesRut=substr($rutUsuario,$largoRut-6,3);
						$millonesRut=substr($rutUsuario,0,$largoRut-6);
						$rutUsuario=$millonesRut.'.'.$milesRut.'.'.$cientosRut.'-'.$this->digitoVerificador($rutUsuario);
						$asuntoPersonalizado=str_replace('%%nombre', $nombreUsuario, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%rut', $rutUsuario, $asuntoPersonalizado);
						$mensajePersonalizado=str_replace('%%nombre', $nombreUsuario, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%rut', $rutUsuario, $mensajePersonalizado);
					}
					else if($ayudante != 0) {
						$datosAyudante=$this->model_ayudante->getDetallesAyudante($receptor);
						$to=$datosAyudante->correo;
						$nombreAyudante=trim($datosAyudante->nombre1).' '.trim($datosAyudante->apellido1);
						$rutAyudante=trim($datosAyudante->rut);
						$largoRut=strlen($rutAyudante);
						$cientosRut=substr($rutAyudante,$largoRut-3,3);
						$milesRut=substr($rutAyudante,$largoRut-6,3);
						$millonesRut=substr($rutAyudante,0,$largoRut-6);
						$rutAyudante=$millonesRut.'.'.$milesRut.'.'.$cientosRut.'-'.$this->digitoVerificador($rutAyudante);
						$asuntoPersonalizado=str_replace('%%nombre', $nombreAyudante, $asuntoPersonalizado);
						$asuntoPersonalizado=str_replace('%%rut', $rutAyudante, $asuntoPersonalizado);
						$mensajePersonalizado=str_replace('%%nombre', $nombreAyudante, $mensajePersonalizado);
						$mensajePersonalizado=str_replace('%%rut', $rutAyudante, $mensajePersonalizado);
					}
					$mensajeMail =$mensajePersonalizado.$link2;
					if($this->enviarMail($to, $asuntoPersonalizado, $mensajeMail, $adjuntos) == TRUE) {
						$enviados+=1;
					}
				}
				catch(Exception $e) {
					array_push($error, $receptor);
				}
			}
			$asuntoAux=str_replace('%%nombre', '[Nombre destinatario]', $asuntoAux);
			$asuntoAux=str_replace('%%rut', '[Rut destinatario]', $asuntoAux);
			$asuntoAux=str_replace('%%carrera_estudiante', '[Carrera estudiante destinatario]', $asuntoAux);
			$asuntoAux=str_replace('%%seccion_estudiante', '[Sección estudiante destinatario]', $asuntoAux);
			$asuntoAux=str_replace('%%modulo_estudiante', '[Módulo estudiante destinatario]', $asuntoAux);
			$mensajeAux=str_replace('%%nombre', '[Nombre destinatario]', $mensajeAux);
			$mensajeAux=str_replace('%%rut', '[Rut destinatario]', $mensajeAux);
			$mensajeAux=str_replace('%%carrera_estudiante', '[Carrera estudiante destinatario]', $mensajeAux);
			$mensajeAux=str_replace('%%seccion_estudiante', '[Sección estudiante destinatario]', $mensajeAux);
			$mensajeAux=str_replace('%%modulo_estudiante', '[Módulo estudiante destinatario]', $mensajeAux);
			$this->Model_correo->InsertarCorreo($asuntoAux,$mensajeAux,$rut,$date,$rutRecept,$codigoBorrador,$adjuntos);
			
			/* Se guarda la información que asocia el correo enviado con cada destinatario. */
			foreach($receptores as $receptor) {
				if(!in_array($receptor, $error)) {
					$estudiante=$this->Model_correo->getRutEst($receptor);
					if($estudiante!=0)
						$this->Model_correo_e->InsertarCorreoE($receptor,$cod);
								
					$user=$this->Model_correo->getRutUser($receptor);
					if($user!=0)
						$this->Model_correo_u->InsertarCorreoU($receptor,$cod);
							
					$ayudante=$this->Model_correo->getRutAyu($receptor);
					if($ayudante!=0)
						$this->Model_correo_a->InsertarCorreoA($receptor,$cod);
				}
			}
			$estado="2";
			redirect('/Correo/correosRecibidos/'.$estado, '');
		}
		/* Si no hay variables predefinidas que cambien según el destinatario, entonces se realiza un sólo envío con copia a todos los destinatarios. */
		else {
			try {
				$to=$this->input->post('to');
				$mensajeMail=$mensaje.$link2;

				if ($this->enviarMail($to, $asunto, $mensajeMail, $adjuntos) == FALSE)
					throw new Exception("Error en el envio");

				$this->Model_correo->InsertarCorreo($asunto,$mensaje,$rut,$date,$rutRecept,$codigoBorrador,$adjuntos);
				
				/* Se guarda la información que asocia el correo enviado con cada destinatario. */
				foreach($receptores as $receptor)
				{
					$estudiante=$this->Model_correo->getRutEst($receptor);
					if($estudiante!=0)
						$this->Model_correo_e->InsertarCorreoE($receptor,$cod);
						
					$user=$this->Model_correo->getRutUser($receptor);
					if($user!=0)
						$this->Model_correo_u->InsertarCorreoU($receptor,$cod);
							
					$ayudante=$this->Model_correo->getRutAyu($receptor);
					if($ayudante!=0)
						$this->Model_correo_a->InsertarCorreoA($receptor,$cod);
				}
			}
			catch (Exception $e)
			{
				if($e->getMessage()=="error en el envio")
					redirect("/Otros/sendMailError/".$codigoBorrador, "sendMailError");
				else
					redirect("/Otros", "databaseError");
			}
			$estado="2";
			redirect('/Correo', 'correosRecibidos/'.$estado);
		}
	}
	

	/**
	* Recarga la tabla de correos recibidos segun los botones de < y > 
	* según sean clickeados
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function getCorreosRecibidosAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if(!$this->isLogged()){
			return;
		}
		$offset = $this->input->post('offset');
		$rut = $this->session->userdata('rut');
		$tipoUsuario = $this->session->userdata('id_tipo_usuario');
		$textoFiltro = $this->input->post('textoBusqueda');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');
		

		$this->load->model('Model_usuario');
		$datosUsuario=$this->Model_usuario->datos_usuario($rut);
		$nombreUsuario=trim($datosUsuario->nombre1).' '.trim($datosUsuario->apellido1);
		$rutUsuario=trim($datosUsuario->rut);
		$largoRut=strlen($rutUsuario);
		$cientosRut=substr($rutUsuario,$largoRut-3,3);
		$milesRut=substr($rutUsuario,$largoRut-6,3);
		$millonesRut=substr($rutUsuario,0,$largoRut-6);
		$rutUsuario=$millonesRut.'.'.$milesRut.'.'.$cientosRut.'-'.$this->digitoVerificador($rutUsuario);
		$this->load->model('Model_correo');
		$resultado =$this->Model_correo->VerCorreosRecibidos($rut, $offset, $tipoUsuario, $textoFiltro, $textoFiltrosAvanzados);
		
		$resultadoAux=array();
		
		foreach ($resultado as $temp)
		{
			$temp=str_replace('[Rut destinatario]', $rutUsuario, $temp);
			$temp=str_replace('[Nombre destinatario]', $nombreUsuario, $temp);
			array_push($resultadoAux, $temp);
		}
		$resultado=$resultadoAux;
		
		if (count($resultado) > 0) {			
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'correos', $this->session->userdata('rut'));
			
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'correos', $this->session->userdata('rut'));
			}
			
		}
		echo json_encode($resultado);
	}
	
	/**
	* Obtiene los archivos adjuntos de un correo.
	*
	* @author: Diego García (DGM)
	*
	*/
	public function getAdjuntosAjax() {
		if (!$this->input->is_ajax_request()) {
			return;
		}
		if(!$this->isLogged()){
			return;
		}
		$codigo = $this->input->post('codigo');
		$this->load->model('Model_correo');
		$resultado =$this->Model_correo->getAdjuntos($codigo);
		echo json_encode($resultado);
	}


	/**
	* Recarga la tabla de borradores segun los botones de < y > 
	* según sean clickeados
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function postBorradores() {
		if(!$this->isLogged()){
			return;
		}
		$offset = $this->input->post('offset');
		$rut = $this->session->userdata('rut');
		$this->load->model('Model_correo');

		$resultado =$this->Model_correo->VerBorradores($rut,$offset);
		echo json_encode($resultado);
	}


	/**
	* Marca el correo seleccionado como leído
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function marcarComoLeidoAjax() {
		if(!$this->isLogged()){
			return;
		}
		$codigo = $this->input->post('codigo');
		$rut = $this->session->userdata('rut');
		$this->load->model('Model_correo');

		$resultado =$this->Model_correo->marcarLeido($rut, $codigo);
		echo json_encode($resultado);
	}


	/**
	* Guarda borradores automaticamente o por el botón guardar
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function postGuardarBorradores() {
		if(!$this->isLogged()){
			return;
		}
		$codigoBorrador = $this->input->post('codigoBorrador');
		$rut = $this->session->userdata('rut');

		$to = $this->input->post('to');
		$asunto =$this->input->post('asunto');
		$mensaje =$this->input->post('editor');
		$adjuntos = $this->input->post('adjuntos');
		$archivosElim = $this->input->post('archivosElim');
		$rutRecept = $this->input->post('rutRecept');
		$date = date("YmdHis");
		$this->load->model('Model_correo');
		$this->load->model('Model_correo_e');
		$this->load->model('Model_correo_u');
		$this->load->model('Model_correo_a');
		
		if($archivosElim!="")
		foreach ($archivosElim as $archivo) {
			unlink("adjuntos/".$archivo);
			
		}

		$resultado =$this->Model_correo->insertarBorrador($asunto,$mensaje,$rut,$date,$rutRecept,$codigoBorrador,$adjuntos);

		$cod=$this->Model_correo->getCodigo($date,$codigoBorrador);

			$receptores = explode(",",$rutRecept);
			foreach ($receptores as $receptor) {
				$estudiante=$this->Model_correo->getRutEst($receptor);
			if($estudiante!=0)
				$this->Model_correo_e->InsertarCorreoE($receptor,$cod);
			$user=$this->Model_correo->getRutUser($receptor);
			if($user!=0)
				$this->Model_correo_u->InsertarCorreoU($receptor,$cod);
			$ayudante=$this->Model_correo->getRutAyu($receptor);
			if($ayudante!=0)
				$this->Model_correo_a->InsertarCorreoA($receptor,$cod);
			}
		echo json_encode($resultado);
	}


	/**
	* Recarga la tabla de correos Enviados segun los botones de < y > 
	* según sean clickeados
	*
	* @author: Byron Lanas (BL)
	*
	*/
	public function getCorreosEnviadosAjax(){
		if(!$this->isLogged()){
			return;
		}
		$offset = $this->input->post('offset');
		$rut = $this->session->userdata('rut');
		$tipoUsuario = $this->session->userdata('id_tipo_usuario');
		$textoFiltro = $this->input->post('textoBusqueda');
		$textoFiltrosAvanzados = $this->input->post('textoFiltrosAvanzados');

		$this->load->model('Model_correo');

		$resultado =$this->Model_correo->VerCorreosUser($rut, $offset, $tipoUsuario, $textoFiltro, $textoFiltrosAvanzados);

		if (count($resultado) > 0) {
			$this->load->model('model_busquedas');
			//Se debe insertar sólo si se encontraron resultados
			$this->model_busquedas->insertarNuevaBusqueda($textoFiltro, 'correos', $this->session->userdata('rut'));
			
			$cantidad = count($textoFiltrosAvanzados);
			for ($i = 0; $i < $cantidad; $i++) {
				$this->model_busquedas->insertarNuevaBusqueda($textoFiltrosAvanzados[$i], 'correos', $this->session->userdata('rut'));
			}
			
		}
		echo json_encode($resultado);
	}
	

	/**
	* Envia a la vista de enviar correo con los datos del borrador seleccionado 
	* @author: Byron Lanas (BL)
	*
	*/
	public function enviarBorrador($codigo)
	{
		redirect('/Correo/enviarCorreo/'.$codigo);
	}


	/**
	* carga los datos del borrador seleccionado para continuar con el envio
	* @author: Byron Lanas (BL)
	*
	*/
	public function postCargarBorrador()
	{
		if(!$this->isLogged()){
			return;
		}

		$rut = $this->session->userdata('rut');
		$codigo = $this->input->post('codigo');
		$this->load->model('Model_correo');

		$resultado =$this->Model_correo->cargarBorrador($codigo,$rut);
		echo json_encode($resultado);
	}


	/**
	* carga los datos del correo para ver en su contexto
	* @author: Byron Lanas (BL)
	*
	*/
	public function getDetallesCorreoAjax()
	{
		if(!$this->isLogged()){
			return;
		}

		$rut = $this->session->userdata('rut');
		$codigo = $this->input->post('codigo');
		$this->load->model('Model_correo');

		$resultado =$this->Model_correo->cargarCorreo($codigo, $rut);
		echo json_encode($resultado);
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


	/**
	* Función que retorna los destinatarios según el tipo seleccionado
	* @author: Diego Gómez 
	* @return arreglo con los atributos de los destinatarios seleccionados
	*/
	public function postBusquedaTipoDestinatario() {
		if (!$this->isLogged()) {
			//echo 'No estás logueado!!';
			return;
		}
		$destinatario = $this->input->post('destinatario');
		$this->load->model('Model_filtro');
		$this->load->model('Model_estudiante');
		$this->load->model('Model_profesor');
		$this->load->model('Model_ayudante');
		$this->load->model('Model_coordinador');

		switch ($destinatario) {
			case 0:
				$resultado = $this->Model_filtro->getAll();
				break;
			case 1:
				$resultado = $this->Model_estudiante->getAllEstudiantes();
				break;
			case 2:
				$resultado = $this->Model_profesor->getAllProfesores();
				break;
			case 3:
				$resultado = $this->Model_ayudante->getAllAyudantes();
				break;
			case 4:
				$resultado = $this->Model_coordinador->getAllCoordinadores();
			default:
				# code...
				break;
		}
		echo json_encode($resultado);
	}


	/**
	* Función que retorna todas las carreras del sistema
	* @author: Diego Gómez
	* @return: arreglo con las carreras
	*/
	public function postCarreras(){
		if(!$this->isLogged()){
			return;
		}
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAllCarreras();
		echo json_encode($resultado);
	}


	/**
	* Función que retorna todas las secciones del sistema
	* @author: Diego Gómez
	* @return: arreglo con las secciones
	*/
	public function postSecciones(){
		if(!$this->isLogged()){
			return;
		}
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAllSecciones();
		echo json_encode($resultado);
	}


	/**
	* Función que retorna todos los bloques horarios del sistema
	* @author: Diego Gómez
	* @return: arreglo con los bloques horarios
	*/
	public function postHorarios(){
		if(!$this->isLogged()){
			return;
		}
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAllHorarios();
		echo json_encode($resultado);
	}


	/**
	* Función que retorna todos los módulos temáticos del sistema del sistema
	* @author: Diego Gómez
	* @return: arreglo con los módulos temáticos
	*/
	public function postModulosTematicos(){
		if(!$this->isLogged()){
			return;
		}
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAllModulosTematicos();
		echo json_encode($resultado);
	}


	/**
	* Función que retorna los atributos de los alumnos según los filtros seleccionados
	* @author: Diego Gómez
	* @return: arreglo con los atributos de los alumnos seleccionados
	*/
	public function postAlumnosByFiltro(){
		if(!$this->isLogged()){
			return;
		}
		$profesor = $this->input->post('profesor');
		$codigo = $this->input->post('codigo');
		$seccion = $this->input->post('seccion');
		$modulo_tematico = $this->input->post('modulo_tematico');
		$bloque = $this->input->post('bloque');
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAlumnosByFiltro($profesor,$codigo,$seccion,$modulo_tematico,$bloque);
		echo json_encode($resultado);
	}


	/**
	* Función que retorna los atributos de los profesores según los filtros seleccionados
	* @author: Diego Gómez
	* @return: arreglo con los atributos de los profesores seleccionados
	*/
	public function postProfesoresByFiltro(){
		if(!$this->isLogged()){
			return;
		}
		$seccion = $this->input->post('seccion');
		$modulo_tematico = $this->input->post('modulo_tematico');
		$bloque = $this->input->post('bloque');
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getProfesoresByFiltro($seccion,$modulo_tematico,$bloque);
		echo json_encode($resultado);
	}


	/**
	* Función que retorna los atributos de los ayudantes según los filtros seleccionados
	* @author: Diego Gómez
	* @return: arreglo con los atributos de los ayudantes seleccionados
	*/
	public function postAyudantesByFiltro(){
		if(!$this->isLogged()){
			return;
		}
		$profesor = $this->input->post('profesor');
		$seccion = $this->input->post('seccion');
		$modulo_tematico = $this->input->post('modulo_tematico');
		$bloque = $this->input->post('bloque');
		$this->load->model('Model_filtro');
		$resultado = $this->Model_filtro->getAyudantesByFiltro($profesor,$seccion,$modulo_tematico,$bloque);
		echo json_encode($resultado);
	}


	/**
	* Función retorna los atributos de las auditorias según el tipo seleccionado
	* ya se correo recibido, correo enviado o borrador
	* @author Diego Gómez (DGL)
	* @return arreglo con los atributos de las auditorias seleccionadas
	*/

	public function postLogEliminados(){
		if(!$this->isLogged()){
			return;
		}
		$tipo = $this->input->post('tipo');
		$this->load->model('model_log');
		$resultado = $this->model_log->getLogEliminados($tipo);
		echo json_encode($resultado);
	}


	/**
	* Función que carga la vista de los Logs 
	* @author Diego Gómez (DGL)
	*/
	public function logEliminados($msj=null)
	{

		$rut = $this->session->userdata('rut');
		$this->load->model('Model_correo');

		$datos_cuerpo = array('msj'=>$msj,'cantidadCorreos'=>$this->Model_correo->cantidadCorreos($rut));

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'logEliminados'; 
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Correos", "cuerpo_log_eliminados", "barra_lateral_correos", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}


	/**
	* Función que retorna la cantidad de correos no leidos por el usuario
	* @author: Víctor flores
	* @return: int La cantidad de correos no leidos
	*/
	public function postCantidadCorreosNoLeidos(){
		if (!$this->isLogged()) {
			return;
		}
		$rut = $this->session->userdata('rut');
		$this->load->model('Model_correo');
		$resultado = $this->Model_correo->cantidadRecibidosNoLeidos($rut);
		echo $resultado;
	}

}