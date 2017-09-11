<?php
class addSpetsializatsiiAction{
	function Go(){
		$dbspecial=new dbspecial();
if($_SESSION['Spetsializatsii']['filter_check']['special']=='on'){
	$special=$_SESSION['Spetsializatsii']['filter']['special'];
}else{
	$special='';
}
if($_SESSION['Spetsializatsii']['filter_check']['topspec']=='on'){
	$topspec=$_SESSION['Spetsializatsii']['filter']['topspec'];
}else{
	$topspec=0;
}
$dbspecial->add( $special,  $topspec);
	}
}
?>