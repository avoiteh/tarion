<?php
class addPrava_BOActionBO{
	function Go(){
		$dbright=new dbright();
if($_SESSION['Prava_BO']['filter_check']['name']=='on'){
	$name=$_SESSION['Prava_BO']['filter']['name'];
}else{
	$name='';
}
$dbright->add( $name);
	}
}
?>