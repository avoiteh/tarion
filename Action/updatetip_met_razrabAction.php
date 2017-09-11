<?php
class updatetip_met_razrabAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbnov_type=new dbnov_type();
		//новые поля
		
		$dbnov_type->update($id, mysql_escape_string($_REQUEST['novtype']));
	}
}
?>