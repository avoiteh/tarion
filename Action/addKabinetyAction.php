<?php
class addKabinetyAction{
	function Go(){
		$dbkabinet=new dbkabinet();
if($_SESSION['Kabinety']['filter_check']['kabinet']=='on'){
	$kabinet=$_SESSION['Kabinety']['filter']['kabinet'];
}else{
	$kabinet='';
}
$dbkabinet->add( $kabinet);
	}
}
?>