<?php
class delPlan_prep__soderzhanieAction{
	function Go(){
		$dbprepod_cont=new dbprepod_cont();
		$dbprepod_cont->del($_REQUEST['id']*1);
	}
}
?>