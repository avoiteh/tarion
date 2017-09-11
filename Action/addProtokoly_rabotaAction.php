<?php
class addProtokoly_rabotaAction{
	function Go(){
		$dbprotokols=new dbprotokols();
if($_SESSION['Protokoly_rabota']['filter_check']['komis']=='on'){
	$komis=$_SESSION['Protokoly_rabota']['filter']['komis'];
}else{
	$komis=0;
}
if($_SESSION['Protokoly_rabota']['filter_check']['datakomis']=='on'){
	$datakomis=$_SESSION['Protokoly_rabota']['filter']['datakomis'];
}else{
	$datakomis=0;
}
if($_SESSION['Protokoly_rabota']['filter_check']['nomer']=='on'){
	$nomer=$_SESSION['Protokoly_rabota']['filter']['nomer'];
}else{
	$nomer='';
}
if($_SESSION['Protokoly_rabota']['filter_check']['status']=='on'){
	$status=$_SESSION['Protokoly_rabota']['filter']['status'];
}else{
	$status=0;
}
$dbprotokols->add( $komis,  $datakomis,  $nomer,  $status);
	}
}
?>