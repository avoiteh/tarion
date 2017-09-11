<?php
class delPednagruzkaAction{
	function Go(){
		$dbped_nagr=new dbped_nagr();
		$dbped_nagr->del($_REQUEST['id']*1);
	}
}
?>