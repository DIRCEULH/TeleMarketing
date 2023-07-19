<?php

namespace crud\login;
require ('../../lib/ado.class.php');


class login_ad extends \db2_dao{
		
function login_select($srv, $usr, $pwd){
$ldap_server = $srv;
$auth_user = $usr;
$auth_pass = $pwd;
 
// Tenta se conectar com o servidor
if (!($connect = @ldap_connect($ldap_server))) {
return FALSE;
}
 
// Tenta autenticar no servidor
if (!($bind = @ldap_bind($connect, $auth_user, $auth_pass))) {
// se não validar retorna false
return FALSE;
} else {
// se validar retorna true
return TRUE;
}
 
}







}

?>