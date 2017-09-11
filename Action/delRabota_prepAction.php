<?php
class delRabota_prepAction{
	function Go(){
		$dbprepod_plan=new dbprepod_plan();
		$dbprepod_plan->del($_REQUEST['id']*1);
	}
}
?>