<?php

date_default_timezone_set('America/Sao_Paulo');

$inputs = json_decode( file_get_contents('php://input'), true);

$alteracao = 'Feedback Cliente';

$texto = ':'.$inputs['usuario'].'-'.$inputs['dataatual'].'-'.$inputs['cgc'].'-'.$alteracao.'-'.$inputs['nome'].'-'.$_SERVER["REMOTE_ADDR"].":\r\n";

function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
       return $valor;
}

$local = 'logs/'.limpaCPF_CNPJ($inputs['cgc']).'.txt';

if(!file_exists($local)){

//mkdir($local,true,'0700');

$fp = fopen($local, "x",0);

//Escreve no arquivo aberto.
fwrite($fp, $texto);
 
//Fecha o arquivo.
fclose($fp);
} else {

$fp = fopen($local, "a+",0);

//Escreve no arquivo aberto.
fwrite($fp, $texto);
 
//Fecha o arquivo.
fclose($fp);


}

$logs = $texto;

print_r(json_encode($logs));

?>