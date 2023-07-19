<?php
require_once('../../lib/conexao.php');
//require_once('../../conn/commons.inc.php');
date_default_timezone_set('America/Sao_Paulo');

$inputs = json_decode( file_get_contents('php://input'), true);

$conexao = conexao::getInstance();
$sql = '
UPDATE cliente_fornecedor_inbox SET status_feedback = :status_feedback WHERE idcadastro = :idcadastro';
$stm = $conexao->prepare($sql);
$stm->bindValue(':status_feedback', $inputs['status_feedback']);
$stm->bindValue(':idcadastro', $inputs['idcadastro']);
$stm->execute();
$updatestatus = $stm->fetchAll(PDO::FETCH_OBJ);
print_r(json_encode($updatestatus));
?>