<?php
class updateGruppyAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbgruppa=new dbgruppa();
		//новые поля
		
		$dbgruppa->update($id, mysql_escape_string($_REQUEST['gruppa']), ($_REQUEST['special']*1), ($_REQUEST['kurs']*1), mysql_escape_string($_REQUEST['sozdan']), ($_REQUEST['status']*1));
	}
}
?>