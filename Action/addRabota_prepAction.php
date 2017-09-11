<?php
class addRabota_prepAction{
	function Go(){
		$dbprepod_plan=new dbprepod_plan();
if($_SESSION['Rabota_prep']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Rabota_prep']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Rabota_prep']['filter_check']['komiss']=='on'){
	$komiss=$_SESSION['Rabota_prep']['filter']['komiss'];
}else{
	$komiss=0;
}
if($_SESSION['Rabota_prep']['filter_check']['god']=='on'){
	$god=$_SESSION['Rabota_prep']['filter']['god'];
}else{
	$god=0;
}
if($_SESSION['Rabota_prep']['filter_check']['remark']=='on'){
	$remark=$_SESSION['Rabota_prep']['filter']['remark'];
}else{
	$remark='';
}
$dbprepod_plan->add( $prepod,  $komiss,  $god,  $remark);
	}
}
?>