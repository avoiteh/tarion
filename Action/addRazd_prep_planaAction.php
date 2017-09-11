<?php
class addRazd_prep_planaAction{
	function Go(){
		$dbppr=new dbppr();
if($_SESSION['Razd_prep_plana']['filter_check']['razdel']=='on'){
	$razdel=$_SESSION['Razd_prep_plana']['filter']['razdel'];
}else{
	$razdel='';
}
$dbppr->add( $razdel);
	}
}
?>