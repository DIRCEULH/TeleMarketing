<?php
require_once('../../lib/conexao.php');
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode( file_get_contents('php://input'), true);

//print_r($inputs); die;

$sql = 'INSERT INTO cliente_fornecedor_inbox (cgc,nome,email,telefone,cep,endereco,bairro, cidade,uf,idclifor,feedback_cliente,feedback_empresa,usuario_cadastro,status_origem,status_feedback,data_cadastro)
VALUES(:cgc, :nome,:email,:telefone , :cep,:endereco,:bairro,:cidade,:uf,:idclifor,:feedback_cliente, :feedback_empresa,:logado,:status_origem,:status_feedback, NOW())';
$conexao = conexao::getInstance();
$stm = $conexao->prepare($sql);
$stm->bindValue(':cgc', $inputs['cgc']);
$stm->bindValue(':nome', $inputs['nome']);
$stm->bindValue(':email',  $inputs['email']);
$stm->bindValue(':telefone',  $inputs['telefone']);
$stm->bindValue(':cep',  $inputs['cep']);
$stm->bindValue(':endereco', $inputs['endereco']);
$stm->bindValue(':bairro', $inputs['bairro']);
$stm->bindValue(':cidade',  $inputs['cidade']);
$stm->bindValue(':uf',  $inputs['uf']);
$stm->bindValue(':idclifor',  $inputs['idclifor']);
$stm->bindValue(':feedback_cliente',  $inputs['feedback_cliente']);
$stm->bindValue(':feedback_empresa',  $inputs['feedback_empresa']);
$stm->bindValue(':logado',  $inputs['logado']);
$stm->bindValue(':status_origem',  $inputs['status_origem']);
$stm->bindValue(':status_feedback',  $inputs['status_feedback']);
$retorno = $stm->execute();
print_r($retorno);




?>