<?php
session_start();
require_once('connect_db.php');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=windows-1251');


header("Content-Coding: gzip");
//Если стервер поддерживает - это поможет дополнительно снизить объём трафика header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

//require('global_constants.php');

/*
function json_decode($content, $assoc=false){
                require_once 'JSON.php';
                if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->decode($content);
    }
  
function json_encode($content, $assoc=false){
                require_once 'JSON.php';
                if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->encode($content);
}
*/

//проверить откуда поступает запрос POST или GET
if(isset($_GET['query'])){
	//оторвать открывающую и закрывающую круглые скобки
	$query=trim(stripslashes($_GET['query']));
}
if(isset($_POST['query'])){
	$query=trim(stripslashes($_POST['query']));
	//echo("<textarea id='answer' style='width:300px;height:150px'>");
}


if($query[0]=='('){$query[0]=' ';}
if($query[strlen($query)-1]==')'){$query[strlen($query)-1]=' ';}
$query=iconv("cp1251", "UTF-8",$query);
$json_query= json_decode($query);
//var_dump($query);echo("<hr><pre>");var_dump($json_query);echo("</pre>");
//$test = array("111","222","333");
if($json_query->id=='Tables'){
	require('scripts/Tables.php');
}
if($json_query->id=='BO'){
	require('scripts/bo.php');
}
if($json_query->id=='FO'){
	require('scripts/fo.php');
}
if($json_query->id=='Translate'){
	require('scripts/Translate.php');
}
?>
