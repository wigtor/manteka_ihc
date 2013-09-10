<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'controllers/Master.php'; //Carga el controlador master

class ReportesSistema extends MasterManteka {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function generarInformes()
	{
		
		$datos_cuerpo = array(); //Cambiarlo por datos que provengan de los modelos para pasarsela a su vista_cuerpo
		//$datos_cuerpo["listado_de_algo"] = model->consultaSQL(); //Este es un ejemplo

		/* Se setea que usuarios pueden ver la vista, estos pueden ser las constantes: TIPO_USR_COORDINADOR y TIPO_USR_PROFESOR
		* se deben introducir en un array, para luego pasarlo como parámetro al método cargarTodo()
		*/
		$subMenuLateralAbierto = 'reportesSistema'; //Para este ejemplo, los informes no tienen submenu lateral
		$muestraBarraProgreso = FALSE; //Indica si se muestra la barra que dice anterior - siguiente
		$tipos_usuarios_permitidos = array();
		$tipos_usuarios_permitidos[0] = TIPO_USR_COORDINADOR;
		$this->cargarTodo("Reportes", "cuerpo_reportes_sistema", "barra_lateral_reportes", $datos_cuerpo, $tipos_usuarios_permitidos, $subMenuLateralAbierto, $muestraBarraProgreso);
	}
	
	public function index() //Esto hace que el index sea la vista que se desee
	{
		$this->generarInformes();
	}

	public function mostrarReporte() //Esto hace que el index sea la vista que se desee
	{
		$nombreReporte = $this->input->post('nombreReporte');
		//Import the PhpJasperLibrary
		//ob_start();
		//include_once (APPPATH.'/../libreportes/PhpJasperLibrary/tcpdf/tcpdf.php');
		//include_once (APPPATH.'/../libreportes/PhpJasperLibrary/PHPJasperXML.inc.php');
		//include_once (APPPATH.'config/database.php');
		
		$this->load->library('PHPJasperXML');
		$this->load->library('tcpdf/tcpdf');
		//database connection details

		
		$server= "127.0.0.1";//$db['default']['hostname'];
		$database = "manteka_db";//$db['default']['database'];
		$user=  "root";//$db['default']['username'];
		$pass= "";//$db['default']['password'];
		$version="0.8d";
		$pgport=3306 ;
		$pchartfolder="./class/pchart2";
		 
		//display errors should be off in the php.ini file
		ini_set('display_errors', 0);
		 
		//setting the path to the created jrxml file
		$xml =  simplexml_load_file(APPPATH.'/../reportes/sample1.jrxml');
		
		//echo var_dump($xml);
		//return;
		//$PHPJasperXML = new PHPJasperXML("en","tcdpdf");

		//$PHPJasperXML->debugsql=false;
		//$PHPJasperXML->arrayParameter=array("parameter1"=>1);
		@$this->PHPJasperXML->xml_dismantle($xml);
		return;
		@$this->PHPJasperXML->transferDBtoArray($server,$user,$pass,$database);
		//ob_end_clean();
		@$this->PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
	}

}

/* End of file ReportesSistema.php */
/* Location: ./application/controllers/ReportesSistema.php */