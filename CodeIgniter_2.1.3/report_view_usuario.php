<?php 
define ('BASEPATH','./');
//Import the PhpJasperLibrary

include ('PhpJasperLibrary/tcpdf/tcpdf.php');
include ('PhpJasperLibrary/PHPJasperXML.inc.php');
require_once 'application/config/database.php';

//database connection details
if(isset($_GET["nombreReporte"]))
	$nombreReporte = $_GET["nombreReporte"];
if(!isset($_GET["mode"]))
	exit();
if(isset($_GET["titulo"]))
	$titulo= $_GET["titulo"];
if(isset($_GET["modulo"]))
	$modulo= $_GET["modulo"];
if(isset($_GET["seccion"]))
	$seccion= $_GET["seccion"];
if(isset($_GET["descripcion"]))
	$descripcion= $_GET["descripcion"];
if(isset($_GET["carrera"]))
	$carrera= $_GET["carrera"];
if(isset($_GET["columnas"]))
	$columnas = $_GET["columnas"];
if(isset($_GET["columna_1"]))
	$columna_1 = $_GET["columna_1"];
if(isset($_GET["columna_2"]))
	$columna_2 = $_GET["columna_2"];
if(isset($_GET["lugar"]))
	$lugar = $_GET["lugar"];
if(isset($_GET["horario"]))
	$horario = $_GET["horario"];

$server= $db['default']['hostname'];
$datbas=$db['default']['database'];
$user=$db['default']['username'];
$pass=$db['default']['password'];
$version="0.8b";
$pgport=3306;
$pchartfolder="./class/pchart2";


//display errors should be off in the php.ini file
ini_set('display_errors', 0);

/* Valores de la variable Filtro
0 = si no se utilizó ninguno de los filtros
1 = si se utilizó Sección
2 = si se utilizó Carrera
3 = si se utilizó Sección y Carrera
*/

if($columnas == 0){
	if( ($seccion == 0) && ($carrera == 0)){
		$filtro = 1;
		$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario.jrxml');
	}
	else{
		if($carrera == 0){
			$filtro = 1;
			$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_s.jrxml');
		}
		else{
			if($seccion == 0){
				$filtro = 2;
				$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c.jrxml');
				
			}
			else{
				$filtro = 3;
				$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c_s.jrxml');
			}
		}
	}
}
else{
	if($columnas==1){
		if( ($seccion == 0) && ($carrera == 0)){
			$filtro = 1;
			$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_1_col.jrxml');
		}
		else{
			if($carrera==0){
				$filtro = 1;
				$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_s_1_col.jrxml');
			}
			else{
				if($seccion==0){
					$filtro = 2;
					$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c_1_col.jrxml');
				}
				else{
					$filtro = 3;
					$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c_s_1_col.jrxml');
				}
			}
		}
	}
	else{
		if( ($seccion == 0) && ($carrera == 0)){
			$filtro = 1;
			$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_2_col.jrxml');
		}
		else{
			if($carrera==0){
				$filtro = 1;
				$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_s_2_col.jrxml');
			}
			else{
				if($seccion==0){
					$filtro = 2;
					$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c_2_col.jrxml');
				}
				else{
					$filtro = 3;
					$xml =  simplexml_load_file('reportes/Estudiantes_por_Usuario_filtro_c_s_2_col.jrxml');
				}
			}
		}
	}
}


$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("titulo"=>$titulo,"descripcion"=>$descripcion,"filtro"=>$filtro,"seccion"=>$seccion,"carrera"=>$carrera,"horario"=>$horario,"lugar"=>$lugar,"columnas"=>$columnas,"columna_1"=>$columna_1,"columna_2"=>$columna_2);
$PHPJasperXML->xml_dismantle($xml);
 
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$datbas);
$PHPJasperXML->outpage($_GET["mode"]);    //page output method I:standard output  D:Download file
?>