<?php
ini_set("default_charset","UTF-8");
defined('ROOT_DIR') ?: define('ROOT_DIR', __DIR__);	
require('../../lib/commons.inc.php');

$inputs = json_decode( file_get_contents('php://input'), true);	

function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
       return $valor;
}

$local = 'ArquivosClientes/'.limpaCPF_CNPJ($_REQUEST['cgc']).'/';

function tratar_arquivo_upload($string){
    // pegando a extensao do arquivo
    $partes 	= explode(".", $string);
    $extensao 	= $partes[count($partes)-1];	
    // somente o nome do arquivo
    $nome	= preg_replace('/\.[^.]*$/', '', $string);	
    // removendo simbolos, acentos etc
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ?';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuuyybyRr-';
    $nome = strtr($nome, utf8_decode($a), $b);
    $nome = str_replace(".","-",$nome);
    $nome = preg_replace( "/[^0-9a-zA-Z\.]+/",'-',$nome);
    return utf8_decode(strtolower($nome.".".$extensao));
 }
  
//  print_r( tratar_arquivo_upload(utf8_decode($_FILES[ 'file' ][ 'name' ])));
//  die;

$filename = tratar_arquivo_upload(utf8_decode($_FILES[ 'file' ][ 'name' ]));

if(!file_exists($local)){

    mkdir($local,true,'0700');
    
    if ( !empty( $_FILES ) ) {

        $tempPath =  $_FILES[ 'file' ][ 'tmp_name' ];
        $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR .$local. DIRECTORY_SEPARATOR .$filename;
        $extensao = strrchr($filename, '.');
        $extensoes_permitidas = array('.png','.jpg','.xls','.csv','.pdf','.xlsx','.msg','.jpeg','.mp4','.mp3','.ogg');
        if(in_array($extensao, $extensoes_permitidas) === true){
        move_uploaded_file( $tempPath, $uploadPath );
  
        $answer = array( 'answer' => '1','extensao' => $filename );
        print_r(json_encode([ $answer ]));
        } else {

            $answer = array( 'answer' => '0','extensao' => $filename );
            print_r(json_encode([ $answer ]));
        }
        
    
    } 

}elseif(file_exists($local)){

if ( !empty( $_FILES ) ) {

    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR .$local. DIRECTORY_SEPARATOR .$filename;
    $extensao = strrchr($filename, '.');
    $extensoes_permitidas = array('.png','.jpg','.xls','.csv','.pdf','.xlsx','.msg','.jpeg','.mp4','.mp3','.ogg');
    if(in_array($extensao, $extensoes_permitidas) === true){
    move_uploaded_file( $tempPath, $uploadPath );

    $answer = array( 'answer' => '1','extensao' => $filename );
    print_r(json_encode([ $answer ]));
    } else {
 
        $answer = array( 'answer' => '0','extensao' => $filename );
        print_r(json_encode([ $answer ]));
    }
    

} else {

   
    $answer = array( 'answer' => '0','extensao' => $filename );
    print_r(json_encode([ $answer ]));

}

}

?>