<?php
class addUchplanAction{
	function Go(){
		$dbuch_plan=new dbuch_plan();
if($_SESSION['Uchplan']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Uchplan']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Uchplan']['filter_check']['god']=='on'){
	$god=$_SESSION['Uchplan']['filter']['god'];
}else{
	$god='';
}
if($_SESSION['Uchplan']['filter_check']['naim']=='on'){
	$naim=$_SESSION['Uchplan']['filter']['naim'];
}else{
	$naim='';
}
if($_SESSION['Uchplan']['filter_check']['special']=='on'){
	$special=$_SESSION['Uchplan']['filter']['special'];
}else{
	$special=0;
}
if($_SESSION['Uchplan']['filter_check']['sem1']=='on'){
	$sem1=$_SESSION['Uchplan']['filter']['sem1'];
}else{
	$sem1=0;
}
if($_SESSION['Uchplan']['filter_check']['sem2']=='on'){
	$sem2=$_SESSION['Uchplan']['filter']['sem2'];
}else{
	$sem2=0;
}
if($_SESSION['Uchplan']['filter_check']['sem3']=='on'){
	$sem3=$_SESSION['Uchplan']['filter']['sem3'];
}else{
	$sem3=0;
}
if($_SESSION['Uchplan']['filter_check']['sem4']=='on'){
	$sem4=$_SESSION['Uchplan']['filter']['sem4'];
}else{
	$sem4=0;
}
if($_SESSION['Uchplan']['filter_check']['sem5']=='on'){
	$sem5=$_SESSION['Uchplan']['filter']['sem5'];
}else{
	$sem5=0;
}
if($_SESSION['Uchplan']['filter_check']['sem6']=='on'){
	$sem6=$_SESSION['Uchplan']['filter']['sem6'];
}else{
	$sem6=0;
}
if($_SESSION['Uchplan']['filter_check']['sem7']=='on'){
	$sem7=$_SESSION['Uchplan']['filter']['sem7'];
}else{
	$sem7=0;
}
if($_SESSION['Uchplan']['filter_check']['sem8']=='on'){
	$sem8=$_SESSION['Uchplan']['filter']['sem8'];
}else{
	$sem8=0;
}
$dbuch_plan->add( $prepod,  $god,  $naim,  $special,  $sem1,  $sem2,  $sem3,  $sem4,  $sem5,  $sem6,  $sem7,  $sem8);
	}
}
?>