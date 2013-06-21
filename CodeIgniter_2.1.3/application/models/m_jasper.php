<?php[/size]

[size=3]if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Jasper extends Model {

        function __construct() {
                parent::Model();
        }


function gerarRelatorioPdf($pastaDoRelatorio, $nomeDoRelatorio, $parametros, $caminhoDoArquivo){

$cliente = new Jasper();[/size]
[size=3]$cliente->credenciais('http://localhost:8090/jasperserver/services/repository?wsdl', 'jasperadmin', 'jasperadmin');[/size]
[size=3]$resultado = $cliente->printReport($pastaDoRelatorio, $nomeDoRelatorio, 'PDF', $parametros);
if ($resultado){
        file_put_contents($caminhoDoArquivo, $resultado);
        
        unset($resultado);
        return true;
}

else{
         unset($resultado);
         return false;
}

}

}
?>
