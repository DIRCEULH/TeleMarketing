<?php
defined('ROOT_DIR') ?: define('ROOT_DIR', __DIR__);	
require('../../lib/commons.inc.php');
date_default_timezone_set('America/Bahia');

$inputs = json_decode( file_get_contents('php://input'), true);	

function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
       return $valor;
}


$pasta = 'ArquivosClientes/'.limpaCPF_CNPJ($inputs['cgc']).'/';

$arquivos = glob("$pasta{*.png,*.jpg,*.xls,*.csv,*.pdf,*.xlsx,*.msg,*.jpeg,*.mp4,*.mp3,*.ogg}", GLOB_BRACE);

$i = 0;

foreach($arquivos as $img){
  
    $i++;
    $ordem[]= basename($img);
}
$linha = 'logs/'.limpaCPF_CNPJ($inputs['cgc']).'.txt';
if(file_exists($linha)){
    $linha2 = file('logs/'.limpaCPF_CNPJ($inputs['cgc']).'.txt');
}

$users = file_exists($linha) ?  array_slice($linha2, -1) : 0;

if($i > 0){
    $quantidade = array([
        'quantidade'=>$i,
        'hora_arquivo'=>"Você anexou o último arquivo em : " . date("d/m/Y H:i:s", filemtime($pasta)),
        'arquivo'=>json_encode($ordem),
        'usuario'=>$users
        
    ]);
} else {
    $quantidade = array([
        'quantidade'=>$i,
        'hora_arquivo'=>0,
        'arquivo'=>0,
        'usuario'=>0
        
    ]);


}

print_r(json_encode($quantidade));

?>