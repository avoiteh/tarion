<?php
class updateSpetsialnostiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbtop_spec=new dbtop_spec();
		//новые поля
		
		$dbtop_spec->update($id, mysql_escape_string($_REQUEST['topspec']));
	}
}
?>