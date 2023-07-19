
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="icon" href="image/logo_correa.png" type="image/x-icon" />
  <link rel="stylesheet" href="../../css/bootstrap.css" />
  <link rel="stylesheet" href="../../css/font-awesome.css" />
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.js"></script>
  <script language="Javascript">
   function pergunta() {

    if (confirm("Deseja confirmar essa operação?")) {

                  window.onload = function(){  
                document.getElementById('link').click();  
                }

          } else {return false;}
}
</script>
</head>
<body >

<div class="container-fluid	">
<nav  style = " background: #ccc;" class="navbar navbar-dark bg-default">
        <div class="container-fluid">
          <div class="navbar-header">
          <a style="margin-top: -10px;" class="navbar-brand" href="#" ><font color="black"><img src="../app/image/logo_correa.png" alt="Correa" height="40" width="65"></font></a>
          </div>
          <ul class="nav navbar-nav">
          <li><a href="#">
            <font color="white"><i class="fa fa-sign-out" aria-hidden="true"></i><?php  $logado =  $_REQUEST['logado']; echo $logado; ?></font>
            </a></li>
              <li><a href="#">
                  <font color="black"></font>
                </a></li>
              <li><a href="#">
                  <font color="black"> </font>
                </a></li>
                <li><a href="#">
                  <font color="#fff"> </font>
                </a></li>                
          </ul>
        </div>
      </nav>

    
<div class="panel panel-default">
<div class="panel-heading" ><i class="fa fa-file-archive-o fa-2x" aria-hidden="true"></i> Arquivos - <?php $nome = $_REQUEST['nome']; echo $nome ; ?></div>
<div class="container-fluid	"><br><br/>
<?php
 error_reporting(E_ALL);
 ini_set('display_errors','off');
$cgc = $_REQUEST['cgc'];

$diretorio = "ArquivosClientes/$cgc";

if(is_dir($diretorio)) {
$iterator = new RecursiveDirectoryIterator($diretorio);
$recursiveIterator = new RecursiveIteratorIterator($iterator);

foreach ( $recursiveIterator as $entry ) {
if($entry->getFilename() != '..' && $entry->getFilename()!= '.') {

  $endereco = $diretorio.'/'.$entry->getFilename();

  if($_REQUEST['logado'] == 'STEFANIES' || $_REQUEST['logado'] == 'stefanies' || $_REQUEST['logado'] == 'taniaf' || $_REQUEST['logado'] == 'TANIAF' || $_REQUEST['logado'] == 'DIRCEUH' || $_REQUEST['logado'] == 'dirceuh'){
    echo '<i class="fa fa-files-o fa-2x" aria-hidden="true"></i> <a class="seta-direita"  href="' . $entry->getPathname() . ' " title="Cadastro Clientes ' . $entry->getFilename() . '"><button class="btn btn-default btn-s" ><font color="green" >' . $entry->getFilename() . '</font></button></a>
    <a id="link" href="delete.rest.php?caminho='.$diretorio."/".$entry->getFilename().'&nome='.$nome.'&cgc='.$cgc.'&logado='.$logado.'" onclick="return pergunta();" class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i></a></br></br>';   

  } else {

 echo '<i class="fa fa-files-o fa-2x" aria-hidden="true"></i> <a class="seta-direita"  href="' . $entry->getPathname() . ' " title="Cadastro Clientes ' . $entry->getFilename() . '"><button class="btn btn-default btn-s" ><font color="green" >' . $entry->getFilename() . '</font></button></a>
 <a  disabled  href="#"  class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i></a></br></br>';
  }


}}}else{    echo '<button class="btn btn-default btn-s" ><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Nenhuma pasta encontrada para este cliente!!</button>';}

/* verificar diretorio*/
$scan = scandir($diretorio);

if(count($scan) > 2) {

}else {
    echo '<button class="btn btn-default btn-s" ><i class="fa fa-chain-broken" aria-hidden="true"></i> Nenhum arquivo!!</button>';

}
?>
<br><br/>
</div>
</div>
</div>
</body>
</html>