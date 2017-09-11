<?php
class addProtokoly_soderzhanieAction{
	function Go(){
		$dbprotokols=new dbprotokols();
if($_SESSION['Protokoly_soderzhanie']['filter_check']['komis']=='on'){
	$komis=$_SESSION['Protokoly_soderzhanie']['filter']['komis'];
}else{
	$komis=0;
}
if($_SESSION['Protokoly_soderzhanie']['filter_check']['datakomis']=='on'){
	$datakomis=$_SESSION['Protokoly_soderzhanie']['filter']['datakomis'];
}else{
	$datakomis=0;
}
if($_SESSION['Protokoly_soderzhanie']['filter_check']['nomer']=='on'){
	$nomer=$_SESSION['Protokoly_soderzhanie']['filter']['nomer'];
}else{
	$nomer='';
}
if($_SESSION['Protokoly_soderzhanie']['filter_check']['status']=='on'){
	$status=$_SESSION['Protokoly_soderzhanie']['filter']['status'];
}else{
	$status=0;
}
$dbprotokols->add( $komis,  $datakomis,  $nomer,  $status);
	}
}
?>