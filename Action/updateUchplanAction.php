<?php
class updateUchplanAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbuch_plan=new dbuch_plan();
		//новые поля
		
		$dbuch_plan->update($id, ($_REQUEST['prepod']*1), mysql_escape_string($_REQUEST['god']), mysql_escape_string($_REQUEST['naim']), ($_REQUEST['special']*1), ($_REQUEST['sem1']*1), ($_REQUEST['sem2']*1), ($_REQUEST['sem3']*1), ($_REQUEST['sem4']*1), ($_REQUEST['sem5']*1), ($_REQUEST['sem6']*1), ($_REQUEST['sem7']*1), ($_REQUEST['sem8']*1));
	}
}
?>