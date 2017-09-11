<?php
class delshabl_prep_planaAction{
	function Go(){
		$dbplan_shablon=new dbplan_shablon();
		$dbplan_shablon->del($_REQUEST['id']*1);
	}
}
?>