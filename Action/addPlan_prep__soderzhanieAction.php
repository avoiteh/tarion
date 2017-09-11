<?php
class addPlan_prep__soderzhanieAction{
	function Go(){
		$dbprepod_cont=new dbprepod_cont();
if($_SESSION['Plan_prep__soderzhanie']['filter_check']['plann']=='on'){
	$plann=$_SESSION['Plan_prep__soderzhanie']['filter']['plann'];
}else{
	$plann=0;
}
if($_SESSION['Plan_prep__soderzhanie']['filter_check']['tip']=='on'){
	$tip=$_SESSION['Plan_prep__soderzhanie']['filter']['tip'];
}else{
	$tip=0;
}
if($_SESSION['Plan_prep__soderzhanie']['filter_check']['opis']=='on'){
	$opis=$_SESSION['Plan_prep__soderzhanie']['filter']['opis'];
}else{
	$opis='';
}
if($_SESSION['Plan_prep__soderzhanie']['filter_check']['srok']=='on'){
	$srok=$_SESSION['Plan_prep__soderzhanie']['filter']['srok'];
}else{
	$srok=0;
}
$dbprepod_cont->add( $plann,  $tip,  $opis,  $srok);
	}
}
?>