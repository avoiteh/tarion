<?php
class delKabinetyAction{
	function Go(){
		$dbkabinet=new dbkabinet();
		$dbkabinet->del($_REQUEST['id']*1);
	}
}
?>