<?php
class updateModuli_FO_derevo_ActionBO{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbfront_modules=new dbfront_modules();
		//новые поля
		
		$dbfront_modules->update($id, mysql_escape_string($_REQUEST['module']), ($_REQUEST['parent']*1), mysql_escape_string($_REQUEST['title']), mysql_escape_string($_REQUEST['type']));
	}
}
?>