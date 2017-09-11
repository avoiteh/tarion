<?php
class addMetod_razrabotkiAction{
	function Go(){
		$dbreg_book=new dbreg_book();
if($_SESSION['Metod_razrabotki']['filter_check']['datareg']=='on'){
	$datareg=$_SESSION['Metod_razrabotki']['filter']['datareg'];
}else{
	$datareg=0;
}
if($_SESSION['Metod_razrabotki']['filter_check']['nomer']=='on'){
	$nomer=$_SESSION['Metod_razrabotki']['filter']['nomer'];
}else{
	$nomer='';
}
if($_SESSION['Metod_razrabotki']['filter_check']['naim']=='on'){
	$naim=$_SESSION['Metod_razrabotki']['filter']['naim'];
}else{
	$naim='';
}
if($_SESSION['Metod_razrabotki']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Metod_razrabotki']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Metod_razrabotki']['filter_check']['komprot']=='on'){
	$komprot=$_SESSION['Metod_razrabotki']['filter']['komprot'];
}else{
	$komprot=0;
}
if($_SESSION['Metod_razrabotki']['filter_check']['komis']=='on'){
	$komis=$_SESSION['Metod_razrabotki']['filter']['komis'];
}else{
	$komis=0;
}
if($_SESSION['Metod_razrabotki']['filter_check']['status']=='on'){
	$status=$_SESSION['Metod_razrabotki']['filter']['status'];
}else{
	$status=0;
}
$dbreg_book->add( $datareg,  $nomer,  $naim,  $prepod,  $komprot,  $komis,  $status);
	}
}
?>