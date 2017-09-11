<?php
class delKomissiya_plana_rab__prep_Action{
	function Go(){
		$dbprepod_plan=new dbprepod_plan();
		$dbprepod_plan->del($_REQUEST['id']*1);
	}
}
?>