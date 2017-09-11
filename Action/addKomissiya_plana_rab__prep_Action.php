<?php
class addKomissiya_plana_rab__prep_Action{
	function Go(){
		$dbprepod_plan=new dbprepod_plan();
if($_SESSION['Komissiya_plana_rab__prep_']['filter_check']['prepod']=='on'){
	$prepod=$_SESSION['Komissiya_plana_rab__prep_']['filter']['prepod'];
}else{
	$prepod=0;
}
if($_SESSION['Komissiya_plana_rab__prep_']['filter_check']['komiss']=='on'){
	$komiss=$_SESSION['Komissiya_plana_rab__prep_']['filter']['komiss'];
}else{
	$komiss=0;
}
if($_SESSION['Komissiya_plana_rab__prep_']['filter_check']['god']=='on'){
	$god=$_SESSION['Komissiya_plana_rab__prep_']['filter']['god'];
}else{
	$god=0;
}
if($_SESSION['Komissiya_plana_rab__prep_']['filter_check']['remark']=='on'){
	$remark=$_SESSION['Komissiya_plana_rab__prep_']['filter']['remark'];
}else{
	$remark='';
}
$dbprepod_plan->add( $prepod,  $komiss,  $god,  $remark);
	}
}
?>