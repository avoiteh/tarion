<?php
class delTovaryAction{
	function Go(){
		$dbproduct=new dbproduct();
		$dbproduct->del($_REQUEST['id']*1);
	}
}
?>