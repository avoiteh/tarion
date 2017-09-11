<?php
class delPredmetnaya_privyazkaAction{
	function Go(){
		$dbppl=new dbppl();
		$dbppl->del($_REQUEST['id']*1);
	}
}
?>