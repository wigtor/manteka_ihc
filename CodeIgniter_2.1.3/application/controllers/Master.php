<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* @package MasterManteka
* @author Grupo 1
*
*/
class MasterManteka extends CI_Controller {


	protected function isLogged() {
		$rut = $this->session->userdata('rut');
		if ($rut == FALSE)
			return FALSE;
		$this->load->model('model_usuario');
		$resultado = $this->model_usuario->ValidarRut($rut);
		if ($resultado == FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	* Método que carga completamente una vista de manteka.
	* 
	* Se hace una comprobación del usuario si está logueado
	* 
	*/
	protected function cargarTodo($titulo, $cuerpo_a_cargar, $barra_lateral, $datos_cuerpo, $tipos_usuarios_permitidos, 
		$subMenuLateralAbierto = '' , $mostrarBarraProgreso = FALSE)
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		if ($rut == FALSE)
			redirect('/Login/', '');
		$esValido = FALSE;
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
		}
		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}

		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = $titulo;

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

		//Se carga la barra de navegación que contiene los botones undo-redo
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = $mostrarBarraProgreso;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view($cuerpo_a_cargar, $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = $subMenuLateralAbierto;

		//Se carga la barra lateral
		if($barra_lateral != ''){
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/'.$barra_lateral, $datos_plantilla, TRUE);
		}
		else{
			$datos_plantilla["barra_lateral"] = '';
		}
		//Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);
	}

	/**
	* Método que carga completamente la vista para mostrar un mensaje
	* 
	* Se hace una comprobación del usuario si está logueado
	* 
	*/
	protected function cargarMsjLogueado($datos_cuerpo, $tipos_usuarios_permitidos)
	{
		
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		
		if ($rut == FALSE)
			redirect('/Login/', '');
		
		$esValido = FALSE;
		
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
		}

		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}

		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = '';

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

		//Se carga la barra de navegación que contiene los botones undo-redo
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = FALSE;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view('templates/big_msj_logueado', $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = '';

		//Se carga la barra lateral
		$datos_plantilla["barra_lateral"] = '';

		//Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);
	}

	/**
	*	Método para cargar vistas del tipo "Ver información"
	*
	*	Al igual que el método "cargarTodo", se encarga de estructurar toda la vista final.
	*	A través de los argumentos obtenidos por parámetro, emite la información
	*	necesaria para poder ver el módulo "Ver" de algún controlador específico.
	*	
	*	@param 
	*
	*/
	protected function cargarVerInfo($titulo, $barra_lateral, $tipos_usuarios_permitidos,
		$nombreVista,
		$jsFile, $nombreFuncionFiltro, 
		$idInputFiltro, $idSelectFiltro,
		$listaOpciones, $listaInfo,
		$subMenuLateralAbierto = '')
	{
		/* Verifica si el usuario que intenta acceder esta autentificado o no. */
		$rut = $this->session->userdata('rut');
		$tipo_usuario = $this->session->userdata('tipo_usuario');
		$id_tipo_usuario = $this->session->userdata('id_tipo_usuario');
		$datos_plantilla["id_tipo_usuario"] = $id_tipo_usuario;
		$datos_plantilla["rut_usuario"] = $rut;
		$datos_plantilla["nombre_usuario"] = $this->session->userdata('nombre_usuario');
		$datos_plantilla["tipo_usuario"] = $tipo_usuario;
		if ($rut == FALSE)
			redirect('/Login/', '');
		$esValido = FALSE;
		foreach ($tipos_usuarios_permitidos as $user_permitido) {
			if ($user_permitido == $id_tipo_usuario) {
				$esValido = TRUE;
			}
		}
		if (!$esValido) {
			redirect('/Login/', ''); //Redirijo si el usuario no puede usar esta vista
		}

		
		/* Carga en el layout los menús, variables, configuraciones y elementos necesarios para ver las vistas */
		//Se setea el título de la página.
		$datos_plantilla["title"] = "ManteKA";

		//Se setea que menú de la barra superior se encuentra abierto.
		$datos_plantilla["menuSuperiorAbierto"] = $titulo;

		//Se carga el template del header.
		$datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, TRUE);

		//Se carga la barra de usuario, utiliza variables como el nombre de usuario para mostrar su información.
		$datos_plantilla["barra_usuario"] = $this->load->view('templates/barra_usuario', $datos_plantilla, TRUE);

		//Se carga el banner de la aplicación.
		$datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', TRUE);

		//Se carga el menú superior de la aplicación, utiliza la variable "menuSuperiorAberto".
		$datos_plantilla["menu_superior"] = $this->load->view('templates/menu_superior', $datos_plantilla, TRUE);

		//Se carga la barra de navegación que contiene los botones undo-redo
		$datos_plantilla["barra_navegacion"] = $this->load->view('templates/barra_navegacion', '', TRUE);

		//Se setea si se quiere o no mostrar la barra de progreso, hay vistas que no lo necesitan
		$datos_plantilla["mostrarBarraProgreso"] = FALSE;

		//Se carga la barra de progreso
		$datos_plantilla["barra_progreso_atras_siguiente"] = $this->load->view('templates/barra_progreso_atras_siguiente', $datos_plantilla, TRUE);

		//Se carga el footer
		$datos_plantilla["footer"] = $this->load->view('templates/footer', '', TRUE);

		//Nombre del archivo JavaScript que utiliza
		$datos_cuerpo["nombreJS"] = $jsFile;

		//Nombre de lo que se está viendo. Ej: "Alumno", "Ayudante"
		$datos_cuerpo["nombreView"] = $nombreVista;

		//ID del objeto input html
		$datos_cuerpo["idInputFiltro"] = $idInputFiltro;

		//Nombre de la función Javascript que se utiliza cuando se cambia el filtro
		$datos_cuerpo["nombreFncCambiarTipoFiltro"] = $nombreFuncionFiltro;

		//ID del objeto select html
		$datos_cuerpo["idSelectFiltro"] = $idSelectFiltro;

		//Opciones del Filtro, posee su ID y el nombre que lo representa
		$datos_cuerpo["OpcionesFiltro"] = $listaOpciones;

		//Información que muestra la vista
		$datos_cuerpo["ListaInformacion"] = $listaInfo;


		//Se carga el cuerpo central indicado por los parámetros y con los datos que se entregan
		$datos_plantilla["cuerpo_central"] = $this->load->view($cuerpo_a_cargar, $datos_cuerpo, TRUE);

		//Se setea que botón de la barra lateral se encuentra presionado
		$datos_plantilla["subVistaLateralAbierta"] = $subMenuLateralAbierto;

		//Se carga la barra lateral
		if($barra_lateral != ''){
			$datos_plantilla["barra_lateral"] = $this->load->view('templates/barras_laterales/'.$barra_lateral, $datos_plantilla, TRUE);
		}
		else{
			$datos_plantilla["barra_lateral"] = '';
		}
		
		//	Se carga la template de todo el sitio pasándole como parámetros los demás templates cargados
		$this->load->view('templates/template_general', $datos_plantilla);
		
	}

}