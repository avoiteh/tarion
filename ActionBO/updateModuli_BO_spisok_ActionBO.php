<?php
class updateModuli_BO_spisok_ActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbmodules=new dbmodules();
		//новые поля
		
		$dbmodules->update($id, mysql_escape_string($_REQUEST['module']), ($_REQUEST['parent']*1), mysql_escape_string($_REQUEST['title']), mysql_escape_string($_REQUEST['type']));
	}
}
?>