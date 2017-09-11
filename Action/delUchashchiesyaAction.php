<?php
class delUchashchiesyaAction{
	function Go(){
		$dbuchenik=new dbuchenik();
		$dbuchenik->del($_REQUEST['id']*1);
	}
}
?>