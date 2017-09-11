<?php
class addshabl_prep_planaAction{
	function Go(){
		$dbplan_shablon=new dbplan_shablon();
if($_SESSION['shabl_prep_plana']['filter_check']['razdel']=='on'){
	$razdel=$_SESSION['shabl_prep_plana']['filter']['razdel'];
}else{
	$razdel=0;
}
if($_SESSION['shabl_prep_plana']['filter_check']['title']=='on'){
	$title=$_SESSION['shabl_prep_plana']['filter']['title'];
}else{
	$title='';
}
if($_SESSION['shabl_prep_plana']['filter_check']['shablon']=='on'){
	$shablon=$_SESSION['shabl_prep_plana']['filter']['shablon'];
}else{
	$shablon='';
}
$dbplan_shablon->add( $razdel,  $title,  $shablon);
	}
}
?>