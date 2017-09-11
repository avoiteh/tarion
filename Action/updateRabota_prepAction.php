<?php
class updateRabota_prepAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbprepod_plan=new dbprepod_plan();
		//новые поля
		
		$dbprepod_plan->update($id, ($_REQUEST['prepod']*1), ($_REQUEST['komiss']*1), ($_REQUEST['god']*1), mysql_escape_string($_REQUEST['remark']));
	}
}
?>