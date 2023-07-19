<?php
defined('ROOT_DIR') ?: define('ROOT_DIR', __DIR__);	
require('dao/clientes.dao.php');
require('../../lib/commons.inc.php');
header("Content-Type: application/json; charset=utf-8", true);

use crud\clientes as c;
$inputs = json_decode( file_get_contents('php://input'), true);	
$dao = new c\clientes(array());
function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
       return $valor;
}	
$clientes = $dao->clientes(array("cgc"=>limpaCPF_CNPJ($inputs['cgc'])));
foreach($clientes as $result){

    $rows[] = array(
   'CGC'=>$result[0],
   'NOME'=>$result[1],
   'EMAIL'=>$result[2],
   'TELEFONE'=>$result[3],
   'CEP'=>$result[4],
   'ENDERECO'=>$result[5],
   'BAIRRO'=>$result[6],
   'CIDADE'=>$result[7],
   'UF'=>$result[8],
   'IDCLIFOR'=>$result[9]

    );
}
print_r(json_encode(utf8_encode_array($rows), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

?>