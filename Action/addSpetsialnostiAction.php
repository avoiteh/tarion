<?php
class addSpetsialnostiAction{
	function Go(){
		$dbtop_spec=new dbtop_spec();
if($_SESSION['Spetsialnosti']['filter_check']['topspec']=='on'){
	$topspec=$_SESSION['Spetsialnosti']['filter']['topspec'];
}else{
	$topspec='';
}
$dbtop_spec->add( $topspec);
	}
}
?>