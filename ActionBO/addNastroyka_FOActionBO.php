<?php
class addNastroyka_FOActionBO{
	function Go(){
		$dbfront_cross_right=new dbfront_cross_right();
if($_SESSION['Nastroyka_FO']['filter_check']['module']=='on'){
	$module=$_SESSION['Nastroyka_FO']['filter']['module'];
}else{
	$module=0;
}
if($_SESSION['Nastroyka_FO']['filter_check']['right']=='on'){
	$right=$_SESSION['Nastroyka_FO']['filter']['right'];
}else{
	$right=0;
}
$dbfront_cross_right->add( $module,  $right);
	}
}
?>