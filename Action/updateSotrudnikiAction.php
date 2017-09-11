<?php
class updateSotrudnikiAction{
	function Go(){
		$id=$_REQUEST['id']*1;
		$dbfront_user=new dbfront_user();
		//новые поля
		
		$dbfront_user->update($id, mysql_escape_string($_REQUEST['email']), mysql_escape_string($_REQUEST['password']), ($_REQUEST['right']*1), mysql_escape_string($_REQUEST['login']), mysql_escape_string($_REQUEST['family']), mysql_escape_string($_REQUEST['name']), mysql_escape_string($_REQUEST['otch']), mysql_escape_string($_REQUEST['dataworkstart']), ($_REQUEST['razryd']*1), ($_REQUEST['category']*1), ($_REQUEST['kabinet']*1));
	}
}
?>