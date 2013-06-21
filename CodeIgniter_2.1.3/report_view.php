<?php 
 
//Import the PhpJasperLibrary

include ('PhpJasperLibrary/tcpdf/tcpdf.php');
include ('PhpJasperLibrary/PHPJasperXML.inc.php');
 
//database connection details
if(isset($_GET["nombreReporte"]))
	$nombreReporte = $_GET["nombreReporte"];
if(!isset($_GET["mode"]))
	exit();
$server="127.0.0.1";
$db="manteka_db";
$user="root";
$pass="";
$version="0.8b";
$pgport=3306;
$pchartfolder="./class/pchart2";
 
 
//display errors should be off in the php.ini file
ini_set('display_errors', 0);
 
//setting the path to the created jrxml file
$xml =  simplexml_load_file('reportes/'.$nombreReporte.'.jrxml');

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=false;
//$PHPJasperXML->arrayParameter=array("parameter1"=>1);
$PHPJasperXML->xml_dismantle($xml);
 
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage($_GET["mode"]);    //page output method I:standard output  D:Download file

 
 
?>