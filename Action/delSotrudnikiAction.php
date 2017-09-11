<?php
class delSotrudnikiAction{
	function Go(){
		$dbfront_user=new dbfront_user();
		$dbfront_user->del($_REQUEST['id']*1);
	}
}
?>