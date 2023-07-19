<?php
defined('ROOT_DIR') ?: define('ROOT_DIR', __DIR__);	
require('dao/login.dao.php');
require('../../lib/commons.inc.php');

use crud\login as c;

$dao = new c\login_ad(array());

$inputs = json_decode( file_get_contents('php://input'), true);

//$inputs['users'] = 'DIRCEUH';
//$inputs['password'] ='arthurah@2010';

$server = "domainserver"; //IP ou nome do servidor
$dominio = "correamte.mat" ;//Dominio Ex: @gmail.com
$user = $inputs['users']."@".$dominio;
$pass = $inputs['password'];




if ($dao->login_select($server, $user, $pass)) {
	
	$autenticacao[] = array(
	"autenticacao"=>"ok"
	);
	
	print_r(json_encode($autenticacao));
} else {
	
		$autenticacao[] = array(
	"autenticacao"=>"error"
	);
  print_r(json_encode($autenticacao));
}


?>