<?php
class delPredmetyAction{
	function Go(){
		$dbpredmet=new dbpredmet();
		$dbpredmet->del($_REQUEST['id']*1);
	}
}
?>