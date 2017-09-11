<?php
class delUchplanAction{
	function Go(){
		$dbuch_plan=new dbuch_plan();
		$dbuch_plan->del($_REQUEST['id']*1);
	}
}
?>