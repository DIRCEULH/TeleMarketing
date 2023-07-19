<?php
require_once('../../lib/conexao.php');
//require_once('../../conn/commons.inc.php');
date_default_timezone_set('America/Sao_Paulo');

//$inputs = json_decode( file_get_contents('php://input'), true);

$conexao = conexao::getInstance();
$sql = '
SELECT 
 count( coalesce(0,status_feedback)) statusexcelente
FROM cliente_fornecedor_inbox WHERE status_feedback = "Excelente"
AND MONTH(data_cadastro) = MONTH(NOW()) and YEAR(data_cadastro) = YEAR(NOW())';
$stm = $conexao->prepare($sql);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stm->execute();
$statusexcelente = $stm->fetchAll(PDO::FETCH_OBJ);
print_r(json_encode($statusexcelente));
?>