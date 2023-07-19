<?php
header('Content-Type: text/html; charset=utf-8');
include('../../phplot-6.2.0/phplot.php');
require_once('../../lib/conexao.php');
date_default_timezone_set('America/Sao_Paulo');



//excelente

function excelente($data){
require_once('../../lib/conexao.php');   
$conexao = conexao::getInstance();
$sqlexcelente = '
SELECT 
 count( coalesce(0,status_feedback)) statusexcelente
FROM cliente_fornecedor_inbox WHERE status_feedback = "Excelente" and MONTH(data_cadastro) = MONTH("'.$data.'") and YEAR ( data_cadastro) = YEAR (NOW())';
$stmexcelente = $conexao->prepare($sqlexcelente);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stmexcelente->execute();
$excelente = $stmexcelente->fetchAll(PDO::FETCH_ASSOC);
foreach ($excelente as $valueexcelente) {
return $valueexcelente['statusexcelente'];

}
}
// bom
function bom($data){
    require_once('../../lib/conexao.php');   
    $conexao = conexao::getInstance();
$sqlbom = '
SELECT 
 count( coalesce(0,status_feedback)) statusbom
FROM cliente_fornecedor_inbox WHERE status_feedback = "Bom" and MONTH(data_cadastro) = MONTH("'.$data.'") and YEAR ( data_cadastro) = YEAR (NOW())';
$stmebom = $conexao->prepare($sqlbom);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stmebom->execute();
$bom = $stmebom->fetchAll(PDO::FETCH_ASSOC);
foreach ($bom as $valuebom) {
return $valuebom['statusbom'];
}
}
//regular
function regular($data){
    require_once('../../lib/conexao.php');   
    $conexao = conexao::getInstance();
$sqlregular = '
SELECT 
 count( coalesce(0,status_feedback)) statusregular
FROM cliente_fornecedor_inbox WHERE status_feedback = "Regular" and MONTH(data_cadastro) = MONTH("'.$data.'") and YEAR ( data_cadastro) = YEAR (NOW())';
$stmregular = $conexao->prepare($sqlregular);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stmregular->execute();
$regular = $stmregular->fetchAll(PDO::FETCH_ASSOC);
foreach ($regular as $valueregular) {
return $valueregular['statusregular'];
}
}
//ruim
function ruim($data){
    require_once('../../lib/conexao.php');   
    $conexao = conexao::getInstance();
$sqlruim = '
SELECT 
 count( coalesce(0,status_feedback)) statusruim
FROM cliente_fornecedor_inbox WHERE status_feedback = "Ruim"  and MONTH(data_cadastro) = MONTH("'.$data.'") and YEAR ( data_cadastro) = YEAR (NOW())';
$stmruim= $conexao->prepare($sqlruim);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stmruim->execute();
$ruim = $stmruim->fetchAll(PDO::FETCH_ASSOC);
foreach ($ruim as $valueruim) {
 return $valueruim['statusruim'];
}
}
// pessimo
function pessimo($data){
    require_once('../../lib/conexao.php');   
    $conexao = conexao::getInstance();
$sqlpessimo = '
SELECT 
 count( coalesce(0,status_feedback)) statuspessimo
FROM cliente_fornecedor_inbox WHERE status_feedback = "Péssimo"  and MONTH(data_cadastro) = MONTH("'.$data.'") and YEAR ( data_cadastro) = YEAR (NOW())';
$stmpessimo= $conexao->prepare($sqlpessimo);
//$stm->bindValue(':usuario', $inputs['usuario']);
$stmpessimo->execute();
$pessimo = $stmpessimo->fetchAll(PDO::FETCH_ASSOC);
foreach ($pessimo as $valuepessimo) {
return $valuepessimo['statuspessimo'];
}
}


#Matriz utilizada para gerar os graficos
$data = array(
 array('Janeiro',  excelente('2020-01-13'),  bom('2020-01-13'),  regular('2020-01-13'), ruim('2020-01-13'), pessimo('2020-01-13')), array('Fevereiro',  excelente('2020-02-13'),  bom('2020-02-13'),  regular('2020-02-13'), ruim('2020-02-13'), pessimo('2020-02-13')), array('Marco',  excelente('2020-03-13'),  bom('2020-03-13'),  regular('2020-03-13'), ruim('2020-03-13'), pessimo('2020-03-13')),
 array('Abril',  excelente('2020-04-13'),  bom('2020-04-13'),  regular('2020-04-13'), ruim('2020-04-13'), pessimo('2020-04-13')), array('Maio',  excelente('2020-05-13'),  bom('2020-05-13'),  regular('2020-05-13'), ruim('2020-05-13'), pessimo('2020-05-13')), array('Junho',  excelente('2020-06-13'),  bom('2020-06-13'),  regular('2020-06-13'), ruim('2020-06-13'), pessimo('2020-06-13')),
 array('Julho',  excelente('2020-07-13'),  bom('2020-07-13'),  regular('2020-07-13'), ruim('2020-07-13'), pessimo('2020-07-13')), array('Agosto',  excelente('2020-08-13'),  bom('2020-08-13'),  regular('2020-08-13'), ruim('2020-08-13'), pessimo('2020-08-13')), array('Setembro', excelente('2020-09-13'),  bom('2020-09-13'),  regular('2020-09-13'), ruim('2020-09-13'), pessimo('2020-09-13')),
 array('Outubro',  excelente('2020-10-13'),  bom('2020-10-13'),  regular('2020-10-13'), ruim('2020-10-13'), pessimo('2020-10-13')), array('Novembro',  excelente('2020-11-13'),  bom('2020-11-13'),  regular('2020-11-13'), ruim('2020-11-13'), pessimo('2020-11-13')), array('Dezembro',  excelente('2020-12-13'),  bom('2020-12-13'),  regular('2020-12-13'), ruim('2020-12-13'), pessimo('2020-12-13')),
);
#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(1400,700);
#Tipo de borda, consulte a documentacao
$plot->SetImageBorderType('plain');
#Tipo de grafico, nesse caso barras, existem diversos(pizza…)
$plot->SetPlotType('bars');
#Tipo de dados, nesse caso texto que esta no array
$plot->SetDataType('text-data');
#Setando os valores com os dados do array
$plot->SetDataValues($data);
#Titulo do grafico
$plot->SetTitle('Status de Feedback dos Clientes');
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados
$plot->SetLegend(array('Excelente','Bom', 'Regular','Ruim','Pessimo'));
#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
#Gera o grafico na tela
$plot->DrawGraph();
?>


