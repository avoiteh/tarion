<?php
class addRaspisanie_punktyAction{
	function Go(){
		$dbraspisanie=new dbraspisanie();
if($_SESSION['Raspisanie_punkty']['filter_check']['week']=='on'){
	$week=$_SESSION['Raspisanie_punkty']['filter']['week'];
}else{
	$week='';
}
if($_SESSION['Raspisanie_punkty']['filter_check']['predmet']=='on'){
	$predmet=$_SESSION['Raspisanie_punkty']['filter']['predmet'];
}else{
	$predmet=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['gruppa']=='on'){
	$gruppa=$_SESSION['Raspisanie_punkty']['filter']['gruppa'];
}else{
	$gruppa=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Raspisanie_punkty']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['den']=='on'){
	$den=$_SESSION['Raspisanie_punkty']['filter']['den'];
}else{
	$den=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['para']=='on'){
	$para=$_SESSION['Raspisanie_punkty']['filter']['para'];
}else{
	$para=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['kabinet']=='on'){
	$kabinet=$_SESSION['Raspisanie_punkty']['filter']['kabinet'];
}else{
	$kabinet=0;
}
if($_SESSION['Raspisanie_punkty']['filter_check']['year']=='on'){
	$year=$_SESSION['Raspisanie_punkty']['filter']['year'];
}else{
	$year=0;
}
$dbraspisanie->add( $week,  $predmet,  $gruppa,  $prepod,  $den,  $para,  $kabinet,  $year);
	}
}
?>