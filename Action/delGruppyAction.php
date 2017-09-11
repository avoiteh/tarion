<?php
class delGruppyAction{
	function Go(){
		$dbgruppa=new dbgruppa();
		$dbgruppa->del($_REQUEST['id']*1);
	}
}
?>