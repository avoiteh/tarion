<?php
class updateshabl_prep_planaAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbplan_shablon=new dbplan_shablon();
		//новые поля
		
		$dbplan_shablon->update($id, ($_REQUEST['razdel']*1), mysql_escape_string($_REQUEST['title']), mysql_escape_string($_REQUEST['shablon']));
	}
}
?>