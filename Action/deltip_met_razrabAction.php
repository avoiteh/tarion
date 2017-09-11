<?php
class deltip_met_razrabAction{
	function Go(){
		$dbnov_type=new dbnov_type();
		$dbnov_type->del($_REQUEST['id']*1);
	}
}
?>