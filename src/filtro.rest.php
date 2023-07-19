<?php
require_once('../../lib/conexao.php');
//require_once('../../conn/commons.inc.php');
date_default_timezone_set('America/Sao_Paulo');

$inputs = json_decode( file_get_contents('php://input'), true);

$conexao = conexao::getInstance();


if(!empty($inputs['statusfeed'])){

$sql = '
SELECT 
  idclifor
, idcadastro
, nome
, feedback_cliente
, feedback_empresa
, DATE_FORMAT(data_cadastro,"%d/%m/%Y %T") as data_cadastro
, usuario_cadastro
, status_origem
, status_feedback
, cgc
FROM cliente_fornecedor_inbox WHERE status_feedback = :status and MONTH(data_cadastro) = MONTH(NOW()) and YEAR(data_cadastro) = YEAR(NOW())';
$stm = $conexao->prepare($sql);
$stm->bindValue(':status', $inputs['statusfeed']);
$stm->execute();
$feedback = $stm->fetchAll(PDO::FETCH_OBJ);
print_r(json_encode($feedback));

} else {

    $sql = '
    SELECT 
      idclifor
    , idcadastro
    , nome
    , feedback_cliente
    , feedback_empresa
    , DATE_FORMAT(data_cadastro,"%d/%m/%Y %T") as data_cadastro
    , usuario_cadastro
    , status_origem
    , status_feedback
    , cgc
    FROM cliente_fornecedor_inbox WHERE MONTH(data_cadastro) = MONTH(NOW()) and YEAR(data_cadastro) = YEAR(NOW())';
    $stm = $conexao->prepare($sql);
   // $stm->bindValue(':status', $inputs['status']);
    $stm->execute();
    $feedback = $stm->fetchAll(PDO::FETCH_OBJ);
    print_r(json_encode($feedback));
    



}

?>