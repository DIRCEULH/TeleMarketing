<?php
date_default_timezone_set('America/Sao_Paulo');
function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
       return $valor;
}

$caminho = $_REQUEST['caminho'];
$cgc = limpaCPF_CNPJ($_REQUEST['cgc']);
$nome = $_REQUEST['nome'];
$logado = $_REQUEST['logado'];
$exclusao = 'Exclusao de arquivo';
$datatual = date('d/m/Y H:m:s');

$texto = ':'.$logado.'-'.$datatual.'-'.$nome.'-'.$cgc .'-'.$exclusao.'-'.substr($caminho,29).'-'.$_SERVER["REMOTE_ADDR"].":\r\n";


$local = 'logs/'.limpaCPF_CNPJ($cgc).'.txt';

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

unlink($caminho);

header('location: arquivos.rest.php?cgc='.$cgc.'&nome='.$nome.'&logado='.$logado.'');


?>