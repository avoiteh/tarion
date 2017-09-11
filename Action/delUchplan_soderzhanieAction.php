<?php
class delUchplan_soderzhanieAction{
	function Go(){
		$dbuch_cont=new dbuch_cont();
		$dbuch_cont->del($_REQUEST['id']*1);
	}
}
?>