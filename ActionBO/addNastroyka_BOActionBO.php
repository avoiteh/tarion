<?php
class addNastroyka_BOActionBO{
	function Go(){
		$dbcross_right=new dbcross_right();
if($_SESSION['Nastroyka_BO']['filter_check']['module']=='on'){
	$module=$_SESSION['Nastroyka_BO']['filter']['module'];
}else{
	$module=0;
}
if($_SESSION['Nastroyka_BO']['filter_check']['right']=='on'){
	$right=$_SESSION['Nastroyka_BO']['filter']['right'];
}else{
	$right=0;
}
$dbcross_right->add( $module,  $right);
	}
}
?>