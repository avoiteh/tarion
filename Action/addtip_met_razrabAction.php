<?php
class addtip_met_razrabAction{
	function Go(){
		$dbnov_type=new dbnov_type();
if($_SESSION['tip_met_razrab']['filter_check']['novtype']=='on'){
	$novtype=$_SESSION['tip_met_razrab']['filter']['novtype'];
}else{
	$novtype='';
}
$dbnov_type->add( $novtype);
	}
}
?>