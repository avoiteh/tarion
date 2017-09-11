<?php
class addPrava_FOActionBO{
	function Go(){
		$dbfront_right=new dbfront_right();
if($_SESSION['Prava_FO']['filter_check']['name']=='on'){
	$name=$_SESSION['Prava_FO']['filter']['name'];
}else{
	$name='';
}
$dbfront_right->add( $name);
	}
}
?>